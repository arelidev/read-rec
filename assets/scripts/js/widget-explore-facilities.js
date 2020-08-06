jQuery(document).ready(function ($) {
    $('.explore-facilities-main-slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        prevArrow: ".widget-explore-facilities-main-slider-nav-prev",
        nextArrow: ".widget-explore-facilities-main-slider-nav-next",
    });

    $('a[data-slide]').on('click', function(e) {
        e.preventDefault();
        let slide = $(this).data('slide');
        $('a[data-slide]').removeClass('active');
        $(this).addClass('active');
        $('.explore-facilities-main-slider').slick('slickGoTo', slide - 1);
    });
})
