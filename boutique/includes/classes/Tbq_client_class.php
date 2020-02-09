<?php
/**
   *  Classe de gestion des clients de la boutique
   *
   * Permet de cr�er, modifier, supprimer des rubriques, en int�raction
   * avec la base de donn�es
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright La�tis Cr�ations Multim�dias
	 * @date 2007-11-12
   */

class Tbq_client
	{

	/**
	* @var int $ID ID de l'element en base de donn�e
	* @access  private
	*/
	var $ID;
	var $codeEntreprise;
	/**
	* @var date $dateCommande Date de la commande
	* @access  private
	*/
	var $dateInscription;
	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $civiliteFacturation;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $nomFacturation;

	/**
	* @var string $titre Prenom de la rubrique
	* @access  private
	*/
	var $prenomFacturation;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $adresseFacturation;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $adresseFacturation2;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $codePostalFacturation;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $villeFacturation;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $emailFacturation;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $telFacturation;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $societe;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $newsletter;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $motDePasse;

	/**
	* @var string $titre Nom de la rubrique
	* @access  private
	*/
	var $dateDeNaissance;

	/**
	* @var int $ID_pointDeVentePrefere Num�ro du point de vente pr�f�r�
	* @access  private
	*/
	var $ID_pointDeVentePrefere;
	var $soldeCompte;

	/**
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element � initialiser (si non renseign�, aucune initialisation)
	* @return Tbq_client l'objet cr��
	* @access  public
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;
		$this->initialiser($ID);
		}


	function initialiser($ID)
		{
		//si on a donn� un parametre, on instancie par rapport � la base
		if ( $this->ID>0 )
			{
			// initialisation de l'objet
			$requete = "SELECT * FROM boutique_obj_client WHERE ID='".$this->ID."'";
			$resultats = T_LAETIS_site::requeter($requete);
			if ($resultats[0])
				{
				foreach ($resultats[0] as $nomChamp => $valeur)
					{
					$this->$nomChamp = stripslashes($valeur);
					}
				}
			}
		}


	/**
	* Alias du constructeur (compatibilit� PHP4)
	* @param int $ID (facultatif) ID de l'element � initialiser (si non renseign�, aucune initialisation)
	* @return Tbq_client l'objet cr��
	* @see Tbq_client::__construct()
	* @access  public
	*/
	function Tbq_client($ID = 0)
		{
		$this->__construct($ID);
		}


	/**
	* Enregistre l'objet en base de donn�e
	* Si l'ID est renseign� ==> modification
	* Sinon ==> insertion
	* @access  public
	*/
	function enregistrer($valeurs)
		{
		T_LAETIS_site::modifierAttributs($valeurs);

		//si l'ID est renseign�, on modifie, sinon, on insere
		$attributs = get_object_vars($this);
		// on donne les champs � mettre � jour (meme syntaxe pour le UPDATE et le INSERT)
		$contenuRequete = "";
		$champsNonEnregistres = array( "pointsFidelite" );

		foreach ($attributs as $nom=>$valeur)
			{
			if ( !in_array( $nom, $champsNonEnregistres ) )
				{
				$valeur = "\"".addslashes($valeur)."\"";
				$contenuRequete .= " ,".$nom."=".$valeur;
				}
			}

		// on enl�ve l'espace et la virgule du d�but
		$contenuRequete = substr($contenuRequete,2);
		if ($this->ID>0)
			{
			// c'est un objet qui existe d�j� en BD
			$requete = "UPDATE boutique_obj_client SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_client SET ";
			$requete .= $contenuRequete;
			T_LAETIS_site::requeter($requete);
			$this->ID = T_LAETIS_site::last_insert_id();
			}
		} // FIN function enregistrer()


	/**
	* Supprime l'objet en base de donn�e
	* @access  public
	*/
	function supprimer()
		{
		$requete = "DELETE FROM boutique_obj_client WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		$this->ID = 0;
		}


	/**
	* Liste les clients
	* @access  public
	*/
	function lister()
		{
		$resultats = array();
		$requete = "SELECT ID FROM boutique_obj_client ORDER BY nomFacturation ASC, prenomFacturation ASC";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_client($ligne['ID']);
			}
		return ($resultats);
		}


	/**
	* Liste les rubriques
	* @access  public
	*/
	function listerAdmin($valeurs)
		{
		$orderBy = "";
		$where = "1";
		/*if ($valeurs['champTri']=='dateInscription')
			{ $orderBy = "dateInscription DESC, nomFacturation ASC, prenomFacturation ASC"; }		*/
		if ($valeurs['champTri']=='parNom')
			{ $orderBy = "nomFacturation ASC, prenomFacturation ASC"; }
		else if ($valeurs['champTri'])
			{
			$orderBy = "nbCommandes DESC, nomFacturation ASC, prenomFacturation ASC";
			if ($valeurs['champTri']=='totale')
				{	$where = "statut != ''"; }
			else
				{	$where = "statut = '".$valeurs['champTri']."'"; }
			}
		/*else
			{ $orderBy = "nomFacturation ASC, prenomFacturation ASC"; }*/
		else
			{ $orderBy = "dateInscription DESC, nomFacturation ASC, prenomFacturation ASC"; }

		//Recherche
		if($valeurs['rechNom'])
			{
			$and_recherche = 'AND (
							  boutique_obj_client.nomFacturation LIKE "'.$valeurs['rechNom'].'%"
							  OR boutique_obj_client.prenomFacturation LIKE "'.$valeurs['rechNom'].'%"
							  OR boutique_obj_client.emailFacturation LIKE "%'.$valeurs['rechNom'].'%")';
			}

		$resultats = array();
		$requete = "SELECT boutique_obj_client.ID, count(boutique_obj_commande.ID) AS nbCommandes 
								FROM boutique_obj_client 
								LEFT JOIN boutique_obj_commande 
									ON (boutique_obj_commande.ID_client=boutique_obj_client.ID)
								WHERE ".$where."
								$and_recherche								
								GROUP BY boutique_obj_client.ID
								ORDER BY ".$orderBy;
		//AND ID_pointDeVente = '".$_SESSION["sessionID_user"]."'
								//echo $requete;
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_client($ligne['ID']);
			}

		/*//Ajoute les clients qui n'ont jamais command�
		$requete = "SELECT * FROM boutique_obj_client
					WHERE ID NOT IN (SELECT ID_client FROM boutique_obj_commande)";
		$ressSql = T_LAETIS_site::requeter($requete);
		foreach($resSql as $ligne)
			{
			$resultats[] = new Tbq_client($ligne['ID']);
			}*/

		return ($resultats);
		}


	/**
	* Cherche le login de l'utilisateur d'apr�s l'adresse courriel donn�e
	* @param
	* @return login pass par email
	*/
	function demanderLogin($email)
		{
		$requete = "SELECT ID FROM boutique_obj_client 
								WHERE emailFacturation = '".$email."' ORDER BY ID DESC";
		$resSql = T_LAETIS_site::requeter($requete);
		$resultats = new Tbq_client($resSql[0]['ID']);
		return ($resultats);
		}


	/**
	* V�rifier si le login et motDepasse correspondent � un client
	* @param array $valeurs Champs POST
	* @return int ID du client correspondant
	*/
	function verifierLogin($valeurs)
		{
		$requete = "SELECT ID FROM boutique_obj_client	
								WHERE emailFacturation = '".$valeurs['email']."' 
								AND motDePasse = '".$valeurs['motDePasse']."'
								AND accesBloque!=1
								ORDER BY ID DESC";
		$resultats = T_LAETIS_site::requeter($requete);
		return ($resultats[0]['ID']);
		} // FIN function verifierLogin($valeurs)


	/**
	* R�cup�rer les ID des commandes en cours (non livr�e)
	* @param
	* @return ID commande
	*/
	function getCommandesEnCours()
		{
		$requete = "SELECT ID FROM boutique_obj_commande 	
								WHERE statut IN ('payee', 'validee cb', 'validee cheque', 'validee fax', 
								'validee virement') 
								AND ID_client = '".$this->ID."'
								ORDER BY dateCommande DESC";
		$resSql = T_LAETIS_site::requeter($requete);
		//echo $requete;
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_commande($ligne['ID']);
			}
		return ($resultats);
		}



	/**
	* R�cup�rer les ID des commandes en cours (non livr�e)
	* @param
	* @return ID commande
	*/
	function getCommandesLivrees()
		{
		$requete = "SELECT ID FROM boutique_obj_commande 	
								WHERE statut = 'livree' 
								AND ID_client = '".$this->ID."'
								ORDER BY dateCommande DESC";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_commande($ligne['ID']);
			}
		return ($resultats);
		}


	/**
	* R�cup�rer les ID des commandes abandonn�es (abandonnee)
	* @param
	* @return ID commande
	*/
	function getCommandesAbandonnees()
		{
		$requete = "SELECT ID FROM boutique_obj_commande 	
								WHERE statut IN ('abandonnee', 'non validee') 
								AND ID_client = '".$this->ID."'
								ORDER BY dateCommande DESC";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_commande($ligne['ID']);
			}
		return ($resultats);
		}


	/**
	* R�cup�rer les ID des commandes abandonn�es (abandonnee)
	* @param
	* @return ID commande
	*/
	function setCommandesAbandonnees()
		{
		$requete = "UPDATE `boutique_obj_commande` 
								SET `statut`= 'abandonnee' 
								WHERE `statut` = 'validee' and `dateCommande` < DATE_SUB(NOW(), INTERVAL 1 MONTH)";
		T_LAETIS_site::requeter($requete);
		}


	/**
	* Generer un Mot De Passe
	* Le mot de passe est compos� en alternant des consonnes et des voyelles
	* (plus facilement m�morisable)
	* @param
	* @return Mot De Passe
	*/
	function genererMotDePasse()
		{
		// Nombre de caract�res dans le mot de passe
		$longueur = 6;
		$consonnes = "bcdfghjklmnpqrstvwxz";
		$voyelles = "aeiouy";

		$mdp='';
		for ($i=0; $i<$longueur; $i++)
			{
			// L'op�rateur % permet le changement entre voyelle et consonne
			if (($i % 2) == 0)
				{
				$mdp = $mdp.substr($voyelles, rand(0,strlen($voyelles)-1), 1);
				}
			else
				{
				$mdp = $mdp.substr($consonnes, rand(0,strlen($consonnes)-1), 1);
				}
			} // FIN for ($i=0; $i<$longueur; $i++)
		return $mdp;
		}


	/**
	* private
	* Envoi par email login pass
	* @param
	* @return
	*/
	function envoyerLogin($new_pwd = false)
		{

                if($new_pwd){
                    $new_pwd_generate = $this->genererMotDePasse();

                    $this->motDePasse = $new_pwd_generate;


                    $requete = "UPDATE `boutique_obj_client` SET `motDePasse`= MD5('". $this->motDePasse ."') WHERE `emailFacturation` = '".$this->emailFacturation."'";
                    T_LAETIS_site::requeter($requete);
                }


		// Pr�paration du courrier
		$pageSource = "/boutique/fr/emails/envoi-codes/envoi-codes-v2.php";
		$post="login=".$this->emailFacturation."&motDePasse=".$this->motDePasse."&email=".$this->emailFacturation;

		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, "https://".$_SERVER['HTTP_HOST'].$pageSource);
		curl_setopt($curl, CURLOPT_HEADER, 0); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_POST, 1); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        $contenu = curl_exec($curl);
		curl_close($curl);
		if(!$contenu){
			echo "Erreur d'envoi du mail";
		}
		// old 
		/*
		$header="POST /".$pageSource."   HTTP/1.0\r\n";
		$header.="Host: ".$_SERVER['HTTP_HOST']."\r\n";
		$header.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header.= "Content-Length: ".strlen($post)."\r\n";
		$header.= "\r\n";
		$header.= $post."\r\n";
		$header.= "\r\n";

		// $stream = fsockopen($_SERVER['SERVER_ADDR'], 80, $errno, $errstr,30);
		$stream = fsockopen($_SERVER['SERVER_ADDR'], 443, $errno, $errstr,30);
		if(!$stream)
			{
			echo "$errstr ($errno)<br>\n";
			exit($_SERVER[HTTP_HOST].' erreur socket fsockopen');
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
			// On vire la reponse http ==> on commente ce qu'il y a avant le <html>
			$contenu = str_replace("<html","--><html ",$contenu);
			$contenu = str_replace("<HTML","--><HTML ",$contenu);
			fclose($stream);
			}
				*/
		
		$contenuTexte='Login : '.$this->emailFacturation.' Mot de passe : '.$this->motDePasse;

		// Envoi du message
		$obj_mail = new htmlMimeMail();
		$obj_mail->setFrom('contact@fraish.fr');
		//$obj_mail->setFrom('technique@couleur-citron.com');
		$obj_mail->setSubject("Vos identifiants fraish.fr");
		$obj_mail->setHtml($contenu,$contenuTexte,'../../../boutique/fr/emails/envoi-codes/');
		// Envoi � l'utilisateur
		$callback = $obj_mail->send(array($this->emailFacturation),'smtp');
		
		return $contenu;
		} // FIN function envoyerLogin($valeurs)
		
		
		/**
	* private
	* Envoi par email login pass
	* @param
	* @return
	*/
	function envoyerLoginInscription()
		{
		// Pr�paration du courrier
		$pageSource = "/boutique/fr/emails/envoi-codes/envoi-codes-inscription.php";

		$pointDeVente = new Tbq_user($this->ID_pointDeVentePrefere);

		$post="login=".$this->emailFacturation."&motDePasse=".$this->motDePasse."&email=".$this->emailFacturation."&nom=".$this->nomFacturation."&prenom=".$this->prenomFacturation."&dateNaissance=".$this->dateDeNaissance."&telephone=".$this->telFacturation."&societe=".$this->societe."&adresse=".$this->adresseFacturation."&adresse2=".$this->adresseFacturation2."&codePostal=".$this->codePostalFacturation."&ville=".$this->villeFacturation."&pointDeVentePrefere=".$pointDeVente->pointDeVente."&codeEntreprise=".$this->codeEntreprise;
		$header="POST /".$pageSource."   HTTP/1.0\r\n";
		$header.="Host: ".$_SERVER['HTTP_HOST']."\r\n";
		$header.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header.= "Content-Length: ".strlen($post)."\r\n";
		$header.= "\r\n";
		$header.= $post."\r\n";
		$header.= "\r\n";

		$stream = fsockopen($_SERVER['SERVER_ADDR'], 80, $errno, $errstr,30);
		if(!$stream)
			{
			echo "$errstr ($errno)<br>\n";
			exit($_SERVER[HTTP_HOST].' erreur socket fsockopen');
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
			// On vire la reponse http ==> on commente ce qu'il y a avant le <html>
			$contenu = str_replace("<html","--><html ",$contenu);
			$contenu = str_replace("<HTML","--><HTML ",$contenu);
			fclose($stream);
			}

		$contenuTexte='Login : '.$this->emailFacturation.' Mot de passe : '.$this->motDePasse;

		// Envoi du message
		$obj_mail = new htmlMimeMail();
		$obj_mail->setFrom('fraishlabege@gmail.com');
		$obj_mail->setSubject("Vos codes d'acc�s client au site fraish.fr");
		$obj_mail->setHtml($contenu,$contenuTexte,'../../../boutique/fr/emails/envoi-codes/');

		// Envoi � l'utilisateur
		$obj_mail->send(array($this->emailFacturation),'smtp');

		return $contenu;
		} // FIN function envoyerLogin($valeurs)

	function peutCommander()
		{
		$retour = true;
		if($this->soldeCompte<0)
			{
			$retour = false;
			}
		return($retour);
		}
	function getMontantCommandesAvecCredit()
		{
		$requete = "SELECT SUM(prix) as montant
					FROM boutique_obj_commande
					WHERE ID_typ_paiement=5
					AND ID_client = '".$this->ID."'
					AND statut IN ('en_cours','livree')";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['montant']);
		}
	function debiterSoldeCompte($montant)
		{
		$requete = "UPDATE boutique_obj_client SET soldeCompte = soldeCompte - ".$montant."
					WHERE ID = '".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		}
	function setPointDeVentePrefere($ID_pointDeVente)
		{
		$requete ="UPDATE boutique_obj_client 
					SET ID_pointDeVentePrefere='".$ID_pointDeVente."'
					WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		}
	function getIDClientFavori()
		{
		$requete = "SELECT ID FROM boutique_obj_client_favori_v2
					WHERE ID_client='".$this->ID."'";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['ID']);
		}
	function getTailleFavori()
		{
		$requete = "SELECT taille FROM boutique_obj_client_favori_v2
					WHERE ID_client = '".$this->ID."'";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['taille']);
		}
	function getPointLivraisonFavori()
		{
		$requete = "SELECT ID_pointLivraison
					FROM boutique_obj_client_favori_v2
					WHERE ID_client = '".$this->ID."'";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['ID_pointLivraison']);
		}
	function getPointVenteFavori()
		{
		$requete = "SELECT ID_pointDeVente
					FROM boutique_obj_client_favori_v2
					WHERE ID_client = '".$this->ID."'";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['ID_pointDeVente']);
		}
	function getNbInscriptions($y,$m,$ID_pointDeVente)
		{
		if(strlen($m)==1)
			{
			$m='0'.$m;
			}
		$requete = "SELECT COUNT(ID) as nb
				FROM boutique_obj_client 
				WHERE dateInscription LIKE ('".$y."-".$m."%')"
				;
				//AND ID_pointDeVentePrefere = '".$ID_pointDeVente."'"
				//echo $requete;
		$resSql = T_LAETIS_site::requeter($requete);
		return ($resSql[0]['nb']);
		}
	function getNbInscriptionsSelonJour($date)
		{
		$requete = "SELECT COUNT(ID) as nb
				FROM boutique_obj_client 
				WHERE dateInscription LIKE ('".$date."%')"
				;
		$resSql = T_LAETIS_site::requeter($requete);
		return ($resSql[0]['nb']);
		}
	}
?>