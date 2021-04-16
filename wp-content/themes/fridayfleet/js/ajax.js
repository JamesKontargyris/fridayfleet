(function ($) {
    window.ajaxPageUpdate = function (url = '', dataView = '', pageType = '') {

        if (dataView && pageType == 'data-view') {
            url = url + '&data-view=' + dataView;
        }

        jQuery.ajax({
            url: url,
            beforeSend: function (xhr) {
                $('.ajax-loader--page').addClass('is-active');
            }
        })
            .done(function (data) {
                $('.ajax-page').html(data);
                // Reinitialise events etc.
                if (pageType == 'data-view') {
                    window.ffInit();
                }
                $('.ajax-loader--page').removeClass('is-active');
            })

            .fail(function () {
                var content = '<main id="primary" class="site__body"><div class="message message--error">ERROR: page not found.</div></main>'
                $('.ajax-page').html(content);
                $('.ajax-loader--page').removeClass('is-active');
            })

    }

    window.ajaxSubmitVesselFinanceCalculator = function (formData) {

        jQuery.ajax({
            type: "POST",
            url: ffAjax.ajaxurl,
            data: {
                action: 'update_vessel_finance_calculator',
                form_data: formData
            },
            beforeSend: function (xhr) {
                $('#ajax-loader--vessel-finance-calculator').addClass('is-active');
            }
        })
            .done(function (data) {
                $('.ajax-section--vessel-finance-calculator').html(data);
                // Reinitialise events etc.
                // window.ffInit();
                $('#ajax-loader--vessel-finance-calculator').removeClass('is-active');
            })

            .fail(function () {
                var content = '<div class="message message--error">ERROR: data not found for build date entered. Please try another date.</div>'
                $('.ajax-section--vessel-finance-calculator').html(content);
                $('#ajax-loader--vessel-finance-calculator').removeClass('is-active');
            })

    }
})(jQuery);