var App = jQuery(document);

jQuery(document).ready(function($) {
	
	//toggle switch to hide and show things
	$('.toggle-switch').on('click', toggleContent);
	//function for toggeling the content and swapping out the icon
	function toggleContent(el){
		//set up vars for swapping
		var
			self = $(this),
			icon = self.find('.toggle-icon'),
			toggleTarget = self.attr('data-toggle-target'),
			content = $('#' + toggleTarget)
		;
		//conditional to figure out what to swap
		if ( content.is(':hidden') ) {
			content.show(100);
			icon.html('-');
		} else {
			content.hide(100);
			icon.html('+'); 
		} 
	}

});


