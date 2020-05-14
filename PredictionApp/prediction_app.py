#!/usr/bin/python3

from Environment import Environment

from typing import List, Tuple

if __name__ == '__main__':
    environment: Environment = Environment('Data', 'Plots', 'Logs')

    environment.begin_log()

    environment.linear_regression(100000, 0.1)
    environment.polynomial_regression(10000, 0.1, 10, 100)
    environment.logistic_polynomial_regression(100000, 0.1)

    environment.end_log()