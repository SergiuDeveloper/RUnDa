<!DOCTYPE html>

<html lang = "en">
    <head>
		<!-- Font? -->
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
		<link rel = "stylesheet" href = "css/layout.css">
        <link rel = "stylesheet" href = "css/graphLayout.css">
        <link rel = "stylesheet" href = "css/map.css">
        <link rel="icon" type="image/x-icon" href="favicon.ico"/>
        <title>
            RunDA
        </title>
    </head>

    <body>
    <header>
        <img src="resources/logo/Logo.png" alt="Logo" width="80" height="49">
    </header>

        <div class="menu-nav">

            <a href = "index.php"> Home </a>
            <a href = "graph.php"> Graph Statistics </a>
            <a href = "mapView.php"> Map View Statistics </a>
            <a href = "about.php"> About </a>
            <div class="dropdown-menu"
                <div class="dropdown-content">
                    <a href = "index.php"> Home </a>
                    <a href = "graph.php"> Graph Statistics </a>
                    <a href = "mapView.php"> Map View Statistics </a>
                    <a href = "about.php"> About </a>
                </div>
            </div>
        </div>

        <div class = "toolbarContainer">
            <div class = "inputs">
                <div class = "exportInput">
                    <label for="exportDataTypeSelect">Export Data Type</label>
                    <select id="exportDataTypeSelect" onchange="updateExportDataURL(this.options[this.selectedIndex].value)">
                        <option value="JSON">JSON</option>
                        <option value="XML">XML</option>
                        <option value="CSV">CSV</option>
                    </select>

                    <a id="exportButton" href="dataExport.php"> Export Data </a>
                </div>

                <div class = "toolbar">
                    <div class="toolbarSelectWrapper">
                        <div class="toolbarSelectGroup">
                            <div class = "toolbarLabelDropWrapper">
                                <label for="selectCategory" class="toolbarLabel">Category : </label>
                                <select id="selectCategory" class="toolbarDropdown">
                                </select>
                            </div>

                            <div class = "toolbarLabelDropWrapper">
                                <label for="selectSubcategory" class="toolbarLabel">Subcategory : </label>
                                <select id="selectSubcategory" class="toolbarDropdown"></select>
                            </div>
                        </div>

                        <div class="toolbarSelectGroup no-show">
                            <div class = "toolbarLabelDropWrapper">
                                <label for="selectLocation" class="toolbarLabel">Location : </label>
                                <select id="selectLocation" class="toolbarDropdown no-show">

                                </select>
                            </div>

                            <div class = "toolbarLabelDropWrapper no-show">
                                <label for="selectRegressionType" class="toolbarLabel">Regression : </label>
                                <select id="selectRegressionType" class="toolbarDropdown no-show">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="loader"></div>
		<div class = "mapInPage">
            <?php
                readfile('resources/svg/RO_Map.svg');
            ?>
		</div>

        <script type="application/javascript" src="scripts/mapView.js"></script>
        <script type="application/javascript" src = "scripts/graph/loadCategories.js"></script>
    </body>
</html>