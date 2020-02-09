<?
class Indexation extends T_LAETIS_site
{

/* Définition des attributs */
var $titreSite;
var $cheminRacine;
var $repertoireExclu;
var $stopList;
var $extensionFichier;

/* Définition des variables globales */
var $conf;
var $formatFichierAIndexer;
var $fichierAIndexer;
var $motsVides;
var $retour;


function Indexation()
	{
	$this->conf = new Configuration();	
	
	// Test de l'existence du répertoire
	/*if (!is_dir($this->conf->getIndexationRepertoireRacine())) 
		{
		//print("Erreur ! <b>".basename($this->conf->getIndexationRepertoireRacine())."</b> n'est pas un répertoire.");
		exit;
		}*/			
	
	// Récupération des fichiers à indexer, que l'on placent dans un tableau
	$this->formatFichierAIndexer = explode(" ", $this->conf->getIndexationTypeFichier());

	// Récupération de la liste de mots vides
	$this->motsVides = $this->conf->getMotsVides();

	// On lance l'indexation sur le site
	$this->indexationSite();		
	}

function getTitreSite()
	{
	return $this->titreSite;
	}
	
function setTitreSite($titreSite)
	{
	$this->titreSite=$titreSite;
	}
	
function getCheminRacine()
	{
	return $this->cheminRacine;
	}
	
function setCheminRacine($cheminRacine)
	{
	$this->cheminRacine=$cheminRacine;
	}
	
function getRepertoireExclu()
	{
	return $this->repertoireExclu;
	}
	
function setRepertoireExclu($repertoireExclu)
	{
	$this->repertoireExclu=$repertoireExclu;
	}
	
function getStopList()
	{
	return $this->stopList;
	}
	
function setStopList($stopList)
	{
	$this->stopList=$stopList;
	}
	
function getExtensionFichier()
	{
	return $this->extensionFichier;
	}
	
function setExtensionFichier($extensionFichier)
	{
	$this->extensionFichier=$extensionFichier;
	}

function indexationSite()
	{
	$this->creerTable();
		
	$chem="../../../";
	// On enleve le dernier "/"
	$chem = substr($chem, 0, strlen($chem)-1);

	$this->scanRepertoire($chem);
	
	$nombreFichiersAIndexer = count($this->fichierAIndexer);
	
	echo "<BR><b>DEBUT DE L'INDEXATION DES MOTS</b>";
	
	// Indexation des différents fichiers stockés dans le tableau $fichierAIndexer
	for ( $compt = 0; $compt < $nombreFichiersAIndexer; $compt++) 
		{
		$cheminFichierCandid=$this->fichierAIndexer[$compt];
		if (!is_readable($cheminFichierCandid)) 
			{
			continue;
			} // FIN if (!is_readable($cheminFichierCandid)) 
		
		// On lance l'indexation sur cette page
		$this->indexationPage($cheminFichierCandid);
		} // FIN for ( $compt = 0; $compt < $nombreFichiersAIndexer; $compt++) 
	
	echo "<BR><b>INDEXATION DES MOTS TERMINEE AVEC SUCCES</b>";
	echo "<BR><b>DEBUT DU CALCUL DES POIDS</b>";
	
	// Lorsque toutes les pages du site ont été indexées, on peut lancer le calcul du poids
	$this->calculPoids();
	
	echo "<BR><b>FIN DU CALCUL DES POIDS</b>";
	echo "<BR><b>INDEXATION TERMINEE AVEC SUCCES</b>";		
		
	//return $fichierAIndexer;	
	}
	
function indexationPage($cheminFichierCandid)
	{	
	if ($this->conf->getIndexationLog() == true)
		{
		$this->insertionTableLog($cheminFichierCandid);
		}

	//echo "Traitement du fichier".$cheminFichierCandid."<br> \n";
	//$idFicCandid = fopen($cheminFichierCandid, "r");

	switch (strstr($_SERVER['HTTP_HOST'],'.'))
		{
		case ".laetis.loc":
			$get="GET /".$this->conf->getRepertoireLocal()."/".str_replace("../","",  $cheminFichierCandid)." HTTP/1.0\r\nHost: ".$_SERVER['HTTP_HOST']."\r\n\n";
			break;
		// Cas pour l'alias de développement 213.246.36.188
		// Le répertoire Distant doit correspondre au sous domaine
		case ".246.36.188":
			$get="GET /".str_replace("../","",  $cheminFichierCandid)."/ HTTP/1.0\r\nHost: ".$_SERVER['HTTP_HOST']."\r\n\n";
			break;
		default:
			$get="GET /".str_replace("../","",  $cheminFichierCandid)."/ HTTP/1.0\r\nHost: ".$_SERVER['HTTP_HOST']."\r\n\n";
		}

	// la page 
	$idFicCandid =fsockopen($_SERVER['SERVER_ADDR'], 80, &$errno, &$errstr, 30);
	
	if(!$idFicCandid)
		{   
		echo "$errstr ($errno)<br>\n";
		exit($_SERVER['HTTP_HOST'].' erreur socket fsockopen');
		} 
	else
		{
		$contenu="<!--";
		fputs($idFicCandid, $get);
		
		// Traitement du nom du fichier, on supprime le format du fichier
		$cheminFichier = substr($cheminFichierCandid, 0, strrpos($cheminFichierCandid, '.'));
		
		$delimiteurs = " ._/";	 
		// Découpe une chaîne de caractères selon les délimiteurs qui lui sont passés en paramètre.
		$tok = strtok($cheminFichier, "/");
		
		while ($tok)
			{
			$motNomFichier = $motNomFichier." ".$tok;
			$tok = strtok($delimiteurs);
			}
		
		// Traitement du contenu du fichier
		while (!feof($idFicCandid)) 
			{			
			$contenu.= fgets($idFicCandid, 10000); 
			}
		
		//on vire la reponse http ==> on commente ce qu'il y a avant le <html>
		$contenu = str_replace("<html>","--><html>",$contenu);
		$contenu = str_replace("<HTML>","--><HTML>",$contenu);
		
		fclose($idFicCandid);		
		} // Fin else


	if ($this->conf->getIndexationTypeTitle() == true)
	    {
	    // Récupération du titre du document (s'il existe)
        if ($testTitre = eregi("<title>(.*)</title>", $contenu, $corresTitre)) 
	        {
            $titre = $corresTitre[1];								
            }
	    else $titre = "";
		
	    // Récupération des META TAGS
        //$MetaTags = get_meta_tags($cheminFichierCandid);
					
	    //$MetaKey = $MetaTags["keywords"];
	    //echo "Meta Key: ".$MetaKey."<br> \n";
	    //$MetaDescription = $MetaTags["description"];
	    //echo "Meta Description: ".$MetaDescription."<br> \n";
		
		if (eregi ("<meta name=\"description\" content=[^>]*", $contenu, $resultatDesc)) 
			{ 
			$description = explode("<meta name=\"description\" content=", $resultatDesc[0]); 
			$MetaDescription = $description[1];
			}
			
		if (eregi ("<meta name=\"keywords\" content=[^>]*", $contenu, $resultatKey)) 
			{ 
			$key = explode("<meta name=\"keywords\" content=", $resultatKey[0]); 
			$MetaKey = $key[1];
			}	
			
		//$metaUrlPageCachee = $MetaTags["urlpagecachee"];
		if (eregi ("<meta name=\"urlpagecachee\" content=[^>]*", $contenu, $resultatCachee)) 
			{ 
			$cachee = explode("<meta name=\"urlpagecachee\" content=", $resultatCachee[0]); 
			$metaUrlPageCachee = $cachee[1];
			}
	
	    $poidsNomFichier = $this->conf->getIndexationPoidsNomFichier();
	    $poidsTitle = $this->conf->getIndexationPoidsTitle();
	
	    $motNomFichier = $this->traitementLinguistique($motNomFichier);
	    $this->split_words($motNomFichier, $poidsNomFichier);
	
	    $sauveTitre = $titre;
	    $titre = $this->traitementLinguistique($titre);
	    $this->split_words($titre, $poidsTitle);
	
	    // Le poids d'un mot est par défaut de 1
	    $n = 1;
	
	    $sauveMetaDescription = $MetaDescription;
	    $MetaDescription = $this->traitementLinguistique($MetaDescription);
	    $this->split_words($MetaDescription, $n);
	
	    $MetaKey = $this->traitementLinguistique($MetaKey);
	    $this->split_words($MetaKey, $n);
		}
		
	if ($this->conf->getIndexationTypeContenu() == true)
	    {
		// Le poids d'un mot est par défaut de 1
	    $n = 1;
	
	    $contenu = $this->traitementLinguistique($contenu);
	    $this->split_words($contenu, $n);					
		}
			
	if ($metaUrlPageCachee != NULL)
	    {
		$metaUrlPageCachee = str_replace('"',"",$metaUrlPageCachee); 
		// On insère l'URL présente dans la balise meta "urlpagecachee" dans la table des fichiers
        $IDFic = $this->insererBDDFichier("../..".$metaUrlPageCachee, trim($sauveTitre), trim($sauveMetaDescription));			
		}
	else
	    {
	    // On insère ce fichier dans la table des fichiers
	    $IDFic = $this->insererBDDFichier($cheminFichierCandid, trim($sauveTitre), trim($sauveMetaDescription));
		}

	//echo sizeof($this->retour)." mots ont été ajoutés pour ce fichier.<BR>";
	
	foreach ($this->retour as $key => $val)
	    {
		//echo ("$key => $val<br> \n");
	    $this->insererBDD($key, $IDFic, $val, $poids);
	    }

	// On reinitialise le tableau
	$this->retour = NULL;
    }

function insertionTableLog($fic)
    {
	$query = "INSERT INTO moteur_recherche_indexationlog (fichierIndexe) VALUES ('$fic')";
	$this->query($query);
	}

function creerTable()
	{
	$tableFichier = $this->conf->getNomTableFichier();
	$tableMotFichier = $this->conf->getNomTableMotFichier();
	
	if ($this->conf->getIndexationLog() == true)
		{
		$sup = "DROP TABLE IF EXISTS moteur_recherche_indexationlog";
		$this->query($sup);
		
		$query = "CREATE TABLE moteur_recherche_indexationlog (
							ID int(10) unsigned NOT NULL auto_increment,
							fichierIndexe varchar(200) NOT NULL,
							PRIMARY KEY  (ID));";
		$this->query($query);
		}		
	
