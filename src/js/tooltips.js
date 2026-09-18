$(function () {
    $('.icon_help').on('mouseenter', function () {
        $($(this).data('hint')).stop(true, true).fadeIn();
    });

    $('.icon_help').on('mouseleave', function () {
        $('.real-hint').stop(true, true).fadeOut();
    });
});