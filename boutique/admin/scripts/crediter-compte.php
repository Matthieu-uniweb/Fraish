<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$appro = new Tbq_approvisionnement();
$client = new Tbq_client($_POST['ID_client']);

		switch($_POST['ID_typ_paiement'])
			{
			case 2://cheque
				if($_POST['montantCheque']>0 && $_POST['montantCheque']<999999)
					{
					$_POST['montant'] = str_replace(',','.',$_POST['montantCheque']);
					$appro->enregistrer($_POST);
					$appro->valider();					
					$messAppro = "Approvisionnement enregistre.";
					}
				else
					{
					$messAppro = 'Veuillez renseigner le montant du cheque!';
					}
				break;
			case 3://titre restau
				if($_POST['nbTitres'] && $_POST['valeurTitre'])
					{
					$_POST['valeurTitre'] = str_replace(',','.',$_POST['valeurTitre']);
					$_POST['montant'] = $_POST['nbTitres']*$_POST['valeurTitre'];
					$appro->enregistrer($_POST);
					$appro->valider();?><?php
					$messAppro = "Approvisionnement enregistre.";
					}
				else
					{
					$messAppro = "Veuillez renseigner le nombre et/ou la valeur des titres!";
					}
				break;
			case 4://especes
				if($_POST['montantEspeces']>0 && $_POST['montantEspeces']<999999)
					{
					$_POST['montant'] = str_replace(',','.',$_POST['montantEspeces']);
					$appro->enregistrer($_POST);
					$appro->valider();?><?php
					$messAppro = "Approvisionnement enregistre.";
					}
				else
					{
					$messAppro = "Veuillez renseigner le montant de l'approvisionnement!";
					}
				break;
			
			case 6://montant offert
				if($_POST['montantOffert']>0 && $_POST['montantOffert']<999999)
					{
					$_POST['montant'] = str_replace(',','.',$_POST['montantOffert']);
					$appro->enregistrer($_POST);
					$appro->valider();?><?php
					$messAppro = "Approvisionnement enregistre.";
					}
				else
					{
					$messAppro="Veuillez renseigner le montant offert!";
					}
				break;
				
			case 7://reprise d'avoir
				if($_POST['montantRepriseAvoir']>0 && $_POST['montantRepriseAvoir']<999999)
					{
					$_POST['montant'] = str_replace(',','.',$_POST['montantRepriseAvoir']);
					$appro->enregistrer($_POST);
					$appro->valider();?><?php
					$messAppro = "Approvisionnement enregistre.";
					}
				else
					{
					$messAppro = "Veuillez renseigner le montant de reprise d'avoir!";
					}
				break;
			//ajout jb , modif directe du solde
			case 99://edition solde
								
					$_POST['soldeCompte'] = str_replace(',','.',$_POST['soldeCompte']);
					$client->soldeCompte = $_POST['soldeCompte'];
					$client->enregistrer($rien);
					$messAppro = "Solde modifié";
					
				break;
			}
			
header("Location:/boutique/admin/client-detail.php?ID_client=".$client->ID."&messAppro=".$messAppro."#approvisionnements");?>