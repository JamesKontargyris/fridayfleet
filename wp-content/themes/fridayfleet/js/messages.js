(function () {
    $('body').on('click', '.message__close', function() {
        $(this).parent('.message').slideUp();
    });
})(jQuery);