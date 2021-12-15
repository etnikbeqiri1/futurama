checkWindowSize();
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

$(window).resize(function () {
    checkWindowSize()
});
$( document ).ready(function() {
    $(".menuRow").first().click().trigger( "click" );
});


$(".menuRow").click(function () {
    let module = this.getAttribute("open");
    console.log(module);
    $(".active").removeClass("active");
    $(this).addClass("active");
    $.get(module, function (data) {
        $("#container").html(data);
        $("#container").fadeIn(200);
    });
})
