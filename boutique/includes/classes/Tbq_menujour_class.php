<?
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

class Tbq_menujour
	{	

	/** 
	* @var int $ID ID de l'element en base de donnée
	* @access  private 
	*/
	var $ID;

	/** 
	* @var int $ID_pointDeVente Point de vente qui propose ce menu du jour
	* @access  private 
	*/
	var $ID_pointDeVente;

	/** 
	* @var date $ingredients Ingredients du jour
	* @access  private 
	*/
	var $ingredients;

	/** 
	* @var date $dateJour Ingredients du jour
	* @access  private 
	*/
	var $dateJour;

	/** 
	* @var date $typeMenu Ingredients du jour
	* @access  private 
	*/
	var $typeMenu;


	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tbq_menujour l'objet créé
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;
		$this->initialiser($ID);
		}


	function initialiser($ID)
		{
		//si on a donné un parametre, on instancie par rapport à la base
		if ( $this->ID>0 )
			{
			// initialisation de l'objet
			$requete = "SELECT * FROM boutique_obj_menujour_v2 WHERE ID='".$this->ID."'";
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
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tbq_menujour l'objet créé
	* @see Tbq_menujour::__construct()
	* @access  public 
	*/
	function Tbq_menujour($ID = 0)
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
			$requete = "UPDATE boutique_obj_menujour_v2 SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_menujour_v2 SET ";
			$requete .= $contenuRequete;
			T_LAETIS_site::requeter($requete);
			$this->ID = T_LAETIS_site::last_insert_id();
			}
		} // FIN function enregistrer()


	/** 
	* Enregistre l'objet en base de donnée
	* Si l'ID est renseigné ==> modification
	* Sinon ==> insertion
	* @access  public 
	*/
	function enregistrerSelonJour($valeurs, $typeMenu, $ID_pointDeVente)
		{
		$requete = "SELECT ID FROM boutique_obj_menujour_v2 
								WHERE typeMenu = '".$typeMenu."' 
								AND dateJour = '".T_LAETIS_site::convertirDate($valeurs['dateJour'])."' 
								AND ID_pointDeVente = '".$ID_pointDeVente."' ";
		$resSql = T_LAETIS_site::requeter($requete);
		
		if ($resSql[0]['ID']>0)
			{
			// c'est un objet qui existe déjà en BD
			$requete = "UPDATE boutique_obj_menujour_v2 
									SET ingredients = '".$valeurs['ingredients']."' 
									WHERE typeMenu = '".$typeMenu."' 
									AND dateJour = '".T_LAETIS_site::convertirDate($valeurs['dateJour'])."' 
									AND ID_pointDeVente = '".$ID_pointDeVente."' ";
			T_LAETIS_site::requeter($requete);
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_menujour_v2 
									SET ingredients = '".$valeurs['ingredients']."', 
									typeMenu = '".$typeMenu."', 
									dateJour = '".T_LAETIS_site::convertirDate($valeurs['dateJour'])."', 
									ID_pointDeVente = '".$ID_pointDeVente."' ";
			T_LAETIS_site::requeter($requete);
			}
		} // FIN function enregistrer()



	/** retourne le plus vieille date **/
	function getMaxDateEnregistre (){
		$requete = "SELECT MAX(dateJour) as date FROM boutique_obj_menujour_v2";
		$res = T_LAETIS_site::requeter($requete);
		if (!$res)
			return false;
		return $res[0]['date'];
	}
	
	
	
	/** 
	* Récupère l'ingrédient du jour pour le menu passé en paramètre
	* @access  public 
	*/
	function getMenuJour($dateJour, $ID_PointDeVente, $typeMenu)
		{		
		$requete = "SELECT ingredients FROM boutique_obj_menujour_v2 
					WHERE dateJour='".T_LAETIS_site::convertirDate($dateJour)."' 
					AND typeMenu = '".$typeMenu."' 
					AND ID_pointDeVente = '".$ID_PointDeVente."'";
		//echo $requete;
		$resultats = T_LAETIS_site::requeter($requete);
		return ($resultats[0]['ingredients']);
		}

	/** 
	* Supprime l'objet en base de donnée
	* @access  public 
	*/
	function supprimer()
		{		
		$requete = "DELETE FROM boutique_obj_menujour_v2 WHERE ID='".$this->ID."'";
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
		$requete = "SELECT ID FROM boutique_obj_menujour_v2
								ORDER BY ID DESC";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_menujour($ligne['ID']);
			}			
		return ($resultats);
		}


	/** 
	* Liste les rubriques
	* @access  public 
	*/   
	function listerParDate($dateDebut, $dateFin, $typeMenu)
		{		
		$resultats = array();
		$requete = "SELECT * FROM boutique_obj_menujour_v2 
								WHERE dateJour >= '".$dateDebut."' AND dateJour <= '".$dateFin."' 
								AND typeMenu = '".$typeMenu."' 
								AND ID_pointDeVente = '".$_SESSION["sessionID_user"]."' 
								ORDER BY dateJour ASC";
		$resSql = T_LAETIS_site::requeter($requete);
		//echo $requete;
		foreach ($resSql as $ligne)
			{
			$resultats[T_LAETIS_site::convertirDate($ligne['dateJour'])] = $ligne;
			}			
		return ($resultats);
		}

	function estFeculentDuJour($feculent,$date, $ID_pointDeVente)
		{
		$retour = false;
		$date = T_LAETIS_site::convertirDate($date);
		$requete = "SELECT ingredients FROM boutique_obj_menujour_v2
					WHERE dateJour='".$date."'
					AND typeMenu = 'feculents'
					AND ID_pointDeVente='".$ID_pointDeVente."'";
					
		$resSql = T_LAETIS_site::requeter($requete);
		//echo $resSql[0]['ingredients'];
		if(ereg($feculent,$resSql[0]['ingredients']))
			{
			$retour = true;
			}
		return $retour;
		}
	
	function estLegumeDuJour($legume,$date, $ID_pointDeVente)
		{
		$retour = false;
		$date = T_LAETIS_site::convertirDate($date);
		$requete = "SELECT ingredients FROM boutique_obj_menujour_v2
					WHERE dateJour='".$date."'
					AND typeMenu = 'legumes'
					AND ID_pointDeVente='".$ID_pointDeVente."'";
					
		$resSql = T_LAETIS_site::requeter($requete);
		//echo $resSql[0]['ingredients'];
		if(ereg($legume,$resSql[0]['ingredients']))
			{
			$retour = true;
			}
		return $retour;
		}
	
	function estGraineDuJour($graine,$date, $ID_pointDeVente)
		{
		$retour = false;
		$date = T_LAETIS_site::convertirDate($date);
		$requete = "SELECT ingredients FROM boutique_obj_menujour_v2
					WHERE dateJour='".$date."'
					AND typeMenu = 'graines'
					AND ID_pointDeVente='".$ID_pointDeVente."'";
					
		$resSql = T_LAETIS_site::requeter($requete);
		//echo $resSql[0]['ingredients'];
		if(ereg($graine,$resSql[0]['ingredients']))
			{
			$retour = true;
			}
		return $retour;
		}
		
	function estDessertDuJour($dessert,$date, $ID_pointDeVente)
		{
		$retour = false;
		$date = T_LAETIS_site::convertirDate($date);
		$requete = "SELECT ingredients FROM boutique_obj_menujour_v2
					WHERE dateJour='".$date."'
					AND typeMenu = 'desserts'
					AND ID_pointDeVente='".$ID_pointDeVente."'";
					
		$resSql = T_LAETIS_site::requeter($requete);
		if(ereg($dessert,$resSql[0]['ingredients']))
			{
			$retour = true;
			}
		return $retour;
		}
	function getDescriptifMenusJour($ID_pointDeVente='')
		{
		$retour = "
		
		<table style='font-size:11px;'>";
		if($ID_pointDeVente==1 || !$ID_pointDeVente)
			{
		$retour.="
		<tr><td><table>
		<tr>
				<td><u>Menu du jour &agrave; Lab&egrave;ge :</u></td></tr>";
	   $labegeSoupeDaily=$this->getMenuJour(date('d-m-Y'),1,'soupe');
			$tbq_labegeSoupeDaily = new Tbq_ingredient();
			$tbq_labegeSoupeDaily->initialiser($labegeSoupeDaily);
			$labegeSoupeDaily = $tbq_labegeSoupeDaily->libelle.', '.$tbq_labegeSoupeDaily->details;
			
if($labegeSoupeDaily)
	{
    $retour .= "<tr><td><strong>Soupe Daily : </strong> ".$labegeSoupeDaily."</td></tr>";
	}
$labegeSoupeDiet=$this->getMenuJour(date('d-m-Y'),1,'soupeDiet');
	$tbq_labegeSoupeDiet = new Tbq_ingredient();
	$tbq_labegeSoupeDiet->initialiser($labegeSoupeDiet);
	$labegeSoupeDiet = $tbq_labegeSoupeDiet->libelle;
if($labegeSoupeDiet)
	{
    $retour.="<tr><td><strong>Soupe Diet : </strong> ".$labegeSoupeDiet.', '.$tbq_labegeSoupeDiet->details."</td></tr>";
	}
$labegeJus=$this->getMenuJour(date('d-m-Y'),1,'jus');
	$tbq_labegeJus = new Tbq_ingredient();
	$tbq_labegeJus->initialiser($labegeJus);
	$labegeJus = $tbq_labegeJus->libelle.', '.$tbq_labegeJus->details;
if($labegeJus)
	{
    $retour.="<tr><td><strong>DailyJuice : </strong> ".$labegeJus."</td></tr>";
	}
$labegeDessert=$this->getMenuJour(date('d-m-Y'),1,'desserts');
	$listeDessert = explode('|',$labegeDessert);
	$labegeDessert='';
	foreach($listeDessert as $itemDessert) {
		if($itemDessert!='') {
		$tbq_labegeDessert = new Tbq_ingredient();
		$tbq_labegeDessert->initialiser($itemDessert);
		$labegeDessert .= $tbq_labegeDessert->libelle.', ';
		}
	}
	$labegeDessert = substr($labegeDessert,0,-1);
if($labegeDessert)
	{
    $retour.="<tr><td><strong>Dessert : </strong> ".$labegeDessert."</td></tr>";
	}
/*$labegeDessert2=$this->getMenuJour(date('d-m-Y'),1,'desserts2');
if($labegeDessert2)
	{
    $retour.="<tr><td> Yaourt ".$labegeDessert2."</td></tr>";
	}*/
//$retour.="</td></tr></table></td>";
			}
	/*if($ID_pointDeVente==2 || !$ID_pointDeVente)
			{
$retour.="
<td>
<table><tr><td><u>Menu du jour aux Filatiers :</u></td></tr>";
$filatiersSoupeDaily=$this->getMenuJour(date('d-m-Y'),2,'soupe');
if($filatiersSoupeDaily)
	{
    $retour.="<tr><td><strong>Soupe Daily</strong> ".$filatiersSoupeDaily."</td></tr>";
	}
$filatiersSoupeDiet=$this->getMenuJour(date('d-m-Y'),2,'soupeDiet');
if($filatiersSoupeDiet)
	{
    $retour.="<tr><td><strong>Soupe Diet</strong> ".$filatiersSoupeDiet."</td></tr>";
	}
$filatiersJus=$this->getMenuJour(date('d-m-Y'),2,'jus');
if($filatiersJus)
	{
    $retour.="<tr><td><strong>DailyJuice</strong> ".$filatiersJus."</td></tr>";
	}
$filatiersDessert=$this->getMenuJour(date('d-m-Y'),2,'desserts');
if($filatiersDessert)
	{
    $retour.="<tr><td><strong>Dessert</strong> Yaourt ".$filatiersDessert."</td></tr>";
	}
$filatiersDessert2=$this->getMenuJour(date('d-m-Y'),2,'desserts2');
if($filatiersDessert2)
	{
    $retour.="<tr><td>Yaourt ".$filatiersDessert2."</td></tr>";
	}
			}*/
	$retour.="</table></td></tr></table>";
	return $retour;
		}
        
	}
	
?>