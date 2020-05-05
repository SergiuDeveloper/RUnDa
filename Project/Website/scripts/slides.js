let slideIndex = 1;
let timeout;
let ignoreSleep = false;
showSlides(slideIndex);

function plusSlide(n){
    clearTimeout(timeout);
    showSlides(slideIndex += n);
}

function currentSlide(n){
    clearTimeout(timeout);
    showSlides(slideIndex = n);
}
/*
function onMouseOverSlides(){
    console.log("m over");
    ignoreSleep = true;
    timeout = null;
}

function onMouseLeaveSlides(){
    console.log("m left");
    ignoreSleep = false;
    showSlides(slideIndex);
}
*/
function showSlides(n){
    //if(ignoreSleep)
       // return;
    let i;
    const slides = document.getElementsByClassName("slideContainer");
    const dots = document.getElementsByClassName("dotSlide");
    const slideDescriptions = document.getElementsByClassName("slideshowDescription");

    /*for(i = 0; i < slides.length; i++){
        slides[i].addEventListener("mouseenter", onMouseOverSlides);
        slides[i].addEventListener("mouseleave", onMouseLeaveSlides);
    }

    for(i = 0; i < slideDescriptions.length; i++){
        slideDescriptions[i].addEventListener("mouseenter", onMouseOverSlides);
        slideDescriptions[i].addEventListener("mouseleave", onMouseLeaveSlides);
    }*/

    //console.log(slideDescriptions.toString());

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

    //if(ignoreSleep === false)
    timeout = setTimeout(showSlides, 5000);
}