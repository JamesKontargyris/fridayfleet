(function ($) {


    $('.switcher__option').on('click', function () {
        var elementToHide = $(this).data('switcher-element-to-hide');
        var elementToShow = $(this).data('switcher-element-to-show');

        $(this).closest('.switcher').find('.switcher__option').removeClass('is-active');
        $(this).addClass('is-active');

        $.when($(elementToHide).fadeOut(200)).done(function () {
            $(elementToShow).fadeIn(200);
        });
    });
})(jQuery);