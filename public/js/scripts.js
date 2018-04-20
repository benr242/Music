$(document).ready(function() {
    //$("#demo").html("Hello, World!");
    $("#demo").html("Hello, World!!!!");

    $("#demo").click(function () {
        //$(this).hide();
        $(this).addClass("blue");
    })

    $('#repolist > li:nth-child(odd)').addClass('altRow');
})