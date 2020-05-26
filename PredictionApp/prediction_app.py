#!/usr/bin/python3

from Environment import Environment
from DataFetcher import DataFetcher

from requests import post
from typing import List, Tuple, Any

if __name__ == '__main__':
    DataFetcher.write_csv_data_to_file_system()

    environment: Environment = Environment('Data', 'JSON', 'Plots', 'Logs')

    environment.begin_log()

    linear_regression_training_results: List[Tuple[Any]] = environment.linear_regression(100000, 0.1)
    polynomial_regression_training_results: List[Tuple[Any]] = environment.polynomial_regression(10000, 0.1, 10, 100)
    logistic_polynomial_regression_training_results: List[Tuple[Any]] = environment.logistic_polynomial_regression(100000, 0.1)

    environment.end_log()

    training_results_json_object: Dict[str, Dict[str, Dict[str, Dict[str, Dict[str, Any]]]]] = environment.create_training_results_json(
        [
            (linear_regression_training_results, 'Linear'),
            (polynomial_regression_training_results, 'Polynomial'),
            (logistic_polynomial_regression_training_results, 'Logistic Polynomial')
        ]
    )

    post('localhost/UpdateTrainingResults', training_results_json_object)