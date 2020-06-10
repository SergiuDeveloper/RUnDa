<!DOCTYPE html>

<html lang = "en">
	<head>
		<!-- Font? -->
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
        <link rel = "stylesheet" href = "css/layout.css">
		<link rel = "stylesheet" href = "css/graphLayout.css">
		<link rel = "stylesheet" href = "css/graphStyle.css">
        <link rel="icon" type="image/x-icon" href="favicon.ico"/>
        <title>
            RunDA
        </title>
    </head>

    <body>
        <div class="subscriptionPopup" id = "exportSubscriptionPopup">
            <div class="subscriptionPopupBlock">
                <button class="closeButton" onclick="closePopup()">
                    x
                </button>
                <div class="headingWrapper">
                    <h3 id="subscriptionHeading"> Subscribe to automatically receive free monthly exports via email </h3>
                </div>
                <div class="center-elem">
<!--                        <div class="inputPopup">-->
                        <label for="subscriptionEmailInput" id ="popupEmailLabel"> Input your email here :
                            <input type="email" id="subscriptionEmailInput">
                        </label
                        <button class="popupSubscribeButton" onclick="subscribe();">Subscribe</button>
<!--                        </div>-->
                </div>
            </div>
        </div>

        <header>
            <img src="resources/logo/Logo.png" alt="Logo" width="80" height="49">
        </header>

        <div class="menu-nav">
            <button class="menuButton" onclick="dropdownClicked()"></button>
            <a href = "index.php"> Home </a>
            <a href = "graph.php"> Graph Statistics </a>
            <a href = "mapView.php"> Map View Statistics </a>
            <a href = "about.php"> About </a>

            <div class="dropdown-menu">
                <div class="dropdown-content" id="menuResponsive">
                    <a href = "index.php"> Home </a>
                    <a href = "graph.php"> Graph Statistics </a>
                    <a href = "mapView.php"> Map View Statistics </a>
                    <a href = "about.php"> About </a>
                </div>
            </div>

        </div>
        
        <section class = "toolbarContainer">
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
                    <label for="exportDataTypeSelect">Export Data Type</label>
                    <select id="exportDataTypeSelect" onchange="updateExportDataURL(this.options[this.selectedIndex].value)">
                        <option value="JSON">JSON</option>
                        <option value="XML">XML</option>
                        <option value="CSV">CSV</option>
                    </select>

<!--                    <a id="exportButton" href="dataExport.php"> Export Data </a>-->
<!--                    <a id = "exportButton" href="dataExport.php"> Export Data </a>-->
                    <a id = "exportButton" onclick="exportClicked();" href="dataExport.php"> Export Data </a>
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

        <script src = "scripts/dataExport.js"></script>
		<script src = "scripts/externals/chartJS/Chart.js"></script>
		<script src = "scripts/graphSelect.js"></script>
        <script src = "scripts/graph/loadCategories.js"></script>
        <script src="./scripts/graph/exportPopup.js"></script>
	</body>
</html>