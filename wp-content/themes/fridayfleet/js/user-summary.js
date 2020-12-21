(function ($) {
    $('body').on('click', '.user-summary__icon', function () {
        $('.sub-menu').slideUp();
        $('.user-summary__menu').slideToggle();
        $('.hamburger').removeClass('is-active');
    });
})(jQuery);