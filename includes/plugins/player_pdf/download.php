<?
header("Content-disposition: attachment; filename=".basename($_GET['pdfPage']));
header("Content-Type: application/force-download");
header("Content-Transfer-Encoding: binary"); 
header("Content-Length: ".filesize($_GET['pdfPage']));
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");
readfile($_GET['pdfPage']);
?>