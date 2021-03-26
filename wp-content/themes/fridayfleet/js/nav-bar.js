(function ($) {
    $('body').on('click', '.nav-bar__menu a, .change-ship', function (e) {

        var url = $(this).attr('href'),
            dataView = $('#data-view-value').val(),
            pageType = $(this).data('page-type'),
            shipType = $(this).data('ship');

        $('#current-url').val(url);
        $('#page-type').val(pageType);

        if (!$(this).hasClass('change-ship') && !$(this).hasClass('is-active')) {

            $('.nav-bar__menu a').removeClass('is-active');
            $(this).addClass('is-active');

            window.ajaxUpdate(url, dataView, pageType);

        }

        if($(this).hasClass('change-ship')) {
            $('.nav-bar__menu a').removeClass('is-active');
            $('.nav-bar__link__' + shipType).addClass('is-active');

            window.ajaxUpdate(url, dataView, pageType);
        }

        e.preventDefault();
    });

})(jQuery);