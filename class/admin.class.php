<?php
include_once('class/affichage/method.class.php');
include_once('class/commun/method.class.php');
include_once('class/catalogue/method.class.php');
include_once ('class/contact/method.class.php');
//include_once('class/evenementiel/method.class.php');

class admin
{

var $taille_image 		= '200';
var $taille_vignette 	= '100';
var $path_templates		= './templates/admin/';

function redirect($url)
	{
		echo '<script language="javascript" type="text/javascript">window.location.replace("'.$url.'");</script>';
	}

function lister_repertoire($path)
	{
		$i = 0;
		$repertoire	= opendir($path);
		while ($fichier = readdir($repertoire)){ 
			if (eregi('.jpg',$fichier)){
				$rst[$i] = $fichier;
				$i++;
			}
		}
		closedir($repertoire);
		return $rst;
	}
	
function verifierLoginPassword($data)
	{
		
		$rqt = new mysql ;
		$rst = $rqt->query("SELECT * FROM admin WHERE login = '".$data['login']."' AND passwd = '".md5($data['passwd'])."'");
		$result	= mysql_fetch_array($rst);
		
		//adminftutti / tuttipizza
		
		if(isset ($result['login'])){
			$_SESSION['login'] = $data['login'];			
		}else{					
			
			$this->redirect("admin/");
		}		
	}
	
function demandeQuitter()
	{
		session_destroy();
		$this->redirect("admin/");
	}
	
function demandeAdmin($data)
	{
		$this->verifierLoginPassword($data);		
		$C_pageAdmin = new pageAdmin();			
		
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'./accueil.tpl');
	}

function accueilAdmin($data)
	{
		//$this->verifierLoginPassword($data);		
		$C_pageAdmin = new pageAdmin();			
		
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'./accueil.tpl');
	}	
	
	
	
	
// Gestion des ACTUS ////////////////

function listerActus($data)
	{
		$C_pageAdmin = new pageAdmin();
		
		// Calcul des actus existantes
		$C_actu	= new actusf();
		$liste		= $C_actu->listeOrdre();

		while ($L_actus = mysql_fetch_array ($liste)){
			
			$max=50;
			
			$chaine=$L_actus[titre];
			
		  if(strlen($chaine)>=$max)
		  {  
			  $chaine=substr($chaine,0,$max);  
			  $espace=strrpos($chaine," ");  
			  if($espace)$chaine=substr($chaine,0,$espace);  
			  $chaine .= '...';
		  }		

		  //on supprime le html
		  $chaine = ereg_replace("<[^>]*>", "", $chaine); 
      
      $imgup="";
      $imgdown="";
      
            
      if ($L_actus[ordre] > $C_actu->ordreMin())      
      {$imgup="<a href=\"?fonction=demandeUpActu&id_actu=".$L_actus[id_actus]."\"><img src=\"styles/admin/picto/up.png\" /></a>";}
      
      if ($L_actus[ordre] < $C_actu->ordreMax())
      {$imgdown="<a href=\"?fonction=demandeDownActu&id_actu=".$L_actus[id_actus]."\"><img src=\"styles/admin/picto/down.png\" /></a>";}
      
      
		  
			$C_pageAdmin->assign_block_vars('actus',array('texte' => $chaine, 'idactu' => $L_actus[id_actus], 'up' => $imgup,'down' => $imgdown,));
			
		}

		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'./actus/listeactus.tpl');
	}

function demandeUpActu($data)
{
    $C_actu = new actusf();
    $C_actu->up($data);    
    $this->redirect("?fonction=listerActus");
   
  }

function demandeDownActu($data)
{
    $C_actu = new actusf();
    $C_actu->down($data);    
    $this->redirect("?fonction=listerActus");
  }
	
function demandeNouvelleActu($data)
	{
		$C_pageAdmin = new pageAdmin();		
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'./actus/nouvelleActu.tpl');
	}
	
