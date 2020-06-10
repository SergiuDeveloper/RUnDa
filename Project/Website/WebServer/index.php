
<!DOCTYPE html>

<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
        <link rel = "stylesheet" href = "css/layout.css">
        <link rel = "stylesheet" href = "css/slides.css">
        <link rel = "stylesheet" href = "css/responsive.css">
        <link rel = "stylesheet" href = "css/adminAuth.css">
        <link rel="icon" type="image/x-icon" href="favicon.ico"/>
        <title>
            RunDA
        </title>
    </head>

    <body>
        <header>
            <img src="resources/logo/Logo.png" alt="Logo" width="80" height="50">
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

            <button onclick="logout();" id="logoutButton" style="display: none;"> Logout </button>

            <div class="adminMenu" id="adminMenuDiv">
                Admin?
                <label for="adminEmailInput" class="descriptionLabel">
                    Email :
                    <input type="email" id="adminEmailInput" name="email">
                </label>
                <label for="adminPasswordInput" class="descriptionLabel">
                    Password :
                    <input type="password" id="adminPasswordInput" name="token">
                </label>
                <button onclick="authenticateAdmin();">
                    Login
                </button>
            </div>

        </div>
        <div class="firstSlide">
            <img src = "resources/phoneSlides/slide1.jpg" alt = "Phone Slide 1" class="phoneSlideImage">
        </div>
        <div class="secondSlide">
            <img src = "resources/phoneSlides/phoneslide2.jpg" alt = "Phone Slide 2" class="phoneSlideImage">
        </div>
        <div class="thirdSlide">
            <img src = "resources/phoneSlides/slide3.jpg" alt = "Phone Slide 3" class="phoneSlideImage">
        </div>
        <div class="forthSlide">
            <img src = "resources/phoneSlides/slide2.jpg" alt = "Phone Slide 1" class="phoneSlideImage">
        </div>

        <div class = "slideshow">
            <div class="slideshowWrapper">
                <div class = "slideshowContainer">
                    <a class = "nextSlide" onclick = "plusSlide(0)"> &gt; </a>
                    <a class = "previousSlide" onclick = "plusSlide(-2)"> &lt; </a>
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
                </div>
            </div>

            <div class="dotWrapper">
                <div style = "text-align: center">
                    <span class = "dotSlide" onclick = "currentSlide(1)"></span>
                    <span class = "dotSlide" onclick = "currentSlide(2)"></span>
                    <span class = "dotSlide" onclick = "currentSlide(3)"></span>
                    <span class = "dotSlide" onclick = "currentSlide(4)"></span>
                </div>
            </div>
        </div>

        <div class = "contentPlaceholder">
            <div class = "contentItem descriptionPlaceholder">
                <div class = "slideshowDescription fade" style="display: none;">
                    <p>
                        The Romanian economy is currently enjoying a period of grace. According to the latest information
                        provided by the country’s statistics office, GDP advanced in the first semester by 4.1 per cent,
                        while at the end of August, the unemployment rate was 3.46 per cent compared with an average of
                        8.3 per cent in the euro area. It is important to note that 70 per cent of Romania’s unemployed
                        reside in rural areas while one third of the total number is represented by people with no
                        qualifications.
                    </p>
                </div>

                <div class = "slideshowDescription fade" style="display: none;">
                    Restructuring the economy through massive closures was a painful process and we are now witnessing
                    the consequences. It has been a tragic experience for people in their forties and fifties in a
                    country with limited job offers, almost impossible to find a new, reliable work place in the same
                    geographical area and during a period when new investments were scarce.  Consequently, many of those
                    people who became unemployed following massive lay-offs after being paid a certain amount as
                    compensation no longer registered with unemployment offices which have long been passive with
                    respect to implementing active labour market policies.
                </div>

                <div class = "slideshowDescription fade" style="display: none;">
                    As such, the Romanian labour market is confronted with multiple challenges, and one major problem is
                    precisely the continuous reduction firstly in terms of volume of workforce and secondly of quality
                    and availability for work. We are more than ever at a crossroads, 15 years after the beginning of the
                    largest migration of Romanians since World War II.The UN estimates that, as of 2017,
                    around 3.58 million Romanians had emigrated to developed EU countries since 2000, especially Italy
                    and Spain. In addition, working age emigrants exceeded 2.65 million persons, accounting for about 20
                    per cent of the Romanian working population. Their remittances in 2016 amounted to 1.9 per cent of
                    GDP from a peak of 4.5 per cent in 2008. The World Bank estimates that Romanians who now live and
                    work in other EU countries have sent home during the past ten years of EU membership over 52 billion
                    euros, which also significantly contributed to raising the living standard of their families back
                    home, especially in rural areas and small towns, and also improving country’s balance of payments.
                </div>

                <div class = "slideshowDescription fade" style="display: none;">
                    In its report on the 2018 Convergence Programme of Romania issued in May this year, the Council of
                    the EU stated that Romania has substantial unused labour potential, and several groups such as young
                    people, Roma, the long-term unemployed and people with disabilities have difficulties in accessing
                    the labour market. In the past year, Romania made little progress addressing the country-specific
                    recommendation to strengthen targeted activation policies and integrated public services, focusing
                    on those furthest away from the labour market.
                </div>
            </div>

            <div class = "contentItem extraPlaceholder" id="newsContainer">
            </div>
        </div>

        <footer>

        </footer>


        <script>
            let adminToken = false;

        </script>
        <script>
            function updateAdminSession(){
                adminToken = true;
                checkAdminToken();
            }

            function logout() {
                adminToken = false;
                checkAdminToken();
                hideAdminElements();
            }
        </script>
        <script src = "scripts/slides.js"></script>
        <script src = "scripts/newsScripts.js"></script>
        <script src = "scripts/buttonEvents.js"></script>
    </body>

</html>