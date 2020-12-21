(function ($) {
    $('body').on('click', '.sub-menu a', function (e) {
        var url = $(this).attr('href'),
            dataView = $('#data-view-value').val(),
            pageType = 'page',
            showDataViewSelect = 0;

        $('#current-url').val(url);
        $('#page-type').val(pageType);

        $('.nav-bar__menu a').removeClass('is-active');
        if($('.hamburger').hasClass('is-active')) { // sub-menu was triggered by hamburger, so close the menu
            $('.sub-menu').slideUp();
            $('.hamburger').removeClass('is-active');
        }
        window.ajaxUpdate(url, dataView, pageType, showDataViewSelect);

        e.preventDefault();
    });
})(jQuery);