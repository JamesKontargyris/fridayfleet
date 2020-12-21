(function($){
	$('body').on('click', '.hamburger', function() {
	    $(this).toggleClass('is-active');
	    $('.user-summary__menu').slideUp();
	    $('.sub-menu').slideToggle();
    });
})(jQuery);