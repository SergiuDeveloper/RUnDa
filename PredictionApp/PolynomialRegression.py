#!/usr/bin/python3

from Regression import Regression

from typing import List, Tuple

class PolynomialRegression(Regression):
    @staticmethod
    def train(
        data_list:                  List[Tuple[int, float]],
        epochs:                     int,
        learning_rate:              float,
        mse_lower_bound:            float,
        max_trainings_performed:    int
    ) -> Tuple[Tuple[List[float], float], Tuple[int, float]]:
        normalization_result: Tuple[List[float, float], Tuple[int, float]] = PolynomialRegression._Regression__normalize(data_list)
        data_list = normalization_result[0]
        data_subtrahend: Tuple[int, float] = normalization_result[1]

        optimal_initial_coefficients: Tuple[float, float, float] = PolynomialRegression.__compute_optimal_initial_coefficients(data_list)
        w: List[float] = [optimal_initial_coefficients[0]]
        b: float = optimal_initial_coefficients[2]

        trainings_performed: int = 0

        previous_MSE: float
        current_MSE: float
        last_computed_coefficients: Tuple[List[float], float]
        optimal_new_weight_value: float
        while trainings_performed < max_trainings_performed:
            trainings_performed = trainings_performed + 1

            (w, b) = PolynomialRegression.__train(data_list, epochs, learning_rate, w, b)

            current_MSE = PolynomialRegression.compute_MSE(data_list, w, b)
            if current_MSE < mse_lower_bound:
                if trainings_performed > 1:
                    (w, b) = last_computed_coefficients
                return (PolynomialRegression.__reduce_polynomial_degree((w, b)), data_subtrahend)

            if trainings_performed > 1:
                if current_MSE >= previous_MSE:
                    return (PolynomialRegression.__reduce_polynomial_degree(last_computed_coefficients), data_subtrahend)

            last_computed_coefficients = (w.copy(), b)
            previous_MSE = current_MSE

            optimal_new_weight_value = optimal_initial_coefficients[1]
            w.append(optimal_new_weight_value)

        return (PolynomialRegression.__reduce_polynomial_degree(last_computed_coefficients), data_subtrahend)

    @staticmethod
    def compute_MSE(
        data_list:  List[Tuple[int, float]],
        w:          List[float],
        b:          float
    ) -> float:
        mse: float = 0

        error: float
        for data_point in data_list:
            error = ((PolynomialRegression.compute_function_result(data_point[0], w, b) - data_point[1]) ** 2) / len(data_point)
            mse += error

        return mse

    @staticmethod
    def compute_function_result(
        x_value:    int,
        w:          List[float],
        b:          float
    ) -> float:
        function_result: float = b
        for w_index in range(len(w)):
            function_result += w[w_index] * (x_value ** (w_index + 1))

        return function_result

    @staticmethod
    def __train(
        data_list:      List[Tuple[int, float]],
        epochs:         int,
        learning_rate:  float,
        w:              List[float],
        b:              float
    ) -> Tuple[Tuple[List[float], float], Tuple[int, float]]:
        for epoch in range(epochs):
            (w, b) = PolynomialRegression.__update_coefficients(data_list, learning_rate, w, b)

        return (w, b)

    @staticmethod
    def __compute_optimal_initial_coefficients(
        data_list: List[Tuple[float, float]]
    ) -> Tuple[float, float, float]:
        w0: float = (data_list[0][1] - data_list[1][1]) / (data_list[0][0] - data_list[1][0])
        wi: float = 0.0
        b: float = data_list[0][1] - data_list[0][0] * wi

        return (w0, wi, b)

    @staticmethod
    def __update_coefficients(
        data_list:      List[Tuple[int, float]],
        learning_rate:  float,
        w:              List[float],
        b:              float
    ) -> Tuple[List[float], float]:
        gradient: Tuple[List[float], float] = PolynomialRegression.__compute_gradient(data_list, w, b)
        w_derivative: List[float] = gradient[0]
        b_derivative: float = gradient[1]

        for w_index in range(len(w)):
            w[w_index] -= learning_rate * PolynomialRegression.__coefficient_modification_rate(w_derivative[w_index])
        b -= learning_rate * PolynomialRegression.__coefficient_modification_rate(b_derivative)

        return (w, b)

    @staticmethod
    def __compute_gradient(
        data_list:  List[Tuple[int, float]],
        w:          List[float],
        b:          float
    ) -> Tuple[List[float], float]:
        w_derivative: List[float] = [0.0 for i in range(len(w))]
        b_derivative: float = 0.0

        for data in data_list:
            function_result: float = PolynomialRegression.compute_function_result(data[0], w, b)
            error: float = data[1] - function_result

            for wi_derivative_index in range(len(w)):
                w_derivative[wi_derivative_index] -= error * (data[0] ** (wi_derivative_index + 1)) / len(data_list)
            b_derivative -= error / len(data_list)

        return (w_derivative, b_derivative)

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

    @staticmethod
    def __reduce_polynomial_degree(
        training_results: Tuple[List[float], float]
    ) -> Tuple[List[float], float]:
        numbers_of_zero_trailing: int = 0
        for training_result in reversed(training_results[0]):
            if training_result == 0:
                numbers_of_zero_trailing
            else:
                break

        training_results = (training_results[0][:len(training_results[0]) - numbers_of_zero_trailing], training_results[1])

        return training_results