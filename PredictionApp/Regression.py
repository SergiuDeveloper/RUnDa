#!/usr/bin/python3

from types import MethodType
from typing import List, Tuple

class Regression():
    def __init__(self):
        if type(getattr(self, 'train')) is not MethodType:
            raise TypeError
        if type(getattr(self, 'compute_function_result')) is not MethodType:
            raise TypeError

    @staticmethod
    def __normalize(
        data_list: List[Tuple[int, float]]
    ) -> Tuple[List[Tuple[int, float]], Tuple[int, float]]:
        data_subtrahend: Tuple[int, float] = (
            min([data[0] for data in data_list]) - 1,
            min([data[1] for data in data_list])
        )

        data_list = [(data[0] - data_subtrahend[0], data[1] - data_subtrahend[1]) for data in data_list]

        return (data_list, data_subtrahend)