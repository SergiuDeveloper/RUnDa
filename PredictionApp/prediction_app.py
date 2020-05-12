#!/usr/bin/python3

from Environment import Environment

from typing import List, Tuple

environment: Environment = Environment('Data')

linear_regression_training_results: List[Tuple[Tuple[str, str, str], Tuple[Tuple[float, float], Tuple[int, float]]]] = environment.linear_regression()
for linear_regression_training_result in linear_regression_training_results:
    print(linear_regression_training_result[0])
    print('\tWeights:', linear_regression_training_result[1][0])
    print('\tSubtrahend:', linear_regression_training_result[1][1])

'''logistic_polynomial_regression_training_results: List[Tuple[Tuple[str, str, str], Tuple[Tuple[float, float], Tuple[int, float]]]] = environment.logistic_polynomial_regression()
for logistic_polynomial_regression_training_result in logistic_polynomial_regression_training_results:
    print(logistic_polynomial_regression_training_result[0])
    print('\tWeights:', logistic_polynomial_regression_training_result[1][0])
    print('\tSubtrahend:', logistic_polynomial_regression_training_result[1][1])'''