<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
<head>   
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>{title}</title>

    <meta name="description" content="Fraish, votre bar à salades, soupes, jus & smoothies à Toulouse Labège - Centre Commercial LABEGE2">
    <meta name="author" content="Magnetic Communication">

    <meta name="viewport" content="width=device-width">
            
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="fr-FR" />
	
    <link href="./styles/frontend/bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="./styles/frontend/style.css" rel="stylesheet" type="text/css" media="screen"/>
	<link href="./styles/frontend/stylePrint.css" rel="stylesheet" type="text/css" media="print"/>

	<link rel="stylesheet" href="./js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>	
	
	
	<link href="js/jqueryUI/css/south-street/jquery-ui-1.10.3.custom.css" rel="stylesheet">	
	<script src="js/jqueryUI/js/jquery-ui-1.10.3.custom.js"></script>
	
	
	<script type="text/javascript" src="./js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript" src="./js/fancyBox.js"></script>
	
    <script type="text/javascript" src="./js/cufon-yui.js"></script>
	<script type="text/javascript" src="./js/blur_550.font.js"></script>
	
	<script type="text/javascript" src="./js/caroufredsel/jquery.carouFredSel-6.2.1-packed.js"></script>	
	
	<script type="text/javascript" src="./js/fraish.js"></script> 	
	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-44493535-1', 'fraish.fr');
	  ga('send', 'pageview');
	
	</script>
	

	<script type="text/javascript" id="cookieinfo"
	src="../../../js/rgpd_cookie.js">
		data-bg="#645862"
		data-fg="#FFFFFF"
		data-link="#F1D600"
		data-cookie="CookieInfoScript"
		data-text-align="left"
		   data-close-text="Got it!">
	</script>

	<style>
	#cookie-law { 
		max-width:940px;
		background:#EEEADD; 
		margin:10px auto 0; 
		border-radius: 17px;
		-webkit-border-radius: 17px;
		-moz-border-radius: 17px;
	}
	 
	#cookie-law p { 
		padding:10px; 
		font-size:1.2em; 
		font-weight:bold; 
		text-align:center; 
		color:#682008; 
		margin:0;
	}
	</style>
	<script>
		// Creare's 'Implied Consent' EU Cookie Law Banner v:2.4
		// Conceived by Robert Kent, James Bavington & Tom Foyster
		
		var dropCookie = true; // false disables the Cookie, allowing you to style the banner
		var cookieDuration = 14; // Number of days before the cookie expires, and the banner reappears
		var cookieName = 'complianceCookie'; // Name of our cookie
		var cookieValue = 'on'; // Value of cookie
		
		
		
		function createCookie(name,value,days) {
		if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		if(window.dropCookie) {
		document.cookie = name+"="+value+expires+"; path=/";
		}
		}
		
		function checkCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
		}
		
		function eraseCookie(name) {
		createCookie(name,"",-1);
		}
		
		
		function removeMe(){
		var element = document.getElementById('cookie-law');
		element.parentNode.removeChild(element);
		}
	</script>	

	
   
   
   
</head>
<body>
<!--[if lt IE 8]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

	<div id="wrapper">
			<div id="top">
				<div id="illusalade"></div>
				<a class="home" href="accueil.html"></a>
				<div id="illuverres"></div>
				<div id="account">
					<a href="{lnkconnexion}" class="connect {classbt}">{txtlnkconnexion}</a>
					<a href="{lnkcompte}" class="compte {classbt}">Mon compte</a>
					<a href="{lnkpanier}" class="panier {classbt}">Mon panier</a>
				</div>
			</div>
			<div id="menu">				
				<a  {hrefbt} class="{btcmd} {classbt}"></a>
				<a class="homebis" href="accueil.html"></a>
				<a class="mlnk1 blur" href="produits.html">Nos produits</a>
				<a class="mlnk2 blur" href="recettes.html">Recettes</a>
				<a class="mlnk3 blur" href="contact.html">Contact</a>
				
				<!--<div id="searchb">
					<span class="searchtxt">Rechercher</span>
					<input type="text" value="" name="searchbox" class="sbox"/>
					<input type="submit" value="" class="searchBT"/>
				</div>	-->
						
			</div>
				
				{contenu}				
				
		</div>
		<div id="footer">
			<div id="mycenter">
				<div id="sociallnks">
					<!--<a href="#" class="twitter"></a>
					<a href="#" class="rss"></a>
					<a href="#" class="facebook"></a>-->
				</div>	
				<div id="footercenter">
					<a class="footerlnk" href="contact.html">Contact</a> &nbsp;&nbsp;|&nbsp;&nbsp;
					<!--<a class="footerlnk">Recrutement</a> &nbsp;&nbsp;|&nbsp;&nbsp;
					<a class="footerlnk">Newsletter</a>-->
					
					<a class="footerlnk" href="mentions.html">Mentions légales</a> &nbsp;&nbsp;|&nbsp;&nbsp;
					<a class="footerlnk" href="rgpd.html">RGPD</a>
				</div>
						
			</div>			
		</div>


</body>
</html>