<?

/* Définition des constantes */
define ("INDEXATION_MOIS", "*");
define ("INDEXATION_JOURMOIS", "*");
define ("INDEXATION_JOURSEM", "*");
define ("INDEXATION_HEURE", "*");
define ("INDEXATION_MINUTE", "*");
define ("INDEXATION_TYPE_FICHIER", ".html .htm .php");
define ("INDEXATION_REPERTOIRE_A_EXCLURE", "includes admin images _Laetis _TEMP _DOCUMENTATION Library Templates");
define ("INDEXATION_FICHIER_POINT", true);
define ("INDEXATION_REPERTOIRE_RACINE", $PHPRoot);
define ("INDEXATION_POIDS_TITLE", 3);
define ("INDEXATION_POIDS_NOM_FICHIER", 5);
define ("INDEXATION_TYPE_TITLE", true);
define ("INDEXATION_TYPE_CONTENU", true);
define ("FEUILLE_STYLE", "includes/plugins/moteur_recherche/includes/styles/style.css");
define ("INDEXATION_LOG", true);
define ("RESULTATS_NB_RESULTATS_PAR_PAGE", 10);
define ("REQUETE_LOG", true);
define ("REQUETE_TRI", "poids"); //date - poids
define ("NOM_TABLE_FICHIER", "moteur_recherche_fichier");
define ("NOM_TABLE_MOT_FICHIER", "moteur_recherche_motfichier");
define ("FICHIER_CONNEXION_BDD", "includes/bdd/bdd_connexion.php");
define ("MOTS_VIDES", " and or et ou le la les un une du de des a à au aux son sa ses ne ni non sauf ce ces cet je tu il elle on nous vous ils elles etc mon ma ton ta vos se y en ");
define ("REPERTOIRE_LOCAL", "levezou_viaur"); //le repertoire sur le serveur local laetis
define ("REPERTOIRE_DISTANT", "~".$BDD->DB_USER); //le repertoire (ou compte sur le serveur distant) par defaut le même que pour la bdd
define ("INDEXATION_LANGUES", " fr uk it de sp ru gb ");
define ("DOMAINE_LOCAL","www.laetis.loc");

