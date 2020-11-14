(function($){
	$('.nav-bar__menu__link').on('click', function() {
	    $('.nav-bar__menu__link').removeClass('is-active');
	    $(this).addClass('is-active');

	    return false;
    });

	// Change switchable content
    $('a.change-ship').on('click', function () {
        var ship = $(this).data('ship');

        $.when($('.ship-content').fadeOut(200)).done(function() {
            $('.ship-content--' + ship).fadeIn(200);
        });

        return false;
    });
})(jQuery);