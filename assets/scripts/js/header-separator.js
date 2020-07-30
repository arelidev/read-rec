jQuery(document).ready(function ($) {
    const headerSpacer = $('.header-spacer');
    const headerHeight = $('.header').outerHeight(true);

    headerSpacer.css('height', headerHeight + "px");
})
