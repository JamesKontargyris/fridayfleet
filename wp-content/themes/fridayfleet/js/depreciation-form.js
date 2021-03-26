(function ($) {
    $('body').on('submit', 'form.depreciation-form', function (e) {

        var url = $(this).attr('action'),
            formData = $(this).serializeArray();

        window.ajaxSubmitForm(url, formData);

        e.preventDefault();
    });

})(jQuery);