function traiterNouvelleActu($data)
	{
		$C_actu	= new actusf();
		$rst		= $C_actu->create($data);
		
		/*Traitement mailing franchisés*/		
		
		 $rst = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
					<html><head>
					<style type="text/css">
					.texte{
						color: #000000;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
					}
					a.url {
						color: #e8b601;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
						text-decoration:none;
					}
					a.url:hover { 
						color: #e8b601;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
						text-decoration:underline;
					}
					</style>
					</head><body class="body">';			
			$rst .= '<table align="left" border="0" cellpadding="4" cellspacing="0" bgcolor="#ffffff" style="border:1px black solid;">
					<tr><td><img src="http://www.tutti-pizza.com/media/images/mail_top.jpg"</td></tr>
					<tr><td align="left">					
					<br />	Cher Franchisé,
					<br />	
					<br />	Votre espace franchisé a été mis à jour.
					<br />	Rendez vous vite sur <a href="http://www.tutti-pizza.com/accueilF.html">celui-ci</a> pour être informé de l\'actualité de votre espace.
					<br />	
					<br />	A très bientôt
					<br /> L\'équipe Tutti Pizza 					
					<br>
					</td></tr></table><br>';		
			$rst .= '</div></body></html>';		
		
		
		
		if ($data[mailing]=="oui")
		{
			$C_Franchises = new Franchises();   
	    	$listee=$C_Franchises-> liste();
	    	while ($L_tuttii = mysql_fetch_array ($listee))
			{
				
				//$L_tuttii['Email']
				$C_contact   = new contact();
				$C_contact->send_mail(utf8_decode("Espace franchisés Tutti Pizza")."<contact@tutti-pizza.com>",$L_tuttii['Email'],utf8_decode("Actualité - $data[titre]"),stripslashes(utf8_decode($rst)));
				
			}
		}
		
		$this->redirect("?fonction=listerActus");
	}

function demandeModifierActu($data)
	{
		$C_pageAdmin = new pageAdmin();		
		$C_actu	= new actusf();		
		$result		= $C_actu->detail($data);
		$actu	= mysql_fetch_array($result);	
		
		list($annee, $mois, $jour) = explode('-', $actu[date]);
		$madate = $jour . "/" . $mois . "/" . $annee;
		
		if ($actu[photo]!="0"){
		$pic = "Pour changer de photo, choisissez-en une nouvelle. <br />";
		$pic .= "<img src=\"./media/up/".$actu[photo].".jpg\"";
		}
		$C_pageAdmin->assign_vars(array('id_actu' => $actu[id_actus], 'texte' => $actu[content],'titre' => $actu[titre], 'date' => $madate, 'photo' => $pic, 'id_photo' => $actu[photo]));			
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'./actus/modifierActu.tpl');
	}
	
function traiterModifierActu($data)
	{
		$C_actu	= new actusf();		
		$rst = $C_actu->update($data);
		$this->redirect("?fonction=listerActus");
	}
	
function traiterSupprimerActu($data)
	{
		$C_actu	= new actusf();
		$rst		= $C_actu->delete($data);
		$this->redirect("?fonction=listerActus");
	}
	

	
	
	
//Gestion des tarifs
function voirTarifs($data)
	{
		$C_pageAdmin = new pageAdmin();		
		// récup bdd des tarifs
		$rqt = new mysql ;
		$rst = $rqt->query("SELECT * FROM tarifs");
		$L_tarifs = mysql_fetch_array ($rst);
			
		$C_pageAdmin->assign_vars(array('tarif1' => $L_tarifs[tarif1], 
										'tarif2' => $L_tarifs[tarif2], 
										'tarif3' => $L_tarifs[tarif3], 
										'tarif4' => $L_tarifs[tarif4], 
										'tarif5' => $L_tarifs[tarif5]));
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'./tarifs/voirTarifs.tpl');
	}
	
function editerTarifs($data)
	{
		$C_pageAdmin = new pageAdmin();		
		// récup bdd des tarifs
		$rqt = new mysql ;
		$rst = $rqt->query("SELECT * FROM tarifs");
		$L_tarifs = mysql_fetch_array ($rst);
			
		$C_pageAdmin->assign_vars(array('tarif1' => $L_tarifs[tarif1], 
										'tarif2' => $L_tarifs[tarif2], 
										'tarif3' => $L_tarifs[tarif3], 
										'tarif4' => $L_tarifs[tarif4], 
										'tarif5' => $L_tarifs[tarif5]));
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'./tarifs/editerTarifs.tpl');
	}
	
