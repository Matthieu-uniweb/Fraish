if (window==parent) //si page racine
{
window.self.name="principal";
}


// fonctions dreamweaver
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

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

function MM_openBrWindow(theURL,winName,features) {
	if (winName=='pdfreader')
		{
		var cheminSansNomFichier = 'http:';
		var listeRepertoire = window.location.href.split("/");

		for (i=1; i<listeRepertoire.length-1; i++)
			{ cheminSansNomFichier = cheminSansNomFichier+'/'+listeRepertoire[i]; }

		if (window.location.hostname.lastIndexOf("laetis.loc") == -1)
			{
			chemin = 'http://'+listeRepertoire[2]+'/';
			win=window.open(chemin+'includes/plugins/pdf/framepdf.php?pdfPage='+cheminSansNomFichier+'/'+theURL,winName,'scrollbars=yes,resizable=yes');
			}
		else
			{
			chemin = 'http://'+listeRepertoire[2]+'/'+listeRepertoire[3]+'/';
			win=window.open(chemin+'includes/plugins/pdf/framepdf.php?pdfPage='+cheminSansNomFichier+'/'+theURL,winName,'scrollbars=yes,resizable=yes');
			}
		}
	else
		{
		win=window.open(theURL,winName,features);
		}
	win.opener = self;
	win.focus();			
}


function openPop(theURL) {
	
	MM_openBrWindow("fr/compositions/" + theURL,"popCompo",'width=900, height=560,scrollbars=yes,resizable=no,status=yes');
	
}

function openPage(theURL) {
	
	MM_openBrWindow("fr/pages/" + theURL,"popPage",'width=900, height=560,scrollbars=yes,resizable=no,status=yes');
	
}
// fonction laetis
nav = navigator.appName.substring(0,3);
ver = navigator.appVersion.substring(0,1);

function printAll()
	{
	window.self.print();
	}

function ajouterFavoris()
{
if (nav == "Mic" && ver >= 4 && navigator.platform.substring(0,3)=="Win")
{
url_site=window.self.location.href;
titre_site = window.document.title;
window.external.AddFavorite(url_site, titre_site);
}
else
{
if (navigator.platform.substring(0,3)=="Win")
{
window.alert("Appuyez sur Ctrl + D, pour ajouter ce site à vos favoris");
}
else
{
window.alert("Appuyez sur Pomme + D, pour ajouter ce site à vos favoris");
}

}
}

function envoyerPageAmi()
{
	objetLien=MM_findObj("pageAmiLien");
	objetLien.href=objetLien.href + "?titreAmi=" + window.document.title + "&urlAmi=" + window.document.location.href;
	
}