<?php
function extraireIngredientsJour($ingredients, $sousFamille) {
	// initialisation des variables
	$IDpointVente = 1;
	$dateSQL = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
	$dateFR = date("d-m-Y", mktime(0,0,0,date("m"),date("d"),date("Y")));
	$extraction = $ingredientsJour = array();
	// code emprunte de Tbq_menujour_class.php::listerParDate()
	$item = array();
	$requete = "SELECT * FROM boutique_obj_menujour_v2 WHERE dateJour = '".$dateSQL."' AND typeMenu = '".$sousFamille."' AND ID_pointDeVente = '".$IDpointVente."' ORDER BY dateJour ASC";
	$result = T_LAETIS_site::requeter($requete);
	$ingredientsJour = explode('|', $result[0]['ingredients']);
	// fin du code emprunte
	foreach($ingredients as $cle => $valeur) {
		if(in_array($valeur['ID'], $ingredientsJour)) $extraction[] = $valeur;
	}
	return $extraction;
}

require_once 'DB.php';
include_once ('class/affichage/method.class.php');
include_once ('class/commun/method.class.php');
include_once ('class/contact/method.class.php');
include_once ('class/catalogue/method.class.php');
require_once ('./js/recaptcha-1.11/recaptchalib.php');
include_once ('class/commande/method.class.php');
include_once ('class/fromv1/method.class.php'); //inclusion des classes de la v1 laetis

function extraireIngredientsJour2($ingredients, $sousFamille) {
	$dateSQL = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
	$dateFR = date("d-m-Y", mktime(0,0,0,date("m"),date("d"),date("Y")));
	$ingredientsTmp = $ingredientsJour = array();
	$menuJour = new Tbq_menujour();
	$item = $menuJour->listerParDate($dateSQL, $dateSQL, $sousFamille);
	$ingredientsJour[$sousFamille] = explode('|', $item[$dateFR]['ingredients']);
	foreach($ingredients as $cle => $valeur)
		if(in_array($valeur['ID'], $ingredientsJour['salade'])) $ingredientsTmp[] = $valeur;
	return $ingredientsTmp;
}

class frontend {

	function __construct(){
		session_start();
	}

	function redirect($url) {
		echo '<script language="javascript" type="text/javascript">window.location.replace("' . $url . '");</script>';
	}

	function remove_accents($str, $charset = 'utf-8') {
		$str = htmlentities($str, ENT_NOQUOTES, $charset);

		$str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
		$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
		// pour les ligatures e.g. '&oelig;'
		$str = preg_replace('#&[^;]+;#', '', $str);
		// supprime les autres caractÃ¨res
		$str = str_replace(" ","-",$str);
		$str = str_replace("'","-",$str);
		$str = preg_replace('`([^abcdefghijklmnopqrstuvwxyz-])`i', '', $str);
		return $str;
	}

	function erreur($data) {

		$this->accueil($data);
	}

	function accueil($data) {
		$C_pagefrontend = new pagefrontend();

		$C_pagefrontend -> enteteHTML('Fraish - Bienvenue');

		$C_pagefrontend -> affichePage('frontend/pages/accueil.tpl');
	}

	function identification($data) {
		$C_pagefrontend = new pagefrontend();

		$C_pagefrontend -> enteteHTML('Fraish - Identification');

		$C_pagefrontend -> affichePage('frontend/pages/client/identification.tpl');
	}

	function identificationbox($data) {
		$C_pagefrontend = new pagefrontend();
		$C_pagefrontend ->loadCSS("styles/frontend/box.css");
		$C_pagefrontend ->loadJS("js/jquery.validate.min.js");
		$C_pagefrontend -> enteteHTMLBASE('Fraish - Identification');
		$C_pagefrontend -> affichePageBase('frontend/pages/client/identificationbox.tpl');
	}

	function traiterLogin($data) {
		//Check si existant
		$client = new client();
		$valeurs['email']=$data['emaillogin'];
		$valeurs['motDePasse']=$data['passlogin'];
		$idclient = $client -> verifierLogin($valeurs);
		if ($idclient)
		{
			$client -> logger();
			$client -> initialiser($idclient);
			$message = "Bienvenue ".$client ->prenomFacturation.", vous allez être redirige automatiquement.<br /> <br /> <br />";
			$message.= "<img src='styles/frontend/img/loader-fv.gif' style='margin: 0 auto;'/>";
			$message.= "
			<script language=\"javascript\" type=\"text/javascript\">
				setTimeout('window.parent.location.replace(\"commande.html\")',2000);	
				setTimeout('parent.$.fancybox.close()',5000);							
			</script>			
			";
			$this -> boxmessagebox($message);
		}
		else
		{
			$message = "Erreur lors de l'authentification, <a href='identification.html'>cliquez ici pour vous identifier</a>";
			$this -> boxmessagebox($message);
		}
	}

	function deconnexion($data)
	{
	 	session_destroy();
    	$this->redirect("accueil.html");
	}

	function traiterMdp($data)
	{
		if ($data['emailoubli']){
			$client = new Tbq_client();
			$detailClient = $client->demanderLogin($data['emailoubli']);
			if ($detailClient->emailFacturation != ''){
				$detailClient->envoyerLogin(true);
				$message="Vos identifiants ont été envoyés sur votre boite mail.";
				}
			else{
				$message="Adresse e-mail inconnu.";
				}
		}
		else{
			$message="Veuillez renseigner votre adresse e-mail";
			}
		$this -> boxmessagebox($message);
	}

	function compte($data){
		//traitement de l'annulation d'une commande
		if(isset($data['submit'])) {
			//récup de l'id commande, et vérification que cette commande a bien pour client celui envoyé par le formulaire
			$comannuled = new Tbq_commande($data['ID_commande']);
			if (($comannuled->ID_client == $data['ID_client']) && ($comannuled->ID_typ_paiement == 5) && $comannuled->statut == "en_cours")
			{
				$comannuled->modifierStatut($data['ID_commande'], "annulee");
				//recrédit du compte fraish du client...
				$valeurs ['ID_client'] =	$_SESSION['client']['id_client'];
				$valeurs ['date'] = date('Y-m-d');
				$valeurs ['montant']=$comannuled->prix;
				$valeurs ['ID_typ_paiement'] = 7;
				$appro = new Tbq_approvisionnement();
				$appro->enregistrer($valeurs);
				$appro->valider();
			}
		}


		//On vérifie si le client est identifié
		if (!$_SESSION['client']['id_client']) {
			//On redirige vers la page de login en dur (pas en box)
			header('Location: identification.html');
		}

		$C_pagefrontend = new pagefrontend();

		$C_pagefrontend -> enteteHTML('Fraish - Compte');

		$client = new client($_SESSION['client']['id_client']);

		//infos client
		$C_pagefrontend -> assign_vars(array(
		'nom' => $client->nomFacturation,
		'prenom' => $client->prenomFacturation ,
		'adresse' => $client->adresseFacturation ,
		'cp' => $client->codePostalFacturation ,
		'ville' => $client-> villeFacturation,
		'tel' => $client-> telFacturation,
		'mail' => $client->emailFacturation,
		'creditfraish'=> $client->soldeCompte
		));

		//3 dernières commandes
		$lastCommandes=$client->getlastCommandes();
		foreach ($lastCommandes as $ligne){
			$com = new Tbq_commande($ligne['ID']);
			$tabdate = explode('-',$com->dateReservation);
			$datefr = $tabdate[2]."/".$tabdate[1]."/".$tabdate[0];
			$C_pagefrontend -> assign_block_vars('commandes', array('date' => $datefr, 'prix' => $com->prix, 'plat' => $com->plat));
		}

		//3 dernières commandes en cours
		$lastCommandesEnCours=$client->getlastCommandesEnCours();
		foreach ($lastCommandesEnCours as $ligne){
			$com2 = new Tbq_commande($ligne['ID']);
			$tabdate = explode('-',$com2->dateReservation);
			$datefr = $tabdate[2]."/".$tabdate[1]."/".$tabdate[0];
			$C_pagefrontend -> assign_block_vars('commandesencours', array(
			'date' => $datefr,
			'prix' => $com2->prix,
			'plat' => $com2->plat,
			'ID_commande' => $com2->ID,
			'ID_client' => $com2->ID_client,
			'ID_typ_paiement' => $com2->ID_typ_paiement
			));
		}

		$C_pagefrontend -> affichePage('frontend/pages/client/compte.tpl');
	}

	function editercompte($data) {

		//On vérifie si le client est identifié
		if (!$_SESSION['client']['id_client']) {
			//On redirige vers la page de login en dur (pas en box)
			header('Location: identification.html');
		}

		$C_pagefrontend = new pagefrontend();
		$C_pagefrontend -> enteteHTML('Fraish - Compte');

		if ($data['edited']) {

			$client = new client();
			$client -> ID=$_SESSION['client']['id_client'];
			$client -> nomFacturation=$data["nomid"];
			$client -> prenomFacturation=$data["prenomid"];
			$client -> adresseFacturation=$data["adresseid"];
			$client -> codePostalFacturation=$data["cpid"];
			$client -> villeFacturation=$data["villeid"];
			$client -> emailFacturation=$data["emailid"];
			$client -> telFacturation=$data["telid"];
			$client -> newsletter=$data["newsletterid"];
			$client -> motDePasse=$data["mdpid"];
			$client -> enregistrer($valeurs);

			$C_pagefrontend ->assign_vars(array('message' => "<br/><b>Vos modifications sont enregistr&eacute;es, <a href='compte.html'>cliquez ici pour retourner sur votre compte</a></b><br/><br/>"));
		}


		$client = new client($_SESSION['client']['id_client']);

		$selectnl1=$selectnl2="";
		if($client->newsletter == 0) $selectnl1="selected='selected'";
		if($client->newsletter == 1) $selectnl2="selected='selected'";
		$C_pagefrontend ->assign_vars(array('selectnl1' => $selectnl1, 'selectnl2' => $selectnl2));


		//infos client
		$C_pagefrontend -> assign_vars(array(
		'nom' => $client->nomFacturation,
		'prenom' => $client->prenomFacturation ,
		'adresse' => $client->adresseFacturation ,
		'cp' => $client->codePostalFacturation ,
		'ville' => $client-> villeFacturation,
		'tel' => $client-> telFacturation,
		'mail' => $client->emailFacturation,
		'mdp' => $client->motDePasse
		));

		$C_pagefrontend -> affichePage('frontend/pages/client/editercompte.tpl');

	}

