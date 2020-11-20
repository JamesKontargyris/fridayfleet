(function ($) {
    window.updateDataViewValue = function() {
        // Set the custom select to the correct value on page load
        $('.data-view-' + $('#data-view-value').val()).prop('checked', true);
    }

    window.updateDataViewValue();

    $('body').on('click', '.custom-select', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).toggleClass('expanded');
        $('.' + $(e.target).attr('for')).prop('checked', true);
        if ($('#page-type').val() == 'data-view' && ($('#data-view-value').val() != $(e.target).data('view-name'))) {
            var currentUrl = $('#current-url').val();
            window.ajaxUpdate(currentUrl, $(e.target).data('view-name'), 'data-view');
        }
        $('#data-view-value').val($(e.target).data('view-name'));
    });

    $(document).bind('click', function () {
        $('.custom-select').removeClass('expanded');
    });

})(jQuery);