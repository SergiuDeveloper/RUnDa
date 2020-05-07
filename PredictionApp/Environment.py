#!/usr/bin/python3

from typing import List, Dict, Tuple

class Environment():
    def __init__(self):
        self.__data_dictionary: Dict[Tuple[str, str], Dict[Tuple[int, int], float]] = {}

    def add_to_data_dictionary(self,
        data:       float,
        location:   str,
        category:   str,
        year:       int,
        month:      int
    ):
        if (location, category) not in self.__data_dictionary:
            self.__data_dictionary[(location, category)] = {}
        if (year, month) in self.__data_dictionary[(location, category)]:
            raise ValueError
        self.__data_dictionary[(location, category)][(year, month)] = data

    @classmethod
    def empty_data_dictionary(self) -> None:
        self.__data_dictionary.clear()