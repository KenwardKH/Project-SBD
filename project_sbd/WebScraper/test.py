import requests
from bs4 import BeautifulSoup
from urllib.parse import urlparse
import mysql.connector
count = 1
def scrape(url,count):
    response = requests.get(url)
    soup = BeautifulSoup(response.content, 'html.parser')

    # Extracting the title
    title = soup.find('div', class_='inside-page-hero grid-container grid-parent').text

    # Extracting the author
    author = soup.find('span', class_='author-name').text

    # Extracting the date posted
    date_element = soup.find('time', class_='updated')
    date_posted = date_element['datetime']
    # Extracting the category
    category = soup.find('span', class_='cat-links').text.strip()

    # Extracting the tags
    tags_section = soup.find('span', class_='tags-links')
    tags = [tag.text for tag in tags_section.find_all('a')] if tags_section else []
    print(count)
    print(f"Title: {title}")
    print(f"Author: {author}")
    print(f"Date Posted: {date_posted}")
    print(f"Category: {category}")
    print(f"Tags: {', '.join(tags)}\n")
    count+=1
    return count

db = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="tubes_sbd"
)
cursor = db.cursor()
cursor.execute("SELECT url FROM temp")
urls = cursor.fetchall()

# Loop through each URL and scrape the content
for url_tuple in urls:
    url = url_tuple[0]
    count=scrape(url,count)
    
# Close the cursor and database connection
cursor.close()
db.close()