	$supFichier = "DROP TABLE IF EXISTS $tableFichier";
	$this->query($supFichier);
	$supMotFichier = "DROP TABLE IF EXISTS $tableMotFichier";
	$this->query($supMotFichier);			
	
	$queryFichier = "CREATE TABLE $tableFichier (
									ID int(10) unsigned NOT NULL auto_increment,
									cheminFichier varchar(100) NOT NULL,
									titrePage text,
									description text,
									dateDerniereModif varchar(10),
									langue varchar(50),
									PRIMARY KEY  (ID));";
	$this->query($queryFichier);
	
	$queryMotFichier = "CREATE TABLE $tableMotFichier (
									ID int(10) unsigned NOT NULL auto_increment,
									mot varchar(30) NOT NULL,
									IDFichier int(10) unsigned NOT NULL REFERENCES $tableFichier,
									nbOccurences int(5) NOT NULL default '0',
									poids float(10,2) NOT NULL default '0.0',
									PRIMARY KEY  (ID));";
	$this->query($queryMotFichier);
	
	$sql = "ALTER TABLE $tableMotFichier ADD INDEX ( `mot` )";
	$this->query($sql);
	$sql = "ALTER TABLE $tableMotFichier ADD INDEX ( `IDFichier` )";
	$this->query($sql);
	$sql = "ALTER TABLE $tableMotFichier ADD INDEX ( `nbOccurences` )";
	$this->query($sql);
	$sql = "ALTER TABLE $tableMotFichier ADD INDEX ( `poids` ) ";
	$this->query($sql);
	$sql = "ALTER TABLE $tableFichier ADD INDEX ( `dateDerniereModif` ) ";
	$this->query($sql);
	$sql = "ALTER TABLE $tableFichier ADD INDEX ( `langue` ) ";
	$this->query($sql);
	}

