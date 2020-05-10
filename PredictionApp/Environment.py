#!/usr/bin/python3

from csv import reader
from typing import List, Dict, Tuple, Union
from os import walk

class Environment():
    def __init__(self,
        data_folder: str
    ):
        self.__initialize(data_folder)

    def print_data_dictionary(self) -> None:
        print(self.__data_dictionary)

    def __initialize(self,
        data_folder: str
    ) -> None:
        self.__data_dictionary: Dict[Tuple[str, str, str], List[Tuple[int, Union[int, float]]]] = {}

        category:   str
        year:       int
        month:      int

        category_directories: List[str] = next(walk(f'{data_folder}'))[1]
        for category_directory in category_directories:
            category = category_directory

            year_directories: List[str] = next(walk(f'{data_folder}/{category_directory}'))[1]
            for year_directory in year_directories:
                year = int(year_directory)

                month_directories: List[str] = next(walk(f'{data_folder}/{category_directory}/{year_directory}'))[1]
                for month_directory in month_directories:
                    month = int(month_directory)

                    data_files: List[str] = next(walk(f'{data_folder}/{category_directory}/{year_directory}/{month_directory}'))[2]

                    for data_file in data_files:
                        data_file = f'{data_folder}/{category_directory}/{year_directory}/{month_directory}/{data_file}'
                        self.__get_data_from_file(data_file, category, year, month)

    @staticmethod
    def __validate_csv_data(
        csv_lines: List[List[str]]
    ) -> List[List[str]]:
        for csv_lines_index in range(len(csv_lines)):
            for csv_line_index in range(len(csv_lines[csv_lines_index])):
                csv_lines[csv_lines_index][csv_line_index] = csv_lines[csv_lines_index][csv_line_index].strip()

        csv_lines = [
            csv_line
            for csv_line in csv_lines
            if csv_line[0] is not ''
        ]

        empty_csv_column_indexes: List[int] = [
            column_index
            for column_index in range(len(csv_lines[0]))
            if csv_lines[0][column_index].strip() is ''
        ]
        csv_lines_valid: List[List[str]] = []
        csv_line_valid: List[str]
        element: str
        for csv_line in csv_lines:
            csv_line_valid = []

            for element_index in range(len(csv_line)):
                if element_index in empty_csv_column_indexes:
                    continue

                element = csv_line[element_index].strip()
                if element is '':
                    element = str(0)

                csv_line_valid.append(element)
                
            csv_lines_valid.append(csv_line_valid)

        return csv_lines_valid

    @staticmethod
    def __get_subcategories(
        csv_lines: List[List[str]],
    ) -> List[str]:
        subcategories: List[str] = []
        
        subcategory: str
        for subcategory_index in range(len(csv_lines[0])):
            subcategory = csv_lines[0][subcategory_index]

            subcategories.append(subcategory.lower())

        return subcategories

    @staticmethod
    def __get_location_column_index(
        csv_lines: List[List[str]],
    ) -> int:
        location_column_index:  int
        location_column_name:   str = 'JUDET'

        subcategory: str
        for subcategory_index in range(len(csv_lines[0])):
            subcategory = csv_lines[0][subcategory_index]
                
            if subcategory.upper().startswith(location_column_name):
                location_column_index = subcategory_index

        return location_column_index

    @staticmethod
    def __string_to_num(
        string_to_parse: str
    ) -> Union[int, float]:
        try:
            return int(string_to_parse)
        except:
            try:
                return float(string_to_parse)
            except:
                return None

    def __add_to_data_dictionary(self,
        category:       str,
        subcategory:    str,
        location:       str,
        xValue:         int,
        yValue:         Union[int, float]
    ):
        if (category, subcategory, location) not in self.__data_dictionary:
            self.__data_dictionary[(category, subcategory, location)] = []

        if len([
            data
            for data in self.__data_dictionary[(category, subcategory, location)]
            if data[0] is xValue
            ]):
            raise ValueError

        self.__data_dictionary[(category, subcategory, location)].append((xValue, yValue))

    def __get_data_from_file(self,
        data_file:      str,
        category:       str,
        year:           int,
        month:          int
    ) -> None:
        location:   str
        xValue:     int
        yValue:     Union[int, float]

        with open(data_file) as csv_file:
            csv_lines: List[List[str]] = list(reader(csv_file))
            csv_lines = Environment.__validate_csv_data(csv_lines)

            subcategories: List[str] = Environment.__get_subcategories(csv_lines)

            location_column_index: int = Environment.__get_location_column_index(csv_lines)
            
            csv_lines.pop(0)

            for csv_line in csv_lines:
                location = csv_line[location_column_index]

                for element_index in range(len(csv_line)):
                    if element_index is location_column_index:
                        continue

                    subcategory = subcategories[element_index]
                    xValue = year * 12 + month
                    yValue = Environment.__string_to_num(csv_line[element_index])
                    if yValue is None:
                        continue

                    self.__add_to_data_dictionary(
                        category,
                        subcategory,
                        location,
                        xValue,
                        yValue
                    )