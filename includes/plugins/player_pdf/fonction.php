<?
/**
 * Constant to represent a Kilobyte
 */
define ('FILE_SIZE_KILO', 1024);

/**
 * Constant to represent a Megabyte
 */
define ('FILE_SIZE_MEGA', 1048576);

/**
 * Constant to represent a Gigabyte
 */
define ('FILE_SIZE_GIGA', 1073741824);


function getCheminRacine ()
	{
	/**
	* une fonction qui recherche le chemin relatif vers la racine pour le fichier courant
	* en comptant à partir du chemin obtenu depuis pathinfo le nombre de '/'
	*
	*
	*/
	$path_parts = pathinfo($_SERVER['PHP_SELF']);
	$niveau=substr_count($path_parts["dirname"],'/')-1;
	// on distingue le serveur local du distant
	// sur le local, le premier repertoire correspond à l'utilisateur
	if (strpos($tab['host'], "laetis.loc", 0))
		{
		// Local
		$niveau--;
		}

	// on construit le chemin relatif
	$cheminRelatif="";
	for ($i=0;$i<=$niveau;$i++)
		{
		$cheminRelatif.="../";
		}
	return $cheminRelatif;
	}
	
/**
 * Outputs the file size in a formatted way
 * 
 * The Modifiers K, M and G will be used to represent Kilobytes,
 * Megabytes and Gigabytes respectively
 *
 * The dp parameter can be used to specify the number of decimal
 * places to display
 *
 * @access public
 * @param  int    $dp Number of decimal places to display
 * @return string Formatted file size
 */
function formattedSize ($nomFichier, $dp=2)
{
	$size = filesize($nomFichier);
	
	if ($size > FILE_SIZE_GIGA) {
		$size = round($size / FILE_SIZE_GIGA, $dp) . ' Go';
	} else if ($size > FILE_SIZE_MEGA) {
		$size = round($size / FILE_SIZE_MEGA, $dp) . ' Mo';
	} else if ($size > FILE_SIZE_KILO) {
		$size = round($size / FILE_SIZE_KILO, $dp) . ' Ko';
	}

	return $size; 
}
?>