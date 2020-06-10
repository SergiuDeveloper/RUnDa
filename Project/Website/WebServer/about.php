<!DOCTYPE html>

<html lang = "en">
    <head>
        <!-- Font? -->
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
        <link rel = "stylesheet" href = "css/about.css">
        <link rel = "stylesheet" href = "css/layout.css">
        <link rel = "stylesheet" href = "css/responsive.css">
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

        <div class="developers">
            <h1>
                Developers
            </h1>
            <div class="Sergiu" id="ser">
                <img src="resources/aboutPhotos/sergiu.jpg" class="Sphoto" alt="Sergiu" width="173" height="150">
                <p> Sergiu-Marian Nistor, Faculty of Computer Science Iasi, 2B6.  </p>
                <button onclick="sergiuButtonClicked()">Contact me!</button>
            </div>
            <div class="Diana" id="dia">
                <img src="resources/aboutPhotos/diana.jpg" alt="Diana" class="Dphoto" width="173" height="150">
                <p> Mihaela-Diana Pascariu, Faculty of Computer Science Iasi, 2B6.  </p>
                <button onclick="dianaButtonClicked()">Contact me!</button>
            </div>
            <div class="Vlad" id="vla">
                <img src="resources/aboutPhotos/vlad.jpg" alt="Vlad" class="Vphoto" width="173" height="150">
                <p> Vlad-Andrei Loghic, Faculty of Computer Science Iasi, 2B6.  </p>
                <button onclick="vladButtonClicked()">Contact me!</button>
            </div>
        </div>
    <script src="scripts/buttonEvents.js"></script>
    </body>
</html>