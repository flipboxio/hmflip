"use strict"

function lightbox(idx) {
    //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
    $('#showSlider').removeClass("d-none");
    nslider.init(idx);
    $("#ninja-slider").addClass("fullscreen");
}

function fsIconClick(isFullscreen) { //fsIconClick is the default event handler of the fullscreen button
    if (isFullscreen) {
        $('#showSlider').addClass("d-none");
    }
}