class Configuration extends T_LAETIS_site
{

/* Définition des attributs */
var $indexationMois;
var $indexationJourMois;
var $indexationJourSem;
var $indexationHeure;
var $indexationMinute;
var $indexationTypeFichier;
var $indexationRepertoireAExclure;
var $indexationFichierPoint;
var $indexationRepertoireRacine;
var $indexationPoidsTitle;
var $indexationPoidsNomFichier;
var $indexationLog;
var $indexationTypeTitle;
var $indexationTypeContenu;
var $feuilleDeStyles;
var $resultatsNbResultatsParPage;
var $requeteLog;
var $requeteTri;
var $nomTableFichier;
var $nomTableMotFichier;
var $fichierConnexionBDD;
var $motsVides;
var $repertoireLocal;
var $repertoireDistant;
var $indexationLangues;
var $domaineLocal;

/* Définitions des méthodes */
function Configuration()
	{
	$this->creationTableConfiguration();
	$this->creationTableStatistiques();
	$this->getConfigurationFromBDD();	
	}

function getIndexationMois()
	{
	return $this->indexationMois;
	}
	
function setIndexationMois($indexationMois)
	{
	$this->indexationMois=$indexationMois;
	}

function getIndexationJourMois()
	{
	return $this->indexationJourMois;
	}
	
function setIndexationJourMois($indexationJourMois)
	{
	$this->indexationJourMois=$indexationJourMois;
	}
	
function getIndexationJourSem()
	{
	return $this->indexationJourSem;
	}
	
function setIndexationJourSem($indexationJourSem)
	{
	$this->indexationJourSem=$indexationJourSem;
	}

function getIndexationHeure()
	{
	return $this->indexationHeure;
	}
	
function setIndexationHeure($indexationHeure)
	{
	$this->indexationHeure=$indexationHeure;
	}

function getIndexationMinute()
	{
	return $this->indexationMinute;
	}
	
function setIndexationMinute($indexationMinute)
	{
	$this->indexationMinute=$indexationMinute;
	}

function getIndexationTypeFichier()
	{
	return $this->indexationTypeFichier;
	}
	
function setIndexationTypeFichier($indexationTypeFichier)
	{
	$this->indexationTypeFichier=$indexationTypeFichier;
	}

function getIndexationRepertoireAExclure()
	{
	return $this->indexationRepertoireAExclure;
	}

function getTabIndexationRepertoireAExclure()
	{
	return explode(' ', $this->indexationRepertoireAExclure);
	}

function setIndexationRepertoireAExclure($indexationRepertoireAExclure)
	{
	$this->indexationRepertoireAExclure=$indexationRepertoireAExclure;
	}
	
function getIndexationFichierPoint()
	{
	return $this->indexationFichierPoint;
	}
	
function setIndexationFichierPoint($indexationFichierPoint)
	{
	$this->indexationFichierPoint=$indexationFichierPoint;
	}
	
function getIndexationRepertoireRacine()
	{
	return $this->indexationRepertoireRacine;
	}
	
function setIndexationRepertoireRacine($indexationRepertoireRacine)
	{
	$this->indexationRepertoireRacine=$indexationRepertoireRacine;
	}
	
function getIndexationPoidsTitle()
	{
	return $this->indexationPoidsTitle;
	}
	
function setIndexationPoidsTitle($indexationPoidsTitle)
	{
	$this->indexationPoidsTitle=$indexationPoidsTitle;
	}
	
function getIndexationPoidsNomFichier()
	{
	return $this->indexationPoidsNomFichier;
	}
	
function setIndexationPoidsNomFichier($indexationPoidsNomFichier)
	{
	$this->indexationPoidsNomFichier=$indexationPoidsNomFichier;
	}
	
function getFeuilleDeStyles()
	{
	return $this->feuilleDeStyles;
	}
	
function setFeuilleDeStyles($feuille)
	{
	$this->feuilleDeStyles=$feuille;
	}
	
function getIndexationLog()
	{
	return $this->indexationLog;
	}
	
function setIndexationLog($indexationLog)
	{
	$this->indexationLog=$indexationLog;
	}
	
function getIndexationTypeTitle()
	{
	return $this->indexationTypeTitle;
	}
	
function setIndexationTypeTitle($indexationTypeTitle)
	{
	$this->indexationTypeTitle=$indexationTypeTitle;
	}
	
function getIndexationTypeContenu()
	{
	return $this->indexationTypeContenu;
	}
	
function setIndexationTypeContenu($indexationTypeContenu)
	{
	$this->indexationTypeContenu=$indexationTypeContenu;
	}
	
function getResultatsNbResultatsParPage()
	{
	return $this->resultatsNbResultatsParPage;
	}
	
function setResultatsNbResultatsParPage($resultatsNbResultatsParPage)
	{
	$this->resultatsNbResultatsParPage=$resultatsNbResultatsParPage;
	}
	
function getRequeteLog()
	{
	return $this->requeteLog;
	}
	
function getRepertoireLocal()
	{
	return $this->repertoireLocal;
	}
function getRepertoireDistant()
	{
	return $this->repertoireDistant;
	}	

function setRequeteLog($requeteLog)
	{
	$this->requeteLog=$requeteLog;
	}
	
function getRequeteTri()
	{
	return $this->requeteTri;
	}
	
function setRequeteTri($requeteTri)
	{
	$this->requeteTri=$requeteTri;
	}
	
function getNomTableFichier()
	{
	return $this->nomTableFichier;
	}
	
function setNomTableFichier($nomTableFichier)
	{
	$this->nomTableFichier=$nomTableFichier;
	}

function getNomTableMotFichier()
	{
	return $this->nomTableMotFichier;
	}
	
function setNomTableMotFichier($nomTableMotFichier)
	{
	$this->nomTableMotFichier=$nomTableMotFichier;
	}
function getFichierConnexionBDD()
	{
	return $this->fichierConnexionBDD;
	}
	
function setFichierConnexionBDD($fichierConnexionBDD)
	{
	$this->fichierConnexionBDD=$fichierConnexionBDD;
	}

function getMotsVides()
	{
	return $this->motsVides;
	}
	
function setMotsVides($motsVides)
	{
	$this->motsVides=$motsVides;
	}

function setRepertoireLocal($repertoire)
	{

	$this->repertoireLocal=$repertoire;
	}
	
function setRepertoireDistant($repertoire)
	{
	$this->repertoireDistant=$repertoire;
	}
	
function getIndexationLangues()
	{
	return $this->indexationLangues;
	}
	
function setIndexationLangues($indexationLangues)
	{
	$this->indexationLangues=$indexationLangues;
	}

function getDomaineLocal()
	{
	return $this->domaineLocal;
	}
	
function setDomaineLocal($domaine)
	{
	$this->domaineLocal=$domaine;
	}

	

/* Initialise les attributs aux valeurs par défaut correspondantes aux constantes */
function setDefault()
	{
	$this->indexationMois=INDEXATION_MOIS;
	$this->indexationJourMois=INDEXATION_JOURMOIS;
	$this->indexationJourSem=INDEXATION_JOURSEM;	
	$this->indexationHeure=INDEXATION_HEURE;
	$this->indexationMinute=INDEXATION_MINUTE;
	$this->indexationTypeFichier=INDEXATION_TYPE_FICHIER;
	$this->indexationRepertoireAExclure=INDEXATION_REPERTOIRE_A_EXCLURE;
	$this->indexationFichierPoint=INDEXATION_FICHIER_POINT;
	$this->indexationRepertoireRacine=INDEXATION_REPERTOIRE_RACINE;
	$this->indexationPoidsTitle=INDEXATION_POIDS_TITLE;
	$this->indexationPoidsNomFichier=INDEXATION_POIDS_NOM_FICHIER;
	$this->indexationLog=INDEXATION_LOG;
	$this->indexationTypeTitle=INDEXATION_TYPE_TITLE;
	$this->indexationTypeContenu=INDEXATION_TYPE_CONTENU;
	$this->feuilleDeStyles=FEUILLE_STYLE;	
	$this->resultatsNbResultatsParPage=RESULTATS_NB_RESULTATS_PAR_PAGE;
	$this->requeteLog=REQUETE_LOG;
	$this->requeteTri=REQUETE_TRI;
	$this->nomTableFichier=NOM_TABLE_FICHIER;
	$this->nomTableMotFichier=NOM_TABLE_MOT_FICHIER;
	$this->fichierConnexionBDD=FICHIER_CONNEXION_BDD;
	$this->motsVides=MOTS_VIDES;
	$this->repertoireLocal=REPERTOIRE_LOCAL;
	$this->repertoireDistant=REPERTOIRE_DISTANT;
	$this->indexationLangues=INDEXATION_LANGUES;
	$this->domaineLocal=DOMAINE_LOCAL;
	}

function creationTableConfiguration()
    {
	// on teste si la table suivante existe, si ce n'est pas le cas, elle est créée
	$query = "CREATE TABLE IF NOT EXISTS moteur_recherche_configuration (
      ID int(10) unsigned NOT NULL,
	  indexationTypeFichier varchar(100) NOT NULL,
	  indexationRepertoireAExclure varchar(255),
	  indexationFichierPoint bool NOT NULL  default 'true',	  
	  indexationRepertoireRacine varchar(200) NOT NULL,
	  indexationPoidsTitle int(3) NOT NULL  default '1',
	  indexationPoidsNomFichier int(3) NOT NULL default '1',
	  feuilleDeStyles varchar(200) NOT NULL,
	  indexationLog bool NOT NULL default 'true',
	  resultatsNbResultatsParPage int(4) NOT NULL,
	  requeteLog bool NOT NULL default 'true',
	  requeteTri varchar(10) NOT NULL,
	  nomTableFichier varchar(100) NOT NULL,
	  nomTableMotFichier varchar(100) NOT NULL,
	  fichierConnexionBDD varchar(100) NOT NULL,
	  motsVides varchar(200),
	  indexationTypeTitle bool NOT NULL default 'true',
	  indexationTypeContenu bool NOT NULL default 'true',
	  repertoireLocal varchar(100) NOT NULL default '',
	  repertoireDistant varchar(100) NOT NULL default '',
	  indexationLangues varchar(200),
	  domaineLocal varchar(200),
	  PRIMARY KEY  (ID));";
	$res=$this->query($query);
	}

