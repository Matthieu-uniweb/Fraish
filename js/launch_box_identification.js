$(document).ready(function() {
	$.fancybox('/identification.html', {
		'type' : 'iframe',
		'centerOnScroll' : true,
		'cyclic' : true,
		'hideOnOverlayClick' : false,
		'hideOnContentClick' : false,
		'autoDimensions' : false,
		'width' : 750,
		'height' : 600,
		'transitionIn' : 'elastic', // fade, elastic, none
		'transitionOut' : 'elastic',
		'zoomSpeedIn' : 200,
		'zoomSpeedOut' : 200,
		'overlayShow' : true,
		'overlayColor' : '#000000',
		'overlayOpacity' : 0.6,
		'scrolling' : 'no',
		'margin' : 5,
		'padding' : 3,
	});
});
