<? 
include_once 'DB.php';
include_once rtrim($_SERVER['DOCUMENT_ROOT']).'/includes/classes/T_LAETIS_site_class.php';
require_once ("mailler/htmlMimeMail".".php");

$tmp = new T_LAETIS_site();

// récupération de l'adresse d'envoi du mail
$query = "SELECT valeur FROM cm_obj_options WHERE libelle='mailOubliPasse'";
$res = $tmp->query($query);
$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
$adresseMail = $row['valeur'];

$query = "SELECT password FROM cm_obj_user WHERE login='".$_POST['identifiant']."'";
$res = $tmp->query($query);
		
if ( $res->numRows() )
	{
	$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
	$mail = new htmlMimeMail();
	$mail->setHtml("Vos paramètres de connexion sur le site ".str_replace('admin.','www.',$_SERVER['SERVER_NAME'])."<p>Identifiant : ".$_POST['identifiant']."<br />Mot de passe : ".$row['password']."</p>");
	$mail->setFrom($adresseMail);
	$mail->setSubject("Oubli du mot de passe Content Manager");
	$mail->send( array($_POST['identifiant']) ,'smtp');
	$message = "Un message vous a été envoyé";
	}
else
	{
	if ($_POST['identifiant'] )
		{
		$message = "Utilisateur inconnu. ";
		}
	else
		{
		$message = "Pour obtenir votre mot de passe, inscrivez votre identifiant ci-dessous.<br />Vos identifiant et mot de passe y seront envoy&eacute;s intanstan&eacute;ment. ";
		}
	}
?>
<html>
<head>
<title>Content Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="/includes/styles/cm_back_errors.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="767"  border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td bgcolor="#C3CCD1">&nbsp;</td>
 </tr>
</table>
<table width="767" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
  <td><img src="/images/e.gif" width="767" height="2"></td>
 </tr>
</table>
<table align="center" width="767" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td width="100%" valign="top">
   <table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#D4D4D4">
    <tr>
     <td><form action="" method="post" name="formulaire">
       <table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
         <td bgcolor="#D9DCEE" class="cm_policeMarquee">Oubli du mot de passe </td>
        </tr>
        <tr>
         <td><img src="/images/e.gif" width="100" height="1"></td>
        </tr>
        <tr>
         <td>&nbsp;</td>
        </tr>
        <tr>
         <td align="center" bgcolor="#EDEDED" class="cm_coulRouge"><? echo $message; ?></td>
        </tr>
        <tr>
            <td height="35" align="center" class="cm_blocFormulaire">Identifiant e-mail:&nbsp;
            	<input name="identifiant" type="text" class="cm_inputTexte" id="identifiant"></td>
        </tr>
        <tr>
            <td align="center"><br /><input name="Submit" type="submit" value="Envoyer" class="cm_boutonAction"><br /><br /></td>
        </tr>
       </table>
      </form></td>
    </tr>
   </table>
   </td>
 </tr>
</table>
<table width="767" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td align="center" valign="middle" bgcolor="#E5E5E5" class="cm_inviteFormulaire">La&euml;tis Multim&eacute;dia - <a href="http://www.laetis.fr" target="_blank" class="pied">www.laetis.fr</a> - <a href="mailto:contact@laetis.fr">contact@laetis.fr</a> - 05.65.74.70.97 </td>
  </tr>
</table>
</body>
</html>