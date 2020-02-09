$(document).ready(function() {	
	
	
	
	
	
		$('#carousel').carouFredSel({
			direction: 'up',
			height: 208,
			items: {
			visible: 1,
			start: 0
			},
			scroll: {
			duration: 1000,
			timeoutDuration: 3000
			}
		});

	
	
	
	Cufon.replace('h1,h3');	
	Cufon.replace('.blur');
	
	$("a.btid").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	300, 
		'speedOut'		:	200, 
		'overlayShow'	:	true,
		'width' 		: 	860,
		'height' 		: 	700,
		'scrolling'     :  'no',
		'margin' 		:	5,
		'padding' 		:	3,
		'overlayColor' : '#000000',
		'overlayOpacity' : 0.6,
		'type' : 'iframe'
	});	
	
	
	$('.spinthat').spinner({
		min: 1,
		
		spin: function( event, ui ) {	
			
			//$(this).focusout();
			//$(".com").focus();
			
			//$(".com").click();
			
			/*$(this).parent().next(".price").val(function( index, value ) {				
				var prix = $(this).next(".pricebase").val() * $( ".spinthat" ).spinner( "value" );		
				alert (	$( ".spinthat" ).spinner( "value" ));
				prix += "€";
				return prix;				
			});		*/
			
			//alert (val);
		},
		
		change: function( event, ui ) {	
			
			$(this).parent().next(".price").val(function( index, value ) {				
				var prix = $(this).next(".pricebase").val() * $( ".spinthat" ).spinner( "value" );		
				//alert (	$( ".spinthat" ).spinner( "value" ));
				prix += "€";
				return prix;				
			});		
		}
		
	});
		
		
	//$( ".radioset" ).buttonset();
	
	
	
	$( document ).tooltip({
		items: "span",
		track: true,
		content: function() {
			var element = $( this );
			return element.attr( "title" );
		}
	});
	
	
	
});