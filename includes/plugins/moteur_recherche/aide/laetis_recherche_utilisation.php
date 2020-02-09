<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Aide :: Editeur d&#8217;image </title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="includes/styles/lien.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body bgcolor="#FFFFFF" onLoad="MM_preloadImages('../../aide/images/imprimer_rollOver.jpg')">
<table width="747" height="590" border="1" cellpadding="0" cellspacing="0" bordercolor="#0066CC">
  <tr> 
    <td align="center" valign="top">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#0066CC">
        <tr>
          <td height="50" valign="top"> 
            <div align="right">
              <table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td width="26%" align="left">&nbsp;<a href="../../aide/index.php"><img src="../aide/images/bouton_home.gif" width="53" height="53" border="0" align="absmiddle" alt="Retour à l'accueil et aux autres rubriques de l'Aide"></a>&nbsp;</td>
                  <td width="74%" align="right"><font color="#FFFFFF" size="6" face="Verdana, Arial, Helvetica, sans-serif"><strong>Aide 
                    partie administration&nbsp;</strong></font></td>
                </tr>
              </table>
              <font color="#FFFFFF" size="6" face="Verdana, Arial, Helvetica, sans-serif"></font></div></td>
        </tr>
      </table> 
      <table width="98%" border="0" cellspacing="8" cellpadding="0">
        <tr> 
          <td width="33%">&nbsp;</td>
          <td width="67%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="33%" align="center" valign="top"> <table width="250" height="206" border="1" cellpadding="2" cellspacing="0" bordercolor="#0066CC" background="../../aide/images/point_interrogation_petit.gif">
              <tr> 
                <td height="12" valign="top" bgcolor="#0066CC"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;<img src="../aide/images/etoile_blanche.gif" width="17" height="16" align="absmiddle"> 
                  Rubriques:</strong></font></td>
              </tr>
              <tr> 
                <td valign="top"><?
					require_once 'DB.php';
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/T_LAETIS_site_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_contact_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/Tcontact_criteres_specifiques_class.php');
include_once(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/plugins/formulaires/includes/classes/Tformulaire_class.php');
					include_once ("../includes/classes/laetis_moteur_recherche_class.php"); 
					include ("../../../../".TmoteurRecherche::getCheminPlugin()."aide/laetis_menu_aide.php");
								?>
                </td>
              </tr>
            </table>
            <br> 
            <table width="250" border="1" cellpadding="1" cellspacing="0" bordercolor="#0066CC" background="../../aide/images/point_interrogation_petit.gif">
              <tr> 
                <td height="12" valign="top" bgcolor="#0066CC"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;<img src="../aide/images/etoile_blanche.gif" width="17" height="16" align="absmiddle"> 
                  Configuration requise :</strong></font></td>
              </tr>
              <tr> 
                <td valign="top"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                  </font> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="9%" height="21" align="center" valign="middle"><img src="../../../../admin/aide/images/carre_plus.gif" width="14" height="15"></td>
                      <td width="91%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Un 
                        PC avec Windows</font></td>
                    </tr>
                    <tr> 
                      <td align="center" valign="middle"><img src="../../../../admin/aide/images/carre_plus.gif" width="14" height="15"></td>
                      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Internet 
                        Explorer 5.5 ou sup&eacute;rieur - [<a href="http://www.microsoft.com/windows/ie_intl/fr/download/" target="_blank" class="lien">Télécharger</a>]</font></td>
                    </tr>
                    <tr> 
                      <td height="22" align="center" valign="middle"><img src="../../../../admin/aide/images/carre_plus.gif" width="14" height="15"></td>
                      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Adobe 
                        Acrobat Reader - [<a href="http://www.adobe.fr/products/acrobat/readstep2.html" target="_blank" class="lien">Télécharger</a>]</font></td>
                    </tr>
                    <tr> 
                      <td height="22" align="center" valign="middle"><img src="../../../../admin/aide/images/carre_plus.gif" width="14" height="15"></td>
                      <td><a href="../../../../admin/aide/configuration_poste.php" class="lien">Comment 
                        configurer votre poste ?</a></td>
                    </tr>
                  </table>
                  <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                  </font></td>
              </tr>
            </table></td>
          <td align="left" valign="top">            <div align="center">
              <p><strong><font size="5">Aide du moteur de recherche </font></strong></p>
              <p align="left"><font size="4"><strong>Recherche simple :</strong></font></p>
              <p align="left">Vous entrez un ou plusieurs mots dans le champ
                de recherche et cliquez sur le bouton &quot;rechercher&quot; (ou
                vous appuyez sur &quot;Entr&eacute;e&quot;).</p>
              <p align="left">Si la recherche porte sur plusieurs termes, le
                moteur signale uniquement les pages qui comportent <strong>TOUS</strong> ces
                termes, mais pas n&eacute;cessairement &agrave; la suite les
                uns des autres.<strong>Pour affiner une recherche, il suffit
                de sp&eacute;cifier d'autres termes. </strong><br>
    Le moteur ne tient pas compte de la casse, il interpr&egrave;te les lettres
    composant les termes de recherche comme des <strong>minuscules</strong>.<br>
    Les mots de moins de 3 lettres ne sont pas interpr&eacute;t&eacute;s.</p>
              <p align="left">Le caract&egrave;re <strong>joker</strong> (&quot;*&quot;)
                peut &ecirc;tre utilis&eacute;. il sert a retrouver des morceaux
                de mots. Par exemple: gast* retournera les mots gastronomie,
                gastronome...</p>
              <p align="left">&nbsp;</p>
              <p align="left"><font size="4"><strong>Recherche avanc&eacute;e
                    :</strong></font></p>
              <p align="left">Vous cliquez sur le lien &quot;Recherche avanc&eacute;e&quot; et
                diff&eacute;rentes options s'affichent:</p>
            </div>            <ol>
              <li>
                <div align="left"><strong>Rechercher dans : Toutes les pages
                    Pages:Fran&ccedil;ais</strong></div>
                Permet de sp&eacute;cifier la langue du document. Seuls les documents
                appartenant &agrave; la langue choisie seront retourner.</li>
              <li><strong>Rechercher au moins un des mots...</strong> : Le moteur
                de recherche va renvoyer les documents qui contiennent au moins
                un mot de la requ&ecirc;te.</li>
              <li><strong>La date</strong> : Seuls les documents ayant une date
                de derni&egrave;re modification correspondante au crit&egrave;re
                choisie seront affich&eacute;s.</li>
          </ol></td>
        </tr>
        <tr> 
          <td align="center"><a href="javascript:window.print();" onMouseOver="MM_swapImage('Image1','','../aide/images/imprimer_rollOver.jpg',1)" onMouseOut="MM_swapImgRestore()"><img src="../aide/images/imprimer.jpg" alt="imprimer" name="Image1" width="29" height="16" border="0" align="absmiddle" id="Image1"><font class="lien"> 
            imprimer</font></a>&nbsp;</td>
          <td valign="top">&nbsp; </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
