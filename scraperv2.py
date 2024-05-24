import requests
from bs4 import BeautifulSoup
import mysql.connector

# Connect to MySQL database
db = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="self_ref_test"
)
cursor = db.cursor()

# URL of the website to scrape
def scrape_url(url):
    try:
        # Fetch the webpage content
        response = requests.get(url)
    
        # Check if the response was successful (status code 200)
        if response.status_code == 200:
            # Convert the webpage content to a BeautifulSoup object
            soup = BeautifulSoup(response.text, 'html.parser')
            
            # Find all articles
            articles = soup.find_all('article')
            
            for article in articles:
                # Find the article title
                title_tag = article.find('h2', class_='entry-title')
                title = title_tag.text.strip() if title_tag else 'N/A'
                
                # Find the post meta information containing "Posted in" and categories
                post_meta = article.find('div', class_='kt-blocks-post-top-meta')
                if post_meta:
                    # Find all categories in this article
                    categories = post_meta.find_all('a', rel='category tag')
                    category_list = [cat.text.strip().replace(' Travel', '') for cat in categories]  # Remove ' Travel' from category names
                else:
                    category_list = []

                # Find additional tags at the bottom of the article
                tags_meta = article.find('div', class_='kt-blocks-tags kt-blocks-post-footer-section')
                if tags_meta:
                    tags = tags_meta.find_all('a', rel='tag')
                    tags_list = [tag.text.strip() for tag in tags]
                else:
                    tags_list = []

                # Find the image URL
                image_tag = article.find('img')
                image_url = image_tag['data-lazy-srcset'].split(',')[0].split()[0] if image_tag and 'data-lazy-srcset' in image_tag.attrs else 'No image'

                # Insert into Posts table
                cursor.execute(
                    "INSERT IGNORE INTO Posts (title, image) VALUES (%s, %s)",
                    (title, image_url)
                )
                post_id = cursor.lastrowid  # Get the ID of the last inserted row

                # Insert into Categories and PostCategories
                for category in category_list:
                    cursor.execute("INSERT IGNORE INTO Categories (name) VALUES (%s)", (category,))
                    cursor.execute(
                        "INSERT INTO Post_Categories (post_id, category_id) VALUES (%s, (SELECT id FROM Categories WHERE name = %s))",
                        (post_id, category)
                    )

                # Insert into Tags and PostTags
                for tag in tags_list:
                    cursor.execute("INSERT IGNORE INTO Tags (name) VALUES (%s)", (tag,))
                    cursor.execute(
                        "INSERT INTO Post_Tags (post_id, tag_id) VALUES (%s, (SELECT id FROM Tags WHERE name = %s))",
                        (post_id, tag)
                    )

            # Commit the transaction to the database after processing all articles
            db.commit()

        else:
            print('Failed to retrieve webpage')
    except Exception as e:
        print("An error occurred:", e)
        db.rollback()  # Rollback the changes if any exception occurs
    # finally:
        # Close the cursor and connection
        

# Call the function with URLs to scrape
scrape_url('https://www.divergenttravelers.com/travel-itineraries/')
scrape_url('https://www.divergenttravelers.com/travel-inspiration/')
scrape_url('https://www.divergenttravelers.com/cultural-experiences/')
scrape_url('https://www.divergenttravelers.com/cruise-travel/')
scrape_url('https://www.divergenttravelers.com/hiking-trips/')
scrape_url('https://www.divergenttravelers.com/best-kayaking-adventures/')
scrape_url('https://www.divergenttravelers.com/polar-expedition-travel/')
scrape_url('https://www.divergenttravelers.com/road-trips/')
scrape_url('https://www.divergenttravelers.com/tropical-destinations/')
scrape_url('https://www.divergenttravelers.com/wildlife-experiences/')
cursor.close()
db.close()