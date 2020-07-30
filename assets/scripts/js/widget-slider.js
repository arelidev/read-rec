jQuery(document).ready(function($){
    const backgroundImage = $('.widget-slider-background');
    const slideControl = $('.widget-slider-control');

    $('.widget-slider').on('init', function(event, slick, direction){
        const currentSlide = $(this).find('.slick-current').find('.widget-slider-slide').attr('data-background');
        backgroundImage.css('background-image', 'url("' + currentSlide + '")');
    }).slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        prevArrow: ".widget-slider-nav-prev",
        nextArrow: ".widget-slider-nav-next",
    }).on('afterChange', function(event, slick, currentSlide, nextSlide){
        const getBackground = $(this).find('[data-slick-index="'+currentSlide+'"]').find('.widget-slider-slide').attr('data-background');
        backgroundImage.css('background-image', 'url("' + getBackground + '")');

        slideControl.removeClass('active');
        $('#slide-control-' + currentSlide).addClass('active');
    });
})
