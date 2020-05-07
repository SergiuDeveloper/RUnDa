#!/usr/bin/python3

from types import MethodType
from typing import List, Tuple

class Regression():
    def __init__(self):
        if type(getattr(self, 'train')) is not MethodType:
            raise TypeError
        if type(getattr(self, 'train')()) is not type(List[float]):
            raise TypeError

    @staticmethod
    def __normalize(
        data_list: List[Tuple[float, float]]
    ) -> Tuple[List[Tuple[float, float]], float]:
        data_subtrahend: float = min([data[0] for data in data_list])
        data_list = [(data[0] - data_subtrahend, data[1]) for data in data_list]

        return (data_list, data_subtrahend)

    #Eliminate bad data