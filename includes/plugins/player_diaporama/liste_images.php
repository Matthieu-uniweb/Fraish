<?
// Variables
$ligne="";
$nombreImages=0;
$listeImage="";

// Test pour serveurs hebergement avec vieux php (Oleane...)
if (!$nomDiaporama)
	{
	$nomDiaporama=$_GET['nomDiaporama'];
	}

// Parcourir le répertoire
chdir("../../../images/diaporamas/".$nomDiaporama."/");
$repertoire=opendir(".");
while ($fichier = readdir($repertoire))
	{
	if($fichier != '..' && $fichier !='.')
		{
		if (strpos($fichier,'jpg')>=1)
		// ce sont des fichiers
			{
			$fichiers[]=$fichier;
		 	}
		}
	}
closedir($repertoire);

// Tri des images par ordre alpha
sort($fichiers);
for ($i=0;$i<=count($fichiers);$i++)
	{
	$listeImage.="&nomImage".($i+1)."=".$fichiers[$i]."&legendeImage".($i+1)."=";
	}
$nombreImages=count($fichiers);

// Envoi des infos à l'appli flash
echo "nombreImages=".$nombreImages.$listeImage."&fichierVariableCharge=ok";
?>