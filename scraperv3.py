import requests
from bs4 import BeautifulSoup
import mysql.connector

# Connect to MySQL database
db = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="tubes_sbd"
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
                title_tag = article.find('h3', class_='entry-title')
                title = title_tag.text.strip() if title_tag else 'N/A'
                
                # Check if the title already exists in the database
                cursor.execute("SELECT id FROM Posts WHERE title = %s", (title,))
                result = cursor.fetchone()
                
                if result:
                    # If title exists, skip this article
                    continue
                
                # Find the post meta information containing "Posted in" and categories
                post_meta = article.find('div', class_='kt-blocks-categories kt-blocks-post-footer-section')
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



# Call the function with URLs to scrape
scrape_url('https://www.divergenttravelers.com/africa-travel-guide/')
scrape_url('https://www.divergenttravelers.com/travel-guides/antarctica-travel-planning/')
scrape_url('https://www.divergenttravelers.com/asia-travel-guide/')
scrape_url('https://www.divergenttravelers.com/southeast-asia-travel-guide/')
scrape_url('https://www.divergenttravelers.com/caribbean-islands-travel-guide/')
scrape_url('https://www.divergenttravelers.com/central-america-travel-guide/')
scrape_url('https://www.divergenttravelers.com/europe-travel-planner/')
scrape_url('https://www.divergenttravelers.com/middle-east-travel-guide/')
scrape_url('https://www.divergenttravelers.com/north-america-travel-guide/')
scrape_url('https://www.divergenttravelers.com/oceania-travel-guide/')
scrape_url('https://www.divergenttravelers.com/south-america-travel-guide/')
scrape_url('https://www.divergenttravelers.com/travel-guides/travel-the-usa/')
scrape_url('https://www.divergenttravelers.com/travel-guides/alaska-travel-tips/')
scrape_url('https://www.divergenttravelers.com/travel-guides/hawaii-travel-tips/')
scrape_url('https://www.divergenttravelers.com/travel-photography/')
scrape_url('https://www.divergenttravelers.com/travel-guides/egypt-travel-tips/')
scrape_url('https://www.divergenttravelers.com/travel-guides/backpacking-jordan-travel/')
scrape_url('https://www.divergenttravelers.com/travel-guides/travel-to-turkey/')
scrape_url('https://www.divergenttravelers.com/travel-guides/travel-in-morocco/')
scrape_url('https://www.divergenttravelers.com/travel-guides/mexico-travel-tips/')
scrape_url('https://www.divergenttravelers.com/travel-guides/travel-to-australia/')
scrape_url('https://www.divergenttravelers.com/travel-guides/travel-to-new-zealand/')
scrape_url('https://www.divergenttravelers.com/travel-guides/fiji-travel-tips/')
scrape_url('https://www.divergenttravelers.com/travel-guides/argentina-travel/')
scrape_url('https://www.divergenttravelers.com/travel-guides/brazil-travel/')
scrape_url('https://www.divergenttravelers.com/travel-guides/chile-travel/')
scrape_url('https://www.divergenttravelers.com/travel-guides/colombia-travel/')
scrape_url('https://www.divergenttravelers.com/travel-guides/ecuador-travel/')
scrape_url('https://www.divergenttravelers.com/travel-guides/peru-travel/')
scrape_url('https://www.divergenttravelers.com/things-to-do-in-venezuela/')
# scrape_url('')

# scrape_url('')

cursor.close()
db.close()