#!/usr/bin/python3

from Regression import Regression

from typing import List, Tuple
from math import log

class LogisticPolynomialRegression(Regression):
    @staticmethod
    def train(
        data_list:      List[Tuple[int, float]],
        epochs:         int,
        learning_rate:  float
    ) -> Tuple[Tuple[float, float, float], Tuple[int, float]]:
        normalization_result: Tuple[List[float, float], Tuple[int, float]] = LogisticPolynomialRegression._Regression__normalize(data_list)
        data_list = normalization_result[0]
        data_subtrahend: Tuple[int, float] = normalization_result[1]

        coefficients_tuple: Tuple[float, float, float] = (LogisticPolynomialRegression.__compute_optimal_initial_coefficients(data_list))
        w0: float = coefficients_tuple[0]
        p0: float = coefficients_tuple[1]
        b: float = coefficients_tuple[2]

        for epoch in range(epochs):
            coefficients_tuple = LogisticPolynomialRegression.__update_coefficients(data_list, learning_rate, w0, p0, b)
            w0 = coefficients_tuple[0]
            p0 = coefficients_tuple[1]
            b = coefficients_tuple[2]

        return ((w0, p0, b), data_subtrahend)

    @staticmethod
    def compute_function_result(
        x_value:    int,
        w0:         float,
        p0:         float,
        b:          float
    ) -> float:
        function_result: float = b + w0 * (x_value ** p0)

        return function_result

    @staticmethod
    def __compute_optimal_initial_coefficients(
        data_list: List[Tuple[int, float]]
    ) -> Tuple[float, float, float]:
        w0: float = (data_list[0][1] - data_list[1][1]) / (data_list[0][0] - data_list[1][0])
        p0: float = 1
        b: float = data_list[0][1] - data_list[0][0] * w0

        return (w0, p0, b)

    @staticmethod
    def __update_coefficients(
        data_list:      List[Tuple[int, float]],
        learning_rate:  float,
        w0:             float,
        p0:             float,
        b:              float
    ) -> Tuple[float, float, float]:
        gradient: Tuple[float, float, float] = LogisticPolynomialRegression.__compute_gradient(data_list, w0, p0, b)
        w0_derivative: float = gradient[0]
        p0_derivative: float = gradient[1]
        b_derivative: float = gradient[2]

        w0 -= learning_rate * LogisticPolynomialRegression.__coefficient_modification_rate(w0_derivative)
        p0 -= learning_rate * LogisticPolynomialRegression.__coefficient_modification_rate(p0_derivative)
        b -= learning_rate * LogisticPolynomialRegression.__coefficient_modification_rate(b_derivative)

        return (w0, p0, b)

    @staticmethod
    def __compute_gradient(
        data_list:  List[Tuple[int, float]],
        w0:         float,
        p0:         float,
        b:          float
    ) -> Tuple[float, float, float]:
        w0_derivative: float = 0
        p0_derivative: float = 0
        b_derivative: float = 0

        for data in data_list:
            function_result: float = LogisticPolynomialRegression.__compute_function_result(data[0], w0, p0, b)
            error: float = data[1] - function_result

            power_result = data[0] ** p0 if data[0] != 0 or p0 >= 0 else 0

            w0_derivative -= error * power_result / len(data_list)
            if data[0] != 0:
                p0_derivative -= error * data[0] * w0 * power_result * log(data[0]) / len(data_list)
            b_derivative -= error / len(data_list)

        return (w0_derivative, p0_derivative, b_derivative)

    @staticmethod
    def __compute_function_result(
        x_value:    float,
        w0:         float,
        p0:         float,
        b:          float
    ) -> float:
        power_result = x_value ** p0 if x_value != 0 or p0 >= 0 else 0

        return b + w0 * power_result

    @staticmethod
    def __coefficient_modification_rate(
        coefficient_derivative: float
    ) -> float:
        return (
            1 if coefficient_derivative >= 1 else (
                -1 if coefficient_derivative <= -1 else
                    coefficient_derivative
            )
        )