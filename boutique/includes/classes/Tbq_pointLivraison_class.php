<?
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

class Tbq_pointLivraison
	{	

	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	/**
	* Identifiant du point de vente où seront préparés les menus pour le point de livraison en cours
	*/
	var $ID_pointDeVente;
	var $nom;
	var $adresse1;
	var $adresse2;
	var $codePostal;
	var $ville;

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tbq_client l'objet créé
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;		
		if($ID>0)
			{
			$requete = "SELECT * FROM boutique_obj_pointLivraison WHERE ID='".$this->ID."'";			
			$resultats = T_LAETIS_site::requeter($requete);
			$this->initialiser($resultats[0]);
			}
		}


	function initialiser($enregistrement)
		{
		/*//si on a donné un parametre, on instancie par rapport à la base
		if ( $this->ID>0 )
			{
			// initialisation de l'objet
			$requete = "SELECT * FROM boutique_obj_pointLivraison WHERE ID='".$this->ID."'";
			$resultats = T_LAETIS_site::requeter($requete);
			if ($resultats[0])
				{
				foreach ($resultats[0] as $nomChamp => $valeur)
					{
					$this->$nomChamp = stripslashes($valeur);
					}
				}
			}*/
		// Si on a donné un parametre, on instancie par rapport a la base
		foreach ($enregistrement as $nomChamp => $valeur)
			{
			$this->$nomChamp = stripslashes($valeur);
			}
		return $this;
		}


	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tbq_client l'objet créé
	* @see Tbq_client::__construct()
	* @access  public 
	*/
	function Tbq_pointLivraison($ID = 0)
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
		T_LAETIS_site::modifierAttributs($valeurs);
		
		//si l'ID est renseigné, on modifie, sinon, on insere
		$attributs = get_object_vars($this);
		// on donne les champs à mettre à jour (meme syntaxe pour le UPDATE et le INSERT)
		$contenuRequete = "";
		$champsNonEnregistres = array('');
		
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
			$requete = "UPDATE boutique_obj_pointLivraison SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_pointLivraison SET ";
			$requete .= $contenuRequete;
			T_LAETIS_site::requeter($requete);
			$this->ID = T_LAETIS_site::last_insert_id();
			}
		} // FIN function enregistrer()
		


	/** 
	* Liste les clients
	* @access  public 
	*/   
	function lister()
		{		
		$resultats = array();
		$requete = "SELECT ID FROM boutique_obj_pointLivraison ORDER BY nom ASC";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_pointLivraison($ligne['ID']);
			}			
		return ($resultats);
		}
	
	function getEntreprisesSelonPointLivraison()
		{
		$resultats = array();
		$requete = "SELECT * FROM boutique_obj_entreprise
					WHERE ID_pointLivraison = '".$this->ID."'";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach($resSql as $ligne)
			{
			$resultats[] = Tbq_entreprise::initialiser($ligne);
			}
		return($resultats);
		}
	function getNom($ID)
		{
		$requete = "SELECT nom FROM boutique_obj_pointLivraison
					WHERE ID='".$ID."'";
		$resSql = T_LAETIS_site::requeter($requete);
		return($resSql[0]['nom']);
		}
	}
?>