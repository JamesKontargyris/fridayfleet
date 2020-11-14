(function ($) {
    $('.tooltip--help').tooltipster({
        animation: 'grow',
        delay: 200,
        maxWidth: 500,
        side: 'bottom',
        trigger: 'custom',
        triggerOpen: {
            click: true,
            tap: true
        },
        triggerClose: {
            click: true,
            scroll: true
        }
    });

    // Close boxes that are set to is-closed on page load
    $('.box--is-closed').find('.box__content').hide();
})(jQuery);