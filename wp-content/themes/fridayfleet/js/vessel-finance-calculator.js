(function ($) {
    $('body').on('submit', 'form.vessel-finance-calculator', function (e) {
        $('.form-errors').slideUp(200);
        var formData = $(this).serializeArray(),
            formErrors = ['Please address the following errors:'],
            haveErrors = 0;

        if(!formData[0]['value']) { // build date not entered
            formErrors.push('Build date is required.');
            haveErrors++;
        }

        if(formData[2]['value'] < 0 || formData[2]['value'] > 100) { // percentage is less than 0 or more than 100
            formErrors.push('Please enter a percentage between 1 and 100.');
            haveErrors++;
        }

        if(haveErrors) {
            $('.form-errors').html(formErrors.join('<br>'));
            $('.form-errors').slideDown(200);
        } else {
            window.ajaxSubmitVesselFinanceCalculator(formData);
        }

        e.preventDefault();
    });

})(jQuery);