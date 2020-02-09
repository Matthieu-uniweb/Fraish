<?php
class demande
{
    var $module = array('0' =>'frontend');
    var $fonctionParDefaut = 'accueil';
    
	function demande($url)
	{
		$this->initFonction();
		$listeParametre = $this->analyseURL($url);
		$fonction 		= $this->extraireFonction($listeParametre);
		$content 		= $this->executeFonction($fonction , $listeParametre);
	}
	
	function initFonction()
	{
		$this->module[0] = array(	'accueil',
									'compte',
									'editercompte',
									'detailscompte',
									'produits',
						            'recettes',	
						            'contact',	
						            'traiterContact',
						            'commande',
						            'paiementretour', 		//utilisé uniquement par le serveur de la banque
						            'paiementcredit',		//paiement de la commande avec le crédit compte fraish
						            'retourcommandeok', 	//renvoi sur le site fraish ok après paiement
						            'retourcommandenotok', 	//renvoi sur le site frais echec paiement						            
						            'heure',
						            'commanderetour',		//utilisé pour remonter d'une étape dans la commande
						            'completercommande',
						            'supprimerpanier',				            
						            'recrutement',
						            'newsletter',
						            'identification',
						            'identificationbox',
						            'inscription_reussi',
						            'traiterLogin',
						            'traiterMdp',
						            'traiternouveauclient',
						            'deconnexion',
						            'panier', //etape 5 de la commande
						            'reapprocheque',
						            'reapproticketresto',
						            'reapprocb',
						            'astuces',
						            'mentions',
						            'rgpd',
						            'reapprocb',
						            'retourcreditok',
						            'retourcreditnotok'
						            
								);              
	}	
	
	/**
	 * Extrait les paramètres de l'URL
	 *
	 * @param string $data
	 * @return array
	 */
	function analyseURL($url)
	{
		$T_urlParam	=	explode('?',$url);
		if(count($T_urlParam) > 1){
			$param = $T_urlParam[1];	
		}else{
			$param = '';
		}
		// separation des parametre de l'url
		parse_str($param,$tableau);
		$tableau2 	=	$_POST + $tableau;
		return $tableau2 ;
	}
	
	
	/**
	 * Retourne le nom de la fonction contenue dans l'URL
	 *
	 * @param array $data
	 * @return string
	 */
	function extraireFonction($data) {
		// si la fonction n'est pas definie
		if(!(isset($data['fonction']))) {
			$data['fonction'] = $this -> fonctionParDefaut;
		}

		//$data['fonction'] = str_replace('-','',$data['fonction']);
		//echo $data['fonction'];
		return $data['fonction'];
	}

	function determineTypeFonction($data) {
		$type = 'no';
		for($i = 0; $i < count($this -> module); $i++) {
			if(in_array($data, $this -> module[$i])) {
				$type = $i;
			}
		}
		return $type;
	}

	function autorisation($type, $fonction) {
		$nomFonction = $fonction;
		switch ($type) {
			case '0' :
				//session_start();
				$nomModule = 'frontend';
				break;			

			default :
				$nomModule = 'frontend';
				$nomFonction = $this -> fonctionParDefaut;
				break;
		}
		$valeur['typeFonction'] = $nomModule;
		$valeur['nomFonction'] = $nomFonction;
		return $valeur;
	}

	function executeFonction($fonction, $data) {
		$typeFonction = $this -> determineTypeFonction($fonction);
		$typeFonction = $this -> autorisation($typeFonction, $fonction);
		//on va chercher la classe correspondante à la fonction
		include_once ($typeFonction['typeFonction'] . ".class.php");
		// on instancie la classe
		$typeObjet = new $typeFonction['typeFonction'];
		// on execute la fonction correspondante
		$result = call_user_method($typeFonction['nomFonction'], $typeObjet, $data);
		//$result = call_user_func(array(&$typeObjet, $fonction), $data);
		$valeur['content'] = $result;
		$valeur['type'] = $typeObjet;
		return $valeur;
	}

}
?>