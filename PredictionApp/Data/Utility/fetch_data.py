import urllib.request
import json
import ssl

ssl._create_default_https_context = ssl._create_unverified_context

with urllib.request.urlopen('https://data.gov.ro/api/3/action/package_search?fq=organization:agentia-nationala-pentru-ocuparea-fortei-de-munca') as json_url:
    packages_count = json.loads(json_url.read())['result']['count']

with urllib.request.urlopen(f'https://data.gov.ro/api/3/action/package_search?fq=organization:agentia-nationala-pentru-ocuparea-fortei-de-munca&rows={packages_count}') as json_url:
    packages_list = json.loads(json_url.read())['result']['results']

resources_list = [
    resource
    for package in packages_list
        if ('somaj' in package['name'].lower()) 
        for resource in package['resources']
            if ('csv' in resource['format'].lower())
]

print(
    * [
        resource['name']
        for resource in resources_list
    ],
    sep = '\n'
);