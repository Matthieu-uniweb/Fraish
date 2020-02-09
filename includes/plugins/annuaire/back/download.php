<? 
/** 
* Télécharger un fichier
* @param string $fichier Nom du fichier à télécharger
* @access  public 
*/
$fic = $_GET['fic'];
header("Content-disposition: attachment; filename=$fic");
header("Content-Type: application/force-download"); 
header("Content-Transfer-Encoding: binary"); 
header("Content-Length: ".filesize('../../../../uploads/'.$fic)); 
header("Pragma: no-cache"); 
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); 
header("Expires: 0"); 
readfile('../../../../uploads/'.$fic); 
?> 
