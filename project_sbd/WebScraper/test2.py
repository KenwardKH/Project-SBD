import requests
from bs4 import BeautifulSoup
import re

# URL of the webpage
url = 'https://www.divergenttravelers.com/giant-panda-volunteers-china/'

# Send a GET request to the webpage
response = requests.get(url)

# Parse the HTML content
soup = BeautifulSoup(response.text, 'html.parser')

# Find the first element with the class '.page-hero'
page_hero_element = soup.find(class_='page-hero')

# Initialize background image URL
bg_image_url = None

# Extract background image URL from the style attribute of the page-hero element
if page_hero_element:
    style_attr = page_hero_element.get('style')
    if style_attr:
        # Search for background image URL within style attribute using regular expression
        url_match = re.search(r'url\((.*?)\)', style_attr)
        if url_match:
            bg_image_url = url_match.group(1)

if bg_image_url:
    print("Background image URL:", bg_image_url)
else:
    print(style_attr)
