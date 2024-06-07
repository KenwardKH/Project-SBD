import requests
from bs4 import BeautifulSoup
from urllib.parse import urlparse
import mysql.connector

# Connect to MySQL database
db = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="web_scraper"
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
                # Find the article title and url
                title_tag = article.find('h2', class_='entry-title')
                if title_tag:
                    title = title_tag.text.strip()
                    full_url = title_tag.find('a')['href'].strip()
                    url = full_url
                    # parsed_url = urlparse(full_url)
                    # url = parsed_url.path.strip('/').split('/')[-1]
                else:
                    title = 'N/A'
                    url = 'N/A'
                image_tag = article.find('img')
                image_url = image_tag['data-lazy-srcset'].split(',')[0].split()[0] if image_tag and 'data-lazy-srcset' in image_tag.attrs else 'No image'

                # Check if the title already exists in the database
                cursor.execute("SELECT id FROM Posts WHERE title = %s", (title,))
                result = cursor.fetchone()
                
                if result:
                    # If title exists, skip this article
                    continue
                
                
                # Insert into Posts table
                cursor.execute(
                    "INSERT IGNORE INTO Posts (title, url, image) VALUES (%s, %s, %s)",
                    (title, url, image_url)
                )
                # post_id = cursor.lastrowid  # Get the ID of the last inserted row

                # # Insert into Categories and PostCategories
                # for category in category_list:
                #     cursor.execute("INSERT IGNORE INTO Categories (name) VALUES (%s)", (category,))
                #     cursor.execute(
                #         "INSERT INTO Post_Categories (post_id, category_id) VALUES (%s, (SELECT id FROM Categories WHERE name = %s))",
                #         (post_id, category)
                #     )

                # # Insert into Tags and PostTags
                # for tag in tags_list:
                #     cursor.execute("INSERT IGNORE INTO Tags (name) VALUES (%s)", (tag,))
                #     cursor.execute(
                #         "INSERT INTO Post_Tags (post_id, tag_id) VALUES (%s, (SELECT id FROM Tags WHERE name = %s))",
                #         (post_id, tag)
                #     )

            # Commit the transaction to the database after processing all articles
            db.commit()

        else:
            print('Failed to retrieve webpage')
    except Exception as e:
        print("An error occurred:", e)
        db.rollback()  # Rollback the changes if any exception occurs
    # finally:
        # Close the cursor and connection

# Example usage

# Call the function with URLs to scrape
scrape_url('https://www.divergenttravelers.com/category/oceania/page/1')
scrape_url('https://www.divergenttravelers.com/category/oceania/page/2')
scrape_url('https://www.divergenttravelers.com/category/oceania/page/3')
scrape_url('https://www.divergenttravelers.com/category/oceania/page/4')
scrape_url('https://www.divergenttravelers.com/category/oceania/page/5')
scrape_url('https://www.divergenttravelers.com/category/oceania/page/6')
scrape_url('https://www.divergenttravelers.com/category/oceania/page/7')
scrape_url('https://www.divergenttravelers.com/category/oceania/page/8')
scrape_url('https://www.divergenttravelers.com/category/trip-ideas/page/1')
scrape_url('https://www.divergenttravelers.com/category/trip-ideas/page/2')
scrape_url('https://www.divergenttravelers.com/category/trip-ideas/page/3')
scrape_url('https://www.divergenttravelers.com/category/trip-ideas/page/4')
scrape_url('https://www.divergenttravelers.com/tag/tropics/page/1')
scrape_url('https://www.divergenttravelers.com/tag/tropics/page/2')
scrape_url('https://www.divergenttravelers.com/tag/tropics/page/3')
scrape_url('https://www.divergenttravelers.com/tag/tropics/page/4')
scrape_url('https://www.divergenttravelers.com/tag/tropics/page/5')
scrape_url('https://www.divergenttravelers.com/tag/tropics/page/6')
scrape_url('https://www.divergenttravelers.com/tag/tropics/page/7')

# scrape_url('')
# scrape_url('')
# scrape_url('')



cursor.close()
db.close()
