<?php
/**
   *  Classe de gestion des menus du jour
   *
   * Permet de créer, modifier, supprimer des menus du jour, en intéraction
   * avec la base de données
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright Laëtis Créations Multimédias
	 * @date 2007-11-12
   */

class Tbq_approvisionnement
	{

	/**
	* @var int $ID ID de l'element en base de donnée
	* @access  private
	*/
	var $ID;
	var $ID_client;
	var $date;
	var $montant;
	var $ID_typ_paiement;
	var $numCheque;
	var $nbTitres;
	var $valeurTitre;
	//var $valide;
	var $ID_commande;
	var $approOffert;

	/**
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tbq_menujour l'objet créé
	* @access  public
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;
		if($ID>0)
			{
			$requete = "SELECT * FROM boutique_obj_approvisionnement WHERE ID='".$this->ID."'";
			$resultats = T_LAETIS_site::requeter($requete);
			$this->initialiser($resultats[0]);
			}
		}


	function initialiser($enregistrement)
		{
		if($enregistrement)
			{
			foreach ($enregistrement as $nomChamp => $valeur)
				{
				$this->$nomChamp = stripslashes($valeur);
				}
			}
		return $this;
		}


	/**
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tbq_menujour l'objet créé
	* @see Tbq_menujour::__construct()
	* @access  public
	*/
	function Tbq_approvisionnement($ID = 0)
		{
		$this->__construct($ID);
		}


	/**
	* Enregistre l'objet en base de donnée
	* Si l'ID est renseigné ==> modification
	* Sinon ==> insertion
	* @access  public
	*/
	function enregistrer($valeurs)
		{

		if($this->ID==0)//IF insertion, date courante
			{
			$valeurs['date'] = date('Y-m-d');
			}//FIN insertion date

		T_LAETIS_site::modifierAttributs($valeurs);

		//si l'ID est renseigné, on modifie, sinon, on insere
		$attributs = get_object_vars($this);
		// on donne les champs à mettre à jour (meme syntaxe pour le UPDATE et le INSERT)
		$contenuRequete = "";
		$champsNonEnregistres = array( );

		foreach ($attributs as $nom=>$valeur)
			{
			if ( !in_array( $nom, $champsNonEnregistres ) )
				{
				$valeur = "\"".addslashes($valeur)."\"";
				$contenuRequete .= " ,".$nom."=".$valeur;
				}
			}

		// on enlève l'espace et la virgule du début

		$contenuRequete = substr($contenuRequete,2);
		if ($this->ID>0)
			{
			// c'est un objet qui existe déjà en BD
			$requete = "UPDATE boutique_obj_approvisionnement SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_approvisionnement SET ";
			$requete .= $contenuRequete;
			$resSql = T_LAETIS_site::requeter($requete);
			$this->ID = T_LAETIS_site::last_insert_id();
			}
		return($resSql);
		} // FIN function enregistrer()

	/**
	* Lorsque l'admin valide l'approvisionnement, ajoute le montant au solde du client
	*/
	function valider()
		{
		$requete = "UPDATE boutique_obj_approvisionnement
					SET valide=1
					WHERE ID='".$this->ID."'";
		$resSql = T_LAETIS_site::requeter($requete);

		if($resSql)
			{
			$requete = "UPDATE boutique_obj_client
						SET soldeCompte=soldeCompte + ".$this->montant."
						WHERE boutique_obj_client.ID='".$this->ID_client."'";
			T_LAETIS_site::requeter($requete);
			}
		else
			{
			echo "La validation de l'approvisionnement a échoué !";
			}
		}
	function setValide($etat) {
		$requete = 'UPDATE boutique_obj_approvisionnement
					SET valide = '.$etat.'
					WHERE ID='.$this->ID;
		T_LAETIS_site::requeter($requete);
	}
	/**
	* Liste les opérations d'approvisionnement du client $ID_client
	*/
	function lister($ID_client,$etat='',$dateDebut='',$dateFin='')
		{
		$resultats = array();
		$and_etat='';
		if($etat=="1" || $etat=="0")
			{
			$and_etat = "AND valide='".$etat."'";
			}
		if($dateDebut)//Recherche avec date de début
				{
				$and_debut = "AND date>='".T_LAETIS_site::convertirDate($dateDebut)."'";
				}
		if($dateFin) //Recherche avec date de fin
			{
			$and_fin = "AND date<='".T_LAETIS_site::convertirDate($dateFin)."'";
			}

		$requete = "SELECT boutique_obj_approvisionnement.*
					FROM boutique_obj_approvisionnement
					WHERE ID_client='".$ID_client."'
					$and_etat
					$and_debut
					$and_fin
					ORDER BY date DESC";
		$resSql = T_LAETIS_site::requeter($requete);

		foreach($resSql as $ligne)
			{
			//$resultats[] = Tbq_approvisionnement::initialiser($ligne);
			$resultats[] = new Tbq_approvisionnement($ligne['ID']);
			}
		return($resultats);
		}
	function listerSaufOffert($ID_client)
		{
		$requete = "SELECT boutique_obj_approvisionnement.*
					FROM boutique_obj_approvisionnement
					WHERE ID_client='".$ID_client."'
					AND valide=0
					AND ID_typ_paiement NOT IN (8)";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach($resSql as $ligne)
			{
			//$resultats[] = Tbq_approvisionnement::initialiser($ligne);
			$resultats[] = new Tbq_approvisionnement($ligne['ID']);
			}
		return($resultats);
		}

	function listerAllCB($criteres)
		{


		// Selon le mois
		if ($criteres['mois'])
			{
			if (strlen($criteres['mois'])==1)
				{ $criteres['mois']='0'.$criteres['mois']; }
			$requeteMois="date LIKE '".date('Y').'-'.$criteres['mois']."%'";
			}
			
		$requete = "SELECT boutique_obj_approvisionnement.*
					FROM boutique_obj_approvisionnement					
					WHERE valide=1
					AND ID_typ_paiement =1
					AND ".$requeteMois."
					AND `date` > '".((int)date('Y')-1)."-12-31'
					";

		$resSql = T_LAETIS_site::requeter($requete);
		foreach($resSql as $ligne)
			{
			//$resultats[] = Tbq_approvisionnement::initialiser($ligne);
			$resultats[] = new Tbq_approvisionnement($ligne['ID']);
			}
		return($resultats);
		}

	function getLabelTypePaiement()
		{
		$requete = "SELECT label
					FROM typ_paiement
					WHERE ID='".$this->ID_typ_paiement."'";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['label']);
		}
	/**
	* Supprime l'objet en base de donnée
	* @access  public
	*/
	function supprimer()
		{
		//Si l'appro était validé, il faut enlever la somme au soldeCompte du Client
		if($this->valide==1)
			{
			$requete = "UPDATE boutique_obj_client
						SET soldeCompte = soldeCompte - ".$this->montant."
						WHERE ID_client='".$this->ID_client."'";
			T_LAETIS_site::requeter($requete);
			}
		$requete = "DELETE FROM boutique_obj_approvisionnement
					WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		$this->ID = 0;
		}

	/**
	* Retourne le descriptif de l'approvisionnement pour afficher dans les listes
	*/
	function getDescriptif()
		{
		return('Approvisionnement de '.$this->montant.' &euro; par '.$this->getLabelTypePaiement().' le '.T_LAETIS_site::convertirDate($this->date));
		}
	/**
	* Retourne le récapitulatif de paiement pour un approvisionnement
	*/
	function getDetailPaiement()
		{
		switch($this->ID_typ_paiement)
			{
			case 2://chèque
				$retour = "Ch&egrave;que num&eacute;ro ".$this->numCheque;
				break;
			case 3://titres restaurant
				$retour = $this->nbTitres." titres restaurant d'une valeur de ".$this->valeurTitre." &euro;";
				break;
			}
		return($retour);
		}
	function getNbApproEnAttente($ID_client)
		{
		$requete = "SELECT IFNULL(count(ID),0) as nb
					FROM boutique_obj_approvisionnement
					WHERE valide=0
					AND ID_client = '".$ID_client."'";
		$resSql = T_LAETIS_site::requeter($requete);
		//echo $requete;
		return($resSql[0]['nb']);
		}
	function getSommeApproSelonDate($date)
		{
		$requete = "SELECT IFNULL(sum(montant),0) as montantTotal
					FROM boutique_obj_approvisionnement
					WHERE valide=1
					AND date='".$date."'
					";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['montantTotal']);
		}
	function getSommeApproSelonClient($ID_client)
		{
		$requete = "SELECT IFNULL(sum(montant),0) as montantTotal
					FROM boutique_obj_approvisionnement
					WHERE valide=1
					AND ID_client='".$ID_client."'";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['montantTotal']);
		}
	function getSommeApproSelonTypeEtDate($type,$date)
		{
		$requete = "SELECT IFNULL(sum(montant),0) as montantTotal
					FROM boutique_obj_approvisionnement
					WHERE valide=1
					AND ID_typ_paiement='".$type."'
					AND (SUBSTRING(date,1,10)='".$date."')";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['montantTotal']);
		}
	function genererMailDemandeAppro($pageSource)
		{
		//require_once("mailler/htmlMimeMail".".php");
		require_once("htmlMimeMail/htmlMimeMail5.php");

		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, "https://".$_SERVER['HTTP_HOST'].$pageSource."?ID_appro=".$this->ID);
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
		$header="GET /".$pageSource."?ID_appro=".$this->ID."   HTTP/1.0\r\n";
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
				// Traitement ligne à ligne du fichier
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
		$sujet='Approvisionnement de votre compte Fraish';

		// Envoi du message
		$obj_mail = new htmlMimeMail();
		$obj_mail->setFrom('fraishlabege@gmail.com');
		$obj_mail->setSubject($sujet);
		$obj_mail->setHtml($contenu,'','./');

		// Envoi à l'utilisateur
		$client = new Tbq_client($this->ID_client);
		$obj_mail->send(array($client->emailFacturation),'smtp');
		//$obj_mail->send(array('pierre.carayol@laetis.fr'),'smtp');
		}
	/**
	*
	*/

	function getEnCours()
		{
		//somme des soldes client
		$requete = "SELECT SUM(soldeCompte) as TOTAL FROM boutique_obj_client";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['TOTAL']);
		}
	function setApproOffert($ID_approOffert)
		{
		$requete = "UPDATE boutique_obj_approvisionnement
					SET approOffert = '".$ID_approOffert."'
					WHERE ID='".$this->ID."'";
		$this->approOffert = $ID_approOffert;
		T_LAETIS_site::requeter($requete);
		}
	}
?>