(function ($) {
    $('.nav-bar__menu a').on('click', function () {
        var shipType = $(this).data('ship');

        if (!$(this).hasClass('is-active')) {

            $('.nav-bar__menu a').removeClass('is-active');
            $(this).addClass('is-active');

            // Load data
            $.ajax({
                url: "/data-view?ship=" + shipType,
                beforeSend: function (xhr) {
                    $('.ajax-loader').addClass('is-active');
                }
            })
                .done(function (data) {
                    $('.ajax-page').html(data);
                    // Reinitialise events etc.
                    window.ffInit();
                    window.switchInit();
                    window.boxInit();
                    $('.ajax-loader').removeClass('is-active');
                });

        }

        // return false;
    });
})(jQuery);