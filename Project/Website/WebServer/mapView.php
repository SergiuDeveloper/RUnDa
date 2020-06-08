<!DOCTYPE html>

<html lang = "en">
    <head>
		<!-- Font? -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
		<link rel = "stylesheet" href = "css/layout.css">
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

		<div class = "mapInPage">
            <?php
                readfile('resources/svg/RO_Map.svg');
            ?>
		</div>
    </body>
</html>