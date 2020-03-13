import unemployed_data as ud;

input_document_format = './Data/medii-somaj-%s-%d.csv';
plot_file_format = './Plots/numar-total-someri.png';
output_file_format = './Output/numar-total-someri.data';
feature_name = 'Luna';
label_name = 'Numar Total Someri';

ud.UnemployedData.extract_data(input_document_format, plot_file_format, output_file_format, feature_name, label_name);