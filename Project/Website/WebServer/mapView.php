<!DOCTYPE html>

<html lang = "en">
    <head>
		<!-- Font? -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
		<link rel = "stylesheet" href = "css/layout.css">
        <link rel = "stylesheet" href = "css/graphLayout.css">
        <link rel = "stylesheet" href = "css/map.css">
		
		<title>
			Placeholder Title
		</title>
	</head>
    <body>
        <header>
			Placeholder header
		</header>

        <div class="menu-nav">

            <a href = "index.php"> Home </a>
            <a href = "graph.php"> Graph Statistics </a>
            <a href = "mapView.php"> Map View Statistics </a>
            <a href = "about.php"> About </a>
            <div class="dropdown-menu">
                <button class="dropdown-button">
                    MENU
                </button>
                <div class="dropdown-content">
                    <a href = "index.php"> Home </a>
                    <a href = "graph.php"> Graph Statistics </a>
                    <a href = "mapView.php"> Map View Statistics </a>
                    <a href = "about.php"> About </a>
                </div>
            </div>
        </div>

        <section class = "toolbarContainer">
            <div class = "inputs">
                <div class = "exportInput">
                    <a id = "exportButton" href="dataExport.php"> Export Data </a>
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
        </section>

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