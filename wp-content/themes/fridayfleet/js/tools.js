(function ($) {
    $('body').on('click', '.tool-menu__button--vessel-finance-calculator', function (e) {
        var $this = $(this);
        if ($this.hasClass('is-active')) { // tool is visible
            $('.tool-drawer').slideUp(function () {
                $this.removeClass('is-active').blur();
                $('.tool-drawer__tool--vessel-finance-calculator').hide();
            });
        } else { // tool isn't visible
            $this.addClass('is-active');
            $('.tool-drawer__tool--vessel-finance-calculator').show();
            $('.tool-drawer').slideDown(function() {
                $('input[name=build_date]').focus();
            });

        }
    });
})(jQuery);