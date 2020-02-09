<?
$classes_supplementaires=array("/includes/plugins/moteur_recherche/includes/classes");
require_once 'DB.php';
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/T_LAETIS_site_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_contact_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_criteres_specifiques_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/plugins/formulaires/includes/classes/Tformulaire_class.php');

$index = $_REQUEST['index'];
if ($index == 1)
	{
	$indexation = new Indexation();
	}
$fini=true;	
?>
<html>
<head>
<title>Indexation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" onLoad="alert('indexation finie');history.go(-1);" onUnload="<? if (!$fini){echo "alert('l\'indexation n\est pas finie');"; } ?>">
<center>
<h1>indexation en cours....</h1>
<br>
<h1>ceci prendra quelques minutes, ne fermez pas votre navigateur....</h1>
</center>

</body>
</html>
