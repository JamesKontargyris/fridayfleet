(function ($) {
    $('.switch__option').on('click', function () {
        var $this = $(this);
        $this.closest('.switch').find('.switch__option').removeClass('is-active');
        $this.addClass('is-active');
        $($this.data('elements-to-hide')).removeClass('is-active');
        $($this.data('elements-to-show')).addClass('is-active');
    });
})(jQuery);