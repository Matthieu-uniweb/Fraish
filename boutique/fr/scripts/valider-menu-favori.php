<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
require_once("mailler/htmlMimeMail.php");
//
// CLIENT
//

$commande = new Tbq_commande();
//$formule = new Tbq_menu($_POST['ID_menu']);
$formule = new Tbq_formule($_POST['ID_formule']);

$favori=Tbq_client_favori::getMenuFavori($_SESSION['ID_client']);
if($_POST['menuOU'])//repositionne les valeurs
	{
	$listeOptions = $formule->getPlatsEnOption();
	foreach($listeOptions as $option)
		{
		if($option=='salade' && $option!=$_POST['menuOU'])
			{
			unset($_POST['radioVinaigrette']);
			$valeurs['salade'] = '';
			$valeurs['vinaigrette'] = '';
			}
		if($option=='boisson' && $option!=$_POST['menuOU'])
			{
			unset($_POST['radioBoisson']);
			$valeurs['boisson'] = '';
			}
		if($option=='soupe' && $option!=$_POST['menuOU'])
			{
			unset($_POST['radioSoupe']);
			$valeurs['soupe'] = '';
			}
		}
		
	}
$menu = new Tbq_menu($formule->getIDMenu($_POST));


//$favori = new Tbq_client_favori($ID_menuFavori[0]);

//$valeurs['dateReservation']= T_LAETIS_site::convertirDate($_SESSION['dateReservation']);
$valeurs['ID_client'] = $_SESSION['ID_client'];

$valeurs['ID_pointDeVente'] = $_POST['ID_pointDeVente'];
if(substr($_POST['ID_pointDeVente'],0,4)=='LIV#')//IF choix livraison
	{
	$valeurs['ID_pointLivraison'] = str_replace('LIV#','',$_POST['ID_pointDeVente']);
	$ptLivraison = new Tbq_pointLivraison($valeurs['ID_pointLivraison']);
	$valeurs['ID_pointDeVente'] = $ptLivraison->ID_pointDeVente;
	}//FIN IF choix livraison
else
	{
	$valeurs['ID_pointLivraison'] = 0;
	}
	
$valeurs['plat'] = "";
$valeurs['ID_menu'] = $menu->ID;

switch($_POST['radioTaille'])
	{
	case 'Grand':
		$valeurs['prix'] = $formule->getPrixGrand();
		break;
	case 'Moyen':
		$valeurs['prix'] = $formule->getPrixMoyen();
		break;
	case 'Petit':
		$valeurs['prix'] = $formule->getPrixPetit();
		break;
	}

if ($menu->salade)
	{
	for($i=0; $i <= 31; $i++)
		{
		if ($_POST[$i."saladeIngredients"] != NULL)
			{
			$valeurs['salade'] .=$_POST[$i."saladeIngredients"]."|";
			}
		}	
	$valeurs['vinaigrette'] = $_POST['radioVinaigrette'];
	} // FIN if ($_POST['radioMenu']=="salades")
	
if ($menu->soupe)
	{
	$valeurs['soupe'] .= $_POST['radioSoupe'];
	for($i=0; $i<3; $i++)
		{
		$valeurs['soupe'] .= ", ".$_POST[$i."soupeIngredients"];
		}	

	} // FIN else

if($menu->eau)
	{
	$valeurs['eau'] = 1;
	}

if ($_POST['radioBoisson']=="JusDeFruits")
	{ $valeurs['boisson'] .= "Jus de Fruits : "; }
if ($_POST['radioBoisson']=="Smoothies")
	{ $valeurs['boisson'] .= "Smoothies : "; }	
if ($_POST['radioBoisson']=="DairySmoothies")
	{ $valeurs['boisson'] .= "Dairy Smoothies : "; }	
if($_POST['radioBoisson']=='DailyJuice')
	{
	$valeurs['boisson'].='DailyJuice';
	}

$boisson = $_POST['radio'.str_replace(' ', '',$_POST['radioBoisson'])];

$valeurs['boissonStat'] = substr($boisson, 0, strpos($boisson, ' - '));

if ( ($valeurs['boissonStat']=='MY JUICE') || ($valeurs['boissonStat']=='MY SMOOTHIE') || ($valeurs['boissonStat']=='MY DAIRY') )
	{	
	$boisson .= " : ".$_POST['myingredients'.str_replace(' ', '',$_POST['radioBoisson'])];
	}

$valeurs['boisson'] .= $boisson;
$valeurs['dessert'] .= $_POST['radioDessert'];
$valeurs['pain'] = $_POST['radioPain'];
$valeurs['taille'] = $_POST['radioTaille'];
$valeurs['commentaire'] = $_POST['commentaire'];
$valeurs['ID_menu'] = /*$_POST['ID_menu']*/$menu->ID;

$ID = $favori -> enregistrer($valeurs);
$client = new Tbq_client($_SESSION['ID_client']);
$client->setPointDeVentePrefere($valeurs['ID_pointDeVente']);

header("Location: /boutique/fr/espace-client/espace-client.php");
//?ID_commande=".$ID."&ID_client=".$valeurs['ID_client']."&ID_menu=".$valeurs['ID_menu']
?>