<?php

require_once ('./class/commun/mysql.class.php');

/*class panier, avec gestion de l'ajout à la commande principale*/
//2 variables de session : panier et commande
//panier contient un menu, commande contient l'ensemble des objets panier du client

class commande {

	var $titlePages = array('Ma formule', 'Mes ingrédients', 'Mes suppléments', 'Mon panier', 'Ma commande', 'Ma commande');
	var $etapeEnCours = 1;
	var $nomFormule = "";
	var $idMenu = "";
	var $tailleMenu = "";
	var $ingredients = array('salade' => array(), 'sauce' => array(), 'soupe' => array(), 'saladeRecettesdujour' => array(), 'pains' => array(), 'desserts' => array(), 'boissons' => array(), 'eaux' => array(), 'agrement' => array());
	var $supplements = array();
	var $quantite = 1;
	var $commentaire = "<i>aucun commentaire</i>";
	var $idClient = "";
	var $prixMenu = "";
	var $prixPanier = "";// prixMenu x quantite+supplements
	var $txtsupplements = ""; // texte récapitulatif des suppléments du panier

	function __construct() {
		//session_start();
	}

	function checkempty(){ // si retour 0, c'est vide
		$empty=0;
		
		if ($this->ingredients['salade']!=array())$empty=1;
		if ($this->ingredients['sauce']!=array())$empty=1;
		if ($this->ingredients['soupe']!=array())$empty=1;
		if ($this->ingredients['saladeRecettesdujour']!=array())$empty=1;
		if ($this->ingredients['pains']!=array())$empty=1;
		if ($this->ingredients['desserts']!=array())$empty=1;
		if ($this->ingredients['boissons']!=array())$empty=1;
		if ($this->ingredients['eaux']!=array())$empty=1;
		if ($this->ingredients['agrement']!=array())$empty=1;
		
		return $empty;		
	}

	function getFullDetails($idIngredient) {
		$requete = "SELECT * FROM boutique_obj_ingredient WHERE ID='" . $idIngredient . "'";
		$resultats = T_LAETIS_site::requeter($requete);
		return $resultats[0];
	}

	function majvars($data) {

		//On teste chaque variable pouvant être récup, on stocke dans l'objet
		if (isset($_SESSION['client']['id_client']))
			$this -> idClient = $_SESSION['client']['id_client'];
		if (isset($data['etape']))
			$this -> etapeEnCours = $data['etape'];
		if (isset($data['menu']))
			$this -> idMenu = $data['menu'];
		if (isset($data['nomFormule']))
			$this -> nomFormule = $data['nomFormule'];
		if (isset($data['size']))
			$this -> tailleMenu = $data['size'];

		if (isset($data['choixingredients'])) {
			//echo "test";
			//Si des ingredients sont envoyés, on vide la variable this->ingredients au cas ou il s'agit d'un retour, avec les agrements.
			$this -> ingredients['sauce'] = $this -> ingredients['salade'] = $this -> ingredients['soupe'] = $this -> ingredients['saladeRecettesdujour'] = $this -> ingredients['pains'] = $this -> ingredients['desserts'] = $this -> ingredients['boissons'] = $this -> ingredients['eaux'] = $this -> ingredients['agrement'] = array();

			if (isset($data['ingredient'])) {
				foreach ($data['ingredient'] as $chkbx) {array_push($this -> ingredients['salade'], $chkbx);
				}
			}

			array_push($this -> ingredients['sauce'], $data['sauce']);
			array_push($this -> ingredients['soupe'], $data['soupe']);

			if (isset($data['agrement'])) {
				//$this->ingredients['agrement']= array(''=>'');
				foreach ($data['agrement'] as $chkbx) {
					array_push($this -> ingredients['agrement'], $chkbx);
				}
				//$this->ingredients['agrement']= array_splice ($this->ingredients['agrement'] , 2);
			}

			array_push($this -> ingredients['saladeRecettesdujour'], $data['saladeRecettesdujour']);
			array_push($this -> ingredients['pains'], $data['pains']);
			array_push($this -> ingredients['desserts'], $data['desserts']);
			array_push($this -> ingredients['boissons'], $data['boissons']);
			array_push($this -> ingredients['eaux'], $data['eaux']);

			if (isset($data['commentaire'])) {$this -> commentaire = $data['commentaire'];
			}
		}

		if (isset($data['sup'])) {
			//On vide s'il s'agit d'un retour
			$this -> supplements = array();
			foreach ($data['sup'] as $chkbxs) {array_push($this -> supplements, $chkbxs);
			}
		}

		if (isset($data['qte']))
			$this -> quantite = $data['qte'];
		if (isset($data['price']))
			$this -> prixPanier = $data['price'];
		if (isset($data['commentaire']))
			$this -> commentaire = $data['commentaire'];

		//Si l'id formule est entré, on récup son prix, en fonction de la taille choisie (petit/moyen/grand)
		if ($this -> idMenu) {
			$requete = "SELECT * FROM boutique_obj_menu WHERE ID='" . $this -> idMenu . "'";
			$resultats = T_LAETIS_site::requeter($requete);
			$allprix = explode("|", $resultats[0]['prix']);
			//on remplace la virgule par un point
			$allprix = str_replace(",", ".", $allprix);

			if ($this -> tailleMenu == "2")
				$this -> prixMenu = $allprix[0];
			if ($this -> tailleMenu == "1")
				$this -> prixMenu = $allprix[1];
		}
	}

