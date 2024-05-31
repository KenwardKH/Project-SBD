import requests
from bs4 import BeautifulSoup
from urllib.parse import urlparse
import mysql.connector

# Connect to MySQL database
db = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="tubes_sbd"
)
cursor = db.cursor()

def get_author_id(author_name):
    # Check if the author exists in the database
    cursor.execute("SELECT id FROM Authors WHERE name = %s", (author_name,))
    result = cursor.fetchone()
    if result:
        return result[0]  # Return the existing author ID
    else:
        # If the author doesn't exist, insert the author into the database
        cursor.execute("INSERT INTO Authors (name) VALUES (%s)", (author_name,))
        db.commit()  # Commit the insertion
        return cursor.lastrowid  # Return the ID of the newly inserted author

# Function to scrape a given URL
def scrape_url(url, image_url):
    try:
        # Fetch the webpage content
        response = requests.get(url)
    
        # Check if the response was successful (status code 200)
        if response.status_code == 200:
            # Convert the webpage content to a BeautifulSoup object
            soup = BeautifulSoup(response.text, 'html.parser')
            
            # Extracting the title
            title_tag = soup.find('div', class_='inside-page-hero grid-container grid-parent')
            if title_tag:
                title = title_tag.text.strip()
                full_url = url
                parsed_url = urlparse(full_url)
                slug = parsed_url.path.strip('/').split('/')[-1]
            else:
                title = 'N/A'
                slug = 'N/A'

            # Check if the title already exists in the database
            cursor.execute("SELECT id FROM Posts WHERE title = %s", (title,))
            result = cursor.fetchone()
            
            if result:
                # If title exists, skip this article
                return
            
            # Extract the author
            author_tag = soup.find('span', class_='author-name')
            author_name = author_tag.text.strip() if author_tag else 'N/A'
            author_id = get_author_id(author_name)

            # Extract the date posted
            date_element = soup.find('time', class_='updated')
            updated_at = date_element['datetime'] if date_element else 'N/A'

            # Extracting the categories
            category_tag = soup.find('span', class_='cat-links')
            category_list = []
            if category_tag:
                categories_text = category_tag.text.strip()
                # Split categories based on common delimiters
                categories = categories_text.split(',')
                for category in categories:
                    clean_category = category.strip().replace(' Travel', '')
                    clean_category1 = clean_category.strip().replace('Categories','')
                    if clean_category1.lower() not in {'categories', 'travel'}:
                        category_list.append(clean_category1)

            # Extracting the tags
            tags_section = soup.find('span', class_='tags-links')
            tags_list = [tag.text for tag in tags_section.find_all('a')] if tags_section else []

            # Insert into Posts table
            cursor.execute(
                "INSERT IGNORE INTO Posts (title, slug, image, date_updated, author_id) VALUES (%s, %s, %s, %s, %s)",
                (title, slug, image_url, updated_at, author_id)
            )
            post_id = cursor.lastrowid  # Get the ID of the last inserted row

            # Insert into Categories and PostCategories only if categories exist
            if category_list:
                for category in category_list:
                    cursor.execute("INSERT IGNORE INTO Categories (name) VALUES (%s)", (category,))
                    cursor.execute(
                        "INSERT INTO Post_Categories (post_id, category_id) VALUES (%s, (SELECT id FROM Categories WHERE name = %s))",
                        (post_id, category)
                    )

            # Insert into Tags and PostTags only if tags exist
            if tags_list:
                for tag in tags_list:
                    cursor.execute("INSERT IGNORE INTO Tags (name) VALUES (%s)", (tag,))
                    cursor.execute(
                        "INSERT INTO Post_Tags (post_id, tag_id) VALUES (%s, (SELECT id FROM Tags WHERE name = %s))",
                        (post_id, tag)
                    )

            # Commit the transaction to the database
            db.commit()

        else:
            print('Failed to retrieve webpage')
    except Exception as e:
        print("An error occurred:", e)
        db.rollback()  # Rollback the changes if any exception occurs

# Execute the SQL query to retrieve URLs
cursor.execute("SELECT url, image FROM temp")
urls = cursor.fetchall()

# Loop through each URL and scrape the content
for url_tuple in urls:
    url = url_tuple[0]
    image_url = url_tuple[1]
    scrape_url(url, image_url)

# Close the cursor and database connection
cursor.close()
db.close()
