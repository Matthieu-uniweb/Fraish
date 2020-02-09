<?php
include_once ('template.php');


/*=========================================================
 * V2  Gestion des metas et inclusions js propres
 * Gestion Google analytics & Google site Verification
 * Préchargement auto des images
 * ========================================================*/



class pagefrontend extends template {
	var $gabarit = array(	'content' 	=> 'frontend/squelette/global.tpl', 
							'contenu' 	=> 'frontend/accueil.tpl',							
							'menu' 		=> 'frontend/squelette/menu.tpl', 
							'top' 		=> 'frontend/squelette/top.tpl', 
							'base' 		=> 'frontend/squelette/base.tpl',
							'page' 		=> 'frontend/squelette/pages.tpl'
							
						);

	var $entete_title = "Magnetic Communication";

	var $UrlSite = "http://";

	var $GoogleUA = "";

	var $googleSiteVerification = "";
	 
	var $btcmd = "commandezr";

	function __construct() {
		
		$this -> set_rootdir("./templates/");
		$this -> assign_vars(array('btcmd' => $this->btcmd));
		
		//définition du lien du bouton commande et compte, selon si le client est loggé ou non
		
		if (!$_SESSION['client']['id_client']) //non loggé
		{
			$this -> assign_vars(array('classbt' => "btid"));
			$this -> assign_vars(array('hrefbt' => "href='identificationbox.html'"));
			$this -> assign_vars(array( 'txtlnkconnexion' => "Me connecter", 
										'lnkconnexion' => 'identificationbox.html',
										'lnkcompte' => 'identificationbox.html',
										'lnkpanier' => 'identificationbox.html'
										));			
		}
		else //loggé
		{
			$this -> assign_vars(array('classbt' => ""));
			$this -> assign_vars(array('hrefbt' => "href='commande.html'"));
			$this -> assign_vars(array( 'txtlnkconnexion' => "Déconnexion", 
										'lnkconnexion' => 'deconnexion.html',
										'lnkcompte' => 'compte.html',
										'lnkpanier' => 'panier.html'										
										));
		}		
	}
	
	function choixbtcmd($bt)
	{
		$this ->btcmd = $bt;
		$this -> assign_vars(array('btcmd' => $this->btcmd));		
	}

		
	function loadCSS($css){
		$this ->loadsCSS .= "<link rel=\"stylesheet\" href=\"".$css."\" type=\"text/css\" media=\"screen\" />\n";		
	}
	
	function loadJS($js){
		$this ->loadsJS .= "<script language=\"javascript\" type=\"text/javascript\" src=\"".$js."\"></script>\n";		
	}

	

	function GoogleAnalytics() {

		$google = "  
	      <script type=\"text/javascript\">
	    
	        var _gaq = _gaq || [];
	        _gaq.push(['_setAccount', '" . $this -> GoogleUA . "']);
	        _gaq.push(['_trackPageview']);
	      
	        (function() {
	          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	        })();
	    
	    </script>";

		return $google;
	}

	function enteteHTML($title) {
		$this -> assign_vars(array('title' => $title));
	}
	function finPage() {

		$end .= $this -> PreLoad($img);
		$end .= "</body>\n";
		$end .= "</html>";
		return $end;
	}
	function PreLoad() {
		//Chargement auto de toutes les images en css, ainsi que celles de la liste
		
	}
	function lire_header($url, $title) {
		$fp = fopen($url, "r");
		//connexion au site
		while (!feof($fp)) {//on parcours toutes les lignes
			$page .= fgets($fp, 4096);
			// lecture du contenu de la ligne
		}
		$head = eregi("<head>(.*)</head>", $page, $regs);

		// traitement de la balise <title> </title>
		if ($title != '') {
			$str .= substr($regs[1], 0, strpos($regs[1], '<title>') + strlen('<title>'));
			$str .= $title;
			$str .= substr($regs[1], strpos($regs[1], '</title>'), strlen($regs[1]));
			$regs[1] = $str;
		}

		fclose($fp);
		return $regs[1];
	}
	function enteteHTMLBASE($title) {
		$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\n";
		$html .= "     \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
		$html .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr-FR\" lang=\"fr-FR\">\n\n";
		$html .= "<head>";
		$html .= $this -> lire_header('index.html', $this -> entete_title . $title);

		/*Inclusions CSS*/
		$html .= "<link href=\"https://" . $_SERVER['HTTP_HOST'] . "/styles/frontend/styleBase.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
		$html .= $this -> loadsCSS;
		/*Inclusions javascript*/
		$html .= "<script language=\"javascript\" type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js\"></script>\n";
		$html .= $this -> loadsJS;

		$html .= "</head>\n";
		$html .= "<body>\n";
		echo $html;
	}

	function remove_accents($str, $charset = 'utf-8') {
		$str = htmlentities($str, ENT_NOQUOTES, $charset);

		$str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
		$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
		// pour les ligatures e.g. '&oelig;'
		$str = preg_replace('#&[^;]+;#', '', $str);
		// supprime les autres caractères
		$str = ereg_replace(" ", "-", $str);
		//on remplace les espaces par des tirets
		$str = ereg_replace("'", "-", $str);
		//on remplace les apostrophes par des tirets
		return $str;
	}

	function affichePageBase($content) {
		$this -> gabarit['contenu'] = $content;
		$this -> set_filenames($this -> gabarit);
		$this -> assign_vars(array('page' => base64_encode($_SERVER["REQUEST_URI"])));
		$this -> assign_var_from_handle('contenu', 'contenu');
		
		$this -> pparse('base');
		echo $this -> finPage();
	}

	function Ajax($content) {
		$this -> gabarit['contenu'] = $content;
		$this -> set_filenames($this -> gabarit);
		$this -> assign_vars(array('page' => base64_encode($_SERVER["REQUEST_URI"])));
		$this -> assign_var_from_handle('contenu', 'contenu');
		$this -> pparse('base');
		//echo $this->finPage();
	}	
	

	function affichePage($content) {
		$this -> gabarit['contenu'] = $content;
		$this -> set_filenames($this -> gabarit);
		$this -> assign_vars(array('page' => base64_encode($_SERVER["REQUEST_URI"])));
		$this -> assign_var_from_handle('menu', 'menu');
		$this -> assign_var_from_handle('contenu', 'contenu');
		$this -> pparse('content');		
	}
	
	function affichePageInterne($content) {
		//$this -> testloged();
		$this -> gabarit['contenu'] = $content;
		$this -> set_filenames($this -> gabarit);
		$this -> assign_vars(array('page' => base64_encode($_SERVER["REQUEST_URI"])));
		$this -> assign_var_from_handle('menu', 'menu');
		$this -> assign_var_from_handle('contenu', 'contenu');
		$this -> assign_var_from_handle('login', 'login');
		$this -> assign_var_from_handle('news', 'news');
		$this -> assign_var_from_handle('top', 'top');	
		
		$this -> pparse('page');
		
	}
	
	
	function affichePageMob($content) {
		
		$this -> gabarit['contenu'] = $content;
		$this -> set_filenames($this -> gabarit);
		$this -> assign_vars(array('page' => base64_encode($_SERVER["REQUEST_URI"])));
		$this -> assign_var_from_handle('contenu', 'contenu');		
		$this -> pparse('content');
		
	}

}
?>