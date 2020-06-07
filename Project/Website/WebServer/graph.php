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
                <div class = "graphSelect" onchange="changeGraph()">
                    <label for="graphSelectObj"></label>
                    <select id = "graphSelectObj">
                        <option class = "graphs" value = "0" onselect="graphChanged(0)"> Vertical Bar Chart </option>
                        <option class = "graphs" value = "1" onselect="graphChanged(1)"> Pie Chart </option>
                        <option class = "graphs" value = "2" onselect="graphChanged(2)"> Line Datasets </option>
                        <option class = "graphs" value = "3" onselect="graphChanged(3)"> Data Set Chart </option>
                        <option class = "graphs" value = "4" onselect="graphChanged(4)"> Country Map Chart </option>
                    </select>
                </div>

                <div class = "toolbar">
                    <button onclick="toggleSmooth(this)" id = "smoothGraphButton" class="toolbarButton">Smooth</button>

                    <label for="selectCategory" class="toolbarLabel">Category : </label>
                    <select id="selectCategory" class="toolbarDropdown">
                    </select>

                    <label for="selectSubcategory" class="toolbarLabel">Subcategory : </label>
                    <select id="selectSubcategory" class="toolbarDropdown">

                    </select>

                    <label for="selectLocation" class="toolbarLabel">Location : </label>
                    <select id="selectLocation" class="toolbarDropdown">

                    </select>

                    <label for="selectRegressionType" class="toolbarLabel">Regression : </label>
                    <select id="selectRegressionType" class="toolbarDropdown">
                    </select>
                </div>

                <div class = "exportInput">
                    <button id = "exportButton"> Export Data </button>
                </div>

            </div>

            <div class = "graph">
				<canvas class = "charts" id = "chart0" width = "400" height = "400"></canvas>
				<canvas class = "charts" id = "chart1" width = "400" height = "400"></canvas>
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