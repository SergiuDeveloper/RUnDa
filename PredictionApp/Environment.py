#!/usr/bin/python3

from LinearRegression import LinearRegression
from PolynomialRegression import PolynomialRegression
from LogisticPolynomialRegression import LogisticPolynomialRegression

from concurrent.futures import ProcessPoolExecutor, Future, as_completed
from multiprocessing import cpu_count
from json import dump
from csv import reader
from typing import List, Dict, Tuple, Union, Callable, Any
from os import walk, mkdir, remove
from os.path import exists, join
from datetime import datetime
from inspect import signature
from matplotlib import use
use('Agg')
from matplotlib.pyplot import plot, scatter, savefig, close

class Environment():
    def __init__(self,
        data_folder:    str,
        json_folder:    str,
        plots_folder:   str,
        logs_folder:    str
    ):
        self.__data_folder: str = data_folder
        self.__json_folder: str = json_folder
        self.__plots_folder: str = plots_folder
        self.__logs_folder: str = logs_folder
        self.__log_file: str = None

        self.__initialize()

    def linear_regression(self,
        epochs:         int,
        learning_rate:  float
    ) -> List[Tuple[Tuple[str, str, str], Tuple[Tuple[float, float], Tuple[int, float], float]]]:
        training_results: List[Tuple[Tuple[str, str, str], Tuple[Tuple[float, float], Tuple[int, float], float]]] = []
        training_result: Tuple[Tuple[float, float], Tuple[int, float], float]

        data_dictionary_keys: List[Tuple[str, str, str]] = list(self.__data_dictionary.keys())
        processes_future_list: List[Future] = []
        processes_future_data_types_dictionary: Dict[Future, Tuple[str, str, str]] = {}
        process_future: Future
        with ProcessPoolExecutor(cpu_count()) as process_pool_executor:
            for data_dictionary_key in data_dictionary_keys:
                process_future = process_pool_executor.submit(LinearRegression.train, self.__data_dictionary[data_dictionary_key], epochs, learning_rate)
                processes_future_list.append(process_future)
                processes_future_data_types_dictionary[process_future] = data_dictionary_key

            data_dictionary_key: Tuple[str, str, str]
            for process_future_element in as_completed(processes_future_list):
                training_result = process_future_element.result()
                data_dictionary_key = processes_future_data_types_dictionary[process_future_element]
                training_results.append((data_dictionary_key, training_result))

                self.__save_plot(data_dictionary_key, training_result, LinearRegression.compute_function_result, 'linear')

                self.__log_results(data_dictionary_key, 'Linear Regression', training_result[0], training_result[1], training_result[2])

        return training_results

    def polynomial_regression(self,
        epochs:                     int,
        learning_rate:              float,
        mse_lower_bound_per_point:  float,
        max_polynomial_degree:      int
    ) -> List[Tuple[Tuple[str, str, str], Tuple[Tuple[List[float], float], Tuple[int, float], float]]]:
        training_results: List[Tuple[Tuple[str, str, str], Tuple[Tuple[List[float], float], Tuple[int, float], float]]] = []
        training_result: Tuple[Tuple[List[float], float], Tuple[int, float], float]

        data_dictionary_keys: List[Tuple[str, str, str]] = list(self.__data_dictionary.keys())
        processes_future_list: List[Future] = []
        processes_future_data_types_dictionary: Dict[Future, Tuple[str, str, str]] = {}
        process_future: Future
        with ProcessPoolExecutor(cpu_count()) as process_pool_executor:
            for data_dictionary_key in data_dictionary_keys:
                process_future = process_pool_executor.submit(PolynomialRegression.train, self.__data_dictionary[data_dictionary_key], epochs, learning_rate, mse_lower_bound_per_point * len(data_dictionary_keys), max_polynomial_degree)
                processes_future_list.append(process_future)
                processes_future_data_types_dictionary[process_future] = data_dictionary_key

            data_dictionary_key: Tuple[str, str, str]
            for process_future_element in as_completed(processes_future_list):
                training_result = process_future_element.result()
                data_dictionary_key = processes_future_data_types_dictionary[process_future_element]
                training_results.append((data_dictionary_key, training_result))

                self.__save_plot(data_dictionary_key, training_result, PolynomialRegression.compute_function_result, 'polynomial')

                self.__log_results(data_dictionary_key, 'Polynomial Regression', training_result[0], training_result[1], training_result[2])

        return training_results

    def logistic_polynomial_regression(self,
        epochs:         int,
        learning_rate:  float
    ) -> List[Tuple[Tuple[str, str, str], Tuple[Tuple[float, float, float], Tuple[int, float], float]]]:
        training_results: List[Tuple[Tuple[str, str, str], Tuple[Tuple[float, float, float], Tuple[int, float], float]]] = []
        training_result: Tuple[Tuple[float, float, float], Tuple[int, float], float]

        data_dictionary_keys: List[Tuple[str, str, str]] = list(self.__data_dictionary.keys())
        processes_future_list: List[Future] = []
        processes_future_data_types_dictionary: Dict[Future, Tuple[str, str, str]] = {}
        process_future: Future
        with ProcessPoolExecutor(cpu_count()) as process_pool_executor:
            for data_dictionary_key in data_dictionary_keys:
                process_future = process_pool_executor.submit(LogisticPolynomialRegression.train, self.__data_dictionary[data_dictionary_key], epochs, learning_rate)
                processes_future_list.append(process_future)
                processes_future_data_types_dictionary[process_future] = data_dictionary_key

            data_dictionary_key: Tuple[str, str, str]
            for process_future_element in as_completed(processes_future_list):
                training_result = process_future_element.result()
                data_dictionary_key = processes_future_data_types_dictionary[process_future_element]
                training_results.append((data_dictionary_key, training_result))

                self.__save_plot(data_dictionary_key, training_result, LogisticPolynomialRegression.compute_function_result, 'logistic_polynomial')

                self.__log_results(data_dictionary_key, 'Logistic Polynomial Regression', training_result[0], training_result[1], training_result[2])

        return training_results

    def create_training_results_json(self,
        training_results_list: List[Tuple[List[Tuple[Any]], str]]
    ) -> str:
        training_results_json_object: Dict[str, Dict[str, Dict[str, Dict[str, Dict[str, Any]]]]] = {
            'TrainingResults': {}
        }

        category: str
        subcategory: str
        location: str
        data_list: List[Tuple[int, Union[int, float]]]
        coefficients: List[Tuple[Any]]
        data_subtrahend: Tuple[int, Union[int, float]]
        mse: float

        for (training_results, training_type) in training_results_list:
            for training_result in training_results:
                category = training_result[0][0]
                subcategory = training_result[0][1]
                location = training_result[0][2]
                data_list = self.__data_dictionary[(category, subcategory, location)]
                coefficients = training_result[1][0]
                data_subtrahend = training_result[1][1]
                mse = training_result[1][2]

                if category not in training_results_json_object['TrainingResults']:
                    training_results_json_object['TrainingResults'][category] = {}
                if subcategory not in training_results_json_object['TrainingResults'][category]:
                    training_results_json_object['TrainingResults'][category][subcategory] = {}
                if location not in training_results_json_object['TrainingResults'][category][subcategory]:
                    training_results_json_object['TrainingResults'][category][subcategory][location] = {}
                if training_type not in training_results_json_object['TrainingResults'][category][subcategory]:
                    training_results_json_object['TrainingResults'][category][subcategory][location][training_type] = {
                        'DataPoints': []
                    }
                    for data_point in data_list:
                        training_results_json_object['TrainingResults'][category][subcategory][location][training_type]['DataPoints'].append(
                            {
                                'X': data_point[0],
                                'Y': data_point[1]
                            }
                        )

                    training_results_json_object['TrainingResults'][category][subcategory][location][training_type]['Coefficients'] = {
                        'w': coefficients[0],
                        'b': coefficients[1]
                    } if len(coefficients) <= 2 else {
                        'w': coefficients[0],
                        'p': coefficients[1],
                        'b': coefficients[2]
                    }

                    training_results_json_object['TrainingResults'][category][subcategory][location][training_type]['DataSubtrahend'] = {
                        'X': data_subtrahend[0],
                        'Y': data_subtrahend[1]
                    }

                    training_results_json_object['TrainingResults'][category][subcategory][location][training_type]['MSE'] = mse

        if not exists(f'{self.__json_folder}'):
            mkdir(f'{self.__json_folder}')
        with open(f'{self.__json_folder}/training_results.json', 'w', encoding = 'latin-1') as training_results_json_file:
            dump(training_results_json_object, training_results_json_file, ensure_ascii = False, indent = 4)

        return training_results_json_object
    
    def begin_log(self) -> None:
        if not exists(f'{self.__logs_folder}'):
            mkdir(f'{self.__logs_folder}')

        self.__log_file = datetime.now().strftime('%d.%m.%Y %H%Mh')

    def end_log(self) -> None:
        self.__log_file = None

    def __initialize(self) -> None:
        self.__data_dictionary: Dict[Tuple[str, str, str], List[Tuple[int, Union[int, Union[int, float]]]]] = {}

        category: str
        year: int
        month: int

        category_directories: List[str] = next(walk(f'{self.__data_folder}'))[1]
        for category_directory in category_directories:
            category = category_directory

            year_directories: List[str] = next(walk(f'{self.__data_folder}/{category_directory}'))[1]
            for year_directory in year_directories:
                year = int(year_directory)

                month_directories: List[str] = next(walk(f'{self.__data_folder}/{category_directory}/{year_directory}'))[1]
                for month_directory in month_directories:
                    month = int(month_directory)

                    data_files: List[str] = next(walk(f'{self.__data_folder}/{category_directory}/{year_directory}/{month_directory}'))[2]

                    for data_file in data_files:
                        data_file = f'{self.__data_folder}/{category_directory}/{year_directory}/{month_directory}/{data_file}'
                        self.__get_data_from_file(data_file, category, year, month)

        self.__remove_single_entry_datasets()

    def __save_plot(self,
        data_dictionary_key:        Tuple[str, str, str],
        training_result:            Tuple[Union[Tuple[Union[List[float], float], float], Tuple[Union[List[float], float], Union[List[float], float], float]], Tuple[int, float], float],
        compute_function_result:    Callable[[int, Union[List[float], float], float], float],
        plot_file_name:             str
    ) -> None:
        training_data: List[Tuple[int, Union[int, float]]] = self.__data_dictionary[data_dictionary_key]

        compute_function_params_count: int = len(signature(compute_function_result).parameters)

        if compute_function_params_count > 3:
            w: Union[List[float], float] = training_result[0][0]
            p: Union[List[float], float] = training_result[0][1]
            b: float = training_result[0][2]
        else:
            w: Union[List[float], float] = training_result[0][0]
            b: float = training_result[0][1]

        x_sub: int = training_result[1][0]
        y_sub: float = training_result[1][1]

        left_point: int = training_data[0][0]
        right_point: int = training_data[-1][0]
        x: List[int] = [(left_point + i * (right_point - left_point) / 1000) for i in range(1001)]
        fx: List[float] = []

        for xi in x:
            if compute_function_params_count > 3:
                function_result = compute_function_result(xi - x_sub, w, p, b + y_sub)
            else:
                function_result = compute_function_result(xi - x_sub, w, b + y_sub)
            fx.append(function_result)

        plot(x, fx)
        scatter(
            [
                data_point[0]
                for data_point in training_data
            ],
            [
                data_point[1]
                for data_point in training_data
            ]
        )

        category_name: str = data_dictionary_key[0].replace('/', ' SI ')
        subcategory_name: str = data_dictionary_key[1].replace('/', ' SI ')
        location: str = data_dictionary_key[2]
        if not exists(f'{self.__plots_folder}'):
            mkdir(f'{self.__plots_folder}')
        if not exists(f'{self.__plots_folder}/{category_name}'):
            mkdir(f'{self.__plots_folder}/{category_name}')
        if not exists(f'{self.__plots_folder}/{category_name}/{subcategory_name}'):
            mkdir(f'{self.__plots_folder}/{category_name}/{subcategory_name}')
        if not exists(f'{self.__plots_folder}/{category_name}/{subcategory_name}/{location}'):
            mkdir(f'{self.__plots_folder}/{category_name}/{subcategory_name}/{location}')
        for root, directories, files in walk(f'{self.__plots_folder}/{category_name}/{subcategory_name}/{location}', topdown = False):
            if f'{plot_file_name}.png' in files:
                remove(join(root, f'{plot_file_name}.png'))
            for directory in directories:
                rmdir(join(root, directory))
        
        savefig(f'{self.__plots_folder}/{category_name}/{subcategory_name}/{location}/{plot_file_name}.png')
        close()

    def __log_results(self,
        log_title:          Tuple[str, str, str],
        log_type:           str,
        training_result:    Union[Tuple[Union[List[float], float], float], Tuple[Union[List[float], float], Union[List[float], float], float]],
        data_subtrahend:    Tuple[int, float],
        mse:                float
    ) -> None:
        if self.__log_file == None:
            return

        with open(f'{self.__logs_folder}/{self.__log_file}.txt', 'a') as logs_file:
            logs_file.write(f'{log_title}({log_type})\n\t')
            logs_file.write(f'Training result: {training_result}\n\t')
            logs_file.write(f'Data subtrahend: {data_subtrahend}\n\t')
            logs_file.write(f'MSE: {mse}\n\n')

    def __get_data_from_file(self,
        data_file:      str,
        category:       str,
        year:           int,
        month:          int
    ) -> None:
        location: str
        xValue: int
        yValue: Union[int, float]

        with open(data_file, 'r', encoding = 'latin-1') as csv_file:
            csv_lines: List[List[str]] = list(reader(csv_file))
            csv_lines = Environment.__validate_csv_data(csv_lines)

            subcategories: List[str] = Environment.__get_subcategories(csv_lines)

            location_column_index: int = 0
            
            csv_lines.pop(0)

            for csv_line in csv_lines:
                location = csv_line[location_column_index]

                for element_index in range(len(csv_line)):
                    if element_index == location_column_index:
                        continue
                    
                    subcategory = subcategories[element_index].replace(', DIN CARE:', '')
                    xValue = year * 12 + month
                    yValue = Environment.__string_to_num(csv_line[element_index])
                    if yValue == None:
                        continue

                    self.__add_to_data_dictionary(
                        category,
                        subcategory,
                        location,
                        xValue,
                        yValue
                    )
        
                    self.__data_dictionary[category, subcategory, location].sort()

    def __add_to_data_dictionary(self,
        category:       str,
        subcategory:    str,
        location:       str,
        xValue:         int,
        yValue:         Union[int, float]
    ) -> None:
        if (category, subcategory, location) not in self.__data_dictionary:
            self.__data_dictionary[(category, subcategory, location)] = []
        elif len([
            data
            for data in self.__data_dictionary[(category, subcategory, location)]
            if data[0] == xValue
        ]) > 0:
            raise ValueError

        self.__data_dictionary[(category, subcategory, location)].append((xValue, yValue))

    def __remove_single_entry_datasets(self) -> None:
        data_dictionary_keys: List[Tuple[str, str, str]] = list(self.__data_dictionary.keys())
        for data_dictionary_key in data_dictionary_keys:
            if len(self.__data_dictionary[data_dictionary_key]) < 2:
                self.__data_dictionary.pop(data_dictionary_key)

    @staticmethod
    def __validate_csv_data(
        csv_lines: List[List[str]]
    ) -> List[List[str]]:
        for csv_lines_index in range(len(csv_lines)):
            for csv_line_index in range(len(csv_lines[csv_lines_index])):
                csv_lines[csv_lines_index][csv_line_index] = csv_lines[csv_lines_index][csv_line_index].strip()

        csv_lines = [
            csv_line
            for csv_line in csv_lines
            if csv_line != ''
            if csv_line.count('') != len(csv_line)
        ]

        empty_csv_column_indexes: List[int] = [
            column_index
            for column_index in range(len(csv_lines[0]))
            if csv_lines[0][column_index].strip() == ''
        ]
        csv_lines_valid: List[List[str]] = []
        csv_line_valid: List[str]
        element: str
        for csv_line in csv_lines:
            csv_line_valid = []

            for element_index in range(len(csv_line)):
                if element_index in empty_csv_column_indexes:
                    continue

                element = csv_line[element_index].strip()
                if element == '':
                    element = str(0)

                csv_line_valid.append(element)
                
            csv_lines_valid.append(csv_line_valid)

        return csv_lines_valid

    @staticmethod
    def __get_subcategories(
        csv_lines: List[List[str]],
    ) -> List[str]:
        subcategories: List[str] = []
        
        subcategory: str
        for subcategory_index in range(len(csv_lines[0])):
            subcategory = csv_lines[0][subcategory_index]

            subcategories.append(subcategory.upper())

        return subcategories

    @staticmethod
    def __string_to_num(
        string_to_parse: str
    ) -> Union[int, float]:
        try:
            return int(string_to_parse)
        except:
            try:
                return float(string_to_parse)
            except:
                return None