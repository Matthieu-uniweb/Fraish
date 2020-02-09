<?php
//Gestion des offres commerciales sur les approvisionnements
$offre = false;
$remise = array();
if($montantAppro>=25)//Tranche 1
	{
	$offre=true;
	$valeurOffre = 2;
	}
if($montantAppro>=50)//Tranche 2
	{
	$offre=true;
	$valeurOffre = 5;
	}
if($montantAppro>=100)//Tranche 3
	{
	$offre=true;
	$valeurOffre = 12;
	}

if($offre)
	{
	$approOffert=new Tbq_approvisionnement();
	$remise['ID_client'] = $client->ID;
	$remise['ID_commande'] = $commande->ID;
	$remise['montant'] = $valeurOffre;
	$remise['ID_typ_paiement'] = 8;
	if($approValide)
		{
		$remise['valide'] = 1;
		}
	$approOffert->enregistrer($remise);
	$appro->setApproOffert($approOffert->ID);
	}
//(FIN) Gestion des offres commerciales sur les approvisionnements
?>