function creationTableStatistiques()
    {
	// on teste si la table suivante existe, si ce n'est pas le cas, elle est créée
	$query = "CREATE TABLE IF NOT EXISTS moteur_recherche_statistiques (
      ID int(10) unsigned NOT NULL auto_increment,
	  requete varchar(100) NOT NULL,
	  nbOccurences int(10) NOT NULL,
	  derniereDate DATE NOT NULL,
	  pageVisitee varchar(200),
	  PRIMARY KEY  (ID));";
	$res=$this->query($query);
	}
	
function enregistreConfiguration()
    {
	$b = $this->getIndexationTypeFichier();
	$c = $this->getIndexationRepertoireAExclure();
	$d = $this->getIndexationFichierPoint();
	$e = $this->getIndexationRepertoireRacine();
	$f = $this->getIndexationPoidsTitle();
	$g = $this->getIndexationPoidsNomFichier();
	$h = $this->getFeuilleDeStyles();
	$i = $this->getIndexationLog();
	$j = $this->getResultatsNbResultatsParPage();
	$k = $this->getRequeteLog();
	$l = $this->getRequeteTri();
	$m = $this->getNomTableFichier();
	$o = $this->getNomTableMotFichier();
	$p = $this->getFichierConnexionBDD();
	$q = $this->getMotsVides();
	$r = $this->getIndexationTypeTitle();
	$s = $this->getIndexationTypeContenu();
	$t = $this->getRepertoireLocal();
	$u = $this->getRepertoireDistant();
	$v = $this->getIndexationLangues();
	$w = $this->getDomaineLocal();
	
	$req = "REPLACE INTO moteur_recherche_configuration (ID, indexationTypeFichier, indexationRepertoireAExclure, indexationFichierPoint, ";
	$req .= "indexationRepertoireRacine, indexationPoidsTitle, indexationPoidsNomFichier, feuilleDeStyles, indexationLog, resultatsNbResultatsParPage, requeteLog, ";
	$req .= "requeteTri, nomTableFichier, nomTableMotFichier, fichierConnexionBDD, motsVides, indexationTypeTitle, indexationTypeContenu,
				repertoireLocal,repertoireDistant, indexationLangues,domaineLocal)";
	$req .= " VALUES ('1', '$b', '$c', '$d', '$e', '$f', '$g', '$h', '$i', '$j', '$k', '$l', '$m', '$o', '$p', '$q', '$r', '$s', '$t', '$u', '$v','$w')";
	
	$idreq = $this->query($req);
	if ($idreq == 0)
        {
        echo("Une erreur lors de l'insertion est survenue !<br>");        
        }			
	}
	
