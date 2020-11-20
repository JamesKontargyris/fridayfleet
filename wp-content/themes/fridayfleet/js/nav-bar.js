(function ($) {
    $('.nav-bar__menu a').on('click', function (e) {

        var url = $(this).attr('href'),
            dataView = $('#data-view-value').val(),
            pageType = $(this).data('page-type'),
            showDataViewSelect = $(this).data('show-data-view-select');

        $('#current-url').val(url);
        $('#page-type').val(pageType);

        if (!$(this).hasClass('is-active')) {

            $('.nav-bar__menu a').removeClass('is-active');
            $(this).addClass('is-active');

            window.ajaxUpdate(url, dataView, pageType, showDataViewSelect);

        }

        e.preventDefault();
    });
})(jQuery);