	function save($data) {

		//mise à jour des variables de l'objet avant sauvegarde
		$this -> majvars($data);		
		
		//$this ->aff_objet($this);
		
		//sauvegarde du panier en session
		$_SESSION['panier']['objet']=serialize($this);
		
		//Au moment de l'ajout du panier à la commande, on vide le cookie panier et on ajoute le panier à la suite de la commande
		if (($this -> etapeEnCours == 5) && ($this -> nomFormule != "") && ($this->checkempty() !=0))//+ filtrage sur nomformule dans le cas d'une actualisation navigateur, pour éviter l'ajout successif (bof bof)
		{				
			//ajout à la variable de session commande
			if ((!$_SESSION['commande']) && ($data['nosave'] != 1)) {$_SESSION['commande'][0] = $_SESSION['panier']['objet'];}
			
			else {array_push($_SESSION['commande'], $_SESSION['panier']['objet']);}
			//echo "vidage panier";
			//Un fois le panier ajouté à la commande, on le vide
			$_SESSION['panier']['objet'] = array();
		}
		
		//gestion du code promo (saisie etape 5, affichage etape 6)		
		if ($this -> etapeEnCours == 6) 
		{
			//on teste que le code promo existe
			
			
			/*if ($data['codepromo']=="DESSERTCADO") {				
				//controle que c'est un nouveau client n'ayant jamais commandé, et qu'il n'a jamais utilisé ce code				
				
				$count1=count($this->listerCommande($_SESSION['client']['id_client'], "livree"));
				$count2=count($this->listerCommande($_SESSION['client']['id_client'], "livree", "DESSERTCADO"));
				
				if(($count1<1)&&($count2<1))				
				{
					$_SESSION['infoscommande']['codepromo']=$data['codepromo'];
					$_SESSION['infoscommande']['codepromotxt']="Un dessert offert sur votre première commande FRAISH ! (choix à préciser au retrait de votre commande)";
				}
			}*/
			
			//on teste que le code promo existe
			/*if ($data['codepromo']=="PROMO10") {				
				$count4=count($this->listerCommande($_SESSION['client']['id_client'], "livree", "PROMO10"));				
				if($count4<1)
				{
					$_SESSION['infoscommande']['codepromo']=$data['codepromo'];
					$_SESSION['infoscommande']['codepromotxt']="10% de réduction sur votre commande !";					
				}
			}	
			
			//on teste que le code promo existe
			if ($data['codepromo']=="PROM010") {				
				$count5=count($this->listerCommande($_SESSION['client']['id_client'], "livree", "PROM010"));				
				if($count5<1)
				{
					$_SESSION['infoscommande']['codepromo']=$data['codepromo'];
					$_SESSION['infoscommande']['codepromotxt']="10% de réduction sur votre commande !";								
				}
			}*/
			
			//on teste que le code promo existe
			/*if (	($data['codepromo']=="3025") &&	(date('Y-m-d')<='2015-10-15')	){				
				$count5=count($this->listerCommande($_SESSION['client']['id_client'], "livree", "3025"));				
				if($count5<1)
				{
					$_SESSION['infoscommande']['codepromo']=$data['codepromo'];
					$_SESSION['infoscommande']['codepromotxt']="10% de réduction sur votre commande !";								
				}
			}	*/		
		}
	}