	function detailscompte($data) {

		$C_pagefrontend = new pagefrontend();
		$C_pagefrontend -> enteteHTML('Fraish - Compte');

		$client = new Tbq_client($_SESSION['client']['id_client']);
		$appro = new Tbq_approvisionnement();
		$sommeappro=0;
		$sommeappro=$appro->getSommeApproSelonClient($_SESSION['client']['id_client']);
		$C_pagefrontend -> assign_vars(array('sommeappro' => $sommeappro));


		$listeApprosValides = $appro->lister($_SESSION['client']['id_client'],1);

		if($listeApprosValides)
			{
			foreach($listeApprosValides as $itemAppro)
				{
				$itemAppro = new Tbq_approvisionnement($itemAppro->ID);

				$C_pagefrontend -> assign_block_vars('appros', array('montant' => $itemAppro->montant, 'label' => $itemAppro->getLabelTypePaiement(), 'date' => T_LAETIS_site::convertirDate($itemAppro->date)));

				}
			}
		else $message="Aucun approvisionnement";

		$C_pagefrontend -> assign_vars(array('message' => $message));

		$C_pagefrontend -> affichePage('frontend/pages/client/detailscompte.tpl');

	}

	function reapprocheque($data) {

		//On vérifie si le client est identifié
		if (!$_SESSION['client']['id_client']) {
			//On redirige vers la page de login en dur (pas en box)
			header('Location: identification.html');
		}

		$valeurs ['ID_client'] =	$_SESSION['client']['id_client'];
		$valeurs ['date'] = date('Y-m-d');
		$valeurs ['montant']= $data['somme'];
		$valeurs ['ID_typ_paiement'] = 2;
		$valeurs ['numCheque']=	$data['numero'];

		$appro = new Tbq_approvisionnement();
		$appro->enregistrer($valeurs);

		//envoyer le mail pour l'approvisionnement
		$appro->genererMailDemandeAppro("/boutique/fr/emails/envoi-commande/envoi-appro.php",$appro->ID, $_SESSION['client']['id_client']);


		$message.= "Le réaprovisionnement de votre compte est enregistré, il sera effectif après validation par notre service";
		$this -> boxmessage($message);
	}

	function reapproticketresto($data) {

		//On vérifie si le client est identifié
		if (!$_SESSION['client']['id_client']) {
			//On redirige vers la page de login en dur (pas en box)
			header('Location: identification.html');
		}

		$valeurs ['ID_client'] =	$_SESSION['client']['id_client'];
		$valeurs ['date'] = date('Y-m-d');
		$valeurs ['montant'] = $data['nombre']*$data['somme'];
		$valeurs ['ID_typ_paiement'] = 3;
		$valeurs ['nbTitres'] = $data['nombre'];
		$valeurs ['valeurTitre'] = $data['somme'];

		$appro = new Tbq_approvisionnement();
		$appro->enregistrer($valeurs);

		//envoyer le mail pour l'approvisionnement
		$appro->genererMailDemandeAppro("/boutique/fr/emails/envoi-commande/envoi-appro.php",$appro->ID, $_SESSION['client']['id_client']);


		$message.= "Le réaprovisionnement de votre compte est enregistré, il sera effectif après validation par notre service";
		$this -> boxmessage($message);
	}

	function reapprocb($data) {

		//On vérifie si le client est identifié
		if (!$_SESSION['client']['id_client']) {
			//On redirige vers la page de login en dur (pas en box)
			header('Location: identification.html');
		}

		//On controle que la somme soit dans le bon format
		$data['somme'] = str_replace ( ',' , '.' , $data['somme']);

		//BONUS
		if ($data['somme']>=25) {$bonus = "FRAISH vous offre 2€ !"; $bonuschiffre=2;}
		if ($data['somme']>=50) {$bonus = "FRAISH vous offre 5€ !"; $bonuschiffre=5;}
		if ($data['somme']>=100) {$bonus = "FRAISH vous offre 12€ !"; $bonuschiffre=12;}

		//On cré le réappro en bdd, on récup l'id qui est passé à la banque pour le retour et validation du paiement
		$valeurs ['ID_client'] =	$_SESSION['client']['id_client'];
		$valeurs ['date'] = date('Y-m-d');
		//$valeurs ['montant']=$data['somme']+$bonuschiffre;
		$valeurs ['montant']=$data['somme'];
		$valeurs ['ID_typ_paiement'] = 1;
		//$valeurs ['valide']=1; //validation immédiate
		//$valeurs ['approOffert']="";

		$appro = new Tbq_approvisionnement();
		$appro->enregistrer($valeurs);
		$idappro=$appro->ID;

		//enregistrement de l'approvisionnement offert (bonus)
		$valeursApproBonus ['ID_client'] =	$_SESSION['client']['id_client'];
		$valeursApproBonus ['date'] = date('Y-m-d');
		$valeursApproBonus ['montant']=$bonuschiffre;
		$valeursApproBonus ['ID_typ_paiement'] = 8;	//Crédit offert sur approvisionnement
		//$valeursApproBonus ['approOffert'] = $idappro;


		$appro2 = new Tbq_approvisionnement();
		$appro2->enregistrer($valeursApproBonus);
		$idapprobonus = $appro2->ID;

		//on met à jour l'id de l'appro bonus dans le champ approOffert de l'appro de base
		$valeurs ['approOffert']= $idapprobonus;
		$appro->enregistrer($valeurs);



		//on passe la somme et on balance le formulaire de base
		$C_pagefrontend = new pagefrontend();

		require_once("./pel/CMCIC_Config_2316875813.php");
		require_once("./pel/CMCIC_Tpe.inc.php");
		$sOptions = "";
		$sReference = "ref" . date("His");
		$sMontant = $data['somme'];
		$sDevise  = "EUR";
		$sTexteLibre ="appro|".$idappro;
		$sDate = date("d/m/Y:H:i:s");
		$sLangue = "FR";
		$client = new client($_SESSION['client']['id_client']);
		$sEmail = $client->emailFacturation;
		$oTpe = new CMCIC_Tpe($sLangue);
		$oHmac = new CMCIC_Hmac($oTpe);
		$CtlHmac = sprintf(CMCIC_CTLHMAC, $oTpe->sVersion, $oTpe->sNumero, $oHmac->computeHmac(sprintf(CMCIC_CTLHMACSTR, $oTpe->sVersion, $oTpe->sNumero)));
		// Data to certify
		$PHP1_FIELDS = sprintf(CMCIC_CGI1_FIELDS,     $oTpe->sNumero,
		                                              $sDate,
		                                              $sMontant,
		                                              $sDevise,
		                                              $sReference,
		                                              $sTexteLibre,
		                                              $oTpe->sVersion,
		                                              $oTpe->sLangue,
		                                              $oTpe->sCodeSociete,
		                                              $sEmail,
		                                              $sNbrEch,
		                                              $sDateEcheance1,
		                                              $sMontantEcheance1,
		                                              $sDateEcheance2,
		                                              $sMontantEcheance2,
		                                              $sDateEcheance3,
		                                              $sMontantEcheance3,
		                                              $sDateEcheance4,
		                                              $sMontantEcheance4,
		                                              $sOptions);

		// MAC computation
		$sMAC = $oHmac->computeHmac($PHP1_FIELDS);

		//Assignation des variables au template
		$myvars = array(
			'sUrlPaiement' => $oTpe->sUrlPaiement,
			'sVersion'=> $oTpe->sVersion,
			'sNumero'=> $oTpe->sNumero,
			'sDate'=> $sDate,
			'sMontant'=> $sMontant . $sDevise,
			'sReference'=> $sReference,
			'sMAC'=> $sMAC,
			'sUrlKO'=> $oTpe->sUrlKO,
			'sUrlOK'=> $oTpe->sUrlOK,
			'sLangue'=> $oTpe->sLangue,
			'sCodeSociete'=> $oTpe->sCodeSociete,
			'sTexteLibre'=> HtmlEncode($sTexteLibre),
			'sEmail'=> $sEmail,
			'montant'=>	$data['somme'],
			'bonus'=>$bonus
		);

		$C_pagefrontend -> assign_vars($myvars);

		$C_pagefrontend -> affichePage('frontend/pages/client/reapprocb.tpl');



		//$message.= "Le réaprovisionnement de votre compte est enregistré, il est directement utilisable pour vos prochaines commandes";
		//$this -> boxmessage($message);
	}

	function heure($data) {

		$C_pagefrontend = new pagefrontend();

		$C_pagefrontend -> enteteHTML('Fraish - Bienvenue');

		$C_pagefrontend -> affichePage('frontend/pages/commande/erreur.tpl');
	}