function insererBDDFichier($cheminFichierCandid, $titre, $description)
	{
	$tableFichier = $this->conf->getNomTableFichier();
	
	// Elimine les ' pour ne pas avoir d'erreurs lors de l'insertion dans la BDD
	$titre = str_replace('\'',"&#146;",$titre); 
	$description = str_replace('\'',"&#146;",$description);
	$description = str_replace('"',"",$description);
		
	$date = date("Ym", filemtime($cheminFichierCandid));
	
	// Traitement de la langue du fichier
	// On prends pour hypothèse que les fichiers dans une langue spécifique se trouve à la racine du site
	// Par exemple pour le site du Levezou on a à la racine de levezou_viaur : levezou_viaur/fr
	//$langues = " fr it gb de sp ru uk ";
	$langues = $this->conf->getIndexationLangues();

    // On enlève les ../ devant le chemin : exemple = ../../fr/laetis/
	$dir = str_replace("../", "", $cheminFichierCandid);
	// On récupère le premier répertoire (dans notre exemple fr)
	$tok = strtok($dir, "/");

    // Si le nom du répertoire correspond dans le tableau de langue, alors on met le nom de la langue
	$lang = "";
    if (eregi($tok, $langues))	    
	    $lang = $tok;		
	
	$reqFichier = "INSERT INTO $tableFichier (cheminFichier, titrePage, description, dateDerniereModif, langue )";
	$reqFichier = $reqFichier." VALUES ('$cheminFichierCandid', '$titre', '$description', '$date', '$lang')";
	
	$idreqFichier = $this->query($reqFichier);
    if ($idreqFichier == 0)
        {
        //echo("Une erreur lors de l'insertion est survenue !<br>");
        }
	
	$req = "SELECT ID FROM $tableFichier WHERE ID=LAST_INSERT_ID()";
	$result = $this->query($req);
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$don = $row["ID"];
	
	return $don;
	}
	
