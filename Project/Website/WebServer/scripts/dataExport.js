function updateExportDataURL(dataType) {
    let exportButton = document.getElementById('exportButton');
    exportButton.href = `${exportButton.href.slice(0, exportButton.href.indexOf('.php') + 4)}?DataType=${dataType}`;
}