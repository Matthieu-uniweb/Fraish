<?

class Recherche extends T_LAETIS_site
{

/* Définition des attributs */
var $requete;
var $conf;

/* Définition des variables globales */
var $result;
var $motsVides;


function Recherche($req)
	{
	$confi = new Configuration();
	$this->setConfiguration($confi);
	$conf = $this->getConfiguration();
	
	// Récupération de la liste de mots vides
	$this->motsVides = $conf->getMotsVides();
	
	$this->setRequete($req);
	}

function getRequete()
	{
	return $this->requete;
	}
	
function setRequete($requete)
	{
	$this->requete=$requete;
	}
	
function getConfiguration()
	{
	return $this->conf;
	}
	
function setConfiguration($conf)
	{
	$this->conf=$conf;
	}

function filtrageMotStopList($mot)
	{
	if ($mot)
		{ return ( !(eregi($mot, $this->motsVides))); }
	return false;
	}
	
function traitementRequete()
	{
	$requete = $this->getRequete();
	$retour = array();
	
	$requete = strtolower($requete); 					// on passe les mots recherchés en minuscules   
	$requete = str_replace("+", "", trim($requete)); 	// on remplace les + par des espaces
	$requete = str_replace("\"", "", $requete); 		// on remplace les " par des espaces
	$requete = str_replace(",", "", $requete); 			// on remplace les , par des espaces
	$requete = str_replace(":", "", $requete); 			// on remplace les : par des espaces
	$requete = str_replace("%", " ", $requete); 		// on remplace les % par des espaces
	$requete = str_replace("'", " ", $requete); 		// on remplace les ' par des espaces
	$requete = str_replace("/", " ", $requete); 		// on remplace les / par des espaces
	$requete = str_replace(";", " ", $requete); 		// on remplace les ; par des espaces

	// on remplace le caractère joker par %
	// Ainsi, lors de la requete SQL, on aura LIKE 'mot%'
	$requete = str_replace("*", "%", $requete);
	
	$requete = trim(stripslashes($requete));	
	
	$tab = explode(" " , $requete); 					// on place les differents mots dans un tableau
	
	foreach ($tab as $a)
		{
		if ($this->filtrageMotStopList($a))
			{
			array_push($retour, $a);
			}            
		}
	$nb = count($retour); 								// on compte le nbr d'élément du tableau.
	
	return $retour;
	}

function selectionBDD($au_moins_un_mot, $langue, $date)
	{
	$conf = $this->getConfiguration();
	
	// Nom de la table
	$tableFichier = $conf->getNomTableFichier();
	$tableMotFichier = $conf->getNomTableMotFichier();
	
	// Nombre de résultats pouvant être affichés sur la meme page
	$limit = $conf->getResultatsNbResultatsParPage();
	
	// Option de tri
	$tri = $conf->getRequeteTri();
	
	$requete = $this->getRequete();
	$tabreq = $this->traitementRequete();
	$nb = count($tabreq);
	
	// La case de recherche d'au moins un des mots a été cochée
	if ($au_moins_un_mot == 1)
		{
		$reqmoins = "SELECT DISTINCT(cheminFichier), mot, IDFichier, poids, titrePage, description, dateDerniereModif ";
		$reqmoins = $reqmoins."FROM $tableFichier, $tableMotFichier";
		
		$reqmoins = $reqmoins." WHERE (mot LIKE '$tabreq[0]' ";
		
		// On boucle pour integrer tous les mots dans la requête	
		for ($j=1; $j < $nb; $j++)
			{
			$reqmoins = $reqmoins."OR mot LIKE '$tabreq[$j]' ";
			}
		
		$reqmoins = $reqmoins.") AND IDFichier=$tableFichier.ID ";
		
		if ($langue != "")
			{
			$reqmoins = $reqmoins."AND $tableFichier.langue = '$langue' ";
			}
		
		if ($date != "")
			{
			$datecourante = date("Ym");
			$reqmoins = $reqmoins."AND PERIOD_DIFF('$datecourante', $tableFichier.dateDerniereModif) < $date ";
			}
		
		$reqmoins = $reqmoins." ORDER BY ( ";
		if ($tri == "date")
			{
			$reqmoins = $reqmoins."dateDerniereModif";
			}
		else
			{
			$reqmoins = $reqmoins."poids";
			}
		$reqmoins = $reqmoins.") DESC";
		
		$this->result = $this->query($reqmoins);
		//echo "La requete SQL 1 execute est : $reqmoins" ;		
		}
	else
	{						
	// On prépare la requête SQL.
	$i=0;
	$req = "SELECT DISTINCT(cheminFichier), M$i.mot, M$i.IDFichier, M$i.poids ";
	
	for ($k=1; $k < $nb; $k++)
		{
		$req = $req." + M$k.poids";
		}
	
	$req = $req.", titrePage, description, dateDerniereModif FROM $tableFichier, $tableMotFichier AS M$i ";
	
	// On boucle pour integrer tous les mots dans la requête	
	for ($j=1; $j < $nb; $j++)
		{
		$req = $req."INNER JOIN $tableMotFichier AS M$j ON (M$i.IDFichier=M$j.IDFichier AND M$j.mot LIKE '$tabreq[$j]') ";
		}
	
	$req = $req."WHERE M$i.mot LIKE '$tabreq[$i]' AND M$i.IDFichier=$tableFichier.ID ";
	
	if ($langue != "")
		{
		$req = $req."AND $tableFichier.langue = '$langue' ";
		}
	
	if ($date != "")
		{
		$datecourante = date("Ym");			
		$req = $req."AND PERIOD_DIFF('$datecourante', $tableFichier.dateDerniereModif) < $date ";
		}
	
	$req = $req." ORDER BY ( ";
	
	if ($tri == "date")
		{
		$req = $req."dateDerniereModif";
		}
	else
	{
	$req = $req."M$i.poids";		
	for ($k=1; $k < $nb; $k++)
		{
		$req = $req." + M$k.poids";
		}
	}
	$req = $req.") DESC";
	
	// on execute la requête SQL.
	$this->result = $this->query($req);
	
	//echo "La requete SQL 2 execute est : $req" ;
	}		
	
	if ($conf->getRequeteLog() == true)
	{
	$this->enregistreLog($requete);
	}
	
	return $this->result;
	}

function enregistreLog($requete)
	{
	$req = "SELECT ID FROM moteur_recherche_statistiques WHERE requete='$requete' AND pageVisitee='total'";
	$result = $this->query($req);
	$nb = $result->numRows();	
	
	if ($nb != 0)
		{
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$id = $row["ID"];
		$requpd = "UPDATE moteur_recherche_statistiques SET nbOccurences = nbOccurences + 1, derniereDate = CURDATE() WHERE ID = '$id' AND pageVisitee='total'";
		$resultupd = $this->query($requpd);
		}
	else
		{
		$reqajout = "INSERT INTO moteur_recherche_statistiques (requete, nbOccurences, derniereDate, pageVisitee) VALUES ('$requete', 1, CURDATE(), 'total')";
		$resultajout = $this->query($reqajout);
		}
	}

function statistiques()
	{
	}
}
?>