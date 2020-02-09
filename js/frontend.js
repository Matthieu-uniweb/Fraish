
$(document).ready( function () {    
	
	//Cufon.replace('h1,h3');
	
	$('BODY').bgStretcher({
		images: ['media/backslides/img1.jpg', 'media/backslides/img2.jpg', 'media/backslides/img3.jpg', 'media/backslides/img4.jpg', 'media/backslides/img5.jpg', 'media/backslides/img6.jpg', 'media/backslides/img7.jpg', 'media/backslides/img8.jpg', 'media/backslides/img9.jpg', 'media/backslides/img10.jpg', 'media/backslides/img11.jpg'],
		imageWidth: 2560, 
		imageHeight: 1819, 
		slideDirection: 'N',
		slideShowSpeed: 2500,
		nextSlideDelay: 10000,		
		transitionEffect: 'fade',
		sequenceMode: 'normal',
		buttonPrev: '#prev',
		buttonNext: '#next',
		//pagination: '#nav',
		anchoring: 'center center',
		anchoringImg: 'center top',
		callbackfunction: test,
		preloadImg: true,
	});
	
	function test()
	{
		//alert("YEAH");
	}
	
	function  showcaption(){   
		var midx = $j('#bgstretcher'+ ' LI.bgs-current').index();
		$j('#title').html(midx + captionlist[midx]);
		}
	
	$('.bt1').hover(
			  function() { $('.bt1').animate({marginTop: "-15px"}, 100); }
			  , 
			  function() { $('.bt1').animate({marginTop: "0px"}, 300); }
			);
	$('.bt2').hover(
			  function() { $('.bt2').animate({marginTop: "-15px"}, 100); }
			  , 
			  function() { $('.bt2').animate({marginTop: "0px"}, 300); }
			);
	$('.bt3').hover(
			  function() { $('.bt3').animate({marginTop: "-15px"}, 100); }
			  , 
			  function() { $('.bt3').animate({marginTop: "0px"}, 300); }
			);
	$('.bt4').hover(
			  function() { $('.bt4').animate({marginTop: "-15px"}, 100); }
			  , 
			  function() { $('.bt4').animate({marginTop: "0px"}, 300); }
			);
	$(".show").click(function () {
		$(".sh").show("slow");
		});	
	$(".show2").click(function () {
		$(".sh2").show("slow");
		});	
	$(".show3").click(function () {
		$(".sh3").show("slow");
		});	
	$(".show4").click(function () {
		$(".sh4").show("slow");
		});	
	$(".show5").click(function () {
		$(".sh5").show("slow");
		});	
	
	
	$('#slider').rhinoslider({
		showTime: 5000,
		effectTime: 800,
		easing: 'easeOutCubic',
		controlsMousewheel: false,
		controlsKeyboard: false,
		controlsPlayPause: false,
		showBullets: 'never',
		slidePrevDirection: 'toRight',
		slideNextDirection: 'toLeft'
	});
	
	
	//newsletter
	
	
	
	$("a.iframe").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	500, 
		'speedOut'		:	200, 
		'overlayShow'	:	true,
		'width'         :	570,
		'height'		:	230
	});
	
	$('a.fancyclose').click(function(){
		parent.$.fancybox.close();
	});

	$("a.external").click(function() { //Open link in new window
		window.open(this.href);
		return false;
	});

	$("a.email").each(function() { //Email address obfuscation
		e = this.rel.replace('/','@');
		this.href = 'mailto:' + e;
		$(this).text(e);
	});
	

	$("#newsletter_name, #newsletter_email").focus(function() {
		$(this).css("color","#292a18");
		$(this).css("background-color","#ffffff");
	});
	
	$("#newsletter_form").submit(function() {
		var $name=$("#newsletter_name").val();
		var $email=$("#newsletter_email").val();
		
		var $error=false;
		
		if (isString($name)==false) {
			$error=true;
			$("#newsletter_name").css("color","#ffffff");
			$("#newsletter_name").css("background-color","#ef7a7a");
		}
		
		if (isEmail($email)==false) {
			$error=true;
			$("#newsletter_email").css("color","#ffffff");
			$("#newsletter_email").css("background-color","#ef7a7a");
		}

		if ($error) {
			return false;
		} else {
			$("#newsletter input#submit").css("visibility","hidden");
			$.post("/ajax/newsletter.php",{newsletter_add: "1", newsletter_name: $name, newsletter_email: $email}, function($xml) {
				$("#response").html('<small style="color: #cc0000; font-weight: bold;">'+$("response",$xml).text()+'</small>');
			});
			
			return false;
		}
	});	
	
	
 
} ) ; 


