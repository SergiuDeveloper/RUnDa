<!DOCTYPE html>

<html lang = "en">
    <head>
        <!-- Font? -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
        <link rel = "stylesheet" href = "css/layout.css">
        <link rel = "stylesheet" href = "css/slides.css">

        <title>
            Placeholder Title
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
        <div class="dropdown-menu">
            <div class="dropdown-content">
                <a href = "index.php"> Home </a>
                <a href = "graph.php"> Graph Statistics </a>
                <a href = "mapView.php"> Map View Statistics </a>
                <a href = "about.php"> About </a>
            </div>
        </div>
    </div>



    <div class = "slideshow">


        <div class = "slideshowContainer">
            <a class = "nextSlide" onclick = "plusSlide(0)"> &#10095 </a>
            <a class = "previousSlide" onclick = "plusSlide(-2)"> &#10094 </a>
            <div class = "slideContainer fade">
                <div class = "slideNumberText"> 1 / 4 </div>
                <img src = "resources/slides/SlideO.jpg" alt = "Slide 1" class="slideImage">
                <div class = "slideText"> Caption Text One </div>
            </div>

            <div class = "slideContainer fade">
                <div class = "slideNumberText"> 2 / 4 </div>
                <img src = "resources/slides/SlideT.jpg" alt = "Slide 2" class="slideImage">
                <div class = "slideText"> Caption Text Two </div>
            </div>

            <div class = "slideContainer fade">
                <div class = "slideNumberText"> 3 / 4 </div>
                <img src = "resources/slides/SlideTh.jpg" alt = "Slide 3" class="slideImage">
                <div class = "slideText"> Caption Text Three </div>
            </div>

            <div class = "slideContainer fade">
                <div class = "slideNumberText"> 4 / 4 </div>
                <img src = "resources/slides/SlideF.jpg" alt = "Slide 4" class="slideImage">
                <div class = "slideText"> Caption Text Four </div>
            </div>


            <div style = "text-align: center">
                <span class = "dotSlide" onclick = "currentSlide(1)"></span>
                <span class = "dotSlide" onclick = "currentSlide(2)"></span>
                <span class = "dotSlide" onclick = "currentSlide(3)"></span>
                <span class = "dotSlide" onclick = "currentSlide(4)"></span>
            </div>
        </div>
    </div>

    <section class = "contentPlaceholder">
        <div class = "contentItem descriptionPlaceholder">
            <div class = "slideshowDescription fade" style="display: none;">
                <h1>
                    Unemployment statistics, all in one place
                </h1>
                <p>
                    This website brings all information about Romania's unemployment data in one place.
                    Easy to use for everyone, we created a user interface for anybody to see all statistics, filtered or not.
                </p>
            </div>

            <div class = "slideshowDescription fade" style="display: none;">
                Slide description 2
            </div>

            <div class = "slideshowDescription fade" style="display: none;">
                Slide description 3
            </div>

            <div class = "slideshowDescription fade" style="display: none;">
                Slide description 4
            </div>
        </div>

        <div class = "contentItem extraPlaceholder">
            Placeholder Extra

        </div>
    </section>

    <footer>
        Placeholder footer
    </footer>

    <script src = "scripts/slides.js"></script>

    </body>

</html>