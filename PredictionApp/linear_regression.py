from matplotlib import pyplot as plt
import numpy
import sys
import unemployed_data as ud
from numba import jit, cuda

class LinearRegression:
    __learning_rate = 0.01

    @staticmethod
    def linear_regression(datalist, epochs, label_name):
        w1 = (datalist[0][1] - datalist[1][1]) / (datalist[0][0] - datalist[1][0])
        w0 = datalist[0][1] - datalist[0][0] * w1

        for epoch in range(epochs):
            #print('Epoch', epoch, '- ', label_name)	

            w0Gradient = 0
            w1Gradient = 0
            for data in datalist:
                w0Gradient += (data[1] - (w0 + w1 * data[0]))
                w1Gradient += (data[1] - (w0 + w1 * data[0])) * data[0]
            w0Gradient /= -len(datalist)
            w1Gradient /= -len(datalist)

            if w0Gradient != 0:
                w0 -= LinearRegression.__learning_rate * w0Gradient
            if w1Gradient != 0:
                w1 -= LinearRegression.__learning_rate * w1Gradient

            #print('Dw0 =', w0Gradient)
            #print('Dw1 =', w1Gradient)
            #print('w0 =', w0)
            #print('w1 =', w1)
            #print('MSE =', currentMSE)
            #print()

        print(epochs, 'epochs')
        print('w0 gradient =', w0Gradient)
        print('w1 gradient =', w1Gradient)
        print('w0 =', w0)
        print('w1 =', w1)
        print('MSE =', LinearRegression.compute_MSE(datalist, w0, w1))

        return [w0, w1]

    @staticmethod
    @jit(target = 'cuda')
    def polynomial_regression(datalist, epochs, label_name, feature_name, plot_file_format, output_file_format):
        w1 = (datalist[0][1] - datalist[1][1]) / (datalist[0][0] - datalist[1][0])
        w0 = datalist[0][1] - datalist[0][0] * w1
        p1 = 1

        ranOnce = False
        epochs = 0
        while ranOnce == False or abs(w0Gradient) > 1000 or abs(w1Gradient) > 1000 or abs(p1Gradient) > 1000:
            ranOnce = True
            #print('Epoch', epoch, '- ', label_name)
            epochs = epochs + 1

            w0Gradient = 0
            w1Gradient = 0
            p1Gradient = 0
            for data in datalist:
                w0Gradient -= (data[1] - (w0 + w1 * (data[0] ** p1))) / len(datalist)
                w1Gradient -= (data[1] - (w0 + w1 * (data[0] ** p1))) * (data[0] ** p1) / len(datalist)
                p1Gradient -= (data[1] - (w0 + w1 * (data[0] ** p1))) * w1 * (data[0] ** p1) * numpy.log(data[0]) / len(datalist)

            #print(w0Gradient)
            #print(w1Gradient)
            #print(p1Gradient)
            #print(w0)
            #print(w1)
            #print(p1)

            #term1_gradient_sign = (1 if w1Gradient >= 1 else -1 if w1Gradient <= -1 else w1Gradient) * (1 if p1Gradient >= 1 else -1 if p1Gradient <= -1 else p1Gradient)
            w0 -= LinearRegression.__learning_rate * (1 if w0Gradient >= 1 else -1 if w0Gradient <= -1 else w0Gradient)
            w1 -= LinearRegression.__learning_rate * (1 if w1Gradient >= 1 else -1 if w1Gradient <= -1 else w1Gradient)
            p1 -= LinearRegression.__learning_rate * (1 if p1Gradient >= 1 else -1 if p1Gradient <= -1 else p1Gradient)

            request_var = ud.get_request_var()
            if request_var == 1:
                print()
                print(label_name)
                print(epochs, 'epochs')
                print('w0 gradient =', w0Gradient)
                print('w1 gradient =', w1Gradient)
                print('p1 gradient =', p1Gradient)
                print('w0 =', w0)
                print('w1 =', w1)
                print('p1 =', p1)
                print('MSE =', LinearRegression.compute_MSE_polynomial(datalist, w0, w1, p1))
                print()
            elif request_var == 2:
                plot = LinearRegression.plot_model_polynomial(w0, w1, p1, datalist, feature_name, label_name)
                plot.savefig(plot_file_format)
                plot.close()

                output_file = open(output_file_format, 'w')
                output_file_content = 'w0 = %f\nw1 = %f' % (w0, w1)
                output_file.write(output_file_content)
                output_file.close()

                print()
                print('Plotting', label_name)
                print()
            elif request_var == 3:
                sys.exit()
            ud.reset_request_var()

        print()
        print(label_name)
        print(epochs, 'epochs')
        print('w0 gradient =', w0Gradient)
        print('w1 gradient =', w1Gradient)
        print('p1 gradient =', p1Gradient)
        print('w0 =', w0)
        print('w1 =', w1)
        print('p1 =', p1)
        print('MSE =', LinearRegression.compute_MSE_polynomial(datalist, w0, w1, p1))
        print()

        return [w0, w1, p1]

    @staticmethod
    def get_datalist_from_dataframe(dataframe):
        dataframe = dataframe.dropna()
        datalist = dataframe.values.tolist()

        return datalist

    @staticmethod
    def compute_MSE(datalist, w0, w1):
        mse = 0
        for data in datalist:
            prediction = data[1]
            computed_value = w0 + w1 * data[0]

            err = prediction - computed_value
            l2loss = err * err
            mse += l2loss
        mse /= len(datalist)

        return mse

    @staticmethod
    def compute_MSE_polynomial(datalist, w0, w1, p1):
        mse = 0
        for data in datalist:
            prediction = data[1]
            computed_value = w0 + w1 * (data[0] ** p1)

            err = prediction - computed_value
            l2loss = err * err
            mse += l2loss
        mse /= len(datalist)

        return mse

    @staticmethod
    def plot_model(w0, w1, datalist, feature_name, label_name):
        feature = []
        label = []
        for data in datalist:
            feature.append(data[0])
            label.append(data[1])

        plt.xlabel(feature_name)
        plt.ylabel(label_name)

        plt.scatter(feature, label)

        feature_prediction = []
        label_prediction = []
        for predicted_points_iterator in range(len(feature)):
            xValue = feature[len(feature) - 1] + predicted_points_iterator + 1
            yValue = w0 + (w1 * xValue)
            feature_prediction.append(xValue)
            label_prediction.append(yValue)

        feature_prediction_not_null_label_points = []
        feature_prediction_null_label_points = []
        started_null_points = False
        for feature_prediction_point in range(len(feature_prediction)):
            if label_prediction[feature_prediction_point] < 0:
                label_prediction[feature_prediction_point] = 0
                started_null_points = True
            
            if started_null_points == True:
                feature_prediction_null_label_points.append(feature_prediction[feature_prediction_point])
            else:
                feature_prediction_not_null_label_points.append(feature_prediction[feature_prediction_point])

        joined_feature = feature
        joined_feature.extend(feature_prediction_not_null_label_points)

        plt.scatter(feature_prediction, label_prediction)

        x0 = joined_feature[0]
        y0 = w0 + (w1 * x0)
        x1 = joined_feature[-1]
        y1 = w0 + (w1 * x1)
        plt.plot([x0, x1], [y0, y1], c = 'r')

        if len(feature_prediction_null_label_points) > 0:
            x0 = feature_prediction_not_null_label_points[len(feature_prediction_not_null_label_points) - 1]
            y0 = w0 + (w1 * x0)
            x1 = feature_prediction_null_label_points[0]
            y1 = 0
            plt.plot([x0, x1], [y0, y1], c = 'r')

            x0 = feature_prediction_null_label_points[0]
            y0 = 0
            x1 = feature_prediction_null_label_points[len(feature_prediction_null_label_points) - 1]
            y1 = 0
            plt.plot([x0, x1], [y0, y1], c = 'r')

        return plt

    @staticmethod
    def plot_model_polynomial(w0, w1, p1, datalist, feature_name, label_name):
        plt.xlabel(feature_name)
        plt.ylabel(label_name)

        plt.scatter([data[0] for data in datalist], [data[1] for data in datalist])

        pointsX = [data[0] for data in datalist]
        x = numpy.linspace(pointsX[0], pointsX[-1], num = 1000)

        fx = []
        for i in range(len(x)):
            fx.append(w0 + w1 * (x[i] ** p1))

        plt.plot(x, fx, c = 'r')
        #plt.grid()
        #plt.axvline()
        #plt.axhline()

        return plt