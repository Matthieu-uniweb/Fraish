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

$commune = new Tannuaire_commune();
$structure = new Tannuaire_structure();
?>
<html><!-- InstanceBegin template="/Templates/annuaire_back_page.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/styles/annuaire_back.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Outil de saisie et de gestion des annuaires pratiques</title>
<!-- InstanceEndEditable -->
<script src="../includes/javascript/annuaire_back.js" type="text/javascript" language="javascript"></script>
<!-- InstanceBeginEditable name="head" -->
<script language="javascript">
function valider()
	{
	if (document.formStructure.motCle.value == '')
		{ document.formStructure.motCle.value = '%' }

	if ( (document.formStructure.motCle.value == '') && (document.formStructure.formeJuridique.value == '') && (document.formStructure.anneeCreation.value == '') && (document.formStructure.typAsso.value == '') && (document.formStructure.typNaf.value == '') && (document.formStructure.siret.value == '') && (document.formStructure.effectifTotal.value == '') && (document.formStructure.typStructure.value == '') )
		{
		alert("Veuillez s�lectionner une option de recherche.");
		document.formStructure.motCle.focus();
		return false;
		}
	else
		{
		document.formStructure.submit();
		}
	}
</script>
<!-- InstanceEndEditable -->
</head>
<body>
<table width="767"  border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td width="204"><img src="../images/back/mail_service.gif" width="204" height="25"></td>
  <td width="554" align="center" valign="middle" bgcolor="#A0A0A0" class="chapitre"><!-- InstanceBeginEditable name="titre" -->Administration des annuaires pratiques<!-- InstanceEndEditable --></td>
  <td width="9" align="right" valign="top" bgcolor="#A0A0A0"><img src="../images/back/coin_haut.gif" width="9" height="25"></td>
 </tr>
</table>
<table width="767" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
  <td><img src="../images/e.gif" width="767" height="2"></td>
 </tr>
