(function ($) {
    // Scroll to page elements
    $(".scroll-to-link").click(function (e) {
        e.preventDefault();
        var aid = $(this).attr("href");
        $('html,body').animate({scrollTop: $(aid).offset().top}, 'slow');
    });

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

    // Make tab header sticky on scroll
    $(".tab__header--sticky").sticky({topSpacing: 0});


})(jQuery);