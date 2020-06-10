#!/usr/bin/python3

from urllib.request import urlopen
from unicodedata import normalize
from json import loads
from typing import List, Dict, Set, Any
from os import mkdir, walk, remove, rename
from os.path import exists, join
from requests.packages.urllib3.exceptions import InsecureRequestWarning
from csv import writer, QUOTE_ALL
from xlrd import open_workbook, book, sheet
import requests
import ssl

class DataFetcher():
    @staticmethod
    def write_csv_data_to_file_system() -> None:
        requests.packages.urllib3.disable_warnings(InsecureRequestWarning)

        resources_list: List[Dict[str, Any]] = DataFetcher.__get_resources_list()

        category_date_linker_keyword: str = 'LA'
        months: Dict[str, int] = {
            'IANUARIE':     1,
            'FEBRUARIE':    2,
            'MARTIE':       3,
            'APRILIE':      4,
            'MAI':          5,
            'IUNIE':        6,
            'IULIE':        7,
            'AUGUST':       8,
            'SEPTEMBRIE':   9,
            'OCTOMBRIE':    10,
            'NOIEMBRIE':    11,
            'DECEMBRIE':    12
        }

        strings_to_replace: List[str] = [
            'NUMAR SOMERI',
            'NUMARUL SOMERILOR',
            'IN FUNCTIE DE',
            ' SI ',
            'STRUCTURATI',
            ' PE '
        ]

        if not exists(f'Data'):
            mkdir(f'Data')

        category_name: str
        month: int
        year: int

        resource_name: str
        month_year_strings: List[str]
        last_year: int
        csv_online_content: requests.models.Response
        for resource in resources_list:
            resource_name = normalize('NFD', resource['name']).encode('ascii', 'ignore').decode('latin-1').upper()
            for string_to_replace in strings_to_replace:
                resource_name = resource_name.replace(string_to_replace, '')
            resource_name.strip()
            month_year_strings = [month_year_string.strip() for month_year_string in resource_name.split()[-2:]]

            category_name = resource_name.split(category_date_linker_keyword)[0].replace('/', ' SI ').strip()

            try:
                month = months[month_year_strings[0]]
                year = int(month_year_strings[1])
            except:
                month = months[month_year_strings[1]]
                year = last_year

            last_year = year

            if not exists(f'Data/{category_name}'):
                mkdir(f'Data/{category_name}')
            if not exists(f'Data/{category_name}/{year}'):
                mkdir(f'Data/{category_name}/{year}')
            if not exists(f'Data/{category_name}/{year}/{month}'):
                mkdir(f'Data/{category_name}/{year}/{month}')

            for root, directories, files in walk(f'Data/{category_name}/{year}/{month}', topdown = False):
                for file in files:
                    remove(join(root, file))
                for directory in directories:
                    rmdir(join(root, directory))

            csv_online_content = requests.get(resource['datagovro_download_url'], verify = False)

            try:
                with open(f'Data/{category_name}/{year}/{month}/Data.csv', 'w', encoding = 'latin-1') as csv_file:
                    csv_file.write(csv_online_content.text.replace(', DIN CARE:', ''))
            except:
                with open(f'Data/{category_name}/{year}/{month}/Data.csv', 'wb') as csv_file:
                    csv_file.write(csv_online_content.content)

                DataFetcher.__xls_to_csv(f'Data/{category_name}/{year}/{month}/Data.csv', f'Data/{category_name}/{year}/{month}/Data2.csv')
                
                remove(f'Data/{category_name}/{year}/{month}/Data.csv')
                rename(f'Data/{category_name}/{year}/{month}/Data2.csv', f'Data/{category_name}/{year}/{month}/Data.csv')

                with open(f'Data/{category_name}/{year}/{month}/Data.csv', 'r') as file:
                    csv_file_content = file.read().replace(', DIN CARE:', '')

                with open(f'Data/{category_name}/{year}/{month}/Data.csv', 'w') as file:
                    file.write(csv_file_content)

    @staticmethod
    def __get_resources_list() -> List[Dict[str, Any]]:
        ssl._create_default_https_context = ssl._create_unverified_context

        packages_count: int
        with urlopen('https://data.gov.ro/api/3/action/package_search?fq=organization:agentia-nationala-pentru-ocuparea-fortei-de-munca') as json_url:
            packages_count = loads(json_url.read())['result']['count']

        with urlopen(f'https://data.gov.ro/api/3/action/package_search?fq=organization:agentia-nationala-pentru-ocuparea-fortei-de-munca&rows={packages_count}') as json_url:
            packages_list: List[Dict[str, Any]] = loads(json_url.read())['result']['results']

        resources_list: List[Dict[str, Any]] = [
            resource
            for package in packages_list
            if 'somaj' in package['name'].lower()
            for resource in package['resources']
            if 'csv' in resource['format'].lower()
        ]

        return resources_list

    @staticmethod
    def __xls_to_csv(
        xls_file_path:  str,
        csv_file_path:  str
    ) -> None:
        xls_workbook: book.Book = open_workbook(xls_file_path)
        xls_sheet: sheet.Sheet = xls_workbook.sheet_by_index(0)

        with open(csv_file_path, 'w') as csv_file:
            for row_number in range(xls_sheet.nrows):
                csv_writer = writer(csv_file, quoting = QUOTE_ALL)
                csv_writer.writerow(xls_sheet.row_values(row_number))