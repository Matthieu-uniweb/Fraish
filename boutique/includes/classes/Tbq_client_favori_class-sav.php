<?php
/**
   *  Classe de gestion des menus favoris des clients
   *
   * Permet de créer, modifier, supprimer des commandes, en intéraction 
   * avec la base de données
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright Laëtis Créations Multimédias
	 * @date 2008-09-10
   */

class Tbq_client_favori
	{

	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var int $ID_client ID du client qui commande
	* @access  private 
	*/
	var $ID_client;

	/** 
	* @var int $ID_pointDeVente ID du point de vente où le client veut commander
	* @access  private 
	*/
	var $ID_pointDeVente;

	/** 
	* @var int $ID_client ID du client qui commande
	* @access  private 
	*/
	var $typePlat;
	
	
	/** 
	* @var int $ID_client ID du client qui commande
	* @access  private 
	*/
	var $plat;

	/** 
	* @var int $ID_client ID du client qui commande
	* @access  private 
	*/
	var $vinaigrette;

	/** 
	* @var int $ID_client ID du client qui commande
	* @access  private 
	*/
	var $typeBoisson;

	/** 
	* @var int $ID_client ID du client qui commande
	* @access  private 
	*/
	var $boisson;

	/** 
	* @var int $ID_client ID du client qui commande
	* @access  private 
	*/
	var $pain;

	/** 
	* @var int $ID_client ID du client qui commande
	* @access  private 
	*/
	var $taille;


	/**
	* Constructeur
	* Constructeur PHP4
	*
	* @param entier $ID Par défaut 0
	* @author Christophe Raffy
	*/
	function Tbq_client_favori ($ID=0)
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
			$requete = "SELECT * FROM boutique_obj_client_favori WHERE ID='".$this->ID."'";
			$resultats = T_LAETIS_site::requeter($requete);
			foreach ($resultats[0] as $nomChamp => $valeur)
				{
				$this->$nomChamp = stripslashes($valeur);
				}
			}
		} // FIN function initialiser()


		/** 
	* Supprime l'objet de la BD
	* @author Christophe Raffy
	*/
	function supprimer()
		{
		$requete = "DELETE FROM boutique_obj_client_favori WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		
		$this->ID = 0;
		}


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
			$requete = "UPDATE boutique_obj_client_favori SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{			
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_client_favori SET ";
			$requete .= $contenuRequete;
			T_LAETIS_site::requeter($requete);
			$this->ID = T_LAETIS_site::last_insert_id();
			}		
		} // FIN function enregistrer()
				

	function lister()
		{
		$resultats = array();
		$requete = "SELECT ID FROM boutique_obj_client_favori ORDER BY ID_client ASC";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_client_favori($ligne['ID']);
			}			
		return ($resultats);
		} // FIN function lister()
		

	/** 
	* Retour le menu favori du client passé en argument
	* ID_client int ID du client
	* 
	* @author Christophe Raffy
	*/
	function getMenuFavori($ID_client)
		{
		$requete = "SELECT ID FROM boutique_obj_client_favori 
								WHERE ID_client = '".$ID_client."'";
		$resSql = T_LAETIS_site::requeter($requete);		
		$resultats = new Tbq_client_favori($resSql[0]['ID']);
		return $resultats;
		} // FIN function getMenuFavori($ID_client)


	}
?>