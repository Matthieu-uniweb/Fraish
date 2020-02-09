<?
header("Expires: 0"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");

$classes_supplementaires=array("/includes/plugins/annuaire/includes/classes");
require_once 'DB.php';
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/T_LAETIS_site_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_contact_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_criteres_specifiques_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/plugins/formulaires/includes/classes/Tformulaire_class.php');
session_start();

if ($_POST['ID_contact'])
	{ $objet = new Tannuaire_contact($_POST['ID_contact']); }
else if ($_POST['ID_service'])
	{ $objet = new Tannuaire_service($_POST['ID_service']); }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../includes/styles/annuaire_back.css" rel="stylesheet" type="text/css">
<title>Outil de saisie et de gestion des annuaires pratiques</title>
<script src="../../includes/javascript/annuaire_back.js" type="text/javascript" language="javascript"></script>
<script src="../../includes/javascript/annuaire_pop.js" type="text/JavaScript" language="JavaScript"></script>
<script language="javascript" type="text/javascript">
function envoyerFormulaire()
	{
	document.formulaire.submit();
	window.parent.an_closePop();
	}

function displayLocalFile (fileName, image) 
	{	
	var url = 'file:///' + fileName;
	
	if (document.layers && location.protocol.toLowerCase() != 'file:' && navigator.javaEnabled())
		netscape.security.PrivilegeManager.enablePrivilege('UniversalFileRead');
		document[image].src= url;
}

//Preview-Image-Popup
function showPreview(fileName)
	{		
	if(document.formulaire.elements[fileName].value!="")
		{
		monImage = new Image;
		monImage.src = document.formulaire.elements[fileName].value;
		width = monImage.width;
		height = monImage.height;
		imageLargeurMax = document.formulaire.imageLargeurMax.value;
		imageHauteurMax = document.formulaire.imageHauteurMax.value;

		if ( (height/width) >= (imageHauteurMax/imageLargeurMax) )
			{							
			width = (width * (imageHauteurMax / height));
			height = imageHauteurMax;
			}
		else
			{							
			height = (height * (imageLargeurMax / width));
			width = imageLargeurMax;
			}

		window.open('../preview.php?img='+document.formulaire.elements[fileName].value+'&l='+width+'&h='+height,'PREVIEW','width=420,height=420,location=no,toolbar=no,status=no,menubar=no,resizable=yes,linkbar=no,scrollbars=no');
		}
	}
</script>
</head>
<body>
<form name="formulaire" method="post" enctype="multipart/form-data" target="_parent" action="<?
if ($_POST['ID_contact'])
			{ echo '../saisir_structure_contact.php';	}
		else if ($_POST['ID_service'])
			{ echo '../saisir_structure.php';	} ?>">
 <table width="350" border="0" cellpadding="0" cellspacing="0">
  <tr>
   <td class="texte"><b><? echo $objet->nom; ?></b></td>
  </tr>
  <tr>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
      <td align="center"><br>
       <table width="95%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0">
        <tr>
         <td width="10" bgcolor="#0D4B91"><img src="../../images/e.gif" width="1" height="1"></td>
         <td width="99%" class="menuHaut">&nbsp;</td>
         <td align="right" valign="top"><img src="../../images/back/tranche.gif" width="10" height="14"></td>
        </tr>
       </table>
       <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#898DB0">
        <tr>
         <td bordercolor="#FAFDFE"><table width="100%" border="0" cellspacing="3" cellpadding="0">
           <tr>
            <td class="texte" colspan="2">Ajouter l'image correspondante (au format jpg) :</td>
           </tr>
           <tr>
            <td class="texte"><input type="file" id="file1" name="file1" onchange="displayLocalFile(this.form.file1.value,'preview_1');"  class="input250"></td>
            <td class="texte"><a href="javascript:showPreview('file1')"><img name="preview_1" src="../../images/back/preview.gif" width="33" height="33" border="0" align="middle"></a></td>
           </tr>
          </table></td>
        </tr>
				       <tr>
        <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../../images/e.gif" width="1" height="1"></td>
       </tr>
        <tr>
         <td bordercolor="#FAFDFE"><table width="100%" border="0" cellspacing="3" cellpadding="0">
           <tr>
            <td class="texte">Largeur max : <input name="imageLargeurMax" type="text" class="input50" value="<? echo $objet->imageLargeurMax; ?>"></td>
            <td class="texte">Hauteur max : <input name="imageHauteurMax" type="text" class="input50" value="<? echo $objet->imageHauteurMax; ?>"></td>
           </tr>
          </table></td>
        </tr>
       </table></td>
     </tr>
       <tr>
        <td><img src="../../images/e.gif" width="1" height="10"></td>
       </tr>		 
		 <tr>
		 	<td align="center"><button name="transferer" value="" class="input150" onClick="envoyerFormulaire(); return false;">Transférer mon image</button></td>
		 </tr>
    </table></td>
  </tr>
 </table>
 <input type="hidden" name="ID_contact" value="<? echo $_POST['ID_contact']; ?>">
 <input type="hidden" name="ID_service" value="<? echo $_POST['ID_service']; ?>">
	<input type="hidden" name="ID_structure" value="<? echo $_POST['ID_structure']; ?>">
 <input type="hidden" name="fonction" value="enregistrerImage">
</form>
<form name="formAction" method="post" action="">
	<input type="hidden" name="ID_contact" value="<? echo $_POST['ID_contact']; ?>">
	<input type="hidden" name="ID_structure" value="<? echo $_POST['ID_structure']; ?>">
	<input type="hidden" name="ID_service" value="<? echo $_POST['ID_service']; ?>">	 
</form>	 
</body>
</html>
