#!/usr/bin/python3

from Environment import Environment

from typing import List, Tuple

environment: Environment = Environment('Data', 'Plots')

environment.linear_regression()
environment.polynomial_regression()
environment.logistic_polynomial_regression()