function traiterModifierTarifs($data)
	{
		$rqt = new mysql ;
		$rst = $rqt->query("UPDATE tarifs set tarif1='".$data[tarif1]."', tarif2='".$data[tarif2]."',tarif3='".$data[tarif3]."',tarif4='".$data[tarif4]."',tarif5='".$data[tarif5]."' where id_tarif='1'");	
		$this->redirect("?fonction=voirTarifs");
	}
	
/**
* GESTION DES GAMMES
**/	
function demandeNouvelleGamme($data)
	{
		$C_pageAdmin = new pageAdmin();
		
		// Calcul des gammes existantes
		$C_gamme	= new gamme();
		$liste		= $C_gamme->liste();
		$nb_gamme	= mysql_num_rows($liste);
		$C_pageAdmin->assign_vars(array('nb_gamme' => $nb_gamme));	
		while ($L_gamme = mysql_fetch_array ($liste)){
			$C_pageAdmin->assign_block_vars('gamme',array('nom' => $L_gamme[nom]));
			
		}
		
		for($i = 1; $i <= ($nb_gamme+1); $i++){
			if($i == ($nb_gamme+1)){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('ordre_aff',array('value' => $i, 'selected' => $selected));
		}
		
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'admin/catalogue/nouvelleGamme.tpl');
	}

function traiterNouvelleGamme($data)
	{
		$C_gamme	= new gamme();
		$rst		= $C_gamme->create($data);
		$this->redirect("?fonction=demandeModifierGamme");
	}

