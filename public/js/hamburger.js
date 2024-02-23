//Burger menu switcher
$(document).ready(function (){
    $('#navToggle').click(function(e) {
        e.preventDefault();
        $('#nav').toggleClass("show");

    })
});

/*-----------------Burger menu User buttons---------------------*/

$(window).on('load', function(){
    var win = $(this); //this = window
    if (win.width() < 750) {
        $('.header-menu').append($('.header-login'));
        $('.header-login').css("display", "flex");

    } else {
        $('.header-right').prepend($('.header-login'));
    }

});

/*---- Move .User div inside .header-menu div depending on screen size---*/
$(window).on('resize', function(){

    if (window.matchMedia('(max-width: 750px)').matches) {
        $('.header-menu').append($('.header-login'));
        $('.header-login').css("display", "flex");
    } else {
        $('.header-right').prepend($('.header-login'));
    }

});