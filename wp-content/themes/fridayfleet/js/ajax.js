(function ($) {
    window.ajaxUpdate = function (url = '', dataView = '', pageType = '') {

        if (dataView && pageType == 'data-view') {
            url = url + '&data-view=' + dataView;

        }

        jQuery.ajax({
            url: url,
            beforeSend: function (xhr) {
                $('.ajax-loader').addClass('is-active');
            }
        })
            .done(function (data) {
                $('.ajax-page').html(data);
                // Reinitialise events etc.
                if (pageType == 'data-view') {
                    window.ffInit();
                }
                $('.ajax-loader').removeClass('is-active');
            })

            .fail(function () {
                var content = '<main id="primary" class="site__body"><div class="message message--error">ERROR: page not found.</div></main>'
                $('.ajax-page').html(content);
                $('.ajax-loader').removeClass('is-active');
            })

    }

    window.ajaxSubmitForm = function (url = '', formData) {

        jQuery.ajax({
            type: "POST",
            url: url,
            data: formData,
            beforeSend: function (xhr) {
                $('.ajax-loader').addClass('is-active');
            }
        })
            .done(function (data) {
                $('.ajax-page').html(data);
                // Reinitialise events etc.
                window.ffInit();
                $('.ajax-loader').removeClass('is-active');
            })

            .fail(function () {
                var content = '<main id="primary" class="site__body"><div class="message message--error">ERROR: page not found.</div></main>'
                $('.ajax-page').html(content);
                $('.ajax-loader').removeClass('is-active');
            })

    }
})(jQuery);