function insererBDD($mot, $IDFichier, $occur, $poids)
	{
	$tableMotFichier = $this->conf->getNomTableMotFichier();		
	
	$reqMotFichier = "INSERT INTO $tableMotFichier (mot, IDFichier, nbOccurences, poids)";
	$reqMotFichier = $reqMotFichier." VALUES ('$mot', $IDFichier, '$occur', '$poids')";
		
	$idreqMotFichier = $this->query($reqMotFichier);
    if ($idreqMotFichier == 0)
        {
        //echo("Une erreur lors de l'insertion est survenue !<br>");
        }
	}

//////////////////////////////////////////////////////////////
/* Recherche les fichiers qui peuvent etre indexés  		*/
/* Pour cela, on parcourt tous les sous-répertoires			*/
/* et on récupère les fichiers ayant les formats recherchés	*/
/* et qui ne sont pas dans des répertoires exclus 			*/
//////////////////////////////////////////////////////////////
function scanRepertoire($repertoire)
	{
	$myRep = opendir($repertoire);
	$repertoireAExclure = $this->conf->getTabIndexationRepertoireAExclure();
	
	while ($entree = readdir($myRep)) 
		{
		// Si l'entrée est un répertoire, et que ce répertoire n'est pas exclu
		// On parcourt ce répertoire à la recherche de fichiers
		if ( is_dir($repertoire."/".$entree) && $entree != "." && $entree != ".." && ( !(in_array($entree, $repertoireAExclure)) ) ) 
			{
			// Récursivité sur le répertoire
			$this->scanRepertoire("$repertoire/$entree");		
			}
		else 
			{
			$commenceParPoint = $this->conf->getIndexationFichierPoint();
			if ( (($entree[0] != '.') && ($entree[0] != '_')) || ($commenceParPoint == false) )
				{
				foreach ($this->formatFichierAIndexer as $element)
					{
					if (eregi($element, $entree))
						{								
						$cheminFichier = $repertoire."/".$entree;					
						
						// Récupération des META TAGS
						// On peut utiliser cette fonction ici car cette meta sera toujours définie en dur
						$MetaTags = get_meta_tags($cheminFichier);
						
						// Vérification de la présence du tag robots pour savoir si ce fichier
						// peut etre indexé
						if ( ($MetaTags["recherche"] == "all") || ($MetaTags["recherche"] == NULL) )
							{
							//$cheminFichier = str_replace($PHPRoot, "", $cheminFichier);
							$this->fichierAIndexer[] = $cheminFichier;											    
							}
						break;
						} // if eregi
					} // Foreach
				}				    			     
			} //else
		} // While readdir
	closedir($myRep);
	} // function scanRepertoire($repertoire)
	
	
