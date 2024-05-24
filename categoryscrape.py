import requests
from bs4 import BeautifulSoup

# URL dari halaman yang ingin di-scrape
url = 'https://www.divergenttravelers.com/travel-guides/'

# Mengirim permintaan HTTP ke halaman tersebut
response = requests.get(url)

# Mengecek apakah permintaan berhasil
if response.status_code == 200:
    # Menguraikan konten HTML
    soup = BeautifulSoup(response.text, 'html.parser')
    
    # Menemukan elemen dropdown utama
    dropdown = soup.find('li', class_='menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-47948')

    if dropdown:
        # Menemukan semua item di dalam dropdown
        categories = []

        def parse_menu(item, parent_id=None):
            # Mengambil nama kategori
            a_tag = item.find('a')
            if a_tag:
                category_name = a_tag.text.strip()
                category_id = len(categories) + 86 # Generate an ID for this category
                categories.append((category_id, category_name, parent_id))

                # Mencari sub-kategori (jika ada)
                sub_items = item.find('ul')
                if sub_items:
                    sub_items = sub_items.find_all('li', recursive=False)
                    for sub_item in sub_items:
                        parse_menu(sub_item, category_id)

        # Memulai parsing dari root dropdown
        parse_menu(dropdown)

        # Menampilkan semua kategori yang ditemukan beserta parent-child relationship
        for category in categories:
            print(f"('{category[0]}', '{category[1]}','{category[2]}'),")
    else:
        print('Dropdown menu tidak ditemukan di halaman tersebut.')
else:
    print('Gagal mengakses halaman web.')
