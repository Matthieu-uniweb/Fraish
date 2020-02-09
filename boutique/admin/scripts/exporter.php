<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

T_LAETIS_site::initialiserSession();

$glue = "\r\n"; 

$commande = new Tbq_commande();
$commandes = $commande->listerTousesCommandes($_GET);

foreach($commandes as $detailCommande)
	{	
	$client = new Tbq_client($detailCommande['ID_client']);

	$jus[] = $detailCommande['boisson'];
	$nom[] = $client->nomFacturation; 
	$prenom[] = $client->prenomFacturation;     
	$numCommande[] = $detailCommande['ID_commande_fraish']; 
	$taille[] = $detailCommande['taille'];           
	$pain[] = $detailCommande['pain']; 
	$ingredient[] = $detailCommande['plat']." ".$detailCommande['vinaigrette'];
	}

// Fichier CSV à downloader
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=commande_$liste.csv");

$separ = ";";
//echo "Commandes FRAISH'Menu du ".$_GET['dateSeuleInsertion'].$glue;
echo "Jus".$separ."Nom".$separ."Prenom".$separ."Num Com".$separ."Taille".$separ."Pain".$separ."Ingredients".$separ;
echo $glue; 

for ($i=0; $i<count($nom); $i++)
	{
	echo $jus[$i].$separ.$nom[$i].$separ.$prenom[$i].$separ.$numCommande[$i].$separ.$taille[$i].$separ.$pain[$i].$separ.$ingredient[$i]; 			
	if( ( $i+1 ) < count($nom) )
		{
		echo $glue; 
		}
	}
?>