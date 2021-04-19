(function ($) {
    // Toggle visibility of trend data in data tables
    $('body').on('change', '.toggle-trend-data', function () {
        var checkbox = $(this).closest('input[type=checkbox]'),
            classToToggle = $(this).data('class-to-toggle');

        if (checkbox.prop("checked") == true) {
            $(classToToggle).show();
        } else {
            $(classToToggle).hide();
        }
    });
})(jQuery);