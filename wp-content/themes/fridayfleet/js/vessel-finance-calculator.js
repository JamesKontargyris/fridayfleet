(function ($) {
    $('body').on('submit', 'form.vessel-finance-calculator', function (e) {
        $('.form-errors').slideUp(200);
        var formData = $(this).serializeArray();

        if(formData[0]['value']) { // build date entered
            window.ajaxSubmitVesselFinanceCalculator(formData);
        } else {
            $('.form-errors__errors').text('Build date is required.');
            $('.form-errors').slideDown(200);
        }

        e.preventDefault();
    });

})(jQuery);