</table>
<table align="center" width="767" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td width="205" valign="top"><table width="205" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td width="141" bgcolor="#DF6400"><table width="141" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td align="left"><img src="../images/back/accueil.gif" width="11" height="13" hspace="5" vspace="0"><a href="index.php" class="menuHaut">Accueil</a></td>
       </tr>
       <tr>
        <td align="left"><img src="../images/back/clients.gif" width="10" height="14" hspace="5" vspace="0"><a href="clients.php" class="menuHaut">Gestion des clients</a> </td>
       </tr>
      </table></td>
     <td width="64"><img src="../images/back/habi_01.gif" width="64" height="47"></td>
    </tr>
    <tr>
     <td><img src="../images/e.gif" width="141" height="1"></td>
     <td><img src="../images/back/habi_02.gif" width="64" height="1"></td>
    </tr>
    <tr>
     <td align="left" bgcolor="#DF6400" class="menuHaut"><img src="../images/e.gif" width="10" height="5">Vos structures</td>
     <td><img src="../images/back/habi_03.gif" width="64" height="17"></td>
    </tr>
   </table>
   <table width="141" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td><img src="../images/e.gif" width="141" height="1"></td>
    </tr>
   </table>
   <table width="141" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
    <tr>
     <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="ajouter_structure.php" class="menu">Ajouter une structure</a> </td>
       </tr>
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="modifier_structure.php" class="menu">Rechercher une structure</a> </td>
       </tr>
      </table></td>
    </tr>
   </table>
   <table width="141" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td><img src="../images/e.gif" width="141" height="3"></td>
    </tr>
   </table>
   <table width="141" border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0">
    <tr>
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Vos supports diffusion</span></td>
    </tr>
   </table>
   <table width="141" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td><img src="../images/e.gif" width="141" height="1"></td>
    </tr>
   </table>
   <table width="141" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
    <tr>
     <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="saisir_support.php" class="menu">Ajouter un support </a></td>
       </tr>
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="menu_support.php" class="menu">Les supports de diffusion </a></td>
       </tr>
      </table></td>
    </tr>
   </table>
   <table width="141" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td><img src="../images/e.gif" width="141" height="3"></td>
    </tr>
   </table>
   <table width="141" border="0" cellpadding="0" cellspacing="0" bgcolor="#D8853D">
    <tr>
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Votre annuaire</span></td>
    </tr>
   </table>
   <table width="141" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td><img src="../images/e.gif" width="141" height="1"></td>
    </tr>
   </table>
   <table width="141" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
    <tr>
     <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="annuaire.php" class="menu">Consulter l'annuaire</a></td>
       </tr>
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="statistiques.php" class="menu">Statistiques</a> </td>
       </tr>
      </table></td>
    </tr>
   </table>
   <table width="141" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td><img src="../images/e.gif" width="141" height="3"></td>
    </tr>
   </table>
   <table width="141" border="0" cellpadding="0" cellspacing="0" bgcolor="#8FB089">
    <tr>
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Outils avanc&eacute;s </span></td>
    </tr>
   </table>
   <table width="141" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td><img src="../images/e.gif" width="141" height="1"></td>
    </tr>
   </table>
   <table width="141" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
    <tr>
     <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="exporter.php" class="menu">Exportation</a></td>
       </tr>
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="services_non_lies.php" class="menu">Services non li�s</a></td>
       </tr>			 
       <tr>
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="nettoyer.php" class="menu">Nettoyer l'annuaire</a> </td>
       </tr>
      </table></td>
    </tr>
   </table>
   <table width="141" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td><img src="../images/e.gif" width="141" height="6"></td>
    </tr>
   </table>
   <table width="141" border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0">
    <tr>
     <td width="126"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td><img src="../images/back/info.gif" width="21" height="17" hspace="5" vspace="1" align="absmiddle"><a href="infos.php" class="menuHaut">Informations</a></td>
       </tr>
       <tr>
        <td><img src="../images/back/deconnexion.gif" width="21" height="17" hspace="5" vspace="1" align="absmiddle"><a href="index.php" class="menuHaut">D&eacute;connexion</a></td>
       </tr>
      </table></td>
     <td width="15"><img src="../images/back/habi_04.gif" width="15" height="43"></td>
    </tr>
   </table>
   <!-- InstanceBeginEditable name="sousMenuGauche" --><!-- InstanceEndEditable -->
   <p>&nbsp;</p>
   <p><img src="../images/back/mail_service_colonne.gif" width="205" height="144"></p></td>
  <td width="562" valign="top"><!-- InstanceBeginEditable name="contenu" -->
   <form name="formStructure" method="post" action="rechercher_structure.php">
    <table width="562" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td background="../images/back/pointille_contenu.gif"><img src="../images/e.gif" width="1" height="1"></td>
     </tr>
     <tr>
      <td><img src="../images/e.gif" width="562" height="3"></td>
     </tr>
    </table>
    <table width="562" border="0" cellpadding="1" cellspacing="0" bgcolor="#D4D4D4">
     <tr>
      <td><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
         <td bgcolor="#D9DCEE" class="titre"><img src="../images/back/fleche_titre.gif" width="22" height="18" align="absmiddle">Gestion des structures</td>
        </tr>
        <tr>
         <td background="../images/back/pointille_titre.gif"><img src="../images/e.gif" width="560" height="1"></td>
        </tr>
        <tr>
         <td><img src="../images/e.gif" width="560" height="20"></td>
        </tr>
        <tr>
         <td><table width="100%" border="0" cellpadding="0" cellspacing="5" bordercolor="#000000" bgcolor="#898DB0">
           <tr>
            <td class="menuHaut"><b>Modifier ou rechercher une structure existante : </b></td>
           </tr>
          </table></td>
        </tr>
        <tr>
         <td><img src="../images/e.gif" width="560" height="15"></td>
        </tr>
        <tr>
         <td><table width="100%" border="0" cellpadding="2" cellspacing="1">
           <tr class="textecourant">
            <th><b>Champ</b></th>
            <th><b>Type</b></th>
            <th><b>Op�rateur</b></th>
            <th><b>Valeur</b></th>
           </tr>
           <tr>
            <td bgcolor="#E5E5E5" class="texte"><b>Nom</b></td>
            <td bgcolor="#E5E5E5" class="texte">Texte</td>
            <td bgcolor="#E5E5E5">&nbsp;</td>
            <td bgcolor="#E5E5E5"><input type="text" name="motCle" size="40" class="input200" value="<? echo $_POST['motCle']; ?>" /></td>
           </tr>
           <tr>
            <td bgcolor="#D5D5D5" class="texte"><b>Forme Juridique</b></td>
            <td bgcolor="#D5D5D5" class="texte">Texte</td>
            <td bgcolor="#D5D5D5">&nbsp;</td>
            <td bgcolor="#D5D5D5"><input type="text" name="formeJuridique" size="40" class="input200" value="<? echo $_POST['formeJuridique']; ?>" /></td>
           </tr>
           <tr>
            <td bgcolor="#E5E5E5" class="texte"><b>Ann&eacute;e de cr&eacute;ation</b></td>
            <td bgcolor="#E5E5E5" class="texte">Nombre</td>
            <td bgcolor="#E5E5E5"><select name="opAnneeCreation" class="input50">
              <option value="=">=</option>
              <option value=">">&gt;</option>
              <option value=">=">&gt;=</option>
              <option value="<">&lt;</option>
              <option value="<=">&lt;=</option>
              <option value="!=">!=</option>
             </select>
            </td>
            <td bgcolor="#E5E5E5"><input type="text" name="anneeCreation" size="40" class="input200" value="<? echo $_POST['anneeCreation']; ?>" /></td>
           </tr>
           <!-- <tr>
            <td bgcolor="#D5D5D5" class="texte"><b>Type de classement</b></td>
            <td bgcolor="#D5D5D5" class="texte">Texte</td>
            <td bgcolor="#D5D5D5">&nbsp;</td>
            <td bgcolor="#D5D5D5"><input type="text" name="ID_typ_classement" size="40" class="input200" value="<? echo $_POST['ID_typ_classement']; ?>" /></td>
           </tr> -->
           <tr>
            <td bgcolor="#E5E5E5" class="texte"><b>Num&eacute;ro Siret</b></td>
            <td bgcolor="#E5E5E5" class="texte">Texte</td>
            <td bgcolor="#E5E5E5"></td>
            <td bgcolor="#E5E5E5"><input type="text" name="siret" size="40" class="input200" value="<? echo $_POST['siret']; ?>" /></td>
           </tr>
           <tr>
            <td bgcolor="#D5D5D5" class="texte"><b>Type de structure</b></td>
            <td bgcolor="#D5D5D5" class="texte">Liste</td>
            <td bgcolor="#D5D5D5">&nbsp;</td>
            <td bgcolor="#D5D5D5"><select name="typStructure" class="input200">
              <option value="">Toutes</option>
              <?
							$typStructure = $structure->listerTypeStructure();
							for ($i=0; $i<count($typStructure); $i++)
								{ ?>
              <option value="<? echo $typStructure[$i]['ID']; ?>"><? echo $typStructure[$i]['type']; ?></option>
              <? } // FIN for ($i=0; $i<count($tab); $i++) ?>
             </select>
            </td>
           </tr>
					 <tr>
            <td bgcolor="#D5D5D5" class="texte"><b>Code Asso - Adm. </b></td>
            <td bgcolor="#D5D5D5" class="texte">Liste</td>
            <td bgcolor="#D5D5D5">&nbsp;</td>
            <td bgcolor="#D5D5D5"><select name="typAsso" class="input250">
              <option value="">Tous</option>
              <?
							$typAsso = $structure->listerCodesAssociations();
							for ($i=0; $i<count($typAsso); $i++)
								{ ?>
              <option value="<? echo $typAsso[$i]['ID']; ?>"><? echo $typAsso[$i]['type']; ?></option>
              <? } // FIN for ($i=0; $i<count($typAsso); $i++) ?>
             </select>
            </td>
					 </tr>
					 <tr>
            <td bgcolor="#D5D5D5" class="texte"><b>Code NAF</b></td>
            <td bgcolor="#D5D5D5" class="texte">Liste</td>
            <td bgcolor="#D5D5D5">&nbsp;</td>
            <td bgcolor="#D5D5D5"><select name="typNaf" class="input250">
              <option value="">Tous</option>
              <?
							$typNaf = $structure->listerCodesNaf();
							for ($i=0; $i<count($typNaf); $i++)
								{ ?>
              <option value="<? echo $typNaf[$i]['ID']; ?>"><? echo $typNaf[$i]['type']; ?></option>
              <? } // FIN for ($i=0; $i<count($typNaf); $i++) ?>
             </select>
            </td>
					 </tr>
           <tr>
            <td bgcolor="#E5E5E5" class="texte"><b>Effectif total</b></td>
            <td bgcolor="#E5E5E5" class="texte">Nombre</td>
            <td bgcolor="#E5E5E5"><select name="opEffectifTotal" class="input50">
              <option value="=">=</option>
              <option value=">">&gt;</option>
              <option value=">=">&gt;=</option>
              <option value="<">&lt;</option>
              <option value="<=">&lt;=</option>
              <option value="!=">!=</option>
             </select>
            </td>
            <td bgcolor="#E5E5E5"><input type="text" name="effectifTotal" size="40" class="input200" value="<? echo $_POST['effectifTotal']; ?>" /></td>
           </tr>
           <!-- <tr>
            <td bgcolor="#D5D5D5" class="texte"><b>Descriptif</b></td>
            <td bgcolor="#D5D5D5" class="texte">Texte</td>
            <td bgcolor="#D5D5D5">&nbsp;</td>
            <td bgcolor="#D5D5D5"><input type="text" name="descriptif" size="40" class="input200" value="<? echo $_POST['descriptif']; ?>" /></td>
           </tr> -->
           <tr>
            <td bgcolor="#E5E5E5" class="texte"><b>Commune</b></td>
            <td bgcolor="#E5E5E5" class="texte">Liste</td>
            <td bgcolor="#E5E5E5">&nbsp;</td>
            <td bgcolor="#E5E5E5"><select name="commune" class="input200">
              <?
							$communes = $commune->listerCommuneCarto();
							for ($i=0; $i<count($communes); $i++)
								{ ?>
              <option value="<? echo $communes[$i]['inseeCommune']; ?>"><? echo $communes[$i]['commune']; ?></option>
              <? } // FIN for ($i=0; $i<count($tab); $i++) ?>
             </select>
            </td>
           </tr>
          </table></td>
        </tr>
        <tr>
         	<td nowrap="nowrap" align="right">
				 		<input name="operation" type="submit" class="bouton" value="Rechercher" onClick="return (valider());">
					</td>
        </tr>
        <tr>
         <td><img src="../images/e.gif" width="560" height="20"></td>
        </tr>
        <tr>
         <td class="textecourant" align="right"><a href="index.php" class="textecourant">Revenir au menu</a></td>
        </tr>
       </table></td>
     </tr>
    </table>
   </form>
   <!-- InstanceEndEditable --></td>
 </tr>
</table>
</td>
</tr>
</table><!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_pied.lbi" --><table width="767" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="9"><img src="../images/back/coin_bas_gch.gif" width="9" height="25"></td>
		<td width="749" align="center" bgcolor="#E5E5E5" class="pied">Une cr&eacute;ation
			La&euml;tis Multim&eacute;dia
			- Novembre 2004 - <a href="http://www.laetis.fr" target="_blank" class="pied">www.laetis.fr</a>  -
		<a href="mailto:contact@laetis.fr" class="pied">contact@laetis.fr</a> - 05.65.74.70.97 <br>		</td>
		<td width="9"><img src="../images/back/coin_bas_dt.gif" width="9" height="25"></td>
	</tr>
</table><!-- #EndLibraryItem --></body>
<!-- InstanceEnd --></html>
