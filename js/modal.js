$("[modal]").click(function () {
    var id = this.getAttribute("modal");

    $("#"+id).css("display","block");

})

$(".close").click(function () {
    $(".modal").css("display","none");
})
