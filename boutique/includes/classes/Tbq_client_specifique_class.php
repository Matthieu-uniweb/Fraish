<?php
/**
   *  Classe de gestion des clients de la boutique
   *
   * Permet de créer, modifier, supprimer des rubriques, en intéraction 
   * avec la base de données
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright Laëtis Créations Multimédias
	 * @date 2007-11-12
   */

class Tbq_client_specifique
	{	

	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;

	/** 
	* @var string $titre Nom de la rubrique
	* @access  private 
	*/
	var $ID_client;

	/** 
	* @var string $titre Nom de la rubrique
	* @access  private 
	*/
	var $aime;

	/** 
	* @var string $titre Prenom de la rubrique
	* @access  private 
	*/
	var $moyen;

	/** 
	* @var string $titre Nom de la rubrique
	* @access  private 
	*/
	var $deteste;


	function Tbq_client_specifique ($ID=0)
	{
		$this->__construct($ID);
	}	
	
	/**
	* Constructeur
	* Constructeur PHP5
	*
	* @param entier $ID Par défaut 0
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
	* L'initialisation se fait à partir de l'ID
	*
	* @author Christophe Raffy
	*/
	function initialiser()
		{
		if ( $this->ID>0 )
			{
			// initialisation de l'objet
			$requete = "SELECT * FROM boutique_obj_client_specifique WHERE ID='".$this->ID."'";
			$resultats = T_LAETIS_site::requeter($requete);
			foreach ($resultats[0] as $nomChamp => $valeur)
				{
				$this->$nomChamp = stripslashes($valeur);
				}
			}
		} // FIN function initialiser()


	/** 
	* Enregistre l'objet en BD
	* Les attributs doivent être remplis
	* 
	* @author Christophe Raffy
	*/
	function enregistrer($valeurs)
		{
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
			$requete = "UPDATE boutique_obj_client_specifique SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_client_specifique SET ";
			$requete .= $contenuRequete;
			T_LAETIS_site::requeter($requete);
			$this->ID = T_LAETIS_site::last_insert_id();
			}
		} // FIN function enregistrer()
		
		
		function detailClient($ID_client)
		{
			$requete = "SELECT * FROM boutique_obj_client_specifique WHERE ID_client='".$ID_client."'";
			$resultats = T_LAETIS_site::requeter($requete);
			return ($resultats[0]);
		} // FIN function initialiser()
		
		function listerGout($ID_client)
		{
			$requete = "SELECT * FROM boutique_obj_client_specifique 
							WHERE ID_client='".$ID_client."'
							ORDER BY ID DESC";
			$resultats = T_LAETIS_site::requeter($requete);
			return ($resultats);
		} // FIN function initialiser()
		
		function listerTousClient()
		{
			$requete = "SELECT * FROM boutique_obj_client_specifique 
							ORDER BY ID DESC";
			$resultats = T_LAETIS_site::requeter($requete);
			return ($resultats);
		} // FIN function initialiser()


	function nbClientsInterroges($ID_pointDeVente)
		{
		$requete = "SELECT boutique_obj_client_specifique.ID_client  
								FROM boutique_obj_client_specifique, boutique_obj_commande 
								WHERE boutique_obj_commande.ID_pointDeVente = '".$ID_pointDeVente."' 
								AND (aime != '' OR moyen != '' OR deteste != '') 
								AND boutique_obj_client_specifique.ID_client = boutique_obj_commande.ID_client 
								GROUP BY boutique_obj_client_specifique.ID_client";
		$ligne = T_LAETIS_site::requeter($requete);
		return count($ligne);
		}
		
			
	function statsPreferences($ID_pointDeVente)
		{
		$requete = "SELECT * FROM boutique_obj_client_specifique, boutique_obj_commande 
								WHERE boutique_obj_commande.ID_pointDeVente = '".$ID_pointDeVente."' 
								AND boutique_obj_client_specifique.ID_client = boutique_obj_commande.ID_client
								GROUP BY boutique_obj_client_specifique.ID_client";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats['aime'] .= $ligne['aime'];
			$resultats['moyen'] .= $ligne['moyen'];
			$resultats['deteste'] .= $ligne['deteste'];
			}
		$resultats['aime']=explode(', ', $resultats['aime']);
		$resultats['moyen']=explode(', ', $resultats['moyen']);
		$resultats['deteste']=explode(', ', $resultats['deteste']);
		
		return ($resultats);
		} // FIN function statsPreferences()

	}
?>