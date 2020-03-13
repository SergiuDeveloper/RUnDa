import re;
import pandas as pd;

class DocumentObject:
    name = None;
    value = None;
    month = None;

def get_unemployed_data(document_format, years, months):
    documents = [];
    for year in range(len(years)):
        for month in range(len(months)):
            try:
                document = DocumentObject();
                document.name = document_format % (months[month], years[year]);
                document.value = pd.read_csv(document.name);
                document.month = year * 12 + month + 1;
                
                documents.append(document);
            except:
                pass;
    
    return documents;

def map_dataframe(documents):
    luni = []
    somaj = [];
    for document in documents:
        luni.append(document.month);
        
        valoare_somaj = document.value.iloc[:, 1].tail(1).head(1).iloc[-1];
        valoare_somaj = int(re.sub('[^0-9]', '', str(valoare_somaj)));
        somaj.append(valoare_somaj);

    dataframe_dictionary = {'Luna': luni, 'Somaj': somaj};
    dataframe = pd.DataFrame(data = dataframe_dictionary);

    return dataframe;