function demandeModifierGamme($data)
	{
		$C_pageAdmin = new pageAdmin();
		
		// Calcul des gammes existantes
		$C_gamme	= new gamme();
		$liste		= $C_gamme->liste();
		$nb_gamme	= mysql_num_rows($liste);
		$C_pageAdmin->assign_vars(array('nb_gamme' => $nb_gamme));	
		while ($L_gamme = mysql_fetch_array ($liste)){
			if($L_gamme[id] == $data[gamme]){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('gamme',array('id' => $L_gamme[id],'nom' => $L_gamme[nom],'description' => $L_gamme[description], 'selected' => $selected));		
		}
		
		// Calcul de la gamme selectionn�e
		$detail		= $C_gamme->detail($data);
		if($detail[en_ligne] == '1'){
			$en_ligne 	= 'checked'; 	
			$hors_ligne = '';
		}else{
			$en_ligne 	= ''; 			
			$hors_ligne = 'checked';
		}
		$C_pageAdmin->assign_vars(array('id'			=> $detail[id], 
										'nom'			=> $detail[nom] , 
										'description'	=> $detail[description],
										'en_ligne' 		=> $en_ligne, 
										'hors_ligne'	=> $hors_ligne));
		
		for($i = 1; $i <= ($nb_gamme); $i++){
			if($i == $detail[ordre_aff]){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('ordre_aff',array('value' => $i, 'selected' => $selected));
		}
		
		// Calcul d'eventuel message d'erreur
		if(isset($data[err])){
			$C_pageAdmin->assign_vars(array('message'=>$C_gamme->T_error[$data[err]]));
		}		
			
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'admin/catalogue/modifierGamme.tpl');
	}
	
function traiterModifierGamme($data)
	{
		$C_gamme	= new gamme();
		$rst		= $C_gamme->update($data);
		$this->redirect("?fonction=demandeModifierGamme&gamme=".$data[gamme]);
	}

function traiterSupprimerGamme($data)
	{
		$C_gamme	= new gamme();
		$C_rayon	= new rayon();
		
		// Teste que la gamme soit vide
		$rst		= $C_rayon->listeParGamme($data);
		$nb_rayon	= mysql_num_rows($rst);
		if($nb_rayon != 0){
			$this->redirect("?fonction=demandeModifierGamme&err=1");
		}else{
			$rst		= $C_gamme->delete($data);
			$this->redirect("?fonction=demandeModifierGamme");
		}		
	}	

/**
* GESTION DES RAYONS
**/
function demandeNouveauRayon($data)
	{
		$C_pageAdmin = new pageAdmin();
		
		// Calcul des gammes existantes
		$C_gamme	= new gamme();
		$liste		= $C_gamme->liste();
		$nb_gamme	= mysql_num_rows($liste);
		while ($L_gamme = mysql_fetch_array ($liste)){
			if($L_gamme[id] == $data[gamme]){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('gamme',array('id' => $L_gamme[id],'nom' => $L_gamme[nom], 'selected' => $selected));		
		}
		
		// Calcul des rayons existants pour la gamme selectionn�e
		$C_rayon	= new rayon();
		$liste		= $C_rayon->listeParGamme($data);
		$nb_rayon	= mysql_num_rows($liste);
		$C_pageAdmin->assign_vars(array('nb_rayon' => $nb_rayon));	
		while ($L_rayon = mysql_fetch_array ($liste)){
			$C_pageAdmin->assign_block_vars('rayon',array('nom' => $L_rayon[nom]));		
		}	
		
		for($i = 1; $i <= ($nb_rayon+1); $i++){
			if($i == ($nb_rayon+1)){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('ordre_aff',array('value' => $i, 'selected' => $selected));
		}
		
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'admin/catalogue/nouveauRayon.tpl');
	}

function traiterNouveauRayon($data)
	{
		$C_rayon	= new rayon();
		$rst		= $C_rayon->create($data);
		$this->redirect("?fonction=demandeNouveauRayon&gamme=".$data[gamme]);
	}

function demandeModifierRayon($data)
	{
		$C_pageAdmin = new pageAdmin();
		
		// Calcul des gammes existantes
		$C_gamme	= new gamme();
		$liste		= $C_gamme->liste();
		$nb_gamme	= mysql_num_rows($liste);
		while ($L_gamme = mysql_fetch_array ($liste)){
			if($L_gamme[id] == $data[gamme]){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('gamme',array('id' => $L_gamme[id],'nom' => $L_gamme[nom], 'selected' => $selected));		
		}
		
		// Calcul des rayons existants pour la gamme selectionn�e
		$C_rayon	= new rayon();
		$liste		= $C_rayon->listeParGamme($data);
		$nb_rayon	= mysql_num_rows($liste);
		$C_pageAdmin->assign_vars(array('nb_rayon' => $nb_rayon));	
		while ($L_rayon = mysql_fetch_array ($liste)){
			if($L_rayon[id] == $data[rayon]){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('rayon',array('id' => $L_rayon['id'],'nom' => $L_rayon['nom'], 'selected' => $selected));		
		}
		
		// Calcul du rayon selectionn�
		$detail		= $C_rayon->detail($data);
		if($detail[en_ligne] == '1'){
			$en_ligne 	= 'checked'; 	
			$hors_ligne = '';
		}else{
			$en_ligne 	= ''; 			
			$hors_ligne = 'checked';
		}
		$C_pageAdmin->assign_vars(array('id'			=> $detail['id'], 
										'nom'			=> $detail['nom'] , 
										'description'	=> $detail['description'],
										'en_ligne' 		=> $en_ligne, 
										'hors_ligne'	=> $hors_ligne));
		
		for($i = 1; $i <= ($nb_rayon); $i++){
			if($i == $detail[ordre_aff]){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('ordre_aff',array('value' => $i, 'selected' => $selected));
		}
		
		// Calcul d'eventuel message d'erreur
		if(isset($data['err'])){
			$C_pageAdmin->assign_vars(array('message'=>$C_rayon->T_error[$data['err']]));
		}
		
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'admin/catalogue/modifierRayon.tpl');
	}

function traiterModifierRayon($data)
	{
		$C_rayon	= new rayon();
		$rst		= $C_rayon->update($data);
		$this->redirect("?fonction=demandeModifierRayon&gamme=".$data[gamme]."&rayon=".$data[rayon]);
	}

function traiterSupprimerRayon($data)
	{
		$C_rayon	= new rayon();
		$C_article	= new article();
		
		// Teste que le rayon soit vide
		$rst		= $C_article->listeParRayon($data);
		$nb_article	= mysql_num_rows($rst);
		if($nb_article != 0){
			$this->redirect("?fonction=demandeModifierRayon&err=1");
		}else{
			$rst		= $C_rayon->delete($data);
			$this->redirect("?fonction=demandeModifierRayon&gamme=".$data[gamme]);
		}		
	}

/**
* GESTION DES ARTICLES
**/
function demandeNouvelArticle($data)
	{
		$C_pageAdmin = new pageAdmin();
		
		// Calcul des gammes existantes
		$C_gamme	= new gamme();
		$liste		= $C_gamme->liste();
		$nb_gamme	= mysql_num_rows($liste);
		while ($L_gamme = mysql_fetch_array ($liste)){
			if($L_gamme[id] == $data[gamme]){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('gamme',array('id' => $L_gamme[id],'nom' => $L_gamme[nom], 'selected' => $selected));		
		}
		
		// Calcul des rayons existants pour la gamme selectionn�e
		$C_rayon	= new rayon();
		$liste		= $C_rayon->listeParGamme($data);
		$nb_rayon	= mysql_num_rows($liste);
		$C_pageAdmin->assign_vars(array('nb_rayon' => $nb_rayon));	
		while ($L_rayon = mysql_fetch_array ($liste)){
			if($L_rayon[id] == $data[rayon]){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('rayon',array('id' => $L_rayon[id],'nom' => $L_rayon[nom], 'selected' => $selected));		
		}	
		
		// gestion des photos
		$C_article	= new article();
		for ($i = 1; $i <= $C_article->nb_photos_max; $i++){
			$title = 'Photo '.$i;
			$C_pageAdmin->assign_block_vars('photos',array(	'num' 		=> $i,
															'title'		=> $title
															));	
		}
		
		$C_editor_1 = new FCKeditor('editor_1');		
		$C_editor_1->BasePath = strrev(substr($BasePath, strpos($BasePath,'/'))).'class/editor/';
		$C_editor_1->ToolbarSet = "Basic";		
		$C_editor_1->Value = '';
			
		$C_editor_2 = new FCKeditor('editor_2');		
		$C_editor_2->BasePath = strrev(substr($BasePath, strpos($BasePath,'/'))).'class/editor/';
		$C_editor_2->ToolbarSet = "Basic";		
		$C_editor_2->Value = '';
			
		$C_pageAdmin->assign_vars(array('editor_1' => $C_editor_1->CreateHtml(), 
										'editor_2' => $C_editor_2->CreateHtml()
										));
		
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'admin/catalogue/nouvelArticle.tpl');
	}
	
function traiterNouvelArticle($data)
	{
		$C_article	= new article();
		$rst		= $C_article->create($data);
		$this->redirect("?fonction=demandeNouvelArticle");
	}

function demandeModifierArticle($data)
	{
		$C_pageAdmin = new pageAdmin();
		
		// Calcul des gammes existantes
		$C_gamme	= new gamme();
		$liste		= $C_gamme->liste();
		$nb_gamme	= mysql_num_rows($liste);
		while ($L_gamme = mysql_fetch_array ($liste)){
			if($L_gamme[id] == $data[gamme]){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$C_pageAdmin->assign_block_vars('gamme',array('id' => $L_gamme[id],'nom' => $L_gamme[nom], 'selected' => $selected));		
		}
		
		// Calcul des rayons existants pour la gamme selectionn�e
		$C_rayon	= new rayon();
		$liste		= $C_rayon->listeParGamme($data);
		$nb_rayon	= mysql_num_rows($liste);
		$C_pageAdmin->assign_vars(array('nb_rayon' => $nb_rayon));	
		while ($L_rayon = mysql_fetch_array ($liste)){
			if($L_rayon[id] == $data[rayon]){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			
			$C_pageAdmin->assign_block_vars('rayon',array('id' => $L_rayon[id],'nom' => $L_rayon[nom], 'selected' => $selected));		
		}
		
		// Calcul des articles existants pour la gamme selectionn�e
		$C_article	= new article();
		$liste		= $C_article->listeParRayonEnLigneOrderByDate($data);
		$nb_article	= mysql_num_rows($liste);
		$C_pageAdmin->assign_vars(array('nb_article' => $nb_article));	
		while ($L_article = mysql_fetch_array ($liste)){
			if($L_article[id] == $data[article]){
				$selected = 'selected';
			}else{
				$selected = '';
			}						
			
			$C_pageAdmin->assign_block_vars('article',array('id' => $L_article[id],'nom' => $L_article[nom], 'selected' => $selected));		
		}
		
		// Calcul de l'article selectionn�
		$detail		= $C_article->detail($data);		
			
			if($detail[en_ligne] == '1'){
				$en_ligne 	= 'checked'; 	
				$hors_ligne = '';
			}else{
				$en_ligne 	= ''; 			
				$hors_ligne = 'checked';
			}
					
			// gestion des photos
			for ($i = 1; $i <= $C_article->nb_photos_max; $i++){
					$filename = 'documents/articles/'.$data[article].'_'.$i.'.jpg';				
					$title = 'Photo '.($i);
					if (file_exists($filename)) {
		   				$size	=	$C_article->redimensionner_image($filename,$this->taille_image); 
		   				$photo_{$i}	= 	'<img src="'.$filename.'" '.$size.' style="border-color:#7f9db9; border-style:solid; border-width:1px;">
										&nbsp;<img onclick="supprimer_doc(\''.$filename.'\');" src="styles/admin/poubelle.gif" border="0" title="Supprimer...">';
					}else{
						$photo_{$i}	= 	'';
					}
					
					$C_pageAdmin->assign_block_vars('photos',array(	'img'		=> $photo_{$i},
																'num' 		=> $i,
																'title'		=> $title
																));
			}	
			
			// gestion du PDF
			$filename = 'documents/articles/'.$data[article].'.pdf';
			if (file_exists($filename)){
				$lien_pdf = '&nbsp;<a href="download.php?doc='.base64_encode('documents/articles/'.$data[article].'.pdf').'" target="_blank" title="T�l�charger le document PDF">T�l�charger le document PDF</a>
							&nbsp;<img onclick="supprimer_doc(\''.$filename.'\');" src="styles/admin/poubelle.gif" border="0" title="Supprimer..."><br><br>';
			}else{
				$lien_pdf = '';
			}
			
			$C_editor_1 = new FCKeditor('editor_1');		
			$C_editor_1->BasePath = strrev(substr($BasePath, strpos($BasePath,'/'))).'class/editor/';
			$C_editor_1->ToolbarSet = "Basic";		
			$C_editor_1->Value = html_entity_decode($detail[texte]);
			
			$C_editor_2 = new FCKeditor('editor_2');		
			$C_editor_2->BasePath = strrev(substr($BasePath, strpos($BasePath,'/'))).'class/editor/';		
			$C_editor_2->ToolbarSet = "Basic";		
			$C_editor_2->Value = html_entity_decode($detail[texte]);
			
			$C_pageAdmin->assign_vars(array('editor_1' 		=> $C_editor_1->CreateHtml(), 
											'editor_2' 		=> $C_editor_2->CreateHtml(),
											'id'			=> $detail[id], 
											'nom'			=> $detail[nom] , 
											'date'			=> $detail[date],
											'description'	=> html_entity_decode($detail[description]), 
											'photo_1' 		=> $photo_1,
											'photo_2' 		=> $photo_2,
											'en_ligne' 		=> $en_ligne, 
											'hors_ligne'	=> $hors_ligne,
											'pdf'			=> $lien_pdf
										));
										
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'admin/catalogue/modifierArticle.tpl');
	}

function traiterModifierArticle($data)
	{
		$C_article	= new article();
		$rst		= $C_article->update($data);
		$this->redirect("?fonction=demandeModifierArticle&gamme=".$data[gamme]."&rayon=".$data[rayon]."&article=".$data[article]);		
	}

function traiterSupprimerArticle($data)
	{
		$C_article	= new article();
		$rst		= $C_article->delete($data);
		$this->redirect("?fonction=demandeModifierArticle&gamme=".$data[gamme]."&rayon=".$data[rayon]);
	}	

function traiterSupprimerDocument($data)
	{
		unlink($data[document]);
		$this->redirect("?fonction=demandeModifierArticle&gamme=".$data[gamme]."&rayon=".$data[rayon]."&article=".$data[article]);		
	}
/**
* GESTION DES EVENEMENTS
**/
function demandeNouvelEvt($data)
	{
		$C_pageAdmin = new pageAdmin();
		
		// Calcul des cat�gories existantes
		$C_categorie	= new categorie();
		$liste			= $C_categorie->liste();
		while ($L_categorie = mysql_fetch_array ($liste)){
			if($L_categorie[id] == $data[categorie]){
				$selected = 'selected';
				if(eregi('Agenda',$L_categorie[nom])){
					$display_une = 'block';
				}else{
					$display_une = 'none';
				}
			}else{
				$selected = '';				
			}
			
			if($data[categorie] == ''){
				$display_une = 'none';
			}
			$C_pageAdmin->assign_block_vars('categorie',array('id' => $L_categorie[id],'nom' => $L_categorie[nom], 'selected' => $selected));		
		}
		
		$C_editor_1 = new FCKeditor('editor_1');		
		$C_editor_1->BasePath = strrev(substr($BasePath, strpos($BasePath,'/'))).'class/editor/';
		$C_editor_1->ToolbarSet = "Basic";		
		$C_editor_1->Value = '';
			
		$C_editor_2 = new FCKeditor('editor_2');		
		$C_editor_2->BasePath = strrev(substr($BasePath, strpos($BasePath,'/'))).'class/editor/';
		$C_editor_2->ToolbarSet = "Basic";		
		$C_editor_2->Value = '';
		
		$C_pageAdmin->assign_vars(array('editor_1' => $C_editor_1->CreateHtml(), 'editor_2' => $C_editor_2->CreateHtml(), 'display_une' => $display_une));
		
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'admin/evenementiel/nouvelEvt.tpl');
	}
	
function traiterNouvelEvt($data)
	{
		$C_evt	= new evenementiel();
		$rst	= $C_evt->create($data);
		$this->redirect("?fonction=demandeNouvelEvt&categorie=".$data[categorie]);
	}

function demandeModifierEvt($data)
	{
		$C_pageAdmin 	= new pageAdmin();
		
		// Calcul des cat�gories existantes
		$C_categorie	= new categorie();
		$liste			= $C_categorie->liste();
		while ($L_categorie = mysql_fetch_array ($liste)){
			if($L_categorie[id] == $data[categorie]){
				$selected = 'selected';
				$display_une = 'block';				
			}else{
				$selected = '';
			}
			
			if($data[categorie] == ''){
				$display_une = 'none';
			}
			$C_pageAdmin->assign_block_vars('categorie',array('id' => $L_categorie[id],'nom' => $L_categorie[nom], 'selected' => $selected));		
		}
					
		// Calcul des evenements existants pour la cat�gorie selectionn�e
		$C_evt		= new evenementiel();
		$liste		= $C_evt->liste_by_categorie($data);
		$nb_evt	= mysql_num_rows($liste);
		$C_pageAdmin->assign_vars(array('nb_evt' => $nb_evt));	
		while ($L_evt = mysql_fetch_array ($liste)){
			if($L_evt[id] == $data[evt]){
				$selected = 'selected';
			}else{
				$selected = '';
			}						
			
			$C_pageAdmin->assign_block_vars('evt',array('id' => $L_evt[id],'nom' => $L_evt[title], 'selected' => $selected));		
		}
		
		// Calcul de l'evenement selectionn�
		$select	= $C_evt->select_by_id($data);	
		$detail	= mysql_fetch_array($select);
			if($detail[en_ligne] == '1'){
				$en_ligne 	= 'checked'; 	
				$hors_ligne = '';
			}else{
				$en_ligne 	= ''; 			
				$hors_ligne = 'checked';
			}			
			
			if($detail[a_la_une] == '1'){
				$checked_une 	= 'checked'; 	
			}else{
				$checked_une 	= '';
			}
				
			// gestion de la photo
			$filename = 'documents/evenementiels/'.$detail[id].'.jpg';
			if (file_exists($filename)) {
   				$size	=	$C_evt->redimensionner_image($filename,$this->taille_image); 
   				$photo 	= 	'<img src="'.$filename.'" '.$size.' style="border-color:#7f9db9; border-style:solid; border-width:1px;">';
			}else{
				$photo 	= 	'';
			}
			
			// gestion du PDF
			if (file_exists('documents/evenementiels/'.$detail[id].'.pdf')) {
				$lien_pdf = '&nbsp;<a href="download.php?doc='.base64_encode('documents/evenementiels/'.$detail[id].'.pdf').'" target="_blank" title="T�l�charger le document PDF">T�l�charger le document PDF</a><br><br>';
			}else{
				$lien_pdf = '';
			}
			
			$C_editor_1 = new FCKeditor('editor_1');		
			$C_editor_1->BasePath = strrev(substr($BasePath, strpos($BasePath,'/'))).'class/editor/';
			$C_editor_1->ToolbarSet = "Basic";		
			$C_editor_1->Value = html_entity_decode($detail[description]);
			
			$C_editor_2 = new FCKeditor('editor_2');		
			$C_editor_2->BasePath = strrev(substr($BasePath, strpos($BasePath,'/'))).'class/editor/';
			$C_editor_2->ToolbarSet = "Basic";		
			$C_editor_2->Value = html_entity_decode($detail[corps]);
			
			$C_pageAdmin->assign_vars(array('id'			=>$detail[id], 
											'nom'			=>$detail[title], 
											'date'			=>$detail[date],
											'description'	=>html_entity_decode($detail[description]), 
											'photo' 		=> $photo,
											'en_ligne' 		=> $en_ligne, 
											'hors_ligne'	=> $hors_ligne,
											'editor_1'		=> $C_editor_1->CreateHtml(),
											'editor_2'		=> $C_editor_2->CreateHtml(),
											'display_une' 	=> $display_une,
											'checked_une'	=> $checked_une,
											'pdf'			=> $lien_pdf
										));
		
		// Affecte le gabarit
		$C_pageAdmin->affichePage($this->path_templates.'admin/evenementiel/modifierEvt.tpl');
	}

function traiterModifierEvt($data)
	{
		$C_evt	= new evenementiel();
		$rst	= $C_evt->update($data);
		$this->redirect("?fonction=demandeModifierEvt&categorie=".$data[categorie]."&evt=".$data[evt]);
	}

function traiterSupprimerEvt($data)
	{
		$C_evt	= new evenementiel();
		$rst	= $C_evt->delete($data);
		$this->redirect("?fonction=demandeModifierEvt&categorie=".$data[categorie]);
	}	
	
function migrationArticle($data)
	{
		$C_pageAdmin 	= new pageAdmin();
		$C_pageAdmin->affichePage($this->path_templates.'admin/catalogue/migrationArticle.tpl');
	}
	
function traiterMigrationArticle($data)
	{
		$C_article	= new article();
		
		$T_insert[rayon] = $data[rayon];
		$lister	= $C_article->lister_migration($data[table]);
		while ($L_article = mysql_fetch_array ($lister)){			
			$T_insert[nom] 	 	= $L_article[titre];
			$T_insert[editor_2]	= $L_article[corps];
			$T_insert[en_ligne] = '1';
			$img_src 	 = '../admin/'.$data[table].'/'.$L_article[id].'.jpg';
			$size 		 = GetImageSize($img_src);  
			echo $T_insert[nom].'<br>';
			echo $T_insert[editor_2].'<br>';
			$T_insert[article] = $C_article->create_migration($T_insert);			
			// traitement de la photo
			if(($size[0] >= $C_article->dimension_image) || ($size[1] >= $C_article->dimension_image)){
				$dest_file = 'documents/articles/'.$T_insert[article].'_1.jpg';
				$C_article->creer_image($dest_file, $img_src);
				chmod($dest_file,0644);	
				echo 'Taille de l\'image ('.$dest_file.') = '.$size[0].'*'.$size[1];
			}
			echo '<hr>';
		}
	}
}
?>