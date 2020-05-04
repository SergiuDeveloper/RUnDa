#!/usr/bin/python3

from types import MethodType
from typing import List

class Regression:
    def __init__(self):
        if type(getattr(self, 'train')) is not MethodType:
            raise TypeError
        if type(getattr(self, 'train')()) is not type(List[float]):
            raise TypeError