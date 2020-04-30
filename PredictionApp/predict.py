import unemployed_data as ud

input_document_format = './Data/medii-somaj-%s-%d.csv'
epochs = 100000

plot_folder = './Plots/'
output_folder = './Output/'
plot_file_extension = '.png'
output_file_extension = '.data'
feature_name = 'Luna'

file_formats = ['numar-total-someri', 'numar-total-someri-femei', 'numar-total-someri-barbati', 'numar-total-someri-din-mediul-urban', 'numar-someri-femei-din-mediul-urban', 'numar-someri-barbati-din-mediul-urban',
    'numar-total-someri-din-mediul-rural', 'numar-someri-femei-din-mediul-rural', 'numar-someri-barbati-din-mediul-rural']
label_names = ['Numar Total Someri', 'Numar Total Someri Femei', 'Numar Total Someri Barbati', 'Numar Total Someri Din Mediul Urban', 'Numar Someri Femei Din Mediul Urban', 'Numar Someri Barbati Din Mediul Urban',
    'Numar Total Someri Din Mediul Rural', 'Numar Someri Femei Din Mediul Rural', 'Numar Someri Barbati Din Mediul Rural']

for file_format_iterator in range(len(file_formats)):
    print()
    print()
    print(label_names[file_format_iterator])
    print()
    plot_file_format = '%s%s%s' % (plot_folder, file_formats[file_format_iterator], plot_file_extension)
    output_file_format = '%s%s%s' % (output_folder, file_formats[file_format_iterator], output_file_extension)
    ud.UnemployedData.extract_data(input_document_format, file_format_iterator + 1, epochs, plot_file_format, output_file_format, feature_name, label_names[file_format_iterator])