function traitementLinguistique($contenu)
	{
	// Passer en minuscule
    $contenu = strtolower($contenu);
	
	$caractere_special = array(
        "&agrave;"=>"à", "&aacute;"=>"á", "&acirc;"=>"â", "&atilde;"=>"ã", "&auml;"=>"ä", "&aring;"=>"å",
        "&aelig;"=>"æ", "&ccedil;"=>"ç", "&egrave;"=>"è", "&eacute;"=>"é", "&ecirc;"=>"ê", "&euml;"=>"ë",
        "&icirc;"=>"î", "&iuml;"=>"ï", "&ocirc;"=>"ô", "&ouml;"=>"ö", "&ugrave;"=>"ù", "&uacute;"=>"ú",
        "&ucirc;"=>"û", "&uuml;"=>"ü", "&amp;"=>"&", ); 	
	
    foreach ($caractere_special as $caractere_code=>$caractere_traduction)
	    { 
        $contenu = str_replace("$caractere_code", "$caractere_traduction", $contenu);         
		}
	
	// Elimination des éventuelles portions de code correspondant à des scripts javascript
	// $contenu = eregi_replace("<script(.*)/script>","",$contenu);
	$contenu = eregi_replace("<script[\s]+[^<]+</script>","",$contenu);	

    // On enlève les informations qui sont entre les balises <title> car elles sont traitées à part
    $contenu = eregi_replace("<title>(.*)</title>","",$contenu);
	
	// Eliminer les tags HTML et Php
	$contenu = strip_tags($contenu);
	
	// Suppression des espaces insecables
	$contenu = str_replace("&nbsp;", "", $contenu);
	$contenu = str_replace("\n", " ", $contenu); 
    $contenu = str_replace("  ", " ", $contenu); 
	
    // Elimination des antislashes éventuels
    $contenu = stripslashes($contenu);
	
	// Liste des caractères à supprimer
   //$caractaires = Array("([[:punct:]])", "([[:digit:]])", "([[:space:]]{1,100})", "([[:cntrl:]])");
   $caractaires = Array("([[:punct:]])", "([[:digit:]])", "([[:space:]])", "([[:cntrl:]])");

   // Supprime les caractères interdits
   for ($i = 0; $i < sizeof($caractaires); $i++) 
   {
       $contenu = eregi_replace($caractaires[$i], " ", $contenu);
   }
	
	return $contenu;			
	}

function filtrageMotStopList($mot)
	{
	return ( !(eregi($mot, $this->motsVides)));
	}
	
function calculPoids()
	{
	// Poids(t,d) = TF(t,d) * (1-log2(n/N))
	// Avec :
	// -	t le mot indexé,
	// -	d le document considéré dans lequel t apparaît,
	// -	TF(t, d) : le nombre d'occurrences de t dans d, 
	// qui n'est autre que le " poids " calculé lors de l'indexation,
	// -	n : le nombre de documents différents dans lesquels apparaît le mot t,
	// -	N : le nombre de documents du corpus.
	
	$table = $this->conf->getNomTableMotFichier();
	$tableFic = $this->conf->getNomTableFichier();
	
	$reqnb = "SELECT count(*) FROM $tableFic";	
	$idreqnb = $this->query($reqnb);
	$row = $idreqnb->fetchRow();
	$nbDocs = $row[0];
	
	$reqg = "SELECT ID, mot, nbOccurences FROM $table";
	$idreqg = $this->query($reqg);
	$nb_res = $idreqg->numRows();      
	
	for ($i = 0; $i < $nb_res; $i++)
		{
		$row = $idreqg->fetchRow(DB_FETCHMODE_ASSOC);
		$id = $row["ID"];
		$rowmot = $row["mot"];
		$nbOccur = $row["nbOccurences"];
		
		$req = "SELECT count(*) FROM $table WHERE mot='$rowmot'";
		$idreq = $this->query($req);
		$nb = $idreq->fetchRow();
		$nb = $nb[0];		
		
		//	$poids = $nbOccur * ( 1 - ( log( $nb / $nbDocs ) / log(2) ) );
		//	$upd = "UPDATE $table SET poids=$poids WHERE ID=$id";
		
		$upd = "UPDATE $table SET poids = (".$nbOccur." * (1 - LOG(".$nb." / ".$nbDocs.") / LOG(2) ) ) WHERE ID=".$id;
		$idupd = $this->query($upd);		
		} // FIN for ($i = 0; $i < $nb_res; $i++)
	} // FIN function calculPoids()


function split_words($string, $nb)
// Cette fonction retourne la chaîne passée en paramètre 
// dans un tableau de mots en conservant l'ordre de la chaîne.
    { 
	// Découpe une chaîne de caractères selon les délimiteurs qui lui sont passés en paramètre.
    $tok = strtok($string, " "); 

	while ($tok)
	    {
		if ( (!empty($tok)) && (strlen($tok) >= 3) && (is_string($tok)) )
            {
			if ($this->filtrageMotStopList($tok))
			    {
				//echo ("$tok => $nb<br> \n");
		        $this->retour[$tok] = $this->retour[$tok] + $nb;
				}
			}
		 $tok = strtok(" "); 
		}
    }

function nbMotsTrouves()
    {
	$table = $this->conf->getNomTableMotFichier();
	// On sélectionne le nombre de mots trouvés
	$reqg = "SELECT count(*) FROM $table";
    $result = $this->query($reqg);
    $row = $result->fetchRow();
    $nb_res = $row[0];
	
	return $nb_res;	
	}
}
?>