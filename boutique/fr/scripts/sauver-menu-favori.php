<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$favori = new Tbq_client_favori($_POST['ID_menuFavori']);

$valeurs['ID_client'] = $_SESSION['ID_client'];
$valeurs['ID_pointDeVente'] = $_POST['ID_pointDeVente'];
$valeurs['typePlat'] = $_POST['radioMenu'];
$valeurs['plat'] = "";

if ($_POST['radioMenu']=="salades")
	{
	for($i=0; $i < 31; $i++)
		{
		if ($_POST[$i."saladeIngredients"] != NULL)
			{
			$valeurs['plat'] .=$_POST[$i."saladeIngredients"].", ";
			}
		}
	$valeurs['vinaigrette'] = $_POST['radioVinaigrette'];
	} // FIN if ($_POST['radioMenu']=="salades")
else
	{
	$valeurs['plat'] .= $_POST['radioSoupe'];
	for($i=0; $i<3; $i++)
		{
		$valeurs['plat'] .= ", ".$_POST[$i."soupeIngredients"];
		}	
	} // FIN else

$valeurs['typeBoisson'] = $_POST['radioBoisson'];
$boisson = $_POST['radio'.str_replace(' ', '',$_POST['radioBoisson'])];
$valeurs['boisson'] .= $boisson;
$valeurs['pain'] = $_POST['radioPain'];
$valeurs['taille'] = $_POST['taille'];

$favori -> enregistrer($valeurs);

header("Location: /boutique/fr/espace-client/espace-client.php");
?>