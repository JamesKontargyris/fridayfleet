(function () {
    // Toggle visibility of trend data in data tables
    $('body').on('change', '#view-trend-data', function () {
        var checkbox = $(this).closest('input[type=checkbox]');

        if (checkbox.prop("checked") == true) {
            $('.is-trend-data').show();
            $('.data-table__key').show();
        } else {
            $('.is-trend-data').hide();
            $('.data-table__key').hide();
        }
    });
})(jQuery);