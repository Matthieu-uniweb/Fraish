<html>
<head>
<title>Téléchargement de fichier PDF</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<frameset rows="142,1*" frameborder="NO" border="0" framespacing="0"> 
  <frame name="menu" scrolling="NO" noresize src="menupdf.php?pdfPage=<? echo $_GET['pdfPage']; ?>" frameborder="NO" >
  <frame name="mainFrame" src="<? echo $_GET['pdfPage']; ?>" frameborder="NO">
</frameset>
<noframes><body bgcolor="#FFFFFF">
</body></noframes>
</html>