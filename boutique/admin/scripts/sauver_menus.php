<?
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

T_LAETIS_site::initialiserSession();

// Enregistrement des modifs
$menu = new Tbq_menujour();

	
/*while(list ($dateJour) = each ($_POST['soupe'])) 
	{
	$menu->enregistrerSelonJour($_POST['soupe'][$dateJour], 'soupe', $_SESSION["sessionID_user"]);
	}*/


while(list ($dateJour) = each ($_POST['soupe'])) 
	{
	$listeIngredientsSoupe = '';
	$listeIngredients = $_POST['soupe'][$dateJour]['ingredients'];
	if($listeIngredients)
		{
		foreach($listeIngredients as $ingredient)
			{
			$listeIngredientsSoupe .= $ingredient.'|';
			}
		}
	$_POST['soupe'][$dateJour]['ingredients'] = $listeIngredientsSoupe;
	$menu->enregistrerSelonJour($_POST['soupe'][$dateJour], 'soupe', $_SESSION["sessionID_user"]);
	}




while(list ($dateJour) = each ($_POST['jus'])) 
	{
	$menu->enregistrerSelonJour($_POST['jus'][$dateJour], 'jus', $_SESSION["sessionID_user"]);
	}

while(list ($dateJour) = each ($_POST['soupeDiet'])) 
	{
	$menu->enregistrerSelonJour($_POST['soupeDiet'][$dateJour], 'soupeDiet', $_SESSION["sessionID_user"]);
	}

// ------ 

while(list ($dateJour) = each ($_POST['salade'])) 
	{
	$listeIngredientsSalade = '';
	$listeIngredients = $_POST['salade'][$dateJour]['ingredients'];
	if($listeIngredients)
		{
		foreach($listeIngredients as $ingredient)
			{
			$listeIngredientsSalade .= $ingredient.'|';
			}
		}
	$_POST['salade'][$dateJour]['ingredients'] = $listeIngredientsSalade;
	$menu->enregistrerSelonJour($_POST['salade'][$dateJour], 'salade', $_SESSION["sessionID_user"]);
	}
	
//------------
	
while(list ($dateJour) = each ($_POST['desserts'])) //Desserts du jour
	{
	$listeDesserts = '';
	$listeIngredients = $_POST['desserts'][$dateJour]['ingredients'];
	if($listeIngredients)
		{
		foreach($listeIngredients as $ingredient)
			{
			$listeDesserts .= $ingredient.'|';
			}
		}
	$_POST['desserts'][$dateJour]['ingredients'] = $listeDesserts;
	$menu->enregistrerSelonJour($_POST['desserts'][$dateJour], 'desserts', $_SESSION["sessionID_user"]);	
	}

/*while(list ($dateJour) = each ($_POST['desserts2'])) //Desserts du jour
	{
	$listeDesserts = '';
	$listeIngredients = $_POST['desserts2'][$dateJour]['ingredients'];
	if($listeIngredients)
		{
		foreach($listeIngredients as $ingredient)
			{
			$listeDesserts .= $ingredient;
			}
		}
	$_POST['desserts2'][$dateJour]['ingredients'] = $listeDesserts;
	$menu->enregistrerSelonJour($_POST['desserts2'][$dateJour], 'desserts2', $_SESSION["sessionID_user"]);	
	}*/



// Redirection
header("Location: ../menu-jour.php");
?>