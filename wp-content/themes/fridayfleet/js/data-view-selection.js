(function () {
    $('body').on('click', '.show-data-view-menu', function (e) {
        $('.data-view-selection-menu-container').addClass('is-active');

        e.preventDefault();
    });

    // close the data view selection menu
    $('body').on('click', '.data-view-selection-menu__close', function (e) {
        $('.data-view-selection-menu-container').removeClass('is-active');

        e.preventDefault();
    });

    // deals with any requests to change the data view, e.g. from fixed age value to depreciation
    $('body').on('click', '.data-view-selector', function (e) {

        var url = $(this).attr('href'),
            dataView = $(this).data('view-to-load'),
            pageType = 'data-view';

        $('#current-url').val(url);
        $('#data-view-value').val(dataView);

        $('.data-view-selection-menu-container').hide();

        window.ajaxUpdate(url, dataView, pageType);

        e.preventDefault();
    });

})(jQuery);