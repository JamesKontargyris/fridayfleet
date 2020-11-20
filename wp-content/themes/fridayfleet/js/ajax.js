(function ($) {
    window.ajaxUpdate = function (url = '', dataView = '', pageType = '', showDataViewSelect = '1') {

        if(dataView && pageType == 'data-view') {
            url = url + '&data-view=' + dataView;

        }

        console.log(url + ' / ' + dataView + ' / ' + pageType);

        jQuery.ajax({
            url: url,
            beforeSend: function (xhr) {
                $('.ajax-loader').addClass('is-active');
            }
        })
            .done(function (data) {
                $('.ajax-page').html(data);
                // Reinitialise events etc.
                window.ffInit();
                window.updateDataViewValue();
                if(showDataViewSelect == '1') {
                    $('.custom-select').addClass('is-active');
                } else {
                    $('.custom-select').removeClass('is-active');
                }
                $('.ajax-loader').removeClass('is-active');
            })

            .fail(function() {
                var content = '<main id="primary" class="site__body"><div class="message message--error">ERROR: page not found.</div></main>'
                $('.ajax-page').html(content);
                $('.ajax-loader').removeClass('is-active');
            })

    }
})(jQuery);