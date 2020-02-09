<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
require_once("mailler/htmlMimeMail.php");


//
// CLIENT
//

//print_r($_POST);

$commande = new Tbq_commande();
$formule = new Tbq_formule($_POST['ID_formule']);
$prixLivraison=0;
if($_POST['menuOU'])//repositionne les valeurs
	{
	$listeOptions = $formule->getPlatsEnOption();
	foreach($listeOptions as $option)
		{
		if($option=='salade' && $option!=$_POST['menuOU'])
			{
			unset($_POST['radioVinaigrette']);
			}
		if($option=='boisson' && $option!=$_POST['menuOU'])
			{
			unset($_POST['radioBoisson']);
			}
		if($option=='soupe' && $option!=$_POST['menuOU'])
			{
			unset($_POST['radioSoupe']);
			}
		}
		
	}

$menu = new Tbq_menu($formule->getIDMenu($_POST));
$valeurs['dateReservation']= T_LAETIS_site::convertirDate($_POST['dateReservation']);

$valeurs['ID_client'] = $_SESSION['ID_client'];

$valeurs['ID_pointDeVente'] = $_POST['ID_pointDeVente'];
if(substr($_POST['ID_pointDeVente'],0,4)=='LIV#')//IF choix livraison
	{
	$prixLivraison = 0.9;
	$valeurs['ID_pointLivraison'] = str_replace('LIV#','',$_POST['ID_pointDeVente']);
	$ptLivraison = new Tbq_pointLivraison($valeurs['ID_pointLivraison']);
	$valeurs['ID_pointDeVente'] = $ptLivraison->ID_pointDeVente;
	}//FIN IF choix livraison

$valeurs['plat'] = "";
$prixSupplements=0;
// PRISE EN COMPTE DES SUPPLEMENTS
$tabSup = $_POST['sup'];
if($tabSup)
	{
	for($iSup=0;$iSup<=sizeof($tabSup);$iSup++)
		{
		if($tabSup[$iSup]['qte']>0)
			{
			if(preg_match('/|/',$tabSup[$iSup]['prix']))//Récupération de la taille sélectionnée (si besoin)
				{
				$tabPrixTaille = explode('|',$tabSup[$iSup]['prix']);
				$tab[$iSup]['prix'] = $tabPrixTaille[0];
				}//FIN Récupération de la taille
			$prixSupplements+=$tabSup[$iSup]['prix']*$tabSup[$iSup]['qte'];
			
			//on cherche le libelle du supplement 
			$tbq_supp = new Tbq_ingredient();
			$tbq_supp->initialiser($tabSup[$iSup]['nom']);
			$nomSupp = $tbq_supp->libelle;
			
			$valeurs['supplement'].='<br/>'.$tabSup[$iSup]['qte'].' '.$nomSupp.' '.$tabPrixTaille[1];
			}
		}
	}
	

//Taille du menu
switch($_POST['radioTaille'])
	{
	case 'Grand':
		$valeurs['prix'] = $formule->getPrixGrand()+$prixSupplements+$prixLivraison;
		break;
	case 'Moyen':
		$valeurs['prix'] = $formule->getPrixMoyen() + $prixSupplements+$prixLivraison;
		break;
	case 'Petit':
		$valeurs['prix'] = $formule->getPrixPetit() + $prixSupplements+$prixLivraison;
		break;
	}

if ($menu->salade)
	{
		
	for($i=0; $i <= $_POST['nbIngredientsSalade']; $i++)
		{
			
		if ($_POST[$i."saladeIngredients"] != NULL)
			{ 
			//on cherche le libelle de la vinaigrette 
			$tbq_saladeIngredients = new Tbq_ingredient();
			$tbq_saladeIngredients->initialiser($_POST[$i.'saladeIngredients']);
			$valeurs['plat'] .= addslashes($tbq_saladeIngredients->libelle).', ';
			$valeurs['idsPlat'] .= $tbq_saladeIngredients->ID.'|';
			}
		}
	/*$valeurs['plat'] .= "<br>Selon disponibilités: ";
	for($i=16; $i <= 31; $i++)
		{
		if ($_POST[$i."saladeIngredients"] != NULL)
			{
			$valeurs['plat'] .=$_POST[$i."saladeIngredients"].", ";
			}
		}*/
		
	//on cherche le libelle de la vinaigrette 
	$tbq_vinaigrette = new Tbq_ingredient();
	$tbq_vinaigrette->initialiser($_POST['radioVinaigrette']);
	$valeurs['vinaigrette'] = addslashes($tbq_vinaigrette->libelle).' : '.addslashes($tbq_vinaigrette->details);
	
	
	} // FIN if ($_POST['radioMenu']=="salades")
