<?
class Infomot extends T_LAETIS_site
{

/* Définition des attributs */
var $ID;
var $mot;
var $cheminFichier;
var $titrePage;
var $nbOccurences;
var $poids;


function Infomot()
	{	
	}

function getID()
	{
	return $this->ID;
	}
	
function setID($ID)
	{
	$this->ID=$ID;
	}

function getMot()
	{
	return $this->mot;
	}
	
function setMot($mot)
	{
	$this->mot=$mot;
	}
	
function getCheminFichier()
	{
	return $this->cheminFichier;
	}
	
function setCheminFichier($cheminFichier)
	{
	$this->cheminFichier=$cheminFichier;
	}
	
function getTitrePage()
	{
	return $this->titrePage;
	}
	
function setTitrePage($titrePage)
	{
	$this->titrePage=$titrePage;
	}
	
function getNbOccurences()
	{
	return $this->nbOccurences;
	}
	
function setNbOccurences($nbOccurences)
	{
	$this->nbOccurences=$nbOccurences;
	}
	
function getPoids()
	{
	return $this->poids;
	}
	
function setPoids($poids)
	{
	$this->poids=$poids;
	}
}
?>
