<?
// Test pour serveurs hebergement avec vieux php (Oleane...)
if (!$nomvideo)
	{
	$nomvideo=$_GET["nomvideo"];
	}
// l'animation flash se charge de redriver vers le dossier vidéo.
// bug sous mac si la chaine video est trop longue
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>player_progressive</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body bgcolor="#ffffff">
<SCRIPT LANGUAGE=JavaScript>
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

//-->
</SCRIPT>

<script language="JavaScript" type="text/JavaScript">
function doPassVar(){
     window.document.myflash.SetVariable("nomFichierVideoDepuisInternet", "<? echo $nomvideo ?>");
}
</script>

</HEAD>
<BODY bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.self.focus();">
<script language=JavaScript>
<!--
var MM_contentVersion = 7;
var plugin = (navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]) ? navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin : 0;
if ( plugin ) {
		var words = navigator.plugins["Shockwave Flash"].description.split(" ");
	    for (var i = 0; i < words.length; ++i)
	    {
		if (isNaN(parseInt(words[i])))
		continue;
		var MM_PluginVersion = words[i]; 
	    }
	var MM_FlashCanPlay = MM_PluginVersion >= MM_contentVersion;
}
else if (navigator.userAgent && navigator.userAgent.indexOf("MSIE")>=0 
   && (navigator.appVersion.indexOf("Win") != -1)) {
	document.write('<SCR' + 'IPT LANGUAGE=VBScript\> \n'); //FS hide this from IE4.5 Mac by splitting the tag
	document.write('on error resume next \n');
	document.write('MM_FlashCanPlay = ( IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash." & MM_contentVersion)))\n');
	document.write('</SCR' + 'IPT\> \n');
}

//-->
</script>
<script language="JavaScript" type="text/JavaScript">
if ( MM_FlashCanPlay) {
} else{
	window.document.location.href="../players_download/telecharge_flash_7.htm"
}
</script>

<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="640" height="400" id="player_progressive" align="middle">
      <param name="allowScriptAccess" value="sameDomain" />
      <param name="movie" value="player_progressive.swf?nomFichierVideoDepuisInternet=<? echo $nomvideo ?>" />
      <param name="quality" value="high" />
      <param name="bgcolor" value="#ffffff" />
      <embed src="player_progressive.swf?nomFichierVideoDepuisInternet=<? echo $nomvideo ?>" quality="high" bgcolor="#ffffff" width="640" height="400" name="player_progressive" align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />    
</object></td>
  </tr>
</table>
</body>
</html>
