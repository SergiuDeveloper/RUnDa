const COUNTY_NAMES = {
    'AB': 'ALBA',
    'AR': 'ARAD',
    'AG': 'ARGES',
    'BC': 'BACAU',
    'BH': 'BIHOR',
    'BN': 'BISTRITA NASAUD',
    'BT': 'BOTOSANI',
    'BR': 'BRAILA',
    'BV': 'BRASOV',
    'B': 'BUCURESTI',
    'BZ': 'BUZAU',
    'CL': 'CALARASI',
    'CS': 'CARAS SEVERIN',
    'CJ': 'CLUJ',
    'CT': 'CONSTANTA',
    'CV': 'COVASNA',
    'DB': 'DAMBOVITA',
    'DJ': 'DOLJ',
    'GL': 'GALATI',
    'GR': 'GIURGIU',
    'GJ': 'GORJ',
    'HR': 'HARGHITA',
    'HD': 'HUNEDOARA',
    'IL': 'IALOMITA',
    'IS': 'IASI',
    'IF': 'ILFOV',
    'MM': 'MARAMURES',
    'MH': 'MEHEDINTI',
    'MS': 'MURES',
    'NT': 'NEAMT',
    'OT': 'OLT',
    'PH': 'PRAHOVA',
    'SJ': 'SALAJ',
    'SM': 'SATU MARE',
    'SB': 'SIBIU',
    'SV': 'SUCEAVA',
    'TR': 'TELEORMAN',
    'TM': 'TIMIS',
    'TL': 'TULCEA',
    'VL': 'VALCEA',
    'VS': 'VASLUI',
    'VN': 'VRANCEA'
};

const EQUIVALENT_COUNTIES = {
    'BUCURESTI': 'MUN. BUC.',
    'SATU MARE': 'SATU M.'
};

function notifyDatasetChanged(dataset) {
    let pathsArray = Array.from(document.getElementsByClassName('land'));
    let dataPoints = [];

    let countyDataset;
    pathsArray.forEach((pathElement) => {
        try {
            countyDataset = dataset[COUNTY_NAMES[pathElement.id.replace('RO-', '')]]['Linear']['DataPoints'];
            dataPoints.push(countyDataset[countyDataset.length - 1].Y);
        }
        catch (exception) {
            try {
                countyDataset = dataset[EQUIVALENT_COUNTIES[COUNTY_NAMES[pathElement.id.replace('RO-', '')]]]['Linear']['DataPoints'];
                dataPoints.push(countyDataset[countyDataset.length - 1].Y);
            }
            catch (exception2) {
                pathElement.style.fill = 'rgba(255, 255, 255, 1)';
                pathsArray.splice(pathsArray.indexOf(pathElement), 1);
            }
        }
    });

    let countyBackgroundColors = getCountyBackgroundColors(dataPoints);

    for (let pathsIterator = 0; pathsIterator < pathsArray.length; ++pathsIterator)
        pathsArray[pathsIterator].style.fill = countyBackgroundColors[pathsIterator];

    document.getElementsByClassName('loader')[0].style.display = 'none';
    document.getElementsByClassName('mapInPage')[0].style.display = 'block';

    for (let i = 0; i < countyBackgroundColors.length; ++i)
        countyBackgroundColors[i] = countyBackgroundColors[i].replace(/,/g, ';').replace(/ /g, '');

    const mapExportButton = document.getElementById('mapExportButton');
    mapExportButton.href = `${mapExportButton.href.slice(0, mapExportButton.href.indexOf('.php') + 4)}?CountyColors=${countyBackgroundColors.join()}`;
}

function getCountyBackgroundColors(dataPoints) {
    const maxDataPointValue = Math.max.apply(null, dataPoints);
    const minDataPointValue = Math.min.apply(null, dataPoints);

    const dataPointsRange = maxDataPointValue - minDataPointValue;

    let countyBackgroundColors = [];

    dataPoints.forEach((dataPoint) => {
        countyBackgroundColors.push(`rgba(${Math.floor(255 * ((dataPoint - minDataPointValue) / dataPointsRange))}, 0, ${Math.floor(255 * ((maxDataPointValue - dataPoint) / dataPointsRange))}, 1)`);
    });

    return countyBackgroundColors;
}