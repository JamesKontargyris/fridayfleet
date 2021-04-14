(function ($) {
    // Display latest year data
    var year = $('tbody.content--value-over-time-quarters tr:first-child').data('year');
    $('tbody.content--value-over-time-quarters tr[data-year-data=' + year + ']').addClass('is-active');

    $('body').on('click', '.data-table__sub-title', function () {
        var year = $(this).data('year');
        $(this).toggleClass('is-active');
        $('.content--value-over-time-quarters tr[data-year-data=' + year + ']').toggleClass('is-active');
    });
})(jQuery);