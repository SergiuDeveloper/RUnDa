import re
import pandas as pd
import linear_regression as lr

class UnemployedData:
    class DocumentObject:
        name = None
        value = None
        month = None

    __event_val = 0
    __file_format_iterator = 0

    @staticmethod
    def get_request_var():
        return __event_val[__file_format_iterator]

    @staticmethod
    def reset_request_var():
        __event_val[__file_format_iterator] = 0

    @staticmethod
    def extract_data(input_document_format, column_number, epochs, plot_file_format, output_file_format, feature_name, label_name, event_val, file_format_iterator):
        __event_val = event_val
        __file_format_iterator = file_format_iterator

        years = [2018, 2019]
        months = ['ianuarie', 'februarie', 'martie', 'aprilie', 'mai', 'iunie', 'iulie', 'august', 'septembrie', 'octombrie', 'noiembrie', 'decembrie']

        documents = UnemployedData.get_unemployed_data(input_document_format, years, months)
        dataframe = UnemployedData.map_dataframe(documents, column_number)

        datalist = lr.LinearRegression.get_datalist_from_dataframe(dataframe)
        [w0, w1, p1] = lr.LinearRegression.polynomial_regression(datalist, epochs, label_name, feature_name, plot_file_format, output_file_format)

        plot = lr.LinearRegression.plot_model_polynomial(w0, w1, p1, datalist, feature_name, label_name)
        plot.savefig(plot_file_format)
        plot.close()

        output_file = open(output_file_format, 'w')
        output_file_content = 'w0 = %f\nw1 = %f' % (w0, w1)
        output_file.write(output_file_content)
        output_file.close()

    @staticmethod
    def get_unemployed_data(document_format, years, months):
        documents = []
        for year in range(len(years)):
            for month in range(len(months)):
                try:
                    document = UnemployedData.DocumentObject()
                    document.name = document_format % (months[month], years[year])
                    document.value = pd.read_csv(document.name)
                    document.month = year * 12 + month + 1
                    
                    documents.append(document)
                except:
                    pass
        
        return documents

    @staticmethod
    def map_dataframe(documents, column_number):
        luni = []
        somaj = []
        for document in documents:
            luni.append(document.month)
            
            valoare_somaj = document.value.iloc[:, 1].tail(column_number).head(1).iloc[-1]
            valoare_somaj = int(re.sub('[^0-9]', '', str(valoare_somaj)))
            somaj.append(valoare_somaj)

        dataframe_dictionary = {'Label': luni, 'Feature': somaj}
        dataframe = pd.DataFrame(data = dataframe_dictionary)

        return dataframe