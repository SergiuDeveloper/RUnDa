<!DOCTYPE html>

<html lang = "en">
	<head>
		<!-- Font? -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
        <link rel = "stylesheet" href = "css/layout.css">
		<link rel = "stylesheet" href = "css/graphLayout.css">
		<link rel = "stylesheet" href = "css/graphStyle.css">
		<title>
			Placeholder Graph Title
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
        
        <section class = "graphContainer">
            <div class = "graphDescription">
                <h3> Graph Placeholder below </h3>
            </div>

            <div class = "inputs">

                <div class = "graphSelect">
                    <label for="graphSelectObj"></label>
                    <select id = "graphSelectObj" onchange="renderChart(this.options[this.selectedIndex].value)">
                        <option class = "graphs" value="bar"> Bar Chart </option>
                        <option class = "graphs" value="pie"> Pie Chart </option>
                        <option class = "graphs" value="line"> Line Chart </option>
                        <option class = "graphs" value="radar"> Radar Chart </option>
                        <option class = "graphs" value="polarArea"> Polar Area Chart </option>
                    </select>
                </div>

                <div class = "exportInput">
                    <a id = "exportButton" href="dataExport.php"> Export Data </a>
                </div>
                <div class = "toolbar">

                    <div class="toolbarButtonsWrapper">
                        <button onclick="toggleSmooth(this)" id = "smoothGraphButton" class="toolbarButton">Smooth</button>
                    </div>

                    <div class="toolbarSelectWrapper">

                        <div class="toolbarSelectGroup">

                            <div class = "toolbarLabelDropWrapper">
                                <label for="selectCategory" class="toolbarLabel">Category : </label>
                                <select id="selectCategory" class="toolbarDropdown">
                                </select>
                            </div>

                            <div class = "toolbarLabelDropWrapper">
                                <label for="selectSubcategory" class="toolbarLabel">Subcategory : </label>
                                <select id="selectSubcategory" class="toolbarDropdown">

                                </select>
                            </div>

                        </div>

                        <div class="toolbarSelectGroup">

                            <div class = "toolbarLabelDropWrapper">
                                <label for="selectLocation" class="toolbarLabel">Location : </label>
                                <select id="selectLocation" class="toolbarDropdown">

                                </select>
                            </div>

                            <div class = "toolbarLabelDropWrapper">
                                <label for="selectRegressionType" class="toolbarLabel">Regression : </label>
                                <select id="selectRegressionType" class="toolbarDropdown">
                                </select>
                            </div>

                        </div>

                    </div>

                </div>


            </div>

            <div id = "graph">
				<canvas class = "charts" id = "chart"></canvas>
			</div>
        </section>

		<footer>
			Placeholder footer
		</footer>

		<script src = "scripts/externals/chartJS/Chart.js"></script>
		<script src = "scripts/graphSelect.js"></script>
        <script src = "scripts/graph/loadCategories.js"></script>
	</body>
</html>