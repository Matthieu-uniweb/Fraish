<?
/**
* Classe permettant la recherche ou l'affichage de listes
*
* @author  Christophe Raffy <christophe.raffy@laetis.fr>
*/
class Tannuaire_moteur_recherche extends T_LAETIS_site
	{

	/** 
	* Nombre de r�ponse par page pour les contacts
	*/
	var $nombreReponseParPage = 10;
	
	/** 
	* Num�ro de la page en cours
	*/
	var $numeroPage;
	
	/** 
	* Nombre total de pages
	*/
	var $nombreTotalPage;
	
	/** 
	* Nombre total de r�ponses
	*/
	var $nombreReponses;
	

	/** 
	* Alias du constructeur (compatibilit� PHP4)
	* @param int $ID (facultatif) ID de l'element � initialiser (si non renseign�, aucune initialisation)
	* @return Tannuaire_moteur_recherche l'objet cr��
	* @see Tannuaire_moteur_recherche::__construct()
	* @access  public 
	*/
	function Tannuaire_moteur_recherche($ID = 0)
		{
		$this->__construct($ID);
		}

	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element � initialiser (si non renseign�, aucune initialisation)
	* @return Tannuaire_moteur_recherche l'objet cr��
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		}

	/** 
	* Renvoie le num�ro de la page en cours
	* @return int Le num�ro de la page en cours
	* @access  public 
	*/
	function getNumeroPage()
		{
		return $this->numeroPage;
		}

	/** 
	* Renvoie le nombre total de pages
	* @return int Le nombre total de pages
	* @access  public 
	*/
	function getNombreTotalPage()
		{
		return $this->nombreTotalPage;
		}

	/** 
	* Renvoie le nombre total de r�ponses
	* @return int Le nombre total de r�ponses
	* @access  public 
	*/
	function getNombreReponses()
		{
		return $this->nombreReponses;
		}

	/** 
	* Initialise la recherche - Appel�e la premi�re fois
	* @param string $query Requete de recherche
	* @access  public 
	*/
	function initialiserRecherche($query)
		{
		$res=$this->query($query);
		if ($res->numRows())
			{	$this->nombreTotalPage=ceil($res->numRows()/$this->nombreReponseParPage);	}
		else
			{	$this->nombreTotalPage=1;	}
		$this->nombreReponses=$res->numRows();
		$res->free();
		}

	/** 
	* Fonction de redirection vers les pages de la recherche
	* @param string $valeurs Les variables POST
	* @param string $query La requete de recherche
	* @return string $limit La fin de la requete de recherche LIMIT
	* @access  public 
	*/
	function creerLimite($valeurs,$query)
		{
		$limit="";
		switch ($valeurs['fonction'])
			{
			case "pagePrecedente":
				$this->numeroPage=$valeurs['numeroPage']-1;
				$limit=" LIMIT ".(($this->numeroPage-1)*$this->nombreReponseParPage)." , ".$this->nombreReponseParPage;
				$this->nombreTotalPage=$valeurs['nombreTotalPage'];
				$this->nombreReponses=$valeurs['nombreReponses'];
				break;
			case "pageSuivante":
				$this->numeroPage=$valeurs['numeroPage']+1;
				$limit=" LIMIT ".(($this->numeroPage-1)*$this->nombreReponseParPage)." , ".$this->nombreReponseParPage;
				$this->nombreTotalPage=$valeurs['nombreTotalPage'];
				$this->nombreReponses=$valeurs['nombreReponses'];
				break;
			case "allerPage":
				$this->numeroPage=$valeurs['numeroPage'];
				$limit=" LIMIT ".(($this->numeroPage-1)*$this->nombreReponseParPage)." , ".$this->nombreReponseParPage;
				$this->nombreTotalPage=$valeurs['nombreTotalPage'];
				$this->nombreReponses=$valeurs['nombreReponses'];
				break;
			default:
				$this->initialiserRecherche($query);
				if ($valeurs['numeroPage'])
					{
					$this->numeroPage=$valeurs['numeroPage'];
					$limit=" LIMIT ".(($this->numeroPage-1)*$this->nombreReponseParPage)." , ".$this->nombreReponseParPage;					
					}
				else
					{
					$limit=" LIMIT 0 , ".$this->nombreReponseParPage;
					$this->numeroPage=1;
					}
				break;
			}
		return $limit;
		}

	}
?>