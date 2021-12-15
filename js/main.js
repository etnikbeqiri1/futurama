var i = 0;
var j = 0;

slider();
checkWindowSize();
testimonial();

function testimonial() {
    changeTestimonialPage(j)
    j = (j + 1) % testimonials.length;

    setInterval(function() {
        changeTestimonialPage(j)
        j = (j + 1) % testimonials.length;
    }, 3000)
}

function stars(stars) {
    var html = "";
    for (var i = 0; i < stars; i++) {
        html = html + '<i class="fa fa-star"></i> ';
    }
    for (var i = 0; i < 5 - stars; i++) {
        html = html + '<i class="fa fa-star" style="color:#cdcdcd"></i> ';
    }
    return html;
}

function changeTestimonialPage(i) {
    $(".testmonialProfile").fadeOut(function() {
        $(".testmonialProfile img").attr("src", testimonials[i]["picture"]);
        $(".testmonialProfile h2").html(testimonials[i]["name"])
        $(".testmonialProfile span").html(testimonials[i]["role"])
        $(".testmonialText").html(testimonials[i]["message"])
        $(".stars").html(stars(testimonials[i]["rating"]))
        $(".testmonialProfile").fadeIn();
    })
}


function slider() {
    changeSliderPage(i)
    i = (i + 1) % sliderData.length;

    setInterval(function() {
        changeSliderPage(i)
        i = (i + 1) % sliderData.length;
    }, 10000)
}

function changeSliderPage(i) {
    console.log(sliderData[i]);
    $(".slider-image").fadeOut(function() {
        $(".slider-image").attr("src", sliderData[i]["image"]).fadeIn();
    })
    $('#slider').animate({ backgroundColor: sliderData[i]["color"] }, 'slow');
    new Typewriter('#typedTitle', {
        strings: sliderData[i]["title"],
        autoStart: true,
    });
    $("#typedDesicripion").html(sliderData[i]["description"])

}
var clicked = false;

function showMenu() {
    $("#menuNav").slideToggle();
    if (!clicked) {
        $("#nav-icon").removeClass("fa-bars")
        $("#nav-icon").addClass("fa-times");
        clicked = true;
    } else {
        $("#nav-icon").removeClass("fa-times")
        $("#nav-icon").addClass("fa-bars");
        clicked = false;
    }
}

function checkWindowSize() {
    console.log($(window).width());
    if ($(window).width() <= 660) {
        $("#menuNav").hide();
    } else {
        $("#menuNav").show();
        clicked = false;
        $("#nav-icon").removeClass("fa-times")
        $("#nav-icon").addClass("fa-bars");
    }
}
$(window).resize(function() {
    checkWindowSize()
});