	function saveOLD($data) {

		//On met à jour les variables de l'objet avec tout ce qu'on peut récup
		$this -> majvars($data);

		//On sauve en session tant que le la formule n'est pas complète et sans un cookie par la suite

		//Serialisation de l'objet en session :)
		$_SESSION['commande']['objet'] = serialize($this);

		//Au moment de l'enregistrement en cookie on vide la session et on stocke cette nouvelle commande à la suite des autres
		if (($this -> etapeEnCours == 5) && ($this -> nomFormule != "")) {
			//Le cookie est une serialization d'un tableau d'objets commande serializés
			$MyBigCookieCommande = array();

			//Si le cookie est vide, on initialise la premiere case avec la commande en session
			//if ($_COOKIE["commandefraish"]=="ok")
			if ((!$_SESSION['tempCookie']) && ($data['nosave'] != 1)) {

				$MyBigCookieCommande[0] = unserialize($_SESSION['commande']['objet']);

				//Supression des cookies ...
				//setcookie ("commandefraish", serialize($MyBigCookieCommande), time()+60*60*24*30, '/');

				//stockage temporaire pour affichage direct...
				$_SESSION['tempCookie'] = serialize($MyBigCookieCommande);

			}

			//Sinon on récup le cookie existant et on ajoute à la suite
			else {
				//echo "cookie fraish deja créé, on ajoute à la suite";
				//On récup le cookie, on le désérialize, on le stocke dans mybigcookiecommande

				//Supression des cookies ...
				//$MyBigCookieCommande = unserialize($_COOKIE["commandefraish"]);
				$MyBigCookieCommande = unserialize($_SESSION['tempCookie']);

				//On ajoute la commande en session à mybigcookiecommande
				array_push($MyBigCookieCommande, unserialize($_SESSION['commande']['objet']));
				//On stocke une serialisation de mybigcookiecommande dans le cookie
				//setcookie ("commandefraish", serialize($MyBigCookieCommande), time()+60*60*24*30, '/'); // 1 mois

				//stockage temporaire pour affichage direct...
				$_SESSION['tempCookie'] = serialize($MyBigCookieCommande);
			}

			//On vide la session commande
			$_SESSION['commande']['objet'] = array();

			//Tant que le bouton "compléter ma commande" n'a pas été cliqué, l'étape courante reste la 5

		}

	}

	function listerCommande($ID_client, $statut, $code_promo='', $dateDebut='', $dateFin='')
			{
			if($dateDebut)//Recherche avec date de d�but
				{
				$and_debut = "AND dateReservation>='".T_LAETIS_site::convertirDate($dateDebut)."'";
				}
			if($dateFin) //Recherche avec date de fin
				{
				$and_fin = "AND dateReservation<='".T_LAETIS_site::convertirDate($dateFin)."'";
				}
			
			if($code_promo) //Recherche avec code promo
				{
				$and_cp = "AND code_promo='".$code_promo."'";
				}
				
			$requete = "SELECT * FROM boutique_obj_commande 
									WHERE ID_client='".$ID_client."'
									AND statut = '$statut' 
									$and_cp
									$and_debut
									$and_fin
									ORDER BY dateReservation DESC, ID_commande_fraish DESC";
									//echo $requete;
			$resultats = T_LAETIS_site::requeter($requete);
			return ($resultats);
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