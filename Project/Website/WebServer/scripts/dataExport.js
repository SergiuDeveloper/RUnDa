function updateExportDataURL(dataType) {
    let exportButton = document.getElementById('exportButton');
    exportButton.href = `${exportButton.href.slice(exportButton.href.indexOf('?'))}?DataType=${dataType}`;
}