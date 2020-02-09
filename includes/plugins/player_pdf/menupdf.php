<?
include("fonction.php");
include("../../fonctions/fonctions.php");
$tab = parse_url($_GET['pdfPage']);
// On enlève le '/' devant $tab['path']
if ($tab['path'][0] == '/')
	{ $cheminFichier = getCheminRacine().substr($tab['path'], 1, strlen($tab['path'])); }
else
	{ $cheminFichier = getCheminRacine().$tab['path']; }
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="styles/pdf.css" type="text/css">
<script language="JavaScript" src="../../javascript/globals.js" type="text/JavaScript"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('images/bouton_fermer_over.gif')">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
	 <tr>
		<td bgcolor="#A9B3E3"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
		 <tr>
	  	<td width="10"><img src="images/espaceur.gif" width="10" height="1"></td>
			<td class="titre_page" width="100%">Lecture et chargement de fichiers pdf </td>
			<td><a href="javascript:self.parent.close();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Fermer','','images/bouton_fermer_over.gif',1)"><img src="images/bouton_fermer.gif" alt="Fermer la fenêtre" name="Fermer" width="20" height="21" border="0"></a></td>
		 </tr>
		</table></td>
	 </tr>
	 <tr>
		<td bgcolor="#E2E5F5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
		 <tr>
			<td width="100%" style="background-repeat:repeat-x " background="images/pointilles.gif"><img src="images/espaceur.gif" width="100%" height="1"></td>
		 </tr>
		 <tr>
			<td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			 <tr>
				<td width="10"><img src="images/espaceur.gif" width="10" height="1"></td>
				<td class="texte">Pour lire des fichiers PDF, vous devez disposer de Acrobat Reader. Pour le t&eacute;lecharger, <a href="http://www.adobe.com/products/acrobat/readstep.html" target="_blank" class="lien_texte">cliquez ici.</a></td>
				<td align="right"><a href="http://www.adobe.com/products/acrobat/readstep.html" target="_blank" alt="T&eacute;l&eacute;charger Acrobat Reader"><img src="images/getacro.gif" width="88" height="31" hspace="5" vspace="2" border="0" align="right"></a></td>
			 </tr>
			</table></td>
		 </tr>
		 <tr>
			<td width="100%" style="background-repeat:repeat-x " background="images/pointilles.gif"><img src="images/espaceur.gif" width="100%" height="1"></td>
		 </tr>
		 <tr>
			<td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			 <tr>
				<td width="10"><img src="images/espaceur.gif" width="10" height="35"></td>
				<td class="texte" width="100%">Pour des raisons techniques, sous certains navigateurs (Internet Explorer 3.0 &agrave; 5.0), le PDF peut ne pas s'afficher correctement. <br>
				 Nous vous conseillons de mettre &agrave; jour votre navigateur.</td>
				<td align="right"><a href="http://www.microsoft.com/france/telechargements/default.aspx" target="_blank" alt="T&eacute;l&eacute;charger Internet Explorer"><img src="images/internet_explorer.gif" width="22" height="24" hspace="32" border="0"></a></td>
			 </tr>
			</table></td>
		 </tr>
		</table></td>
	 </tr>
	 <tr>
	 	<td><table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#81838C">
		 <tr>
			<td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			 <tr>
				<td bgcolor="#D7C59D"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
				 <tr>
				 	<td width="10"><img src="images/espaceur.gif" width="10" height="20"></td>
					<td class="caracteristiques" nowrap>Si le fichier ci dessous ne s'affiche pas ou pour l'enregistrer sur votre poste cliquez-ici :</td>
					<td class="telechargement" align="right" nowrap><a href="download.php?pdfPage=<? echo $cheminFichier; ?>" class="telechargement"><img src="images/fleche_telechargement.gif" width="17" height="18" hspace="5" align="absmiddle" border="0">T&eacute;l&eacute;chargez le fichier PDF</a><img src="images/espaceur.gif" width="10" height="1"></td>
				 </tr>
				</table></td>
			 </tr>
			 <tr>
				<td bgcolor="#DDD4C1" height="25"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
				 <tr>
					<td class="caracteristiques"><img src="images/logo_pdf.gif" width="10" height="10" hspace="10"><? echo basename($_GET['pdfPage']); ?><img src="images/espaceur.gif" width="10" height="1">|<img src="images/espaceur.gif" width="10" height="1"><? echo formattedSize($cheminFichier); ?><img src="images/espaceur.gif" width="10" height="1">|<img src="images/espaceur.gif" width="10" height="1"><? echo convertirDateTexte(date('Y-m-d', filectime($cheminFichier))); ?></td>
				 </tr>
				</table></td>
			 </tr>
			</table></td>
		 </tr>
		</table></td>
	 </tr>
	</table></td>
 </tr>
</table>
</body>
</html>