function getConfigurationFromBDD()
    {
	$req = "SELECT * FROM moteur_recherche_configuration";
	$res=$this->query($req);
	$row=$res->fetchRow(DB_FETCHMODE_ASSOC);
	
	$this->setIndexationTypeFichier($row["indexationTypeFichier"]);
	$this->setIndexationRepertoireAExclure($row["indexationRepertoireAExclure"]);
	$this->setIndexationFichierPoint($row["indexationFichierPoint"]);
	$this->setIndexationRepertoireRacine($row["indexationRepertoireRacine"]);
	$this->setIndexationPoidsTitle($row["indexationPoidsTitle"]);
	$this->setIndexationPoidsNomFichier($row["indexationPoidsNomFichier"]);
	$this->setFeuilleDeStyles($row[feuilleDeStyles]);
	$this->setIndexationLog($row["indexationLog"]);
	$this->setResultatsNbResultatsParPage($row["resultatsNbResultatsParPage"]);
	$this->setRequeteLog($row["requeteLog"]);
	$this->setRequeteTri($row["requeteTri"]);
	$this->setNomTableFichier($row["nomTableFichier"]);
	$this->setNomTableMotFichier($row["nomTableMotFichier"]);
	$this->setFichierConnexionBDD($row["fichierConnexionBDD"]);
	$this->setMotsVides($row["motsVides"]);
	$this->setIndexationTypeTitle($row["indexationTypeTitle"]);
	$this->setIndexationTypeContenu($row["indexationTypeContenu"]);
	$this->setRepertoireLocal($row[repertoireLocal]);
	$this->setRepertoireDistant($row[repertoireDistant]);
	$this->setIndexationLangues($row["indexationLangues"]);
	$this->setDomaineLocal($row["domaineLocal"]);
	}

