<?
// Test pour serveurs hebergement avec vieux php (Oleane...)
if (!$nomvideo)
	{
	$nomvideo=$_GET["nomvideo"];
	}
// l'animation flash se charge de redriver vers le dossier vidéo.
// bug sous mac si la chaine video est trop longue
?>
<HTML>
<HEAD>
<meta http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<TITLE>Player Vid&eacute;o La&euml;tis</TITLE>

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
var MM_contentVersion = 6;
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
	window.document.location.href="../players_download/telecharge_flash.htm"
}
</script>

<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" name="myflash" width="363" height="338" id="myflash">
  <param name="movie" value="player.swf?nomFichierVideoDepuisInternet=<? echo $nomvideo?>">
  <param name="quality" value="high"><param name="SCALE" value="exactfit">
<embed src="player.swf?nomFichierVideoDepuisInternet=<? echo $nomvideo ?>" width="363" height="338" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" scale="exactfit" name="myflash" swLiveConnect="true"></embed></object>
<script language="JavaScript" type="text/JavaScript">
if ( MM_FlashCanPlay )
{
//envoie la chaine string à l'animation flash pour touver la video
//doPassVar();
}
</script>
</BODY>
</HTML>
