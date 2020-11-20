(function ($) {
    $('body').on('click', '.box__header__title', function (e) {
        if (!e.target.className.includes('help-icon')) {
            $(this).closest('.box').toggleClass('box--is-closed').find('.box__content').slideToggle(200);
        }
    });
})(jQuery);