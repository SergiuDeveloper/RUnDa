#!/usr/bin/python3

from Environment import Environment
from csv import reader
from typing import List

environment: Environment = Environment()

data:       float = None
location:   str = None
category:   str = None
year:       int = 2019
month:      int = 4
categories: List[str] = []

location_column_name:   str = 'JUDET'
location_column_index:  int = None

with open('Data/medii-somaj-aprilie-2019.csv') as csv_file:
    csv_lines: List[str] = list(reader(csv_file))

    for category_index in range(len(csv_lines[0])):
        category = csv_lines[0][category_index]
        
        if category.startswith(location_column_name):
            location_column_index = category_index

        categories.append(category.lower())
    csv_lines.pop(0)

    for csv_line in csv_lines:
        location = csv_line[location_column_index]

        for element_index in range(len(csv_line)):
            if element_index is location_column_index:
                continue
                
            category = categories[element_index]
            data = csv_line[element_index]

            environment.add_to_data_dictionary(
                data,
                location,
                category,
                year,
                month
            )