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

$service = new Tannuaire_service();
$listeServices = $service->verifierServiceNonLie();
?>
<html>
<!-- InstanceBegin template="/Templates/annuaire_back_page.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/styles/annuaire_back.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Outil de saisie et de gestion des annuaires pratiques</title>
<!-- InstanceEndEditable -->
<script src="../includes/javascript/annuaire_back.js" type="text/javascript" language="javascript"></script>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>
<body> 
<table width="767"  border="0" align="center" cellpadding="0" cellspacing="0"> 
 <tr> 
  <td width="204"><img src="../images/back/mail_service.gif" width="204" height="25"></td> 
  <td width="554" align="center" valign="middle" bgcolor="#A0A0A0" class="chapitre"><!-- InstanceBeginEditable name="titre" -->Administration
    des annuaires pratiques<!-- InstanceEndEditable --></td> 
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
        <td align="left"><img src="../images/back/clients.gif" width="10" height="14" hspace="5" vspace="0"><a href="clients.php" class="menuHaut">Gestion
          des clients</a> </td> 
       </tr> 
      </table></td> 
     <td width="64"><img src="../images/back/habi_01.gif" width="64" height="47"></td> 
    </tr> 
    <tr> 
     <td><img src="../images/e.gif" width="141" height="1"></td> 
     <td><img src="../images/back/habi_02.gif" width="64" height="1"></td> 
    </tr> 
    <tr> 
     <td align="left" bgcolor="#DF6400" class="menuHaut"><img src="../images/e.gif" width="10" height="5">Vos
      structures</td> 
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
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="ajouter_structure.php" class="menu">Ajouter
          une structure</a> </td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="modifier_structure.php" class="menu">Rechercher
          une structure</a> </td> 
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
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Vos
       supports diffusion</span></td> 
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
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="saisir_support.php" class="menu">Ajouter
          un support </a></td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="menu_support.php" class="menu">Les
          supports de diffusion </a></td> 
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
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Votre
       annuaire</span></td> 
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
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="annuaire.php" class="menu">Consulter
          l'annuaire</a></td> 
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
     <td><span class="menuHaut"><img src="../images/e.gif" width="10" height="17" align="absmiddle">Outils
       avanc&eacute;s </span></td> 
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
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="services_non_lies.php" class="menu">Services
          non liés</a></td> 
       </tr> 
       <tr> 
        <td><img src="../images/back/puce.gif" width="9" height="7" align="absmiddle"><a href="nettoyer.php" class="menu">Nettoyer
          l'annuaire</a> </td> 
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
        <td bgcolor="#D9DCEE" class="titre"><img src="../images/back/fleche_titre.gif" width="22" height="18" align="absmiddle">Recherche
         des services li&eacute;s &agrave; aucun support de diffusion</td> 
       </tr> 
       <tr> 
        <td background="../images/back/pointille_titre.gif"><img src="../images/e.gif" width="560" height="1"></td> 
       </tr> 
       <tr> 
        <td><img src="../images/e.gif" width="560" height="20"></td> 
       </tr> 
       <tr> 
        <td class="texte"><img src="../images/e.gif" width="20" height="1"><b><? echo count($listeServices); ?> services
          trouvés</b></td> 
       </tr> 
       <?
			if (count($listeServices) == 0)
				{ ?> 
       <tr> 
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#0D4B91" bgcolor="#FAFDFE"> 
          <tr> 
           <td align="center" bordercolor="#0D4B91" class="texte"><br> 
            <br> 
            <strong>Votre recherche n'a retourné aucun résultat</strong><br> 
            <a href="modifier_structure.php" class="textecourant">Cliquez ici
            pour effectuer une nouvelle recherche</a><br> 
            <br> 
            <br> </td> 
          </tr> 
         </table></td> 
       </tr> 
       <? } // FIN if($nombreReponses == 0)
			else
				{
				for ($i=0; $i<count($listeServices); $i++)
					{ 
					$service = new Tannuaire_service($listeServices[$i]);
					$structure = new Tannuaire_structure($service->getStructure());
					?> 
       <tr> 
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0"> 
          <tr> 
           <td align="center"><br> 
            <table width="95%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#898DB0"> 
             <tr> 
              <td width="10" bgcolor="#0D4B91"><img src="../images/e.gif" width="1" height="1"></td> 
              <td width="99%" class="menuHaut"><strong>&nbsp;&nbsp;<? echo $structure->nom; ?></strong></td> 
              <td align="right" valign="top"><img src="../images/back/tranche.gif" width="10" height="14"></td> 
             </tr> 
            </table> 
            <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#898DB0"> 
             <tr> 
              <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0"> 
                <tr> 
                 <td width="99%" class="texte"><? 
								if ($service->nom != "")
									{
									echo $service->nom;
									} ?></td> 
                 <td align="right"><a href="javascript:;" onClick="saisirStructure('<? echo $structure->ID; ?>', '<? echo $service->ID; ?>');return false;" class="textecourant">Modifier</a>&nbsp;</td> 
                </tr> 
               </table></td> 
             </tr> 
             <?
						if ($service->descriptif != '' || $structure->descriptif != '')
							{	?> 
             <tr> 
              <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../images/e.gif" width="1" height="1"></td> 
             </tr> 
             <tr> 
              <td bordercolor="#FAFDFE"><table width="100%" border="0" cellspacing="3" cellpadding="0"> 
                <tr> 
                 <td class="texte"><? echo $service->descriptif.$structure->descriptif; ?></td> 
                </tr> 
               </table></td> 
             </tr> 
             <? } 
						$adresses = $service->listerAdresses();
						for($j=0; $j < sizeof($adresses); $j++)
							{
							$adresse = new Tannuaire_adresse($adresses[$j]);
							if($adresse->ville != '')
							{
							?> 
             <tr> 
              <td bordercolor="#FAFDFE" bgcolor="#898DB0"><img src="../images/e.gif" width="1" height="1"></td> 
             </tr> 
             <tr> 
              <td bordercolor="#FFF2FC"><table width="100%"  border="0" cellspacing="3" cellpadding="0"> 
                <tr> 
                 <td class="texte"><strong>Adresse : </strong><span class="Style5"><? echo $adresse->afficherAdresse(); ?></span></td> 
                </tr> 
               </table></td> 
             </tr> 
             <? } } ?> 
            </table></td> 
          </tr> 
         </table></td> 
       </tr> 
       <?	}
				} ?> 
       <tr> 
        <td><img src="../images/e.gif" width="1" height="20"></td> 
       </tr> 
      </table></td> 
    </tr> 
   </table> 
   <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
    <tr> 
     <td><img src="../../images/e.gif" width="1" height="15"></td> 
    </tr> 
   </table> 
   <form name="formulaire" method="post" action=""> 
    <input type="hidden" name="ID_structure"> 
    <input type="hidden" name="ID_service"> 
   </form> 
   <!-- InstanceEndEditable --></td> 
 </tr> 
</table> 
</td> 
</tr> 
</table> 
<!-- #BeginLibraryItem "/includes/plugins/annuaire/back/modeles/annuaire_back_pied.lbi" --> 
<table width="767" border="0" align="center" cellpadding="0" cellspacing="0"> 
 <tr> 
  <td width="9"><img src="../images/back/coin_bas_gch.gif" width="9" height="25"></td> 
  <td width="749" align="center" bgcolor="#E5E5E5" class="pied">Une cr&eacute;ation
   La&euml;tis Multim&eacute;dia - Novembre 2004 - <a href="http://www.laetis.fr" target="_blank" class="pied">www.laetis.fr</a> - <a href="mailto:contact@laetis.fr" class="pied">contact@laetis.fr</a> -
   05.65.74.70.97 <br> </td> 
  <td width="9"><img src="../images/back/coin_bas_dt.gif" width="9" height="25"></td> 
 </tr> 
</table> 
<!-- #EndLibraryItem --> 
</body>
<!-- InstanceEnd -->
</html>
