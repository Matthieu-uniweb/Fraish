<?
$classes_supplementaires=array("/includes/plugins/annuaire/includes/classes");
require_once 'DB.php';
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/T_LAETIS_site_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_contact_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_criteres_specifiques_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/plugins/formulaires/includes/classes/Tformulaire_class.php');

if (isset($_GET['ID_support']))
	{ $_POST = $_GET; }

if (! $_POST['ID_support'])
	{ $_POST['ID_support'] = 1; }

//$_POST['ID_categorie_consulte'] = 318;

$support = new Tannuaire_support($_POST['ID_support']);

if ($_POST['ID_categorie_consulte'])
	{ 
	$categorie = new Tannuaire_categorie($_POST['ID_categorie_consulte']); 
	$tabCategories = explode(',', $_POST['ID_categorie_consulte']);
	}
	
$commune = new Tcommune();
$cantons = $commune->listerCantons();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Moteurs annuaires</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function rechercher()
	{
	if (document.forms[0].motCle.value == '')
		{
		alert("Veuillez saisir un mot clé.");
		}
	else
		{
		win = window.open("" , 'resultats', 'width=500,height=650,toolbar=0,menubar=no,scrollbars=yes,status=yes'); 
		document.forms[0].target = win.name;
		document.forms[0].submit();
		}
	}
function voirCategorie()
	{
	if (document.forms[0].ID_categorie_consulte.value == '')
		{
		alert("Veuillez choisir une catégorie.");
		}
	else
		{		
		win = window.open("" , 'resultats', 'width=500,height=650,toolbar=0,menubar=no,scrollbars=yes,status=yes'); 
		document.forms[0].motCle.value = '';
		document.forms[0].target = win.name;
		document.forms[0].submit();
		}
	}
function checkAll()
	{
	on = document.forms[0].tous.checked;
	for (i=0;i<document.forms[0].elements.length;i++)
		{
		if ( (document.forms[0].elements[i].type=="checkbox") && (document.forms[0].elements[i].name=="ID_canton[]") )
			{
			document.forms[0].elements[i].checked=on;
			}
		}
	}
//-->
</script>
<script language="javascript" src="../includes/javascript/annuaire_front.js"></script>
<script language="javascript" src="../../../javascript/globals.js"></script>
<script language="JavaScript" src="../../../javascript/iframe.js" type="text/JavaScript"></script>
<link href="../includes/styles/annuaire_front.css" rel="stylesheet" type="text/css">
<link href="../../../styles/styles.css" rel="stylesheet" type="text/css">
<link href="../../../styles/contenu.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="MM_preloadImages('../images/front/clic_plus-over.gif','../images/front/clic_moins-over.gif','../images/front/oeil.gif'); parent.redimmensionnerFrame(window.name,'',getHauteurDocument());">
<form name="form1" method="post" action="resultats_annuaire.php" onSubmit="rechercher(); return false;">
  <table width="440" border="0" cellpadding="0" cellspacing="0" bgcolor="#AA6262">
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td bgcolor="#E3C393"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="annuaireRecherche"><img src="../images/front/recherche.gif" width="16" height="20" hspace="3" vspace="2" align="absmiddle">Recherchez
                     un organisme, un service</td>
                </tr>
                <tr>
                  <td height="25" background="../images/front/pointille_rouge.gif" bgcolor="#E9D7BC" style="background-repeat: repeat-x;background-position: top;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="295" class="annuaireRubrique" nowrap><img src="../images/e.gif" width="28" height="24" align="absmiddle"><strong>Rubriques</strong> 
                          : ( <a href="javascript:;" onClick="toutDevelopper();parent.redimmensionnerFrame(window.name,'',getHauteurDocument());return false;" class="annuaireLien">tout 
                          d&eacute;velopper</a> )</td>
                        <td width="99%" height="25" background="../images/front/degrade_canton.gif" class="annuaireRubrique" style="background-repeat: no-repeat;background-position: right;"><strong><img src="../images/front/canton.gif" width="23" height="23" align="absmiddle">&nbsp;&nbsp;Les 
                        cantons</strong> <input type="checkbox" name="tous" value="1" class="checkbox_canton" onClick="checkAll();"></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td bgcolor="#E3C393"><img src="../images/e.gif" width="1" height="1"></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
												<td bgcolor="#F4EADB"><img src="../images/e.gif" width="10" height="1"></td>
                        <td width="285" valign="top" nowrap bgcolor="#F4EADB"><br>
                        <? echo $support->genererHtmlFront('', '#DBD5CB', $tabCategories); ?><br></td>
                        <td valign="top" bgcolor="#EDD7B6" class="canton" width="99%"><img src="../images/e.gif" width="1" height="5"><br>
												<?
												for ($i=0; $i<count($cantons); $i++)
													{
													?><input type="checkbox" name="ID_canton[]" id="ID_canton[]" value="<? echo $cantons[$i]['ID_canton']; ?>" class="checkbox_canton" onSelect=""><? echo $cantons[$i]['nomSimplifie'].'<br>';
													}
												?>
												<input type="checkbox" name="ID_canton[]" id="ID_canton[]" value="99999" class="checkbox_canton" onSelect="">Hors Territoire<br>
												<img src="../images/e.gif" width="1" height="5"><br></td>
                      </tr>
                    </table></td>
                </tr>								
                <tr>
                  <td background="../images/front/pointille_rouge.gif" style="background-repeat: repeat-x;background-position: top;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="28" class="annuaireSousRubrique"><img src="../images/front/loupe.gif" width="14" height="14" hspace="3">Mots cl&eacute;s 
                          <input name="motCle" type="text" class="inputAnnuaire" id="motCle"><input name="rubrique" type="radio" class="radioAnnuaire" value="toutes" checked>
																Toutes les rubriques <input name="rubrique" type="radio" class="radioAnnuaire" value="selection">
												Rubrique s&eacute;lectionn&eacute;e</td>
                      </tr>
                      <tr>
                        <td height="22" align="right" background="../images/front/degrade_rechercher.gif" class="annuaireRecherche" style="background-repeat: no-repeat;background-position: right;"><a href="javascript:;" onClick="rechercher(); return false;" class="boutonRechercher">Rechercher</a>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <input type="hidden" name="ID_categorie_consulte">
 <input type="hidden" name="ID_support" value="<? echo $_POST['ID_support']; ?>">
</form>
</body>
