import requests
from bs4 import BeautifulSoup
import mysql.connector

# Connect to MySQL database
db = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="project-sbd"
)
cursor = db.cursor()

# URL of the website to scrape
url = 'https://www.divergenttravelers.com/travel-itineraries/'

# Fetch the webpage image
response = requests.get(url)

# Check if the response was successful (status code 200)
if response.status_code == 200:
    # Convert the image to a BeautifulSoup object
    soup = BeautifulSoup(response.text, 'html.parser')
    
    # Find all articles
    articles = soup.find_all('article')
    
    # Set to store processed article titles
    processed_titles = set()
    
    # Initialize post ID counter
    post_id_counter = 1

    for article in articles:
        # Find the article title
        title_tag = article.find('h2', class_='entry-title')
        title = title_tag.text.strip() if title_tag else 'N/A'
        
        # Ensure the title hasn't been processed before
        if title not in processed_titles:
            # Add title to processed_titles set
            processed_titles.add(title)
            
            # Find the post meta information containing "Posted in" and categories
            post_meta = article.find('div', class_='kt-blocks-post-top-meta')
            if post_meta:
                # Find all categories in this article
                categories = post_meta.find_all('a', rel='category tag')
                category_list = [cat.text.strip().replace(' Travel', '') for cat in categories]  # Remove ' Travel' from category names
                category_str = ', '.join(category_list) if category_list else 'N/A'
            else:
                category_str = 'N/A'
            
            # Find additional tags at the bottom of the article
            tags_meta = article.find('div', class_='kt-blocks-tags kt-blocks-post-footer-section')
            if tags_meta:
                tags = tags_meta.find_all('a', rel='tag')
                tags_list = [tag.text.strip() for tag in tags]
                tags_str = ', '.join(tags_list) if tags_list else 'N/A'
            else:
                tags_str = 'N/A'

            # Find the image URL
            image_tag = article.find('img')
            image_url = image_tag['data-lazy-srcset'].split(',')[0].split()[0] if image_tag and 'data-lazy-srcset' in image_tag.attrs else 'No image'

            # Insert into Posts table
            cursor.execute(
                "INSERT INTO Posts (id, title, image, date_posted) VALUES (%s, %s, %s, CURRENT_TIMESTAMP)",
                (post_id_counter, title, image_url)
            )

            # Insert into Categories and PostCategories
            for category in category_list:
                cursor.execute("INSERT IGNORE INTO Categories (name) VALUES (%s)", (category,))
                cursor.execute(
                    "INSERT INTO Post_Categories (post_id, category_id) VALUES (%s, (SELECT id FROM Categories WHERE name = %s))",
                    (post_id_counter, category)
                )

            # Insert into Tags and PostTags
            for tag in tags_list:
                cursor.execute("INSERT IGNORE INTO Tags (name) VALUES (%s)", (tag,))
                cursor.execute(
                    "INSERT INTO Post_Tags (post_id, tag_id) VALUES (%s, (SELECT id FROM Tags WHERE name = %s))",
                    (post_id_counter, tag)
                )

            # Commit the transaction to the database
            db.commit()

            # Increment the post ID counter
            post_id_counter += 1

else:
    print('Failed to retrieve webpage')

# Close the cursor and connection
cursor.close()
db.close()