function isValid()
    {
	if ($this->getIndexationTypeFichier() == NULL)	return false;
	if ($this->getIndexationFichierPoint() == NULL)	return false;
	if ($this->getIndexationRepertoireRacine() == NULL)	return false;
	if ($this->getIndexationPoidsTitle() == NULL)	return false;
	if ($this->getIndexationPoidsNomFichier() == NULL)	return false;
	if ($this->getFeuilleDeStyles() == NULL)	return false;
	if ($this->getIndexationLog() == NULL)	return false;
	if ($this->getResultatsNbResultatsParPage() == NULL)	return false;
	if ($this->getRequeteLog() == NULL)	return false;
	if ($this->getRequeteTri() == NULL)	return false;
	if ($this->getNomTableFichier() == NULL)	return false;
	if ($this->getNomTableMotFichier() == NULL)	return false;
	if ($this->getFichierConnexionBDD() == NULL)	return false;
	
	return true;
	}
	
function afficher()
    {
	echo "Affichage des informations de configuration <BR> \n";
	echo "IndexationMois = ".$this->getIndexationMois()."<BR> \n";
	echo "IndexationJourMois = ".$this->getIndexationJourMois()."<BR> \n";
	echo "IndexationJourSem = ".$this->getIndexationJourSem()."<BR> \n";
	echo "IndexationHeure = ".$this->getIndexationHeure()."<BR> \n";
	echo "IndexationMinute = ".$this->getIndexationMinute()."<BR> \n";
	echo "IndexationTypeFichier = ".$this->getIndexationTypeFichier()."<BR> \n";
	echo "IndexationRepertoireAExclure = ".$this->getIndexationRepertoireAExclure()."<BR> \n";
	echo "IndexationFichierPoint = ".$this->getIndexationFichierPoint()."<BR> \n";
	echo "IndexationRepertoireRacine = ".$this->getIndexationRepertoireRacine()."<BR> \n";
	echo "IndexationPoidsTitle = ".$this->getIndexationPoidsTitle()."<BR> \n";
	echo "IndexationPoidsNomFichier = ".$this->getIndexationPoidsNomFichier()."<BR> \n";
	echo "IndexationTypeTitle = ".$this->getIndexationTypeTitle()."<BR> \n";
	echo "IndexationTypeContenu = ".$this->getIndexationTypeContenu()."<BR> \n";
	echo "feuilleDeStyles = ".$this->getFeuilleDeStyles()."<BR> \n";
	echo "IndexationLog = ".$this->getIndexationLog()."<BR> \n";
	echo "ResultatsNbResultatsParPage = ".$this->getResultatsNbResultatsParPage()."<BR> \n";
	echo "RequeteLog = ".$this->getRequeteLog()."<BR> \n";
	echo "RequeteTri = ".$this->getRequeteTri()."<BR> \n";
	echo "NomTableFichier = ".$this->getNomTableFichier()."<BR> \n";
	echo "NomTableMotFichier = ".$this->getNomTableMotFichier()."<BR> \n";
	echo "FichierConnexionBDD = ".$this->getFichierConnexionBDD()."<BR> \n";
    echo "Mots Vides = ".$this->getMotsVides()."<BR> \n";
	echo "Domaine local = ".$this->getDomaineLocal()."<BR> \n";
	}
}
?>