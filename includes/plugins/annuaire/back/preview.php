<HTML>
<HEAD>
<TITLE>Preview</TITLE>
<link href="../includes/styles/annuaire_back.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
if (navigator.appName=="Microsoft Internet Explorer") 
{	ty = document.body.clientHeight; tx = document.body.clientWidth; }
else 
{	ty = window.innerHeight; tx = window.innerWidth; }
x = screen.availWidth/2 - tx/2
y = screen.availHeight/2 - ty/2
self.moveTo(x,y);
</script>
</HEAD>
<BODY BGCOLOR="#ffffff">
<?
if ( (! $_GET['l']) && (! $_GET['h']) )
	{
	//Récupération des infos sur le fichier
	$taille=getimagesize($_GET['img']);
				
	//Format de la photo
	$_GET['l'] = $taille[0];
	$_GET['h'] = $taille[1];
	}
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td width="100%"><p align="center"> <img src="<? echo $_GET['img']; ?>" border="0" width="<? echo $_GET['l']; ?>" height="<? echo $_GET['h']; ?>" onclick="window.close();" onmouseover="this.style.cursor='pointer';" onmouseout="this.style.cursor='hand';"><br>
    <br>
    <button class="input100" onclick="window.close();" onmouseover="this.style.cursor='pointer';" onmouseout="this.style.cursor='hand';">Fermer</button>
  </td>
 </tr>
</table>
</BODY>
</HTML>
