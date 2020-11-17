(function ($) {
    $('.switch__option').on('click', function () {
        var $this = $(this);
        $this.closest('.switch').find('.switch__option').removeClass('is-active');
        $this.addClass('is-active');
        $($this.data('elements-to-hide')).fadeOut(200, function() {
            $(this).removeClass('is-active');
            $($this.data('elements-to-show')).fadeIn(200).addClass('is-active');
        });

        return false;
    });
})(jQuery);