	function traiternouveauclient($data)
	{
	 	$client = new client();

		//On met à jour chaque valeur de l'objet, en fct de ce qui est récup du formulaire
		$client -> codeEntreprise="";
		$client -> dateInscription=date("Y-m-d");
		$client -> civiliteFacturation="";
		$client -> nomFacturation=$data["nomid"];
		$client -> prenomFacturation=$data["prenomid"];
		$client -> adresseFacturation=$data["adresseid"];
		$client -> adresseFacturation2="";
		$client -> codePostalFacturation=$data["cpid"];
		$client -> villeFacturation=$data["villeid"];
		$client -> emailFacturation=$data["emailid"];
		$client -> telFacturation=$data["telid"];
		$client -> societe="";
		$client -> newsletter=$data["newsletterid"];
		$client -> motDePasse=$data["mdpid"];
		$client -> dateDeNaissance=$data["naissanceid"];
		$client -> ID_pointDeVentePrefere="0";
		$client -> soldeCompte="0";


		$client -> enregistrer($valeurs);
		$client -> logger();
		$client -> envoyerLoginInscription();

		$message = "Bienvenue ".$client ->prenomFacturation.", votre inscription est enregistrée, vous allez être redirigé automatiquement.<br /> <br /> <br />";
		$message.= "<img src='styles/frontend/img/loader-fv.gif' style='margin: 0 auto;'/>";
		$message.= "
			<script language=\"javascript\" type=\"text/javascript\">			
				setTimeout('window.parent.location.replace(\"commande.html\")',4000);
				setTimeout('parent.$.fancybox.close()',5000);
				//parent.$.fancybox.close();			
			</script>			
			";
		$this -> boxmessage($message);
	}

	function boxmessage($message)
	{
		$C_pagefrontend = new pagefrontend();
		$C_pagefrontend -> enteteHTML('Fraish');
		$C_pagefrontend -> assign_vars(array('message' => $message));
		$C_pagefrontend -> affichePage('frontend/pages/client/boxmessage.tpl');
	}

	function boxmessagebox($message)
	{
		$C_pagefrontend = new pagefrontend();
		$C_pagefrontend ->loadCSS("styles/frontend/box.css");
		$C_pagefrontend ->loadJS("js/jquery.validate.min.js");
		$C_pagefrontend -> enteteHTMLBASE('Fraish');
		$C_pagefrontend -> assign_vars(array('message' => $message));
		$C_pagefrontend -> affichePageBase('frontend/pages/client/boxmessage.tpl');
	}

	function commanderetour($data)
	{
		//On récup l'étape en cours dans la session, on retire 1, on met à jour la session et on renvoi vers la commande
		if ($_SESSION['panier']['objet']) $commandev2= unserialize($_SESSION['panier']['objet']);
		else $commandev2 = new commande();
		$commandev2 ->etapeEnCours = ($commandev2 ->etapeEnCours) -1;
		$commandev2 -> save($data);
		header('Location: commande.html');
	}

	function completercommande($data)
	{
		//Le cookie ne bouge pas, la session est deja vide.
		//On envoi la commande
		$data['etape']="1";
		$this->commande($data);
	}

	function panier($data){
		$data['etape']="5";
		$data['menu']="ok";
		$this->commande($data);
	}

	function supprimerpanier($data)
	{
		//On récup l'élement à supprimer
		$element = $data['elem'];
		$data=array();

		//Si elem = 'panier', c'est une suppression depuis l'étape 4, donc on vide le panier en session
		if($element=="panier"){
			$_SESSION['panier']['objet']=array();
			header('Location: commande.html');
		}

		//Sinon, on supprime l'element dans le cookie et la variable de session temporaire
		else{
				$mytemps = $_SESSION['commande'];
				unset($mytemps[$element]);
				$mytemps = array_merge($mytemps);
				unset($_SESSION['commande']);
				$_SESSION['commande']=$mytemps;
				$data['nosave']=1;
				$this->panier($data);
			}
	}

