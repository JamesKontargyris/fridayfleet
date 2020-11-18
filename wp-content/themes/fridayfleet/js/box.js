(function($){
	window.boxInit = function() {

	$('.box__header__title').on('click', function(e) {
	    if(! e.target.className.includes('help-icon')) {
	        $(this).closest('.box').toggleClass('box--is-closed').find('.box__content').slideToggle(200);
        }
    });

	}

	window.boxInit();
})(jQuery);