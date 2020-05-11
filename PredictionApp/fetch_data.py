#!/usr/bin/python3

from urllib.request import urlopen
from unicodedata import normalize
from json import loads
from typing import List, Dict, Set, Any
import ssl

ssl._create_default_https_context = ssl._create_unverified_context

packages_count: int
with urlopen('https://data.gov.ro/api/3/action/package_search?fq=organization:agentia-nationala-pentru-ocuparea-fortei-de-munca') as json_url:
    packages_count = loads(json_url.read())['result']['count']

with urlopen(f'https://data.gov.ro/api/3/action/package_search?fq=organization:agentia-nationala-pentru-ocuparea-fortei-de-munca&rows={packages_count}') as json_url:
    packages_list: List[Dict[str, Any]] = loads(json_url.read())['result']['results']

resources_list: List[Dict[str, Any]] = [
    resource
    for package in packages_list
    if ('somaj' in package['name'].lower()) 
    for resource in package['resources']
    if ('csv' in resource['format'].lower())
]

categories: Set[str] = set()
category_date_linker_keyword: str = ' LA'

resource_name: str
category_name: str
for resource in resources_list:
    resource_name = normalize('NFD', resource['name']).encode('ascii', 'ignore').decode("utf-8").upper()
    category_name = resource_name.partition(category_date_linker_keyword)[0]
    categories.add(category_name)
    #print(resource['datagovro_download_url'])

print(* categories, sep = '\n')