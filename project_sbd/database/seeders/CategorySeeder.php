<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    //     $data = [
    //         ['id' => '1', 'name' => 'DESTINATIONS', 'parent_id' => NULL],
    //         ['id' => '2', 'name' => 'WORLDWIDE', 'parent_id' => '1'],
    //         ['id' => '3', 'name' => 'AFRICA', 'parent_id' => '1'],
    //         ['id' => '4', 'name' => 'BOTSWANA', 'parent_id' => '3'],
    //         ['id' => '5', 'name' => 'ETHIOPIA', 'parent_id' => '3'],
    //         ['id' => '6', 'name' => 'KENYA', 'parent_id' => '3'],
    //         ['id' => '7', 'name' => 'MALAWI', 'parent_id' => '3'],
    //         ['id' => '8', 'name' => 'NAMIBIA', 'parent_id' => '3'],
    //         ['id' => '9', 'name' => 'RWANDA', 'parent_id' => '3'],
    //         ['id' => '10', 'name' => 'SOUTH AFRICA', 'parent_id' => '3'],
    //         ['id' => '11', 'name' => 'TANZANIA', 'parent_id' => '3'],
    //         ['id' => '12', 'name' => 'ZIMBABWE', 'parent_id' => '3'],
    //         ['id' => '13', 'name' => 'ANTARCTICA', 'parent_id' => '1'],
    //         ['id' => '14', 'name' => 'ASIA', 'parent_id' => '1'],
    //         ['id' => '15', 'name' => 'CHINA', 'parent_id' => '14'],
    //         ['id' => '16', 'name' => 'HONG KONG', 'parent_id' => '14'],
    //         ['id' => '17', 'name' => 'INDIA', 'parent_id' => '14'],
    //         ['id' => '18', 'name' => 'KYRGYZSTAN', 'parent_id' => '14'],
    //         ['id' => '19', 'name' => 'MACAU', 'parent_id' => '14'],
    //         ['id' => '20', 'name' => 'MALDIVES', 'parent_id' => '14'],
    //         ['id' => '21', 'name' => 'RUSSIA', 'parent_id' => '14'],
    //         ['id' => '22', 'name' => 'SOUTH KOREA', 'parent_id' => '14'],
    //         ['id' => '23', 'name' => 'SRI LANKA', 'parent_id' => '14'],
    //         ['id' => '24', 'name' => 'TIBET', 'parent_id' => '14'],
    //         ['id' => '25', 'name' => 'TURKMENISTAN', 'parent_id' => '14'],
    //         ['id' => '26', 'name' => 'UZBEKISTAN', 'parent_id' => '14'],
    //         ['id' => '27', 'name' => 'SOUTHEAST ASIA', 'parent_id' => '1'],
    //         ['id' => '28', 'name' => 'BORNEO', 'parent_id' => '27'],
    //         ['id' => '29', 'name' => 'CAMBODIA', 'parent_id' => '27'],
    //         ['id' => '30', 'name' => 'INDONESIA', 'parent_id' => '27'],
    //         ['id' => '31', 'name' => 'MALAYSIA', 'parent_id' => '27'],
    //         ['id' => '32', 'name' => 'MYANMAR', 'parent_id' => '27'],
    //         ['id' => '33', 'name' => 'PHILIPPINES', 'parent_id' => '27'],
    //         ['id' => '34', 'name' => 'SINGAPORE', 'parent_id' => '27'],
    //         ['id' => '35', 'name' => 'THAILAND', 'parent_id' => '27'],
    //         ['id' => '36', 'name' => 'VIETNAM', 'parent_id' => '27'],
    //         ['id' => '37', 'name' => 'CARIBBEAN', 'parent_id' => '1'],
    //         ['id' => '38', 'name' => 'CENTRAL AMERICA', 'parent_id' => '1'],
    //         ['id' => '39', 'name' => 'EUROPE', 'parent_id' => '1'],
    //         ['id' => '40', 'name' => 'NORDICS', 'parent_id' => '39'],
    //         ['id' => '41', 'name' => 'DENMARK', 'parent_id' => '40'],
    //         ['id' => '42', 'name' => 'FINLAND', 'parent_id' => '40'],
    //         ['id' => '43', 'name' => 'ICELAND', 'parent_id' => '40'],
    //         ['id' => '44', 'name' => 'NORWAY', 'parent_id' => '40'],
    //         ['id' => '45', 'name' => 'SWEDEN', 'parent_id' => '40'],
    //         ['id' => '46', 'name' => 'WESTERN EUROPE', 'parent_id' => '39'],
    //         ['id' => '47', 'name' => 'BELGIUM', 'parent_id' => '46'],
    //         ['id' => '48', 'name' => 'ENGLAND', 'parent_id' => '46'],
    //         ['id' => '49', 'name' => 'FRANCE', 'parent_id' => '46'],
    //         ['id' => '50', 'name' => 'IRELAND', 'parent_id' => '46'],
    //         ['id' => '51', 'name' => 'LUXEMBOURG', 'parent_id' => '46'],
    //         ['id' => '52', 'name' => 'NETHERLANDS', 'parent_id' => '46'],
    //         ['id' => '53', 'name' => 'SCOTLAND', 'parent_id' => '46'],
    //         ['id' => '54', 'name' => 'CENTRAL EUROPE', 'parent_id' => '39'],
    //         ['id' => '55', 'name' => 'CZECH REPUBLIC', 'parent_id' => '54'],
    //         ['id' => '56', 'name' => 'GERMANY', 'parent_id' => '54'],
    //         ['id' => '57', 'name' => 'HUNGARY', 'parent_id' => '54'],
    //         ['id' => '58', 'name' => 'POLAND', 'parent_id' => '54'],
    //         ['id' => '59', 'name' => 'SOUTHERN EUROPE', 'parent_id' => '39'],
    //         ['id' => '60', 'name' => 'ITALY', 'parent_id' => '59'],
    //         ['id' => '61', 'name' => 'SPAIN', 'parent_id' => '59'],
    //         ['id' => '62', 'name' => 'BALKANS', 'parent_id' => '39'],
    //         ['id' => '63', 'name' => 'CROATIA', 'parent_id' => '62'],
    //         ['id' => '64', 'name' => 'GREECE', 'parent_id' => '62'],
    //         ['id' => '65', 'name' => 'MONTENEGRO', 'parent_id' => '62'],
    //         ['id' => '66', 'name' => 'MIDDLE EAST', 'parent_id' => '1'],
    //         ['id' => '67', 'name' => 'EGYPT', 'parent_id' => '66'],
    //         ['id' => '68', 'name' => 'JORDAN', 'parent_id' => '66'],
    //         ['id' => '69', 'name' => 'MOROCCO', 'parent_id' => '66'],
    //         ['id' => '70', 'name' => 'TURKEY', 'parent_id' => '66'],
    //         ['id' => '71', 'name' => 'NORTH AMERICA', 'parent_id' => '1'],
    //         ['id' => '72', 'name' => 'CANADA', 'parent_id' => '71'],
    //         ['id' => '73', 'name' => 'GREENLAND', 'parent_id' => '71'],
    //         ['id' => '74', 'name' => 'MEXICO', 'parent_id' => '71'],
    //         ['id' => '75', 'name' => 'UNITED STATES', 'parent_id' => '71'],
    //         ['id' => '76', 'name' => 'OCEANIA', 'parent_id' => '1'],
    //         ['id' => '77', 'name' => 'AUSTRALIA', 'parent_id' => '76'],
    //         ['id' => '78', 'name' => 'EASTER ISLAND', 'parent_id' => '76'],
    //         ['id' => '79', 'name' => 'FIJI', 'parent_id' => '76'],
    //         ['id' => '80', 'name' => 'NEW ZEALAND', 'parent_id' => '76'],
    //         ['id' => '81', 'name' => 'SOUTH AMERICA', 'parent_id' => '1'],
    //         ['id' => '82', 'name' => 'ARGENTINA', 'parent_id' => '81'],
    //         ['id' => '83', 'name' => 'BRAZIL', 'parent_id' => '81'],
    //         ['id' => '84', 'name' => 'CHILE', 'parent_id' => '81'],
    //         ['id' => '85', 'name' => 'COLOMBIA', 'parent_id' => '81'],
    //         ['id' => '86', 'name' => 'ECUADOR', 'parent_id' => '81'],
    //         ['id' => '87', 'name' => 'PERU', 'parent_id' => '81'],
    //         ['id' => '88', 'name' => 'VENEZUELA', 'parent_id' => '81'],
    //         ['id' => '89', 'name' => 'WEST COAST USA', 'parent_id' => '75'],
    //         ['id' => '90', 'name' => 'ALASKA', 'parent_id' => '89'],
    //         ['id' => '91', 'name' => 'CALIFORNIA', 'parent_id' => '89'],
    //         ['id' => '92', 'name' => 'HAWAII', 'parent_id' => '89'],
    //         ['id' => '93', 'name' => 'MOUNTAIN USA', 'parent_id' => '75'],
    //         ['id' => '94', 'name' => 'COLORADO', 'parent_id' => '93'],
    //         ['id' => '95', 'name' => 'MONTANA', 'parent_id' => '93'],
    //         ['id' => '96', 'name' => 'WYOMING', 'parent_id' => '93'],
    //         ['id' => '97', 'name' => 'MIDWEST USA', 'parent_id' => '75'],
    //         ['id' => '98', 'name' => 'MINNESOTA', 'parent_id' => '97'],
    //         ['id' => '99', 'name' => 'NORTH DAKOTA', 'parent_id' => '97'],
    //         ['id' => '100', 'name' => 'WISCONSIN', 'parent_id' => '97'],
    //         ['id' => '101', 'name' => 'NORTHEAST USA', 'parent_id' => '75'],
    //         ['id' => '102', 'name' => 'NEW YORK', 'parent_id' => '101'],
    //         ['id' => '103', 'name' => 'SOUTHWEST USA', 'parent_id' => '75'],
    //         ['id' => '104', 'name' => 'ARIZONA', 'parent_id' => '103'],
    //         ['id' => '105', 'name' => 'NEVADA', 'parent_id' => '103'],
    //         ['id' => '106', 'name' => 'UTAH', 'parent_id' => '103'],
    //         ['id' => '107', 'name' => 'SOUTHEAST USA', 'parent_id' => '75'],
    //         ['id' => '108', 'name' => 'FLORIDA', 'parent_id' => '107'],
    //         ['id' => '109', 'name' => 'NORTH CAROLINA', 'parent_id' => '107'],
    //         ['id' => '110', 'name' => 'VIRGINIA', 'parent_id' => '107']
    //     ];
    //     foreach ($data as $item) {
    //         // Tambahkan perintah untuk menyimpan data ke dalam database
    //         Category::create([
    //             'id' => $item['id'],
    //             'name' => $item['name'],
    //             'parent_id' => $item['parent_id']
    //         ]);
        // }
    }
}
