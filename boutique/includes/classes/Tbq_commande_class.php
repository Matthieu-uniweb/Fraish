<?php
/**
   *  Classe de gestion des commandes
   *
   * Permet de cr�er, modifier, supprimer des commandes, en int�raction 
   * avec la base de donn�es
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright La�tis Cr�ations Multim�dias
	 * @date 2007-11-12
   */

class Tbq_commande
	{
	/** 
	* @var int $ID ID de l'element en base de donn�e
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var date $dateCommande Date de la commande
	* @access  private 
	*/
	var $dateCommande;
	var $dateReservation;
	/** 
	* @var int $ID_client ID du client qui commande
	* @access  private 
	*/
	var $ID_client;
	
	/** 
	* @var int $ID_commande_fraish ID de la commande pour gestion Fraish
	* @access  private 
	*/
	var $ID_commande_fraish;
	/**
	* @var int $ID_pointDeVente ID du point de vente o� sera pr�par� le menu
	*/
	var $ID_pointDeVente;
	/**
	* @var int $ID_pointLivraison ID du point o� sera livr�e la commande
	*/
	var $ID_pointLivraison;
	var $ID_typ_paiement;
	var $soupe;
	var $plat;
	var $vinaigrette;
	var $boisson;
	var $boissonStat;
	var $dessert;
	var $pain;
	var $eau;
	var $supplement;
	var $taille;
	var $prix;
	var $commentaire;
	var $sondage;
	var $recapitulatif;
	var $statut;
	var $reglement;
	var $nb_dans_panier;//ajout jb
	var $code_promo;//ajout jb
	/** 
	* @var string $ingredients Tableau des ingr�dients salade
	* @access  private 
	*/
	var $ingredients = array("Salade verte", "Haricots verts", "Carottes", "Courgettes", "Betteraves", "Ma�s", "Concombres", "Poivrons", "Champignons", "Coeurs d'artichaut", "Fourme d'Ambert", "Emmental", "Croutons", "Olives", "Tomates", "Oeuf", "Fenouil", "Lentilles", "Endives", "Choux rouges", "Choux blancs", "Riz", "Pates", "Bl�", "Boulgour", "Quinoa", "Cranberries", "Pralin", "Tournesol", "Noix", "Amandes");

	var $ingredientsAdmin = array("Salade verte", "Riz", "Pates", "Bl�", "Boulgour", "Quinoa", "Haricots verts", "Lentilles", "Carottes", "Courgettes", "Betteraves", "Ma�s", "Concombres", "Poivrons", "Champignons", "Choux rouges", "Choux blancs", "Coeurs d'artichaut", "Fourme d'Ambert", "Emmental", "Croutons", "Olives", "Tomates", "Oeuf", "Fenouil", "Endives", "Cranberries", "Pralin", "Tournesol", "Noix", "Amandes");
	/**
	* Constructeur
	* Constructeur PHP4
	*
	* @param entier $ID Par d�faut 0
	* @author Christophe Raffy
	*/
	function Tbq_commande ($ID=0)
		{
		$this->ID = $ID;
		$this->__construct($ID);
		}	
	
	/**
	* Constructeur
	* Constructeur PHP5
	*
	* @param entier $ID Par d�faut 0
	* @author Christophe Raffy
	*/
	function __construct ($ID=0)
	{
		$this->ID = $ID;
		$this->initialiser();
	}
		
	/**
	* Destructeur
	* @author Christophe Raffy
	*/
	function __destruct ()
		{}
		
	/** 
	* Initialisation de l'objet
	* L'initialisation se fait � partir de l'ID
	*
	* @author Christophe Raffy
	*/
	function initialiser()
		{
		if ( $this->ID>0 )
			{
			// initialisation de l'objet
			$requete = "SELECT * FROM boutique_obj_commande WHERE ID='".$this->ID."'";
			$resultats = T_LAETIS_site::requeter($requete);
			foreach ($resultats[0] as $nomChamp => $valeur)
				{
				$this->$nomChamp = stripslashes($valeur);
				}
			}
		} // FIN function initialiser()


	function getIdsParOrdreAdmin (){
		$requete = "SELECT ID
				FROM boutique_obj_ingredient 
				WHERE ID_famille = 1
				ORDER BY ordreAdmin";
		$res = T_LAETIS_site::requeter($requete);
		
		$tabStockageProvisoire = array();
		for ($i=0; $i<count($res); $i++){
			$tabStockageProvisoire[$i] = $res[$i]['ID'];
		}
		return $tabStockageProvisoire;
	}
	
	/** 
	* Enregistre l'objet en BD
	* Les attributs doivent �tre remplis
	* 
	* @author Christophe Raffy
	*/
	function enregistrer($valeurs)
		{
		/*$requete = "SELECT max(ID_commande_fraish)+1 as ID_commande_fraish FROM boutique_obj_commande
								WHERE dateReservation = '".$valeurs['dateReservation']."' 
								AND ID_pointDeVente = '".$valeurs['ID_pointDeVente']."' ";
		$resultats = T_LAETIS_site::requeter($requete);
		if (! $resultats[0]['ID_commande_fraish'])
			{ $resultats[0]['ID_commande_fraish']=1; }*/
		
		$requete = "INSERT INTO boutique_obj_commande (dateCommande, dateReservation, ID_client, ID_pointDeVente, ID_pointLivraison, soupe, plat, IDsPlat, vinaigrette, boisson, boissonStat, dessert, pain, eau, supplement, taille, prix,nb_dans_panier,code_promo,
								commentaire, statut ) 
								VALUES (NOW(), '".$valeurs['dateReservation']."', '".$valeurs['ID_client']."', 
								'".$valeurs['ID_pointDeVente']."',
								'".$valeurs['ID_pointLivraison']."',
								'".$valeurs['soupe']."', '".$valeurs['plat']."', 
								'".$valeurs['idsPlat']."', 
								'".$valeurs['vinaigrette']."', 
								'".$valeurs['boisson']."', '".$valeurs['boissonStat']."',
								'".$valeurs['dessert']."', 
								'".$valeurs['pain']."', 
								'".$valeurs['eau']."','".$valeurs['supplement']."', 
								'".$valeurs['taille']."',
								'".$valeurs['prix']."', 
								'".$valeurs['quantite']."', 
								'".$valeurs['code_promo']."', 
								'".$valeurs['commentaire']."', 'abandonnee')";
								//,ID_commande_fraish '".$resultats[0]['ID_commande_fraish']."', 
		T_LAETIS_site::requeter($requete);
		$this->ID = T_LAETIS_site::last_insert_id();
		return ($this->ID);
		} // FIN function enregistrer()

	/**
	* Positionne le num�ro de commande Fraish pour une commande valid�e
	*/
	function setIDCommandeFraish()
		{
		$requete = "SELECT max(ID_commande_fraish)+1 as ID_commande_fraish FROM boutique_obj_commande
								WHERE dateReservation = '".$this->dateReservation."' 
								AND ID_pointDeVente = '".$this->ID_pointDeVente."' ";
		$resultats = T_LAETIS_site::requeter($requete);
		if (! $resultats[0]['ID_commande_fraish'])
			{ $resultats[0]['ID_commande_fraish']=1; }
		
		$requete = "UPDATE boutique_obj_commande
					SET ID_commande_fraish = '".$resultats[0]['ID_commande_fraish']."'
					WHERE ID = '".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		$this->ID_commande_fraish = $resultats[0]['ID_commande_fraish'];
		}
		
		function detailCommande($ID_commande)
			{
			$requete = "SELECT * FROM boutique_obj_commande WHERE ID='".$ID_commande."'";
			$resultats = T_LAETIS_site::requeter($requete);
			return ($resultats);
			} // FIN function initialiser()
		

		function listerCommande($ID_client, $statut, $dateDebut='', $dateFin='')
			{
			if($dateDebut!='')//Recherche avec date de debut
			{
				$and_debut = "AND dateReservation>='".T_LAETIS_site::convertirDate($dateDebut)."'";
			}
			else{
				$and_debut = "AND dateReservation>'".T_LAETIS_site::convertirDate(((int)date('Y')-1))."-12-31'";
			}
				
			if($dateFin!=''){//Recherche avec date de fin
				$and_fin = "AND dateReservation<='".T_LAETIS_site::convertirDate($dateFin)."'";
			}
							
			$requete = "SELECT * FROM boutique_obj_commande 
									WHERE ID_client='".$ID_client."'
									AND statut = '$statut' 
									$and_debut
									$and_fin
									ORDER BY dateReservation DESC, ID_commande_fraish DESC";
									//echo $requete;
			$resultats = T_LAETIS_site::requeter($requete);
			return ($resultats);
			} // FIN function initialiser()


		function listerCommandeAdmin($ID_client, $statut, $ID_pointDeVente)
		{
			$requete = "SELECT * FROM boutique_obj_commande 
									WHERE ID_client='".$ID_client."'
									AND statut = '$statut' 
									AND ID_pointDeVente = '".$ID_pointDeVente."' 
									AND dateCommande > '".date("Y-m-d H:i:s", strtotime("-1 year"))."' 
									ORDER BY dateReservation DESC, ID_commande_fraish DESC";
			$resultats = T_LAETIS_site::requeter($requete);
			return ($resultats);
		} // FIN function initialiser()


		function listerDerCommande($ID_client, $statut, $ID_pointDeVente)
		{
			$requete = "SELECT * FROM boutique_obj_commande 
							WHERE ID_client='".$ID_client."'
							AND statut = '$statut' 
							AND ID_pointDeVente = '".$ID_pointDeVente."' 
							ORDER BY dateReservation DESC
							LIMIT 1";
			$resultats = T_LAETIS_site::requeter($requete);
			return ($resultats);
		} // FIN function initialiser()


		function listerToutesCommandes($ID_client, $ID_pointDeVente)
		{
			$requete = "SELECT * FROM boutique_obj_commande
							WHERE ID_client='".$ID_client."' 
							AND ID_pointDeVente = '".$ID_pointDeVente."' 
							AND dateCommande > '".date("Y-m-d H:i:s", strtotime("-1 year"))."' 
							ORDER BY dateReservation DESC";
			$resultats = T_LAETIS_site::requeter($requete);
			return ($resultats);
		} // FIN function initialiser()

	/**
	* private
	* Liste les commandes selon des crit�res de recherche
	* @param
	* @return La liste des commandes
	*/
	function listerTousesCommandes($criteres)
		{
		$requeteStatut='1';
		$requeteAnnee='1';
		$requeteMois='1';
		$requeteDate='1';
		$requeteLivraison = "";

		//print_r($criteres);
		// Selon le/les statuts de la commande
		if ($criteres['statut'])
			{ 
			$requeteStatut="statut IN ("; 
			$statuts = explode(',', $criteres['statut']);
			foreach($statuts as $statut)
				{ $requeteStatut.="'".$statut."',"; }
			$requeteStatut=substr($requeteStatut,0,strlen($requeteStatut)-1);
			$requeteStatut.=')';
			} // FIN if ($criteres['statut'])
		
		// Selon le statut de livraison de la commande : en livraison / pas de livraison
		if (isset($criteres['livraison'] )){
			
		
			if($criteres['livraison']=='afficherNonLivraison')//N'Affiche pas les cmdes avec livraisons
				{
				$requeteLivraison = "AND ID_pointLivraison=0";
				}
			if($criteres['livraison']=='afficherLivraison')//N'affiche que les commandes avec livraisons
				{
				$requeteLivraison = "AND ID_pointLivraison>0";
				}
		}
		// Selon l'ann�e de la commande
		
		if (isset($criteres['annee'])){
			$requeteAnnee="dateCommande LIKE '".$criteres['annee']."%'";
		}
		else{
			$requeteAnnee="dateCommande LIKE '".date('Y')."%'";
		}
			
		// Selon le mois de la commande
		if (isset($criteres['mois']))
			{ 
			if (strlen($criteres['mois'])==1)
				{ $criteres['mois']='0'.$criteres['mois']; }
			$requeteMois="dateCommande LIKE '".date('Y').'-'.$criteres['mois']."%'"; 
			}
		if (isset($criteres['dateSeuleInsertion']))
			{ $requeteDate="dateReservation = '".$criteres['dateSeuleInsertion']."'"; }
		if (! $criteres['ordre'])
			{ $criteres['ordre'] = "DESC"; }

		$requete="SELECT * FROM boutique_obj_commande
							WHERE 1 AND ".$requeteStatut." AND ".$requeteAnnee." AND ".$requeteMois."  AND ".$requeteDate." 
							AND statut!='abandonnee' 
							AND ID_pointDeVente = '".$_SESSION["sessionID_user"]."' $requeteLivraison 
							ORDER BY dateReservation ".$criteres['ordre'].", ID_commande_fraish ".$criteres['ordre'];
							//ORDER BY dateReservation ".$criteres['ordre'].", dateCommande ".$criteres['ordre']."";

		//echo $requete;
		$resultats = T_LAETIS_site::requeter($requete);
		return ($resultats);
		} // FIN function listerTousesCommandes($criteres)


		function modifierStatut($ID_commande, $statut)
			{
			$requete = "UPDATE boutique_obj_commande 
								SET	statut='".$statut."' 
								WHERE ID='".$ID_commande."'";

			$resultats = T_LAETIS_site::requeter($requete);
			return ($resultats);
			} // FIN function initialiser()
		

	function listerStatsBoissonsCommandes($valeurs)
		{
		// Selon le/les statuts de la commande
		$requeteStatut='1';
		if ($valeurs['statut'])
			{ 
			$requeteStatut="statut IN ("; 
			$statuts = explode(',', $valeurs['statut']);
			foreach($statuts as $statut)
				{ $requeteStatut.="'".$statut."',"; }
			$requeteStatut=substr($requeteStatut,0,strlen($requeteStatut)-1);
			$requeteStatut.=')';
			} // FIN if ($criteres['statut'])
		
		$requete="SELECT count(*) AS nbBoissons, boissonStat, taille 
							FROM boutique_obj_commande 
							WHERE dateReservation = '".$valeurs['dateSeuleInsertion']."' 
							AND ".$requeteStatut." 
							AND ID_pointDeVente = '".$_SESSION["sessionID_user"]."' 
							GROUP BY boissonStat, taille 
							ORDER BY boissonStat";
		//echo $requete;
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[$ligne['boissonStat']][$ligne['taille']] = $ligne['nbBoissons'];
			}			
		return ($resultats);
		} // FIN function listerStatsBoissonsCommandes($dateJour)
		
		
		/** 
	* Supprime l'objet de la BD
	* @author Christophe Raffy
	*/
	function supprimer()
		{
		$requete = "DELETE FROM boutique_obj_commande WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		
		$this->ID = 0;
		}
		
	/**
	* private
	* Liste les commandes selon des crit�res de recherche
	* @param
	* @return La liste des commandes
	*/
	function listerSelonCriteres($criteres)
		{
		$requeteStatut='1';
		$requeteAnnee='1';

		// Selon le/les statuts de la commande
		if ($criteres['statut'])
			{ $requeteStatut="statut IN ('".$criteres['statut']."')"; }
		// Selon l'ann�e de la commande
		if ($criteres['annee'])
			{ $requeteAnnee="dateCommande LIKE '".$criteres['annee']."%'"; }

		$requete="SELECT ID FROM boutique_obj_commande
							WHERE 1 AND ".$requeteStatut." AND ".$requeteAnnee." 
							AND statut != 'non validee' AND statut != 'validee' 
							ORDER BY ID DESC";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_commande($ligne['ID']);
			}			
		return ($resultats);
		}


	/**
	* Calcule le taux de fiabilit� d'un client
	* selon le nombre de commandes qu'il est venu chercher, et le nombre qu'il n'est pas venu chercher
	* @param $ID_client
	* @return le taux de fiabilit�
	*/
	function tauxFiabilite($ID_client, $ID_pointDeVente)
		{
		$requete = "SELECT COUNT(ID) AS nbLivrees 
					FROM `boutique_obj_commande` 
					WHERE `statut` = 'livree' AND ID_client = '".$ID_client."' 
					AND ID_pointDeVente = '".$ID_pointDeVente."' ";
		$livree = T_LAETIS_site::requeter($requete);
		$requete = "SELECT COUNT(ID) AS nbNonLivrees 
					FROM `boutique_obj_commande` 
					WHERE `statut` = 'non livree' AND ID_client = '".$ID_client."'
					AND ID_pointDeVente = '".$ID_pointDeVente."' ";
		$nonLivree = T_LAETIS_site::requeter($requete);

		if ($livree[0]['nbLivrees']==0 && $nonLivree[0]['nbNonLivrees']==0)
			{ return '-'; }
		else
			{ return number_format(($livree[0]['nbLivrees'] / ($livree[0]['nbLivrees']+$nonLivree[0]['nbNonLivrees']) * 100),0,',',' ').'%'; }
		} // FIN function tauxFiabilite($ID_client)


	/**
	* private
	* Sauver la liste des commandes dans l'espace d'administration
	* @param
	* @return
	*/
	function sauverListe($valeurs)
		{
		// On modifie le statut de la commande
		while(list($ID_commande) = each($valeurs['statut'])) 
			{
				
			$itemCommande = new Tbq_commande($ID_commande);
			
			//on abandonne la commande
			if($itemCommande->ID_typ_paiement==5 && ($itemCommande->statut=='en_cours' || $itemCommande->statut=='livree') && ($valeurs['statut'][$ID_commande]=='annulee' || $valeurs['statut'][$ID_commande]=='abandonnee'))//IF commande avec paiement par compte client
				{
				$itemCommande->annulerPaiementCompteFraish();
				
				}//FIN IF commande avec paiement compte client*/
			
			//on reprend en compte la commande				
			if($itemCommande->ID_typ_paiement==5 && ($itemCommande->statut=='annulee' || $itemCommande->statut=='abandonnee') && ($valeurs['statut'][$ID_commande]=='en_cours' || $valeurs['statut'][$ID_commande]=='livree'))//IF commande avec paiement par compte client
				{
				$itemCommande->validerPaiementCompteFraish();
				}
			unset($itemCommande);
				
			$requete="UPDATE boutique_obj_commande 
								SET	statut='".$valeurs['statut'][$ID_commande]."' 
								WHERE ID='".$ID_commande."'";
			T_LAETIS_site::requeter($requete);
			
			
			} // FIN while(list ($ID_commande) = each ($valeurs['statut'])) 
		} // FIN function sauverListe($valeurs)


	function determineDateJour($dateReservation)
	{
		if ($dateReservation == date('Y-m-d'))
		{
				$mois = date('m');
				$jour = date('d');
				$annee = date('Y');
				//ajoute '0' si c'est un chiffre compris entre 0 et 9
				if( 0 < $mois && $mois < 10 && strlen($mois) == 1)
				{	$mois = '0'.$mois;	}
				if( 0 < $jour && $jour < 10 && strlen($jour) == 1)
				{	$jour = '0'.$jour;  }
				
				$dateReservation = $annee."-".$mois."-".$jour;
		}
	
		 return T_LAETIS_site::convertirDate( $dateReservation );	 
	} // FIN function determineDateJour($dateReservation)


	function genererEmailReservation($pageSource, $ID_client)
		{
		require_once("htmlMimeMail/htmlMimeMail5.php");
		
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, "https://".$_SERVER['HTTP_HOST'].$pageSource."?ID_commande=".$this->ID."&ID_client=".$ID_client);
		curl_setopt($curl, CURLOPT_HEADER, 0); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		// curl_setopt($curl, CURLOPT_POST, 1); 
		// curl_setopt($curl, CURLOPT_POSTFIELDS, $post); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        $contenu = curl_exec($curl);
		curl_close($curl);
		if(!$contenu){
			echo "Erreur d'envoi du mail";
		}
		/*
		$header="GET /".$pageSource."?ID_commande=".$this->ID."&ID_client=".$ID_client."   HTTP/1.0\r\n";
		$header.="Host: ".$_SERVER['HTTP_HOST']."\r\n";
		$header.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header.= "\r\n";
		$header.= "\r\n";
	
		$stream=fsockopen($_SERVER['SERVER_ADDR'], 80, $errno, $errstr,30);
		if(!$stream)
			{   
			 echo "$errstr ($errno)<br>\n";
			 exit($_SERVER['HTTP_HOST'].' erreur socket fsockopen');
			 } 
			else
			 {
			 $contenu="<!--";
			fputs($stream, $header);
			while (!feof($stream)) 
				{
				// Traitement ligne � ligne du fichier 
				$contenu.= fgets($stream, 10000);               
				}
			//on vire la reponse http ==> on commente ce qu'il y a avant le <html>
			$contenu = str_replace("<html","--><html ",$contenu);
			$contenu = str_replace("<HTML","--><HTML ",$contenu);
		
			fclose($stream);
			}
		*/
		
		
		// on met toutes les sources en chemin absolu
		//$contenu = preg_replace( '/src=\"(.*)\"/i', 'src="http://' . $_SERVER['HTTP_HOST'] . '$1"', $contenu );
		//$contenu = preg_replace( '/href=\"(.*)\"/i', 'href="http://' . $_SERVER['HTTP_HOST'] . '$1"', $contenu );
		//$contenu = preg_replace( '/url\((.*)/i', 'url(http://' . $_SERVER['HTTP_HOST'] . '$1', $contenu );
		
		// Archivage
		$requete="UPDATE boutique_obj_commande 
							SET recapitulatif='".addslashes($contenu)."'
							WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		
		// envoi du mail		
		$sujet='Votre reservation sur le site Fraish';
		
		// Envoi du message
		$obj_mail = new htmlMimeMail();
		$obj_mail->setFrom('fraishlabege@gmail.com');
		$obj_mail->setSubject($sujet);
		$obj_mail->setHtml($contenu,'','./');
		
		// Envoi � l'utilisateur
		if($this->ID>14320)//pb bug envoi mail sur recharge compte client
			{
			$client = new Tbq_client($ID_client);
			$obj_mail->send(array($client->emailFacturation),'smtp');
			//$obj_mail->send(array('contact@fraish.fr'),'smtp');
			//$obj_mail->send(array('pierre.carayol@laetis.fr'),'smtp');
			}
		} // FIN function genererEmailReservation($pageSource, $ID_client)
		

	function genererEmailAbandon($valeurs)
		{
		require_once("htmlMimeMail/htmlMimeMail5.php");
		
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, "https://".$_SERVER['HTTP_HOST']."/boutique/fr/emails/envoi-commande/envoi-annulation.php?ID_commande=".$valeurs['ID_commande']."&ID_client=".$valeurs['ID_client']);
		curl_setopt($curl, CURLOPT_HEADER, 0); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		// curl_setopt($curl, CURLOPT_POST, 1); 
		// curl_setopt($curl, CURLOPT_POSTFIELDS, $post); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        $contenu = curl_exec($curl);
		curl_close($curl);
		if(!$contenu){
			echo "Erreur d'envoi du mail";
		}
		/*
		$header="GET /boutique/fr/emails/envoi-commande/envoi-annulation.php?ID_commande=".$valeurs['ID_commande']."&ID_client=".$valeurs['ID_client']."   HTTP/1.0\r\n";
		$header.="Host: ".$_SERVER['HTTP_HOST']."\r\n";
		$header.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header.= "\r\n";
		$header.= "\r\n";
	
		$stream=fsockopen($_SERVER['SERVER_ADDR'], 80, $errno, $errstr,30);
		if(!$stream)
			{   
			 echo "$errstr ($errno)<br>\n";
			 exit($_SERVER['HTTP_HOST'].' erreur socket fsockopen');
			 } 
			else
			 {
			 $contenu="<!--";
			fputs($stream, $header);
			while (!feof($stream)) 
				{
				// Traitement ligne � ligne du fichier 
				$contenu.= fgets($stream, 10000);               
				}
			//on vire la reponse http ==> on commente ce qu'il y a avant le <html>
			$contenu = str_replace("<html","--><html ",$contenu);
			$contenu = str_replace("<HTML","--><HTML ",$contenu);
		
			fclose($stream);
			}
*/
		// on met toutes les sources en chemin absolu
		//$contenu = preg_replace( '/src=\"(.*)\"/i', 'src="http://' . $_SERVER['HTTP_HOST'] . '$1"', $contenu );
		//$contenu = preg_replace( '/href=\"(.*)\"/i', 'href="http://' . $_SERVER['HTTP_HOST'] . '$1"', $contenu );
		//$contenu = preg_replace( '/url\((.*)/i', 'url(http://' . $_SERVER['HTTP_HOST'] . '$1', $contenu );
		
		// envoi du mail		
		$sujet='Annulation de votre reservation Fraish';
		
		// Envoi du message
		$obj_mail = new htmlMimeMail();
		$obj_mail->setFrom('fraishlabege@gmail.com');
		$obj_mail->setSubject($sujet);
		$obj_mail->setHtml($contenu,'','./');
		
		// Envoi � l'utilisateur
		$client = new Tbq_client($valeurs['ID_client']);
		$obj_mail->send(array($client->emailFacturation),'smtp');
		//$obj_mail->send(array('contact@fraish.fr'),'smtp');
		//$obj_mail->send(array('pierre.carayol@laetis.fr'),'smtp');
		} // FIN function genererEmailAbandon($valeurs)

	function validerPaiementCompteFraish()
		{
		$requete = "UPDATE boutique_obj_client
					SET soldeCompte = soldeCompte - ".$this->prix."
					WHERE boutique_obj_client.ID = '".$this->ID_client."'";
		T_LAETIS_site::requeter($requete);
		}
	function annulerPaiementCompteFraish()
		{
		$requete = "UPDATE boutique_obj_client
					SET soldeCompte = soldeCompte + ".$this->prix."
					WHERE boutique_obj_client.ID = '".$this->ID_client."'";
		T_LAETIS_site::requeter($requete);
		}
	function setIDPaiement($ID_typ_paiement)
		{
		$requete = "UPDATE boutique_obj_commande
					SET ID_typ_paiement='".$ID_typ_paiement."'
					WHERE ID = '".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		}
	function reglementCB($reglement)
		{		
		$requete="UPDATE boutique_obj_commande  
					SET
					reglement= '".$reglement."'
					WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		}

	function getLabelTypePaiement($ID_commande='')
		{
		if(!$ID_commande)
			{
			$and = "AND boutique_obj_commande.ID = '".$this->ID."'";
			}
		else
			{
			$and = "AND boutique_obj_commande.ID = '".$ID_commande."'";
			}
		$requete = "SELECT label, reglement 
					FROM typ_paiement, boutique_obj_commande
					WHERE typ_paiement.ID = boutique_obj_commande.ID_typ_paiement
					$and";

		$resSql = T_LAETIS_site::requeter($requete);
		switch($resSql[0]['reglement'])
			{
			case 'retourAutoPaiementAccepte':
				$etat = ' accepte';
				break;
			case 'retourAutoPaiementRefuse':
				$etat = ' refuse';
			}
		return($resSql[0]['label'].$etat);
		}
	function getIDFormule($ID_commande)
		{
			
		$detail = Tbq_commande::detailCommande($ID_commande);
		
		if($detail[0]['plat'])
			{
			$and = "AND salade=1 ";
			}
		else
			{
			$and = "AND salade=0 ";
			}
		if($detail[0]['soupe']!=', , ,')
			{
			$and.= "AND soupe=1 ";
			}
		else
			{
			$and.="AND soupe=0 ";
			}
		if($detail[0]['boisson'])
			{
			$and.="AND boisson=1 ";
			}
		else
			{
			$and.="AND boisson=0 ";
			}
		if($detail[0]['dessert'])
			{
			$and.="AND dessert=1 ";
			}
		else
			{
			$and.="AND dessert=0 ";
			}
		if($detail[0]['pain'])
			{
			$and.="AND pain=1 ";
			}
		else
			{
			$and.="AND pain=0 ";
			}
		if($detail[0]['eau'])
			{
			$and.="AND eau=1 ";
			}
		else
			{
			$and.="AND eau=0 ";
			}
		$requete = "SELECT ID_typ_formule FROM boutique_obj_menu
				   WHERE 1
				   $and";
			//echo $requete;
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[sizeof($resSql)-1]['ID_typ_formule']);
		}
	
	/** 
	* retourne le nombre de commandes et leur montant pour une ann�e et un mois donn�es
	* @return array Tableau de Tbq_commande
	* @author Christophe Raffy
	*/
	function commandesAnneeMois($statut,$annee,$mois,$ID_pointDeVente)
		{
		$resultats = array();
		$requete = "SELECT COUNT(ID) as nb, IFNULL(SUM(prix),0) as somme
				FROM boutique_obj_commande 
				WHERE statut = '".$statut."' 
				AND YEAR(dateCommande) = ".$annee." 
				AND MONTH(dateCommande) = ".$mois;
				//."AND ID_pointDeVente = '".$ID_pointDeVente."'"
				//echo $requete;
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats['somme'] = $ligne['somme'];
			$resultats['nb'] = $ligne['nb'];
			}			
		return ($resultats);
		}
	function getCASelonTypePaiementEtDate($type,$date)
		{
			//dateReservation
		$requete ="SELECT IFNULL(SUM(prix),0) as montant
					FROM boutique_obj_commande
					WHERE (SUBSTRING(dateCommande,1,10) = '".$date."')
					AND ID_typ_paiement=".$type."
					AND statut IN ('livree')
					";
					//AND ID_pointDeVente = '".$_SESSION['sessionID_user']."'
		$resSql=T_LAETIS_site::requeter($requete);
		return($resSql[0]['montant']);
		}
	function getNbCommandesSelonTypePaiementEtDate($type,$date)
		{
		//dateReservation
			$requete ="SELECT COUNT(ID) as NB FROM boutique_obj_commande
						WHERE ID_typ_paiement='".$type."'
						AND (SUBSTRING(dateCommande,1,10)='".$date."')
						AND statut IN ('livree')
						";
						//AND ID_pointDeVente = '".$_SESSION['sessionID_user']."'
			$resSql = T_LAETIS_site::requeter($requete);
			return($resSql[0]['NB']);
			
		}
	/*function getStatsMoyens($date)
		{
		$requete = "SELECT boutique_obj_commande.*
					FROM boutique_obj_commande
					WHERE statut IN ('livree')
					AND SUBSTRING(dateCommande,1,10)='".$date."')";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach($resSql as $ligne)
			{
			}
		}*/
	function peutAnnuler()
		{
		$retour = false;
		
		if(date('Y-m-d H:i:s') <= $this->dateReservation.' 11:30:00')//IF paiement compte Fraish et date ok
			{
			$retour = true;
			}
		return $retour;
		}
		
	function genererEmailAbandonCB($valeurs)
		{
		require_once("htmlMimeMail/htmlMimeMail5.php");
		
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, "https://".$_SERVER['HTTP_HOST']."/boutique/fr/emails/envoi-commande/envoi-annulation-cb.php?ID_commande=".$valeurs['ID_commande']."&ID_client=".$valeurs['ID_client']);
		curl_setopt($curl, CURLOPT_HEADER, 0); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		// curl_setopt($curl, CURLOPT_POST, 1); 
		// curl_setopt($curl, CURLOPT_POSTFIELDS, $post); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        $contenu = curl_exec($curl);
		curl_close($curl);
		if(!$contenu){
			echo "Erreur d'envoi du mail";
		}
		/*
		$header="GET /boutique/fr/emails/envoi-commande/envoi-annulation-cb.php?ID_commande=".$valeurs['ID_commande']."&ID_client=".$valeurs['ID_client']."   HTTP/1.0\r\n";
		$header.="Host: ".$_SERVER['HTTP_HOST']."\r\n";
		$header.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header.= "\r\n";
		$header.= "\r\n";
	
		$stream=fsockopen($_SERVER['SERVER_ADDR'], 80, $errno, $errstr,30);
		if(!$stream)
			{   
			 echo "$errstr ($errno)<br>\n";
			 exit($_SERVER['HTTP_HOST'].' erreur socket fsockopen');
			 } 
			else
			 {
			 $contenu="<!--";
			fputs($stream, $header);
			while (!feof($stream)) 
				{
				// Traitement ligne � ligne du fichier 
				$contenu.= fgets($stream, 10000);               
				}
			//on vire la reponse http ==> on commente ce qu'il y a avant le <html>
			$contenu = str_replace("<html","--><html ",$contenu);
			$contenu = str_replace("<HTML","--><HTML ",$contenu);
		
			fclose($stream);
			}
		*/
		// on met toutes les sources en chemin absolu
		$contenu = preg_replace( '/src=\"(.*)\"/i', 'src="http://' . $_SERVER['HTTP_HOST'] . '$1"', $contenu );
		$contenu = preg_replace( '/href=\"(.*)\"/i', 'href="http://' . $_SERVER['HTTP_HOST'] . '$1"', $contenu );
		$contenu = preg_replace( '/url\((.*)/i', 'url(http://' . $_SERVER['HTTP_HOST'] . '$1', $contenu );
		
		// envoi du mail		
		$sujet="Annulation d'une commande CB";
		
		// Envoi du message
		$obj_mail = new htmlMimeMail();
		$obj_mail->setFrom('fraishlabege@gmail.com');
		$obj_mail->setSubject($sujet);
		$obj_mail->setHtml($contenu,'','./');
		
		// Envoi � l'utilisateur
		$client = new Tbq_client($valeurs['ID_client']);
		$obj_mail->send(array('frederique@fraish.fr'),'smtp');
		//$obj_mail->send(array('contact@fraish.fr'),'smtp');
		$obj_mail->send(array('pierre.carayol@laetis.fr'),'smtp');
		}
	function getMontantTTCSelonDate($date)
		{
			//dateReservation
		$requete = "SELECT IFNULL(SUM(prix),0) as TOTAL FROM boutique_obj_commande
					WHERE statut='livree'
					AND (SUBSTRING(dateCommande,1,10) = '".$date."')
					";
					//AND ID_pointDeVente = '".$_SESSION['sessionID_user']."'
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['TOTAL']);
		}
	function getMontantHTSelonDate($date,$taux=7)
		{
		$ttc = Tbq_commande::getMontantTTCSelonDate($date);
		$ht = $ttc/(1+($taux/100));
		return(round($ht,2));
		}
	function getMontantTVASelonDate($date,$taux=7)
		{
		return(Tbq_commande::getMontantTTCSelonDate($date)-Tbq_commande::getMontantHTSelonDate($date,$taux));
		}
	function getNbMenuVendusSelonTailleEtDate($ID_menu,$taille,$date)
		{
		$menuType = new Tbq_menu($ID_menu);
		if($menuType->salade)//salade
			{
			$and=" AND plat!=''";
			}
		else
			{
			$and=" AND plat=''";
			}
		if($menuType->soupe)//soupe
			{
			$and.=" AND (soupe!='' AND soupe!=', , ,')";
			}
		else
			{
			$and.=" AND (soupe='' OR soupe=', , ,')";
			}
		if($menuType->boisson)//boisson
			{
			$and.=" AND boisson!=''";
			}
		else
			{
			$and.=" AND boisson=''";
			}
		if($menuType->dessert)//dessert
			{
			$and.=" AND dessert!=''";
			}
		else
			{
			$and.=" AND dessert=''";
			}
		if($menuType->eau)//eau
			{
			$and.= " AND eau!=''";
			}
		else
			{
			$and.= " AND eau=''";
			}
			//dateReservation
		$requete = "SELECT COUNT(ID) as NB FROM boutique_obj_commande
					WHERE statut='livree'
					AND (SUBSTRING(dateCommande,1,10)='".$date."')
					$and
					AND taille = '".$taille."'";
					//AND ID_pointDeVente = '".$_SESSION['sessionID_user']."'
		$resSql = T_LAETIS_site::requeter($requete);
		//echo $requete;
		return($resSql[0]['NB']);
		}
	function listerSupplements($date)
		{
			//dateReservation
		$requete = "SELECT DISTINCT(supplement)
					FROM boutique_obj_commande
					WHERE (SUBSTRING(dateCommande,1,10)='".$date."')
					AND statut='livree'";
					//AND ID_pointDeVente = '".$_SESSION['sessionID_user']."'
		$resSql = T_LAETIS_site::requeter($requete);
		foreach($resSql as $ligne)
			{
			$retour[] = $ligne;
			}
		return($retour);
		}
		
	
	/** 
	* retourne l'ann�e de la premiere commande
	* @return array Tableau de Tbq_commande
	* @author Christophe Raffy
	*/
	function anneePremiereCommande()
		{
		$date = 0;
		$requete = "SELECT YEAR(dateCommande) as annee
				FROM boutique_obj_commande 
				ORDER BY dateCommande
				LIMIT 0, 1";
		$resSql = T_LAETIS_site::requeter($requete);
		return ($resSql[0]['annee']);
		}
		
	function setDateReservation($date) {
		$requete = 'UPDATE boutique_obj_commande
					SET dateReservation=\''.$date.'\'
					WHERE ID='.$this->ID;
		T_LAETIS_site::requeter($requete);	
	}
}
	
?>