if ($menu->soupe)
	{
		
	//on cherche le libelle de la soupe 
	$tbq_soupe = new Tbq_ingredient();
	$tbq_soupe->initialiser($_POST['radioSoupe']);
	$valeurs['soupe'] = $tbq_soupe->libelle.' : '.addslashes($tbq_soupe->details);
	
	for($i=0; $i<$_POST['nbOptionSoupe']; $i++)
		{
		//on cherche le libelle des option soupe
		if ($_POST[$i.'soupeIngredients']){
			$tbq_soupe = new Tbq_option();
			$valeurs['soupe'] .= ', '.addslashes($tbq_soupe->getOptionName($_POST[$i.'soupeIngredients']));
		}
		//$valeurs['soupe'] .= ", ".$_POST[$i."soupeIngredients"];
		}	
	} // FIN else

if ($_POST['radioBoisson']=="JusDeFruits")
	{ $valeurs['boisson'] .= "Jus de Fruits  "; }
if ($_POST['radioBoisson']=="Smoothies")
	{ $valeurs['boisson'] .= "Smoothies  "; }	
if ($_POST['radioBoisson']=="DairySmoothies")
	{ $valeurs['boisson'] .= "Dairy Smoothies : "; }
if($_POST['radioBoisson'] == 'DailyJuice')
	{
	$valeurs['boisson'] .= "DailyJuice";
	}

$boisson = $_POST['radio'.str_replace(' ', '',$_POST['radioBoisson'])];

$tbq_boisson = new Tbq_ingredient();
$tbq_boisson->initialiser($boisson);
$valeurs['boissonStat'] = $tbq_boisson->libelle;
//$valeurs['boissonStat'] = substr($boisson, 0, strpos($boisson, ' - '));

if ( /*($valeurs['boissonStat']=='MY JUICE') || ($valeurs['boissonStat']=='MY SMOOTHIE') || ($valeurs['boissonStat']=='MY DAIRY')*/$valeurs['boissonStat']=='MY' )
	{	
	$valeurs['boisson'] = ' au choix :';
	$valeurs['boisson'] .= " ".$_POST['myingredients'.str_replace(' ', '',$_POST['radioBoisson'])];
	}
else
	{
	$valeurs['boisson'] .= ' '.$tbq_boisson->libelle;	
	}
if($menu->eau)
	{
	$valeurs['eau'] = "Bouteille eau 50 cl";
	}
	

//on cherche le libelle du dessert 
$tbq_dessert = new Tbq_ingredient();
$tbq_dessert->initialiser($_POST['radioDessert']);
$valeurs['dessert'] = $tbq_dessert->libelle;


//on cherche le libelle du pain 
$tbq_pain = new Tbq_ingredient();
$tbq_pain->initialiser($_POST['radioPain']);
$valeurs['pain'] = $tbq_pain->libelle;


$valeurs['taille'] = $_POST['radioTaille'];
$valeurs['commentaire'] = $_POST['commentaire'];
$valeurs['ID_menu'] = /*$_POST['ID_menu']*/$menu->ID;


$ID = $commande -> enregistrer($valeurs);

//sondage
Tbq_sondage::enregistrerReponses($_POST['tabSondages'],$_POST['reponse']);

$_SESSION['ID_commande'] = $ID;

header("Location: /boutique/fr/espace-client/recapitulatif.php?ID_commande=".$ID."&ID_client=".$valeurs['ID_client']."&ID_menu=".$menu->ID);
?>