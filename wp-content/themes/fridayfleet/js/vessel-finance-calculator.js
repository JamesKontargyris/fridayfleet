(function ($) {
    $('body').on('submit', 'form.vessel-finance-calculator', function (e) {

        var formData = $(this).serializeArray();

        window.ajaxSubmitVesselFinanceCalculator(formData);

        e.preventDefault();
    });

})(jQuery);