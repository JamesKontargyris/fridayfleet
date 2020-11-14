(function($){
	$('.toggler').on('click', function() {
	   var elementToToggle = $($(this).data('element-to-toggle'));

	   elementToToggle.slideToggle(500);
	   $(this).toggleClass('is-active');

	   return false;
    });
})(jQuery);