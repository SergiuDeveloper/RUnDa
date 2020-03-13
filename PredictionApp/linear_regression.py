from matplotlib import pyplot as plt;

class LinearRegression:
    @staticmethod
    def linear_regression(datalist, epochs):
        w1 = (datalist[0][1] - datalist[1][1]) / (datalist[0][0] - datalist[1][0]);
        w0 = datalist[0][1] - datalist[0][0] * w1;

        for epoch in range(epochs):
            print('Epoch', epoch);	

            w0Gradient = 0;
            w1Gradient = 0;
            for data in datalist:
                w0Gradient += -2 * (data[1] - (w1 * data[0] + w0));
                w1Gradient += -2 * data[0] * (data[1] - (w1 * data[0] + w0));
            w0Gradient /= len(datalist);
            w1Gradient /= len(datalist);

            learning_rate = LinearRegression.compute_optimal_learning_rate();

            w0 -= w0Gradient * learning_rate;
            w1 -= w1Gradient * learning_rate;
            print('w0 =', w0);
            print('w1 =', w1);
            currentMSE = LinearRegression.compute_MSE(datalist, w0, w1);
            print('MSE =', currentMSE);
            print();

        return [w0, w1];

    @staticmethod
    def get_datalist_from_dataframe(dataframe):
        dataframe = dataframe.dropna();
        datalist = dataframe.values.tolist();

        return datalist;

    @staticmethod
    def compute_MSE(datalist, w0, w1):
        mse = 0;
        for data in datalist:
            prediction = data[1];
            computed_value = w0 + w1 * data[0];

            err = prediction - computed_value;
            l2loss = err * err;
            mse += l2loss;
        mse /= len(datalist);

        return mse;

    @staticmethod
    def compute_optimal_learning_rate():
        return 0.001;

    @staticmethod
    def plot_model(w0, w1, datalist, feature_name, label_name):
        feature = [];
        label = [];
        for data in datalist:
            feature.append(data[0]);
            label.append(data[1]);

        plt.xlabel(feature_name);
        plt.ylabel(label_name);

        plt.scatter(feature, label);

        x0 = 0;
        y0 = w0;
        x1 = feature[-1];
        y1 = w0 + (w1 * x1);
        plt.plot([x0, x1], [y0, y1], c = 'r');

        return plt;