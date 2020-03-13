var slideIndex = 1;
var timeout;
showSlides(slideIndex);

function plusSlide(n){
    clearTimeout(timeout);
    showSlides(slideIndex += n);
}

function currentSlide(n){
    clearTimeout(timeout);
    showSlides(slideIndex = n);
}

function showSlides(n){
    var i; 
    var slideDescriptions = document.getElementsByClassName("slideshowDescription");
    var slides = document.getElementsByClassName("slideContainer");
    var dots = document.getElementsByClassName("dotSlide");
    if(n > slides.length) {
        slideIndex = 1;
    }
    if(n < 1){
        slideIndex = slides.length - (-n);
    }

    for(i = 0; i < slides.length; i++){
        slides[i].style.display = "none";
        slideDescriptions[i].style.display = "none";
    }

    for(i = 0; i < dots.length; i++){
        dots[i].className = dots[i].className.replace(" active", "");
    }

    slides[slideIndex-1].style.display = "block";
    slideDescriptions[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";

    slideIndex++;
    if(slideIndex > slides.length){
        slideIndex = 1;
    }

    timeout = setTimeout(showSlides, 2000);
}