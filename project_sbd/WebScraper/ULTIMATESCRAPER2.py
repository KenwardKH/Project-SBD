import requests
from bs4 import BeautifulSoup
from urllib.parse import urlparse
import mysql.connector
from datetime import datetime

# Connect to MySQL database
db = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="tubes_sbd"
)
cursor = db.cursor()

def get_author_id(author_name):
    cursor.execute("SELECT id FROM Authors WHERE name = %s", (author_name,))
    result = cursor.fetchone()
    if result:
        return result[0]
    else:
        cursor.execute("INSERT INTO Authors (name) VALUES (%s)", (author_name,))
        db.commit()
        return cursor.lastrowid

def scrape_url(url, image_url):
    try:
        response = requests.get(url)
        if response.status_code == 200:
            soup = BeautifulSoup(response.text, 'html.parser')
            
            title_tag = soup.find('div', class_='inside-page-hero grid-container grid-parent')
            if title_tag:
                title = title_tag.text.strip()
                full_url = url
                parsed_url = urlparse(full_url)
                slug = parsed_url.path.strip('/').split('/')[-1]
            else:
                title = 'N/A'
                slug = 'N/A'

            cursor.execute("SELECT id FROM Posts WHERE title = %s", (title,))
            result = cursor.fetchone()
            
            if result:
                return
            
            author_tag = soup.find('span', class_='author-name')
            author_name = author_tag.text.strip() if author_tag else 'N/A'
            author_id = get_author_id(author_name)

            date_element = soup.find('time', class_='updated')
            updated_at = date_element['datetime'] if date_element else 'N/A'

            category_tag = soup.find('span', class_='cat-links')
            category_list = []
            if category_tag:
                categories_text = category_tag.text.strip()
                categories = categories_text.split(',')
                for category in categories:
                    clean_category = category.strip().replace(' Travel', '')
                    clean_category1 = clean_category.strip().replace('Categories','')
                    if clean_category1.lower() not in {'categories', 'travel'}:
                        category_list.append(clean_category1)

            tags_section = soup.find('span', class_='tags-links')
            tags_list = [tag.text for tag in tags_section.find_all('a')] if tags_section else []

            cursor.execute(
                "INSERT IGNORE INTO Posts (title, slug, image, date_updated, author_id) VALUES (%s, %s, %s, %s, %s)",
                (title, slug, image_url, updated_at, author_id)
            )
            post_id = cursor.lastrowid

            if category_list:
                for category in category_list:
                    cursor.execute("INSERT IGNORE INTO Categories (name) VALUES (%s)", (category,))
                    cursor.execute(
                        "INSERT INTO Post_Categories (post_id, category_id) VALUES (%s, (SELECT id FROM Categories WHERE name = %s))",
                        (post_id, category)
                    )

            if tags_list:
                for tag in tags_list:
                    cursor.execute("INSERT IGNORE INTO Tags (name) VALUES (%s)", (tag,))
                    cursor.execute(
                        "INSERT INTO Post_Tags (post_id, tag_id) VALUES (%s, (SELECT id FROM Tags WHERE name = %s))",
                        (post_id, tag)
                    )
            
            # Scrape comments
            comments_section = soup.find_all('article', class_='comment-body')
            for comment in comments_section:
                comment_author_tag = comment.find('cite', class_='fn')
                comment_author = comment_author_tag.text.strip() if comment_author_tag else 'N/A'
                comment_date_tag = comment.find('time', class_='comment-time')
                comment_date = comment_date_tag['datetime'] if comment_date_tag else datetime.now().isoformat()
                comment_content_tag = comment.find('div', class_='comment-content')
                comment_content = comment_content_tag.text.strip() if comment_content_tag else 'N/A'
                
                cursor.execute(
                    "INSERT INTO Comments (author, date, content, post_id) VALUES (%s, %s, %s, %s)",
                    (comment_author, comment_date, comment_content, post_id)
                )

            db.commit()

        else:
            print('Failed to retrieve webpage')
    except Exception as e:
        print("An error occurred:", e)
        db.rollback()

cursor.execute("SELECT url, image FROM temp")
urls = cursor.fetchall()

for url_tuple in urls:
    url = url_tuple[0]
    image_url = url_tuple[1]
    scrape_url(url, image_url)

cursor.close()
db.close()
