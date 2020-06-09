#!/usr/bin/python3

from Regression import Regression

from typing import List, Tuple, Union

class LinearRegression(Regression):
    @staticmethod
    def train(
        data_list:      List[Tuple[int, float]],
        epochs:         int,
        learning_rate:  float
    ) -> Tuple[Tuple[float, float], Tuple[int, Union[int, float]], float]:
        normalization_result: Tuple[List[Tuple[int, float]], Tuple[int, Union[int, float]]] = LinearRegression._Regression__normalize(data_list)
        data_list = normalization_result[0]
        data_subtrahend: Tuple[int, Union[int, float]] = normalization_result[1]

        coefficients_tuple: Tuple[float, Union[int, float]] = (LinearRegression.__compute_optimal_initial_coefficients(data_list))
        w0: float = coefficients_tuple[0]
        b: float = coefficients_tuple[1]

        for epoch in range(epochs):
            coefficients_tuple = LinearRegression.__update_coefficients(data_list, learning_rate, w0, b)
            w0 = coefficients_tuple[0]
            b = coefficients_tuple[1]

        return ((w0, b), data_subtrahend, LinearRegression.compute_MSE(data_list, w0, b))

    @staticmethod
    def compute_MSE(
        data_list:  List[Tuple[int, float]],
        w0:         float,
        b:          float
    ) -> float:
        mse: float = 0

        error: float
        for data_point in data_list:
            error = ((LinearRegression.compute_function_result(data_point[0], w0, b) - data_point[1]) ** 2) / len(data_point)
            mse += error

        return mse

    @staticmethod
    def compute_function_result(
        x_value:    int,
        w0:         float,
        b:          float
    ) -> float:
        function_result: float = b + w0 * x_value

        return function_result

    @staticmethod
    def __compute_optimal_initial_coefficients(
        data_list: List[Tuple[float, float]]
    ) -> Tuple[float, float]:
        w0: float = (data_list[0][1] - data_list[1][1]) / (data_list[0][0] - data_list[1][0])
        b: float = data_list[0][1] - data_list[0][0] * w0

        return (w0, b)

    @staticmethod
    def __update_coefficients(
        data_list:      List[Tuple[int, float]],
        learning_rate:  float,
        w0:             float,
        b:              float
    ) -> Tuple[float, float]:
        gradient: Tuple[float, float] = LinearRegression.__compute_gradient(data_list, w0, b)
        w0_derivative: float = gradient[0]
        b_derivative: float = gradient[1]

        w0 -= learning_rate * LinearRegression.__coefficient_modification_rate(w0_derivative)
        b -= learning_rate * LinearRegression.__coefficient_modification_rate(b_derivative)

        return (w0, b)

    @staticmethod
    def __compute_gradient(
        data_list:  List[Tuple[int, float]],
        w0:         float,
        b:          float
    ) -> Tuple[float, float]:
        w0_derivative: float = 0
        b_derivative: float = 0

        for data in data_list:
            function_result: float = LinearRegression.__compute_function_result(data[0], w0, b)
            error: float = data[1] - function_result

            w0_derivative -= error * data[0] / len(data_list)
            b_derivative -= error / len(data_list)

        return (w0_derivative, b_derivative)

    @staticmethod
    def __compute_function_result(
        x_value:    float,
        w0:         float,
        b:          float
    ) -> float:
        return b + w0 * x_value

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