<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';
$appro = new Tbq_approvisionnement($_GET['ID_appro']);
$client = new Tbq_client($appro->ID_client);
?>
<HTML>
<HEAD>
<TITLE>Fraish - approvisionnement</TITLE>
<meta name="description" content="">
<script language="JavaScript" src="/includes/javascript/globals.js" type="text/JavaScript"></script>
<script language="JavaScript" type="text/JavaScript">
window.self.name="fenetrePrincipale";
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="/includes/styles/contenu.css" rel="stylesheet" type="text/css">
<link href="/includes/styles/espace-client.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/Library/form-approvisionnement.php';?>
<script type="text/javascript" language="javascript">
<!--//
window.onload = function ()
	{
	printAll();
	}
//-->
</script>
</BODY>
</HTML>
