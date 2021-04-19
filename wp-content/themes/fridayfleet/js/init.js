(function ($) {
    // Make page loader animation appear when a link to a new page is clicked
    $("a[href^='//']:not([target='_blank']):not('.is-unclickable'), a[href^='http://']:not([target='_blank']):not('.is-unclickable'), a[href^='https://']:not([target='_blank']):not('.is-unclickable')")
        .on('click', function () {
            $('.ajax-loader--page').addClass('is-active');
        });

    // elements and events that should be reinitialised after an AJAX call
    window.reInit = function() {
        // Options and init for tooltips (not graph ones)
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
    }

    // Call on page load
    window.reInit();


    // Close boxes that are set to is-closed on page load
    $('.box--is-closed').find('.box__content').hide();

    // Make tab header sticky on scroll
    $(".data-view__header--sticky").sticky({topSpacing: 0});

    // Datepicker
    $('.datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy',
        maxDate: '+0d'
    });

    // Scroll to page elements
    $('body').on('click', '.scroll-to-link', function (e) {
        e.preventDefault();
        var aid = $(this).attr("href");
        $('html,body').animate({scrollTop: $(aid).offset().top}, 'slow');
    });

})(jQuery);