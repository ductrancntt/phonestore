(function ($) {

    $("#product-image").on('mouseover', function () {
        $(this).css({'transform': 'scale(' + $(this).attr('data-scale') + ')'});
    }).on('mouseout', function () {
        $(this).css({'transform': 'scale(1)'});
    }).on('mousemove', function (e) {
        $(this).css({'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 + '%'});
    });

})(jQuery);