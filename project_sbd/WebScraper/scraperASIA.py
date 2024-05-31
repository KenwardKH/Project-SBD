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
                else:
                    title = 'N/A'
                    full_url = 'N/A'

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
            # Commit the transaction to the database after processing all articles
            db.commit()

        else:
            print('Failed to retrieve webpage')
    except Exception as e:
        print("An error occurred:", e)
        db.rollback()  # Rollback the changes if any exception occurs

# Base URL for the paginated pages
base_url = 'https://www.divergenttravelers.com/category/asia/page/'

# Iterate through all pages (1 to 17)
for page in range(1, 7):
    url = f"{base_url}{page}/"
    scrape_url(url)

cursor.close()
db.close()
