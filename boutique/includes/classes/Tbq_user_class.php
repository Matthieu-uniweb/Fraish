<?
/**
   *  Classe de gestion des administrateurs de la boutique
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

class Tbq_user
	{	

	/**
	 * Identifiant de l'utilisateur
	 * 
	 * @var integer 
	 */
	var $ID;

	/**
	 * Login mail de l'utilisateur
	 * 
	 * @var string 
	 */
	var $login;
	
	/**
	 * Mot de passe pour l'utilisateur
	 * 
	 * @var string 
	 */
	var $motDePasse;

	/**
	 * Point De Vente de l'utilisateur
	 * 
	 * @var string 
	 */
	var $pointDeVente;



	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element � initialiser (si non renseign�, aucune initialisation)
	* @return Tbq_user l'objet cr��
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
			$requete = "SELECT * FROM boutique_obj_user WHERE ID='".$this->ID."'";
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
	* @return Tbq_user l'objet cr��
	* @see Tbq_user::__construct()
	* @access  public 
	*/
	function Tbq_user($ID = 0)
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
		$champsNonEnregistres = array( "" );
		
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
			$requete = "UPDATE boutique_obj_user SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_user SET ";
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
		$requete = "DELETE FROM boutique_obj_user WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		$this->ID = 0;
		}


	/** 
	* Liste les rubriques
	* @access  public 
	*/   
	function lister()
		{		
		$resultats = array();
		$requete = "SELECT ID FROM boutique_obj_user";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_user($ligne['ID']);
			}			
		return ($resultats);
		}


	/**
	* V�rifier si le login et motDepasse correspondent � un utilisateur
	* @param
	* @return login pass par email
	*/
	function verifierLogin($valeurs)
		{
		$query = "SELECT * FROM boutique_obj_user	
							WHERE login = '".$valeurs['login']."' AND motDePasse = '".$valeurs['motDePasse']."'";
		$resultats = T_LAETIS_site::requeter( $query );
		return ($resultats[0]['ID']);
		} // FIN function verifierLogin($valeurs)


	/**
	* V�rifier si l'utilisateur est bien connect� � l'espace Pro
	* @param 
	* @return 
	*/
	function estConnecte()
		{
		if (! $_SESSION["sessionID_user"])
			{
			header("Location: /boutique/admin/index.php");
			}
		} // FIN function estConnecte()


	}
?>