	function commande($data)
	{

		$C_pagefrontend = new pagefrontend();

		//On vérifie si le client est identifié
		if (!$_SESSION['client']['id_client']) {
			//On redirige vers la page de login en dur (pas en box)
			header('Location: identification.html');
		}

		//Si oui, on charge le client, et éventuellement sa commande en cours
		else
		{

			$client = new client($_SESSION['client']['id_client']);

			//Controle de l'heure
			//On enregistre l'heure en session si ce n'est pas déja fait
			if (!$_SESSION['infoscommande']['heure'])$_SESSION['infoscommande']['heure']=date("H:i");

			if ($_SESSION['infoscommande']['heure']>='11:31'){
				// autoriser le compte Sophie Friash et les IP couleur citron
				 if((string)$_SESSION['client']['id_client'] != '4648'	&&	($_SERVER['REMOTE_ADDR'] != '37.1.253.217')	&&	($_SERVER['REMOTE_ADDR'] != '82.234.79.170')	&&	($_SERVER['REMOTE_ADDR'] != '78.234.92.119')	&&	!preg_match('/^192\.168/msi', $_SERVER['REMOTE_ADDR'])	){
					  header('Location: heure.html');
				 }
			}

			// on vérifie le nombre max de commandes du jour
			$CommRequete = "SELECT * FROM `boutique_obj_commande` WHERE `dateReservation` = '".date("Y-m-d")."' AND `statut` LIKE 'en_cours' ";
			$CommResult = T_LAETIS_site::requeter($CommRequete);

			// Système de gestion du quota max de commande par jour
				// On limite le nombre de commande par jour. Si un utilisateur tarde à commander, il ne sera pas bloqué dans sa commande
				// car on stockera une variable en session lui autorisant à finaliser sa commande
			if(!$_SESSION['access']) {
				if (count($CommResult) <= 1000000){ // nmbre max de commande : 1M = no limit
					$_SESSION['access'] = true;
				} else {
					$message = "Commande impossible, quota du jour atteint pour notre boutique.<br /> <br />Nous vous invitons &agrave; revenir passer commande d&egrave;s demain !";
					$this -> boxmessage($message);
					exit;
				}
			}

			//On vérifie si le client peut commander
			if (!$client -> peutCommander())
			{
				$message = "Commande impossible, le solde de votre compte est négatif ! <br /> <br /><a href='compte.html'>Veuillez créditer votre compte.</a>";
				$this -> boxmessage($message);
				exit;
			}

			//On met à jour l'étape si l'étape 1 est franchie (pas de formulaire sur l'étape 1)
			if (($data["menu"]!="") && !$data['etape']) $data['etape']=2;

			//Si un panier est déja en cours, on le charge, sinon on en cré une nouvelle
			if ($_SESSION['panier']['objet']) {$commandev2= unserialize($_SESSION['panier']['objet']);}
			else if ($data['menu']!="ok") {$commandev2 = new commande();}

			//On sauvegarde dans l'objet commande les éventuelles saisies précédents (à partir de l'étape 2 en fait)
			if ($data['menu']!="ok") $commandev2 -> save($data);

			//$this->aff_objet($commandev2);

			//On charge le template avec des valeurs courantes
			if ($data['menu']!="ok"){
			if($data[menu]) $idFormule = $data[menu];else $idFormule = $data[idformule];
			$C_pagefrontend -> assign_vars(array('nomformule' => $commandev2 ->nomFormule,'size' => $commandev2 ->tailleMenu, 'idformule' => $idFormule));
			$etape= $commandev2 ->etapeEnCours;
			}

			else $etape=$data['etape'];


			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//////  Pré-traitement ETAPE 2   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			if ($etape==2)
			{

				//On récup le menu choisi
				$menu = $commandev2->idMenu;
				$size = $commandev2->tailleMenu;


				//Pour l'instant, le choix de la date n'est pas prévu, donc on la fixe à la date du jour
				$dateReservation = date('d-m-Y');

				//Listing de tous les ingrédients
				$commande = new Tbq_commande();
				$commandeEnCours = new Tbq_commande($_GET['ID_commandeEnCours']);
				$formule=new Tbq_formule($menu);

				$C_pagefrontend -> assign_vars(array('nomformule' => $formule->nom,'size' => $size));

				//init des droits à 0
				$C_pagefrontend -> assign_vars(array('droitsalade' => '0','droitsoupe' => '0','droitdessert' => '0','droitboisson' => '0','droiteau' => '0','droitpain' => '0'));


				$ingredients = Tbq_famille::listerIngredients(1, 'ordreWeb', 'Féculents');
$ingredients = extraireIngredientsJour($ingredients, 'salade');
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('salade')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled=""; $C_pagefrontend -> assign_vars(array('droitsalade' => '1'));}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$C_pagefrontend -> assign_block_vars('feculents', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

				$ingredients = Tbq_famille::listerIngredients(1, 'ordreWeb', 'salades');
$ingredients = extraireIngredientsJour($ingredients, 'salade');
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('salade')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$C_pagefrontend -> assign_block_vars('salades', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

				$ingredients = Tbq_famille::listerIngredients(1, 'ordreWeb', 'crudites');
$ingredients = extraireIngredientsJour($ingredients, 'salade');
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('salade')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$C_pagefrontend -> assign_block_vars('crudites', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

				$ingredients = Tbq_famille::listerIngredients(1, 'ordreWeb', 'fromages');
$ingredients = extraireIngredientsJour($ingredients, 'salade');
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('salade')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$C_pagefrontend -> assign_block_vars('fromages', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

				$ingredients = Tbq_famille::listerIngredients(1, 'ordreWeb', 'viandes');
$ingredients = extraireIngredientsJour($ingredients, 'salade');
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('salade')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$C_pagefrontend -> assign_block_vars('viandes', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

				$ingredients = Tbq_famille::listerIngredients(1, 'ordreWeb', 'poissons');
$ingredients = extraireIngredientsJour($ingredients, 'salade');
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('salade')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$C_pagefrontend -> assign_block_vars('poissons', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

				$ingredients = Tbq_famille::listerIngredients(1, 'ordreWeb', 'topping');
$ingredients = extraireIngredientsJour($ingredients, 'salade');
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('salade')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$C_pagefrontend -> assign_block_vars('topping', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

				$ingredients = Tbq_famille::listerIngredients(7, 'ordreWeb', '' ,1);
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('salade')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$details='<span class="tdet">'.$tbq_ingredient->libelle.'</span><br /> <br />'.$tbq_ingredient->details;
					$C_pagefrontend -> assign_block_vars('sauces', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled, 'details' => $details));
				}

				$ingredients = Tbq_famille::listerIngredients(2, 'ordreWeb', 'Daily' ,1);
				$ingredients = extraireIngredientsJour($ingredients, 'soupe');
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('soupe')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled=""; $C_pagefrontend -> assign_vars(array('droitsoupe' => '1'));}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$details='<span class="tdet">'.$tbq_ingredient->libelle.'</span><br /> <br />'.$tbq_ingredient->details;
					$C_pagefrontend -> assign_block_vars('recettesdujour', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled, 'details' => $details));
				}

				$tbq_option = new Tbq_option();
				$options=$tbq_option->listerOptions();
				if(!$formule->aLePlatV2('soupe')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($options); $i++){
					$C_pagefrontend -> assign_block_vars('agrements', array('id' => $options[$i]['ID'], 'intitule' => $options[$i]['libelle'], 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

				$ingredients = Tbq_famille::listerIngredients(1, 'ordreWeb', 'Daily' ,1);
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('salade')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$details='<span class="tdet">'.$tbq_ingredient->libelle.'</span><br /> <br />'.$tbq_ingredient->details;
					$C_pagefrontend -> assign_block_vars('saladeRecettesdujour', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled, 'details' => $details));
				}

				$ingredients = Tbq_famille::listerIngredients(3, 'ordreWeb', '' ,1);
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('pain')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";}	else {$classdisabled=$disabled="";$C_pagefrontend -> assign_vars(array('droitpain' => '1'));}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$C_pagefrontend -> assign_block_vars('pains', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

				$ingredients = Tbq_famille::listerIngredients(4, 'ordreWeb', '' );
				$ingredients = extraireIngredientsJour($ingredients, 'desserts');
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('dessert')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";} else {$classdisabled=$disabled=""; $C_pagefrontend -> assign_vars(array('droitdessert' => '1'));}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$C_pagefrontend -> assign_block_vars('desserts', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

				$ingredients = Tbq_famille::listerIngredients(5, 'ordreWeb', 'Jus de fruits' ,1);
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('boisson')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";} else {$classdisabled=$disabled=""; $C_pagefrontend -> assign_vars(array('droitboisson' => '1'));}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$details='<span class="tdet">'.$tbq_ingredient->libelle.'</span><br /> <br />'.$tbq_ingredient->details;
					$C_pagefrontend -> assign_block_vars('jusdefruits', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled, 'details' => $details));
				}

				$ingredients = Tbq_famille::listerIngredients(5, 'ordreWeb', 'Daily Juice' ,1);
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('boisson')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";} else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$details='<span class="tdet">'.$tbq_ingredient->libelle.'</span><br /> <br />'.$tbq_ingredient->details;
					$C_pagefrontend -> assign_block_vars('jusdefruits', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled, 'details' => $details));
				}

				$ingredients = Tbq_famille::listerIngredients(5, 'ordreWeb', 'Milk Shakes' ,1);
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('boisson')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";} else {$classdisabled=$disabled="";	}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$details='<span class="tdet">'.$tbq_ingredient->libelle.'</span><br /> <br />'.$tbq_ingredient->details;
					$C_pagefrontend -> assign_block_vars('milkshakes', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled, 'details' => $details));
				}

				$ingredients = Tbq_famille::listerIngredients(5, 'ordreWeb', 'Smoothies' ,1);
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('boisson')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";} else {$classdisabled=$disabled="";}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$details='<span class="tdet">'.$tbq_ingredient->libelle.'</span><br /> <br />'.$tbq_ingredient->details;
					$C_pagefrontend -> assign_block_vars('smoothies', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled, 'details' => $details));
				}

				$ingredients = Tbq_famille::listerIngredients(6, 'ordreWeb', '' ,1);
				$tabProvisoire = array();
				if(!$formule->aLePlatV2('eau')) {$classdisabled = "class='labeldisabled'"; $disabled = "disabled='disabled'";} else {$classdisabled=$disabled=""; $C_pagefrontend -> assign_vars(array('droiteau' => '1'));}
				for($i = 0; $i<count($ingredients); $i++){
					$tabProvisoire[$i] = $ingredients[$i]['ID'];
					//ajout direct
					$tbq_ingredient = new Tbq_ingredient();
					$tbq_ingredient->initialiser($tabProvisoire[$i]);
					$C_pagefrontend -> assign_block_vars('eaux', array('id' => $tbq_ingredient->ID, 'intitule' => $tbq_ingredient->libelle, 'classdisabled' => $classdisabled, 'disabled' => $disabled));
				}

			}


			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//////  Pré-traitement ETAPE 3   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			if ($etape==3)
			{

				//controle que les choix de l'étape 2 sont bien faits, au cas ou la personne n'a rien choisi et n'a pas le javascript activé !
				if (!$commandev2->checkempty()){
					$message = "Veuillez choisir les ingrédients de votre menu !";
					$this -> boxmessage($message);
					exit;
				}

				$listeFamille = Tbq_famille::listerFamilles();
				$index = 0;
				$mycount=0;
				foreach ($listeFamille as $famille) //on parcours chaque famille
				{
					//on récup les sous familles de cette famille
					$sousFamilles= Tbq_ingredient::getSsFamilles($famille['ID']);

					//On parcours les sous familles

					foreach ($sousFamilles as $sFamille)
					{
						//On récup les suppléments de cette famille d'ingrédients
						$supplementSsFamilles = Tbq_ingredient::getSupplements($famille['ID'],'ordreWeb', $sFamille['libelleSousFamille']);

						//Si il y a des suppléments dans cette sous famille, on affiche
						if ($supplementSsFamilles)
						{
							//Si la sous famille est vide, on remplace son libelle par le libelle de la famille
							if (!$sFamille['libelleSousFamille'])	$sFamille['libelleSousFamille'] = $famille['libelle'];

							$C_pagefrontend -> assign_block_vars('ssfamilles', array('intitule' => $sFamille['libelleSousFamille'], 'IDFamille'=>$famille['ID']));



							foreach($supplementSsFamilles as $supplement)
							{

								//création du tableau des options
								$prixOptionAdecouper = explode('][',substr($supplement['prixSupplement'],1,-1));
								$prixOption = array();
								for($y=0; $y<count($prixOptionAdecouper); $y++)
								{
									$tabPrixOption = explode('|',$prixOptionAdecouper[$y]);
									if ($tabPrixOption[1]){
										$prixOption[$y] = array ();
										$prixOption[$y]['libelle'] = $tabPrixOption[0];
										$prixOption[$y]['prix'] = $tabPrixOption[1];
									}
								}

				                if(count($prixOption)<=1){
				                	//prix supplément unique
				                	$C_pagefrontend -> assign_block_vars('ssfamilles.supplement', array('mycount'=> $mycount,'idsup' => $supplement['ID'], 'libellePrix' => $prixOption[0]['libelle'], 'prix' => $prixOption[0]['prix'], 'libelle' => $supplement['libelle']));
				        			$mycount++;
								}
				        		else {
									$C_pagefrontend -> assign_block_vars('ssfamilles.supplementmulti', array('mycount'=> $mycount,'idsup' => $supplement['ID'], 'libelle' => $supplement['libelle'], 'tooltip' => " title='".$supplement['details']."'"));
									$mycount++;
									$count=1;
				                   foreach($prixOption as $option){
				                   	//prix supplément selon taille
				                   		$C_pagefrontend -> assign_block_vars('ssfamilles.supplementmulti.each', array('libellePrix' => $option['libelle']." - ".$option['prix']."€", 'prix' => $option['prix'], 'count'=> $count, 'taille' => $option['libelle']));
										$count++;
									}
								}
								$index++;
							}


						}

					}
				}

			}

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//////  Pré-traitement ETAPE 4   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			if ($etape==4)
			{
				//$this->aff_objet($commandev2 ->ingredients);
				//$elementsCommandes = array('salade','sauce','soupe','saladeRecettesdujour','pains','desserts','boissons','eaux');
				$tbq_option = new Tbq_option();

				$txtDetailsFormule = "";

				//Gestion de la salade

				if ($commandev2 ->ingredients['salade']) $txtDetailsFormule .= "<b>Salade :</b> ";

				foreach($commandev2 ->ingredients['salade'] as $salade){
					$details = $commandev2->getFullDetails($salade);
					$txtDetailsFormule .=  $details['libelle'].', ';
				}

				//Gestion de la sauce
				//Si salade
				if ($commandev2 ->ingredients['salade']){
					foreach($commandev2 ->ingredients['sauce'] as $sauce){
						$detailssauce = $commandev2->getFullDetails($sauce);
						$txtDetailsFormule .=  "sauce ".$detailssauce['libelle'].'.';

					}
				}

				//Gestion de la soupe
				foreach($commandev2 ->ingredients['soupe'] as $soupe){
					$details = $commandev2->getFullDetails($soupe);
					if($details['libelle']) $txtDetailsFormule .=  "<br /><b>Soupe :</b> ".$details['libelle'].'.';
				}

				//Gestion agréments de la soupe
					if ($commandev2 ->ingredients['soupe'][0]!=""){
						foreach($commandev2 ->ingredients['agrement'] as $agrement){
							if($agrement) $option=$tbq_option->getOptionName($agrement);
							if($option) $txtDetailsFormuleAgrements .=  " ".$option;
						}
					}
					if ($commandev2 ->ingredients['soupe'][0]!="") $txtDetailsFormule .= "<br />Agrément(s) : ".$txtDetailsFormuleAgrements.'.';

				//Gestion Recettesdujour
				/*foreach($commandev2 ->ingredients['saladeRecettesdujour'] as $Recettesdujour){
					$details = $commandev2->getFullDetails($Recettesdujour);
					$txtDetailsFormule .=  "<br />Soupe ".$details['libelle'].'.';
				}*/

				//Gestion pains
				foreach($commandev2 ->ingredients['pains'] as $pains){
					$details = $commandev2->getFullDetails($pains);
					if($details['libelle']) $txtDetailsFormule .=  "<br /><b>Pain : </b>".$details['libelle'].'.';
				}

				//Gestion desserts
				foreach($commandev2 ->ingredients['desserts'] as $desserts){
					$details = $commandev2->getFullDetails($desserts);
					if($details['libelle']) $txtDetailsFormule .=  "<br /><b>Dessert : </b>".$details['libelle'].'.';
				}

				//Gestion boissons
				foreach($commandev2 ->ingredients['boissons'] as $boissons){
					$details = $commandev2->getFullDetails($boissons);
					if($details['libelle']) $txtDetailsFormule .=  "<br /><b>Boisson : </b>".$details['libelle'].'.';
				}

				//Gestion eaux
				foreach($commandev2 ->ingredients['eaux'] as $eaux){
					$details = $commandev2->getFullDetails($eaux);

					if($details['libelle']) $txtDetailsFormule .=  "<br /><b>Eau : </b>".$details['libelle'].'.';
				}

				if($commandev2->tailleMenu==1) $sizemenu="moyen"; else $sizemenu="grand";



				$txtDetailsFormuleSup = "<b>Vos suppléments : </b><br/><br/>";
				$supok=0;
				$tbq_ingredient = new Tbq_ingredient();
				$PrixSupplements=0;
				foreach($commandev2 ->supplements as $keySup => $valueSup){


					if ($valueSup[key($valueSup)]['qte'] >= 1) {
						$supok=1;
						$details = $commandev2->getFullDetails(key($valueSup));
						$ssfamille= $tbq_ingredient->getLibelleFamille ($details['ID_famille']);
						$txtDetailsFormuleSup .= $ssfamille." : ".$details['libelle']." (x".$valueSup[key($valueSup)]['qte'].")";

						//Si la taille est choisie, on complete
						if($valueSup[key($valueSup)]['taille']) $txtDetailsFormuleSup .= " (".$valueSup[key($valueSup)]['taille'].")";
						$txtDetailsFormuleSup .= "<br />";

						//On ajoute au prix du menu global
						$tbq_ingredient->initialiser(key($valueSup));

						//Extraction du prix du supplément choisi, en fct de sa taille
						if(!$valueSup[key($valueSup)]['taille'])
						{
							$prix1 = explode ( "|" , $tbq_ingredient->prixSupplement);
							$prixsup= substr ( $prix1[1] , 0, 4);
						}
						else
						{
							$prixOptionAdecouper = explode('][',substr($tbq_ingredient->prixSupplement,1,-1));
							if($valueSup[key($valueSup)]['taille']=="petit"){$tabPrixOption = explode('|',$prixOptionAdecouper[0]);}
							if($valueSup[key($valueSup)]['taille']=="moyen"){$tabPrixOption = explode('|',$prixOptionAdecouper[1]);}
							if($valueSup[key($valueSup)]['taille']=="grand"){$tabPrixOption = explode('|',$prixOptionAdecouper[2]);}
							$prixsup=$tabPrixOption[1];
						}
						$PrixSupplements += $prixsup * $valueSup[key($valueSup)]['qte'];
					}
				}

				if(!$supok) $txtDetailsFormuleSup ="";

				//calcul du prix du panier, prix du menu + suppléments
				$PrixTotalMenu = $commandev2->prixMenu + $PrixSupplements;

				//On met à jour l'objet
				$commandev2->prixPanier=$PrixTotalMenu;
				$commandev2->save($data);

				//On rajoute un 0 à la fin du prix, si c'est un prix à virgule
				if (strpos($PrixTotalMenu,".") !== false)  $PrixTotalMenu .= "0";

				$C_pagefrontend -> assign_vars(array('txtDetailsFormule' => $txtDetailsFormule,'txtDetailsFormuleSup' => $txtDetailsFormuleSup,'size' =>$sizemenu, 'price'=> $PrixTotalMenu));

			}




			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//////  Pré-traitement ETAPE 5 & 6  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





			if (($etape==5) OR ($etape==6)) // Affichage commande complète
			{


				if ((count($_SESSION['commande'])==0) OR ($_SESSION['commande']=="")) {
					$C_pagefrontend -> assign_vars(array('message' => "<div style='margin: 20px 0 0 50px;'>Votre panier est vide, veuillez <a href='./completercommande.html'>compléter votre commande</a>.</div>"));
					$paniernonvide=1;
				}

				//On parcours chaque case de la commande et on envoi la même chose qu'en étape 4
				$mycount=0;

				if(!$paniernonvide){

					$prixcommandetotal=0;

					//$this->aff_objet($_SESSION['commande']);

					foreach($_SESSION['commande'] as $monpanier){

						//On cré l'objet

						//$this->aff_objet($monpanier);

						$commandev2= unserialize($monpanier);

						//$this->aff_objet($commandev2);


						$txtDetailsFormule = "";

						//Gestion de la salade

						if ($commandev2 ->ingredients['salade']) $txtDetailsFormule .= "Salade : ";

						if ($commandev2 ->ingredients['salade']){
							foreach($commandev2 ->ingredients['salade'] as $salade){
								$details = $commandev2->getFullDetails($salade);
								$txtDetailsFormule .=  $details['libelle'].', ';
							}
						}
						//Gestion de la sauce
						//Si salade
						if ($commandev2 ->ingredients['salade']){
							foreach($commandev2 ->ingredients['sauce'] as $sauce){
								$detailssauce = $commandev2->getFullDetails($sauce);
								$txtDetailsFormule .=  "sauce ".$detailssauce['libelle'].'.';

							}
						}

						//Gestion de la soupe
						if ($commandev2 ->ingredients['soupe']){
							foreach($commandev2 ->ingredients['soupe'] as $soupe){
								$details = $commandev2->getFullDetails($soupe);
								if($details['libelle']) $txtDetailsFormule .=  "<br />Soupe : ".$details['libelle'].'.';
							}
						}

						//Gestion agréments de la soupe
						if ($commandev2 ->ingredients['soupe']){
							foreach($commandev2 ->ingredients['agrement'] as $agrement){
								//echo "test";
								$details = $commandev2->getFullDetails($agrement);
								if($details['libelle']) $txtDetailsFormule .=  "<br />Agréments : ".$details['libelle'].'.';
							}
						}

						//Gestion Recettesdujour
						/*foreach($commandev2 ->ingredients['saladeRecettesdujour'] as $Recettesdujour){
							$details = $commandev2->getFullDetails($Recettesdujour);
							$txtDetailsFormule .=  "<br />Soupe ".$details['libelle'].'.';
						}*/

						//Gestion pains
						if ($commandev2 ->ingredients['pains']){
							foreach($commandev2 ->ingredients['pains'] as $pains){
								$details = $commandev2->getFullDetails($pains);
								if($details['libelle']) $txtDetailsFormule .=  "<br />Pain : ".$details['libelle'].'.';
							}
						}
						//Gestion desserts
						if ($commandev2 ->ingredients['desserts']){
							foreach($commandev2 ->ingredients['desserts'] as $desserts){
								$details = $commandev2->getFullDetails($desserts);
								if($details['libelle']) $txtDetailsFormule .=  "<br />Dessert : ".$details['libelle'].'.';
							}
						}
						//Gestion boissons
						if ($commandev2 ->ingredients['boissons']){
							foreach($commandev2 ->ingredients['boissons'] as $boissons){
								$details = $commandev2->getFullDetails($boissons);
								if($details['libelle']) $txtDetailsFormule .=  "<br />Boisson : ".$details['libelle'].'.';
							}
						}
						//Gestion eaux
						if ($commandev2 ->ingredients['eaux']){
							foreach($commandev2 ->ingredients['eaux'] as $eaux){
								$details = $commandev2->getFullDetails($eaux);

								if($details['libelle']) $txtDetailsFormule .=  "<br />Eau : ".$details['libelle'].'.';
							}
						}
						if($commandev2->tailleMenu==1) $sizemenu="moyen"; else $sizemenu="grand";

						$txtDetailsFormuleSup = "";
						$supok=0;
						$tbq_ingredient = new Tbq_ingredient();
						$PrixSupplements=0;

						if ($commandev2 ->supplements){
							foreach($commandev2 ->supplements as $keySup => $valueSup){

								if ($valueSup[key($valueSup)]['qte'] >= 1) {
									$supok=1;
									$details = $commandev2->getFullDetails(key($valueSup));
									$ssfamille= $tbq_ingredient->getLibelleFamille ($details['ID_famille']);
									$txtDetailsFormuleSup .= $ssfamille." : ".$details['libelle']." (x".$valueSup[key($valueSup)]['qte'].")";

									//Si la taille est choisie, on complete
									if($valueSup[key($valueSup)]['taille']) $txtDetailsFormuleSup .= " (".$valueSup[key($valueSup)]['taille'].")";
									$txtDetailsFormuleSup .= "<br />";

									//On ajoute au prix du menu global
									$tbq_ingredient->initialiser(key($valueSup));

									//Extraction du prix du supplément choisi, en fct de sa taille
									if(!$valueSup[key($valueSup)]['taille'])
									{
										$prix1 = explode ( "|" , $tbq_ingredient->prixSupplement);
										$prixsup=$prix1[1];
									}
									else
									{
										$prixOptionAdecouper = explode('][',substr($supplement['prixSupplement'],1,-1));
										if($valueSup[key($valueSup)]['taille']=="petit"){$tabPrixOption = explode('|',$prixOptionAdecouper[0]);}
										if($valueSup[key($valueSup)]['taille']=="moyen"){$tabPrixOption = explode('|',$prixOptionAdecouper[1]);}
										if($valueSup[key($valueSup)]['taille']=="grand"){$tabPrixOption = explode('|',$prixOptionAdecouper[2]);}
										$prixsup=$tabPrixOption[1];
									}

									$PrixSupplements += $prixsup * $valueSup[key($valueSup)]['qte'];
								}
							}


						$_SESSION['infoscommande'][$mycount]['txtsupplements']=$txtDetailsFormuleSup;
						$txtDetailsFormuleSup = "Vos suppléments : <br/><br/>".$txtDetailsFormuleSup;

						}
						if(!$supok) $txtDetailsFormuleSup ="";

						//calcul du prix du panier: prix du menu + suppléments
						//$PrixTotalMenu = ($commandev2->prixMenu + $PrixSupplements)*$commandev2->quantite;
						$PrixTotalMenu=$commandev2->prixPanier*$commandev2->quantite;

						//Ajout du code promo PROMO10
						//if ($_SESSION['infoscommande']['codepromo'] == "3025") {$PrixTotalMenu = $PrixTotalMenu*0.90;}
						//elseif ($_SESSION['infoscommande']['codepromo'] == "PROM010") {$PrixTotalMenu = $PrixTotalMenu*0.90;}

						$_SESSION['infoscommande'][$mycount]['PrixPanier']=$PrixTotalMenu;	//pour savebdd



						$prixcommandetotal+=$PrixTotalMenu;

						//echo "prixtotalmenu : ".$PrixTotalMenu;
						//echo "prixpanier objet : ".$commandev2->prixPanier;


						//On rajoute un 0 à la fin du prix, si c'est un prix à virgule
						if (strpos($PrixTotalMenu,".") !== false)  $PrixTotalMenu .= "0";

						if($commandev2->commentaire=="")$commandev2->commentaire="<i>aucun commentaire</i>";

						$C_pagefrontend -> assign_block_vars('panier', array('nomformule'=> $commandev2->nomFormule, 'quantite'=> $commandev2->quantite,'mycount'=>$mycount, 'commentaire' => $commandev2->commentaire, 'txtDetailsFormule' => $txtDetailsFormule,'txtDetailsFormuleSup' => $txtDetailsFormuleSup,'size' =>$sizemenu, 'price'=> $PrixTotalMenu));


						$mycount++;
					}//fin foreach panier

					$_SESSION['infoscommande']['prixcommandetotal']=$prixcommandetotal;
					if (strpos($prixcommandetotal,".") !== false)  $prixcommandetotal .= "0";
					$C_pagefrontend -> assign_vars(array('prixcommandetotal' => $prixcommandetotal));
				}

				//Si dernière étape, au sauve en bdd en tant que commande abandonnée
				if ($etape==6) $this->saveCommandeBdd();

				//gestion des infos à transmettre en plus de la commande
				if ($etape==6) $C_pagefrontend -> assign_vars($this-> formpaiement());
				$C_pagefrontend -> assign_vars(array('creditfraish' => $client->soldeCompte, 'emailFacturation'=> $client->emailFacturation));

				//Gestion code promo
				if (($etape==6)&&($_SESSION['infoscommande']['codepromo']!="")) {
					$C_pagefrontend -> assign_vars(array(
					'codepromo' => "<p class='txtcodepromo'>Code promotion : <span>".$_SESSION['infoscommande']['codepromo']."</span></p>",
					'codepromodescription' => "<div class='codepromodescription'>".$_SESSION['infoscommande']['codepromotxt']."</div>"));
				}



				}//fin if etape 5 ou 6



			//On charge la page de la commande en cours
			$C_pagefrontend -> enteteHTML('Fraish - Commande - '.$commandeEnCours->title[$etape]);
			$C_pagefrontend -> choixbtcmd('commandezv');
			$C_pagefrontend -> affichePage('frontend/pages/commande/commande'.$etape.'.tpl');
		}
	}


	function saveCommandeBdd()
	{
		//Une commande enregistrée par ligne dans le panier
		//$BigCookieCommande = unserialize($_SESSION['commande']);
		$count=0;

		//echo "test fct savecommandebdd";
		//$this->aff_objet($_SESSION['commande']);

		//initialisation de la liste des id commande fraish, pour éviter de cumuler les numéro lors d'un retour en arrière dans la commande
		$_SESSION['infoscommande']['idcommande'] = array();



		foreach($_SESSION['commande'] as $monpanier){

			$commandev2= unserialize($monpanier);

			$pain = $dessert =	$boisson = $eau = $saladenoms =	$vinaigrette = $txtDetailsFormuleAgrements = $txtAgrementsSoupe="";
			//$this->aff_objet($commandev2);


			//pains
			if ($commandev2 ->ingredients['pains']){foreach($commandev2 ->ingredients['pains'] as $pains){$details = $commandev2->getFullDetails($pains);if($details['libelle']) $pain .=  $details['libelle'].'.';}}
			//desserts
			if ($commandev2 ->ingredients['desserts']){foreach($commandev2 ->ingredients['desserts'] as $desserts){$details = $commandev2->getFullDetails($desserts);if($details['libelle']) $dessert .=  $details['libelle'].'.';}}
			//boissons
			if ($commandev2 ->ingredients['boissons']){foreach($commandev2 ->ingredients['boissons'] as $boissons){$details = $commandev2->getFullDetails($boissons);if($details['libelle']) $boisson .=  $details['libelle'].'.';}}
			//eaux
			if ($commandev2 ->ingredients['eaux']){foreach($commandev2 ->ingredients['eaux'] as $eaux){$details = $commandev2->getFullDetails($eaux);if($details['libelle']) $eau .=  $details['libelle'].'.';}}
			//salade
			if ($commandev2 ->ingredients['salade']){foreach($commandev2 ->ingredients['salade'] as $salade){$details = $commandev2->getFullDetails($salade);$saladenoms .=  $details['libelle'].', ';$idsSalade.= $salade.'|';}}
			//Gestion de la sauce
			//Si salade
			if ($commandev2 ->ingredients['salade']){foreach($commandev2 ->ingredients['sauce'] as $sauce){$detailssauce = $commandev2->getFullDetails($sauce);$vinaigrette .=  $detailssauce['libelle'].'.';}}
			//Gestion de la soupe
			if ($commandev2 ->ingredients['soupe']){
				foreach($commandev2 ->ingredients['soupe'] as $soupe){
					$details = $commandev2->getFullDetails($soupe);
					if($details['libelle']) $soupe =  $details['libelle'].'.';
				}
			}

			$tbq_option = new Tbq_option();
			//Gestion agréments de la soupe
			if ($commandev2 ->ingredients['soupe'][0]!=""){
				foreach($commandev2 ->ingredients['agrement'] as $agrement){
					if($agrement) $option=$tbq_option->getOptionName($agrement);
					if($option) $txtDetailsFormuleAgrements .=  " ".$option;
				}
			}
			if ($commandev2 ->ingredients['soupe'][0]!="") $txtAgrementsSoupe .= " - Agrément(s) : ".$txtDetailsFormuleAgrements.'.';



			if($commandev2->tailleMenu==1) $sizemenu="moyen"; else $sizemenu="grand";

			$valeurs['dateReservation']=date('Y-m-d');
			$valeurs['ID_client']=$_SESSION['client']['id_client'];
			$valeurs['ID_pointDeVente']="1";
			$valeurs['ID_pointLivraison']="0";
			$valeurs['soupe']= addslashes($soupe).addslashes($txtAgrementsSoupe); //nom de la soupe et ingrédients
			$valeurs['plat']= addslashes($commandev2->nomFormule." : <br />".$saladenoms); //liste de noms séparé par des virgules
			$valeurs['idsPlat']= addslashes($idsSalade); //liste id ingredients séparés par des |
			$valeurs['vinaigrette']= addslashes($vinaigrette);
			$valeurs['boisson']= addslashes($boisson);
			$valeurs['dessert']= addslashes($dessert);
			$valeurs['pain']= addslashes($pain);
			$valeurs['eau']= addslashes($eau);
			//$valeurs['supplement']= addslashes($_SESSION['commande']['txtsupplements']);
			$valeurs['supplement']= addslashes($_SESSION['infoscommande'][$count]['txtsupplements']);
			$valeurs['taille']=$sizemenu;
			//$valeurs['prix']=$commandev2->prixPanier;
			$valeurs['prix']=$_SESSION['infoscommande'][$count]['PrixPanier'];
			$valeurs['commentaire']=addslashes($commandev2->commentaire);
			$valeurs['quantite']=$commandev2->quantite;
			$valeurs['code_promo']=$_SESSION['infoscommande']['codepromo'];

			$commandev1 = new Tbq_commande();
			$_SESSION['infoscommande']['idcommande'][]=$commandev1->enregistrer($valeurs);

			$count++;
		}


	}

	function formpaiement()
	{

		require_once("./pel/CMCIC_Config_3843187189.php");
		// PHP implementation of RFC2104 hmac sha1 ---
		require_once("./pel/CMCIC_Tpe.inc.php");

		$sOptions = "";

		// Reference: unique, alphaNum (A-Z a-z 0-9), 12 characters max
		$sReference = "ref" . date("His");

		// Amount : format  "xxxxx.yy" (no spaces)
		$sMontant = $_SESSION['infoscommande']['prixcommandetotal'];
		// Currency : ISO 4217 compliant
		$sDevise  = "EUR";

		// free texte : a bigger reference, session context for the return on the merchant website
		//$sTexteLibre = "fraish31";

		foreach($_SESSION['infoscommande']['idcommande'] as $idcommande){
			$myIds .= $idcommande."|";
		}
		$sTexteLibre =$myIds;

		// transaction date : format d/m/y:h:m:s
		$sDate = date("d/m/Y:H:i:s");

		// Language of the company code
		$sLangue = "FR";

		// customer email
		$client = new client($_SESSION['client']['id_client']);
		$sEmail = $client->emailFacturation;

		$oTpe = new CMCIC_Tpe($sLangue);
		$oHmac = new CMCIC_Hmac($oTpe);

		// Control String for support
		$CtlHmac = sprintf(CMCIC_CTLHMAC, $oTpe->sVersion, $oTpe->sNumero, $oHmac->computeHmac(sprintf(CMCIC_CTLHMACSTR, $oTpe->sVersion, $oTpe->sNumero)));

		// Data to certify
		$PHP1_FIELDS = sprintf(CMCIC_CGI1_FIELDS,     $oTpe->sNumero,
		                                              $sDate,
		                                              $sMontant,
		                                              $sDevise,
		                                              $sReference,
		                                              $sTexteLibre,
		                                              $oTpe->sVersion,
		                                              $oTpe->sLangue,
		                                              $oTpe->sCodeSociete,
		                                              $sEmail,
		                                              $sNbrEch,
		                                              $sDateEcheance1,
		                                              $sMontantEcheance1,
		                                              $sDateEcheance2,
		                                              $sMontantEcheance2,
		                                              $sDateEcheance3,
		                                              $sMontantEcheance3,
		                                              $sDateEcheance4,
		                                              $sMontantEcheance4,
		                                              $sOptions);

		// MAC computation
		$sMAC = $oHmac->computeHmac($PHP1_FIELDS);

		//Assignation des variables au template

		return array(
			'sUrlPaiement' => $oTpe->sUrlPaiement,
			'sVersion'=> $oTpe->sVersion,
			'sNumero'=> $oTpe->sNumero,
			'sDate'=> $sDate,
			'sMontant'=> $sMontant . $sDevise,
			'sReference'=> $sReference,
			'sMAC'=> $sMAC,
			'sUrlKO'=> $oTpe->sUrlKO,
			'sUrlOK'=> $oTpe->sUrlOK,
			'sLangue'=> $oTpe->sLangue,
			'sCodeSociete'=> $oTpe->sCodeSociete,
			'sTexteLibre'=> HtmlEncode($sTexteLibre),
			'sEmail'=> $sEmail
		);

	}

	function paiementretour($data) { //appelé directement par la banque, invisible, ne pas changer le nom de cette fonction, l'url est rentrée en dur sur le serveur de la banque
		header("Pragma: no-cache");
		header("Content-type: text/plain");

		require_once("./pel/CMCIC_Config_3843187189.php");
		// PHP implementation of RFC2104 hmac sha1 ---
		require_once("./pel/CMCIC_Tpe.inc.php");

		// Begin Main : Retrieve Variables posted by CMCIC Payment Server
		//$CMCIC_bruteVars = getMethode();

		$CMCIC_bruteVars = $data;

		// TPE init variables
		$oTpe = new CMCIC_Tpe();
		$oHmac = new CMCIC_Hmac($oTpe);

		// Message Authentication
		$cgi2_fields = sprintf(CMCIC_CGI2_FIELDS, $oTpe->sNumero,
							  $CMCIC_bruteVars["date"],
						          $CMCIC_bruteVars['montant'],
						          $CMCIC_bruteVars['reference'],
						          $CMCIC_bruteVars['texte-libre'],
						          $oTpe->sVersion,
						          $CMCIC_bruteVars['code-retour'],
							  $CMCIC_bruteVars['cvx'],
							  $CMCIC_bruteVars['vld'],
							  $CMCIC_bruteVars['brand'],
							  $CMCIC_bruteVars['status3ds'],
							  $CMCIC_bruteVars['numauto'],
							  $CMCIC_bruteVars['motifrefus'],
							  $CMCIC_bruteVars['originecb'],
							  $CMCIC_bruteVars['bincb'],
							  $CMCIC_bruteVars['hpancb'],
							  $CMCIC_bruteVars['ipclient'],
							  $CMCIC_bruteVars['originetr'],
							  $CMCIC_bruteVars['veres'],
							  $CMCIC_bruteVars['pares']
							);


		if ($oHmac->computeHmac($cgi2_fields) == strtolower($CMCIC_bruteVars['MAC']))
			{
			switch($CMCIC_bruteVars['code-retour']) {
				case "Annulation" :
					// Payment has been refused
					//$commandev1 = new Tbq_commande($_SESSION['commande']['idcommande']);
					//$commandev1->setIDCommandeFraish();
					//$commande->genererEmailReservation("/boutique/fr/emails/envoi-commande/envoi-annulation-cb.php", $_SESSION['client']['id_client']);

					//mail ( "jb.rouanet@magnetic-communication.com" , "fraish - paiement en ligne - refuse" , "pas OK");
					// Attention : an autorization may still be delivered for this payment
					break;

				case "payetest":
					// Payment has been accepeted on the test server
          			//error_log('payetest'.$data["texte-libre"]);
					//enregistrement de l'etat du paiement des commandes
					$tabids = explode('|',$data["texte-libre"]);

					//Si c'est un approvisionnement
					if($tabids[0]=="appro"){
					  //error_log('appro trouvé');
						$appro = new Tbq_approvisionnement($tabids[1]);
						$appro->valider();
					}

					else { //Sinon, c'est un paiement CB direct
						$nbcommande=0;
						foreach($tabids as $idcommande){
							//mise à jour etat commande (payée)
							$commandev1 = new Tbq_commande($idcommande);
							//Creation du numéro de commande fraish (repart de 0 tous les jours)
							$commandev1->setIDCommandeFraish();
							//mise à jour du status du paiement
							$commandev1->reglementCB(1);
							$commandev1-> modifierStatut($idcommande, "en_cours");

							//envoi mail client
							$commande = new Tbq_commande($idcommande);	//pour données mail
							$commandev1->genererEmailReservation("/boutique/fr/emails/envoi-commande/envoi-commande.php", $commandev1->ID_client);


						}
					}

					//mail ( "jb.rouanet@magnetic-communication.com" , "fraish - paiement en ligne - OK" , "YES c'est OK");

					break;

				case "paiement":
					// Payment has been accepted on the productive server
					//enregistrement de l'etat du paiement des commandes
					$tabids = explode('|',$data["texte-libre"]);

					//Si c'est un approvisionnement
					if($tabids[0]=="appro"){
						$appro = new Tbq_approvisionnement($tabids[1]);
						$appro->valider();

						//on valide aussi l'appro bonus !
						$approbonus = new Tbq_approvisionnement(($tabids[1])+1);
						$approbonus->valider();

						//envoi du mail au client
						$appro->genererMailDemandeAppro('/boutique/fr/emails/envoi-commande/envoi-appro-ok.php');

					}

					else { //Sinon, c'est un paiement CB direct
						$nbcommande=0;

						foreach($tabids as $idcommande){
							//mise à jour etat commande (payée)
							$commandev1 = new Tbq_commande($idcommande);
							//Creation du numéro de commande fraish (repart de 0 tous les jours)
							$commandev1->setIDCommandeFraish();
							//mise à jour du status du paiement
							$commandev1->reglementCB(1);
							$commandev1->setIDPaiement(1); //1=CB
							$commandev1-> modifierStatut($idcommande, "en_cours");

							//envoi mail client
							$commande = new Tbq_commande($idcommande);	//pour données mail
							$commandev1->genererEmailReservation("/boutique/fr/emails/envoi-commande/envoi-commande.php", $commandev1->ID_client);
						}
					}

					mail ( "technique@couleur-citron.com" , "fraish - paiement en ligne - OK" , "YES c'est OK, co cli : ".$_SESSION['client']['id_client']);

					break;
			}

			$receipt = CMCIC_CGI2_MACOK;

		}
		else
		{
			// your code if the HMAC doesn't match
			mail ( "technique@couleur-citron.com" , "fraish - paiement en ligne - CGI2 : NOT OK" , "CGI2 : NOT OK, co cli : ".$_SESSION['client']['id_client']);
			$receipt = CMCIC_CGI2_MACNOTOK.$cgi2_fields;
		}

		//-----------------------------------------------------------------------------
		// Send receipt to CMCIC server
		//-----------------------------------------------------------------------------
		printf (CMCIC_CGI2_RECEIPT, $receipt);

	}

	function retourcommandeok($data) // retour du client sur le site, après un paiement CB réussi :)
	{
		mail ( "technique@couleur-citron.com" , "fraish - retourcommandeok" , "retourcommandeok, co cli : ".$_SESSION['client']['id_client'].' co comm : '.$_SESSION['infoscommande']['idcommande']);
    /*foreach($data as $k => $v){


      error_log($k . ' = '.$v);
    }*/
		$client = new client($_SESSION['client']['id_client']);
		//$client->debiterSoldeCompte($_SESSION['infoscommande']['prixcommandetotal']);

		//Pour chaque commande en session
		$nbcommande=0;

		if (isset($_SESSION['infoscommande']['idcommande'])){
			foreach($_SESSION['infoscommande']['idcommande'] as $idcommande){
				//mise à jour etat commande (payée)
				$commandev1 = new Tbq_commande($idcommande);
				//mise à jour du status du paiement
				$commandev1->setIDPaiement(1); //1=CB
				//$commandev1-> modifierStatut($idcommande, "en_cours");
				//envoi d'un mail de confirmation
				//$commandev1->genererEmailReservation("/boutique/fr/emails/envoi-commande/envoi-commande.php", $_SESSION['client']['id_client']);

				//envoi d'un mail de confirmation
				//$commande = new Tbq_commande($idcommande);	//pour données mail
				//$commandev1->genererEmailReservation("/boutique/fr/emails/envoi-commande/envoi-commande.php", $_SESSION['client']['id_client']);

				$numscommande .= " ".$commandev1->ID_commande_fraish;
				$nbcommande++;
			}
		}

			//redirection vers page paiement ok avec numéro de commande
			//if ($nbcommande==1) $message = "Le paiement de votre commande s'est correctement déroulé, veuillez noter votre n°  : <br /> <br /> <br /><span style='font-size: 30px;'> commande n°".$numscommande.'</span>';
			//else $message = "Le paiement de vos commandes s'est correctement déroulé, veuillez noter vos n°  : <br /> <br /> <br /><span style='font-size: 30px;'> commandes n°".$numscommande.'</span>';


			$message = "Le paiement de votre commande s'est correctement déroulé.";

			$message .= "<br /><br /><br />Vous allez recevoir un email de confirmation avec le numéro de celle-ci.<br /><br />Veuillez l'imprimer avant d'aller sur votre point de vente.";





			$this -> boxmessage($message);

			//On vide alors les sessions commande
			$_SESSION['commande']=array();
			$_SESSION['infoscommande']=array();
			$_SESSION['panier']=array();

	}

	function retourcommandenotok($data) // retour du client sur le site, après un paiement CB réussi :)
	{
		mail ( "technique@couleur-citron.com" , "fraish - retourcommandenotok" , "retourcommandenotok, co cli : ".$_SESSION['client']['id_client'].' co comm : '.$_SESSION['infoscommande']['idcommande']);

		//redirection vers page paiement ok avec numéro de commande
		$message = "ECHEC du paiement de votre commande, <a href='panier.html'> cliquez ici pour retourner à votre commande</a>";
		$this -> boxmessage($message);

			//On vide alors les sessions commande
			$_SESSION['commande']=array();
			$_SESSION['infoscommande']=array();
			$_SESSION['panier']=array();

	}
	function retourcreditok($data) // retour du client sur le site, après un paiement CB réussi de réappro compte
	{
		$message = "Le paiement s'est correctement déroulé, le crédit de votre compte est mis à jour";
		$this -> boxmessage($message);
	}

	function retourcreditnotok($data) // retour du client sur le site, après un paiement CB réussi de réappro compte
	{
		$message = "ECHEC du paiement, <a href='compte.html'> cliquez ici pour retourner sur votre compte</a> ";
		$this -> boxmessage($message);
	}

	function paiementcredit($data)
	{
		//check commande en cours
		if (!$_SESSION['infoscommande']['idcommande']) {
			//On redirige vers la page compte
			header('Location: compte.html');
		}

		$C_pagefrontend = new pagefrontend();

		//test si crédit suffisant, si solde - totalcommande < 15, echec
		$client = new client($_SESSION['client']['id_client']);
		if ($client->soldeCompte - $_SESSION['infoscommande']['prixcommandetotal']<(-15))
			{
			$message = "Utilisation de votre crédit Fraish impossible, veuillez <a href='compte.html'>créditer votre compte</a>.";
			$this -> boxmessage($message);
			}

		else
			{

			//mise à jour solde compte fraish
			//$client->debiterSoldeCompte($_SESSION['infoscommande']['prixcommandetotal']);

			//echo "prixcommandetotal : ".$_SESSION['infoscommande']['prixcommandetotal'];

			//Pour chaque commande en session
			$nbcommande=0;


			//$this->aff_objet($_SESSION['infoscommande']['idcommande']);

			foreach($_SESSION['infoscommande']['idcommande'] as $idcommande){
				//mise à jour etat commande (payée)
				$commandev1 = new Tbq_commande($idcommande);
				$commandev1->validerPaiementCompteFraish();
				//Creation du numéro de commande fraish (repart de 0 tous les jours)
				$commandev1->setIDCommandeFraish();
				//mise à jour du status du paiement
				$commandev1->setIDPaiement(5); //5=compte fraish
				$commandev1-> modifierStatut($idcommande, "en_cours");
				//envoi d'un mail de confirmation
				$commande = new Tbq_commande($idcommande);	//pour données mail
				$commandev1->genererEmailReservation("/boutique/fr/emails/envoi-commande/envoi-commande.php", $_SESSION['client']['id_client']);
				$numscommande .= " ".$commandev1->ID_commande_fraish;
				$nbcommande++;
			}

			//redirection vers page paiement ok avec numéro de commande
			if ($nbcommande==1) $message = "Le paiement de votre commande s'est correctement déroulé, veuillez noter votre n°  : <br /> <br /> <br /><span style='font-size: 30px;'> commande n°".$numscommande.'</span>';
			else $message = "Le paiement de vos commandes s'est correctement déroulé, veuillez noter vos n°  : <br /> <br /> <br /><span style='font-size: 30px;'> commandes n°".$numscommande.'</span>';
			$message .= "<br /><br /><br />Vous allez recevoir un email de confirmation.<br /><br />Veuillez l'imprimer avant d'aller sur votre point de vente.";

			$this -> boxmessage($message);

			//On vide alors les sessions commande
			$_SESSION['commande']=array();
			$_SESSION['infoscommande']=array();
			$_SESSION['panier']=array();
			}
	}

	function contact($data) {
		$C_pagefrontend = new pagefrontend();
		$C_pagefrontend -> enteteHTML("Fraish - Nous contacter");

		$publickey = "6LcEu8ISAAAAAGoagsMhfzfYtt-X4g6iCRVWYjXU";

		$C_pagefrontend -> assign_vars(array('recaptcha' => recaptcha_get_html($publickey)));

		$C_pagefrontend -> affichePage('frontend/pages/contact.tpl');

	}

	function traiterContact($data) {
		$C_pagefrontend = new pagefrontend();
		$C_pagefrontend -> enteteHTML("Fraish - Nous contacter");

		//Test si ReCaptcha OK
		$privatekey = "6LcEu8ISAAAAAAAdKHB532Ootd8U8tk5cfXH8_C3";
		$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $data["recaptcha_challenge_field"], $data["recaptcha_response_field"]);

		//Composition du message retour
		if(!$resp -> is_valid) {$message = "Le code de vérification saisie est erroné. <br> <br> <a href='contact.html'> << retour </a>";
		} else {$message = "Votre demande est transmise, elle sera traitée prochainement.";
			$amailer = 1;
		}
		$C_pagefrontend -> assign_vars(array('message' => $message));

		if($amailer) {
			$C_contact = new contact();
			$messagem = $C_contact -> creer_message_contact_fraish($data);
			$C_contact -> send_mail($data[email], "technique@couleur-citron.com", "FRAISH - Demande de contact - copie test", $messagem);
			$C_contact -> send_mail($data[email], "fraishlabege@gmail.com", "FRAISH - Demande de contact", $messagem);
		}

		$C_pagefrontend -> affichePage('frontend/pages/contactformok.tpl');
	}

	function mentions($data) {
		$C_pagefrontend = new pagefrontend();
		$C_pagefrontend -> enteteHTML('Fraish - Mentions légales');
		$C_pagefrontend -> affichePage('frontend/pages/mentions.tpl');
	}
	function rgpd($data) {
		$C_pagefrontend = new pagefrontend();
		$C_pagefrontend -> enteteHTML('Fraish - RGPD');
		$C_pagefrontend -> affichePage('frontend/pages/rgpd.tpl');
	}

	function newsletter($data) {
		$C_pagefrontend = new pagefrontend();
		$C_pagefrontend ->loadCSS("styles/frontend/newsletter.css");
		$C_pagefrontend ->loadJS("js/jquery.validate.min.js");
		$C_pagefrontend ->loadJS("js/newsletter.js");
		$C_pagefrontend -> enteteHTMLBASE(' - Newsletter');
		$email = str_replace ("aaaaa", "@", $data[email]);
		$email = str_replace ("poiiint", ".", $email);
		$C_pagefrontend->assign_vars(array('email' => $email));
		$C_pagefrontend -> affichePageBase('frontend/pages/newsletter.tpl');
	}

	function newsletterAdd($data) {
		//Ajax...
		$C_pagefrontend   = new pagefrontend();
		$rqt = new mysql ;
		$rst1 = $rqt->query("INSERT INTO inscris_NL (nom, email, nom) VALUES ('".$data['newsletter_name']."','".$data['newsletter_email']."', NOW())");
	}

	function astuces($data){
		$C_pagefrontend   = new pagefrontend();
		$C_pagefrontend -> enteteHTML('Fraish - Astuces de Sophie');
		$astuce = new Tbq_astuces();
		$C_pagefrontend->assign_vars(array('content' => $astuce->content));
		$C_pagefrontend -> affichePage('frontend/pages/astuces.tpl');
	}

	function produits($data){
		$C_pagefrontend   = new pagefrontend();
		$C_pagefrontend -> enteteHTML('Fraish - Nos produits');
		$C_pagefrontend -> affichePage('frontend/pages/produits.tpl');
	}

	function recettes($data){
		$C_pagefrontend   = new pagefrontend();
		$C_pagefrontend -> enteteHTML('Fraish - Recettes');

		//soupe du jour
		$ingredients = Tbq_famille::listerIngredients(2, 'ordreWeb', 'Daily' ,1);
		$tabProvisoire = array();
		for($i = 0; $i<count($ingredients); $i++){
			$tabProvisoire[$i] = $ingredients[$i]['ID'];
			$tbq_ingredient = new Tbq_ingredient();
			$tbq_ingredient->initialiser($tabProvisoire[$i]);
			$C_pagefrontend -> assign_block_vars('soupes', array('intitule' => $tbq_ingredient->libelle, 'details' => $tbq_ingredient->details));
		}

		$C_pagefrontend -> affichePage('frontend/pages/recettes.tpl');
	}



	function aff_objet () {
	$style_table = 'empty-cells:show; border-collapse:collapse; border:1px solid #AAAAAA; background-color:#F9F9F9;';
	$style_pre = 'text-align:left; font-family:courier new; font-size:11px;';
	$style_font = 'background-color:#FF0000; color:#FFFFFF; font-weight:bold; font-family:courier new; font-size:11px;';
	$tabObjets = func_get_args();
	?>
	<table border="1" cellpadding="2" style="<?php echo $style_table; ?>">
		<tr>
		<?php
			for ($i = 0; $i < count ($tabObjets); $i++) {
				if (isset ($tabObjets[$i])) {
				?>
					<td valign="top">
						<PRE style="<?php echo $style_pre; ?>"><?php print_r($tabObjets[$i]); ?></PRE>
					</td>
				<?php
				} else {
				?>
					<td valign="top">
						<font style="<?php echo $style_font; ?>">!! OBJET VIDE !!</font>
					</td>
				<?php
				}
			}
		?>
		</tr>
	</table>
	<?php
	}


}
?>