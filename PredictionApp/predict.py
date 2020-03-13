import unemployed_data as ud; 
import linear_regression as lr;

document_format = './Data/medii-somaj-%s-%d.csv';
years = [2018, 2019];
months = ['ianuarie', 'februarie', 'martie', 'aprilie', 'mai', 'iunie', 'iulie', 'august', 'septembrie', 'octombrie', 'noiembrie', 'decembrie'];

documents = ud.get_unemployed_data(document_format, years, months);
dataframe = ud.map_dataframe(documents);

datalist = lr.get_datalist_from_dataframe(dataframe);
[w0, w1] = lr.linear_regression(datalist, 100000);
lr.plot_model(w0, w1, datalist,  'Luna', 'Numar Total Someri')