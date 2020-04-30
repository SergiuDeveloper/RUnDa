from matplotlib import pyplot as plt
import math
import sys

class LinearRegression:
    __learning_rate = 0.005

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