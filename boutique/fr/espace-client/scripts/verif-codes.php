<?
session_start();
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';

$ok='';
if (($_POST['email']) && ($_POST['motDePasse']))
	{
	$client = new Tbq_client();
	$ID_client = $client->verifierLogin($_POST);

	if ($ID_client)
		{
		$_SESSION['ID_client'] = $ID_client;
		$ok='ok';
		if($_POST['retenirMdp']==1)
			{
			$client = new Tbq_client($ID_client);
			//placer 1 cookie pour retenir l'utilisateur (identifiant et mdp et retenir coché)
			//setcookie('fraish_id',$client->emailFacturation,time()+2592000,'/',str_replace('www','',$_SERVER['HTTP_HOST']));
			setcookie('fraish_id',$client->emailFacturation,time()+2592000,'/');
			//setcookie('fraish_mdp',$client->motDePasse,time()+2592000,'/',str_replace('www','',$_SERVER['HTTP_HOST']));
			setcookie('fraish_mdp',$client->motDePasse,time()+2592000,'/');
			//setcookie('fraish_rmbmdp',1,time()+2592000,'/',str_replace('www','',$_SERVER['HTTP_HOST']));
			setcookie('fraish_rmbmdp',1,time()+2592000,'/');
			}
		else
			{
			setcookie('fraish_id','');
			setcookie('fraish_mdp','');
			setcookie('fraish_rmbmdp','');
			}
		} // FIN if ($ID_user)
	}

if ($ok)
	{ header("Location: ../espace-client.php"); }
// Erreur
else
	{ header("Location: ../index.php?message=erreur"); }
?>