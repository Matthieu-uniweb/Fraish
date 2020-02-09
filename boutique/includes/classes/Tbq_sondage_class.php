<?
   /**
   *  Classe de gestion des sondages
   *
   * Permet de créer, modifier, supprimer des menus du jour, en intéraction 
   * avec la base de données
   *
   * @author Pierre Carayol
   * @version 1.0
   * @access public
   * @copyright Laëtis Créations Multimédias
   * @date 2010-12-09
   */

class Tbq_sondage
	{	

	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;
	var $question;
	var $reponse1;
	var $reponse2;
	var $reponse3;
	var $actif;

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
			$requete = "SELECT * FROM obj_sondage WHERE ID='".$this->ID."'";
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
	function Tbq_sondage($ID = 0)
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
			$requete = "UPDATE obj_sondage SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO obj_sondage SET ";
			$requete .= $contenuRequete;
			$resSql = T_LAETIS_site::requeter($requete);
			$this->ID = T_LAETIS_site::last_insert_id();
			}
		return($resSql);
		} // FIN function enregistrer()

	/**
	* Enregistre les réponses du sondage données par le client lors de la commande
	*/
	function enregistrerReponses($tabSondages,$tabReponses)
		{
		/*print_r($tabSondages);
		print_r($tabReponses);
		exit;*/
		if($tabSondages && $tabReponses)
			{
			foreach($tabSondages as $key=>$valeur)
				{
				if($tabReponses[$valeur])
					{
					$requete = "INSERT INTO rel_sondage_client
								SET ID_sondage='".$valeur."',
								ID_client='".$_SESSION['ID_client']."',
								reponse='".$tabReponses[$valeur]."',
								dateReponse = NOW()";
					T_LAETIS_site::requeter($requete);
					}
				}
			}
		}
	/**
	* Liste les opérations d'approvisionnement du client $ID_client
	*/
	function lister()
		{	
		$requete = "SELECT obj_sondage.*
					FROM obj_sondage";

		$resSql = T_LAETIS_site::requeter($requete);

		foreach($resSql as $ligne)
			{
			$resultats[] = Tbq_sondage::initialiser($ligne);
			}
		return($resultats);
		}
	/**
	* Liste les questions actives pour lesquelles le client n'a jamais répondu
	*/
	function listerQuestionsActives()
		{
		$requete = "SELECT obj_sondage.*
					FROM obj_sondage
					WHERE obj_sondage.actif=1";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach($resSql as $ligne)
			{
			if(!Tbq_sondage::clientARepondu($ligne['ID']))
				{
				$resultats[] = Tbq_sondage::initialiser($ligne);
				}
			}
		return($resultats);
		}
		
	function basculerEtat()
		{
		$etat = 0;
		if($this->actif==0)
			{
			$etat=1;
			}
		$requete = "UPDATE obj_sondage
					SET actif='".$etat."'
					WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		}
	function getResultats()
		{
		//récupérer le nombre de clients ayant répondu
		$requete = "SELECT COUNT(ID) as nbReponses
					FROM rel_sondage_client
					WHERE ID_sondage='".$this->ID."'";
		$resSql = T_LAETIS_site::requeter($requete);
		$resultats['nbReponsesTotal'] = $resSql[0]['nbReponses'];
		//récupérer le nombre de réponses 1
		$requete = "SELECT IFNULL(COUNT(ID),0) as nbReponses
					FROM rel_sondage_client
					WHERE ID_sondage='".$this->ID."'
					AND reponse = 'reponse1'";
		$resSql = T_LAETIS_site::requeter($requete);
		$resultats['nbReponses1'] = $resSql[0]['nbReponses'];
		$resultats['ratioReponses1'] = @($resultats['nbReponses1']/$resultats['nbReponsesTotal'])*100;
		//récupérer le nombre de réponses 2
		$requete = "SELECT IFNULL(COUNT(ID),0) as nbReponses
					FROM rel_sondage_client
					WHERE ID_sondage='".$this->ID."'
					AND reponse = 'reponse2'";
		$resSql = T_LAETIS_site::requeter($requete);
		$resultats['nbReponses2'] = $resSql[0]['nbReponses'];
		$resultats['ratioReponses2'] = @($resultats['nbReponses2']/$resultats['nbReponsesTotal'])*100;
		//récupérer le nombre de réponses 3
		$requete = "SELECT IFNULL(COUNT(ID),0) as nbReponses
					FROM rel_sondage_client
					WHERE ID_sondage='".$this->ID."'
					AND reponse = 'reponse3'";
		$resSql = T_LAETIS_site::requeter($requete);
		$resultats['nbReponses3'] = $resSql[0]['nbReponses'];
		$resultats['ratioReponses3'] = @($resultats['nbReponses3']/$resultats['nbReponsesTotal'])*100;
		return($resultats);
		}
	function clientARepondu($ID_sondage)
		{
		$retour = false;
		$requete = "SELECT ID FROM rel_sondage_client
					WHERE ID_client='".$_SESSION['ID_client']."'
					AND ID_sondage = '".$ID_sondage."'";
		$resSql = T_LAETIS_site::requeter($requete);
		if($resSql[0]['ID'])
			{
			$retour = true;
			}
		return($retour);
		}
	/** 
	* Supprime l'objet en base de donnée
	* @access  public 
	*/
	function supprimer()
		{
		//supprime les résultats
		$requete = "DELETE FROM rel_sondage_client
					WHERE ID_sondage = '".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		//supprime le sondage
		$requete = "DELETE FROM obj_sondage
					WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		$this->ID = 0;
		
		$requete = "OPTIMIZE TABLE obj_sondage, rel_sondage_client";
		T_LAETIS_site::requeter($requete);
		}
	}
?>