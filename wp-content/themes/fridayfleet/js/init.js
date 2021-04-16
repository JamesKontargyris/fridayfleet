window.addEventListener('load', function (e) {
    jQuery('.ajax-loader').removeClass('is-active');
});

(function ($) {
    window.ffInit = function () {

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
        $(".data-view__header--sticky").sticky({topSpacing: 0});

        // Datepicker
        $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            maxDate: '+0d'
        });
    }

    window.ffInit();

    // Scroll to page elements
    $('body').on('click', '.scroll-to-link', function (e) {
        e.preventDefault();
        var aid = $(this).attr("href");
        $('html,body').animate({scrollTop: $(aid).offset().top}, 'slow');
    });

    $('body').on('click', '.btn--key', function (e) {
        $('.data-view__legend').slideToggle();
    });

})(jQuery);