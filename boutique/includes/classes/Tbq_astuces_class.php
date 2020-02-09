<?php
class Tbq_astuces
	{	
	
	var $content;	
	
	function __construct()
		{		
		$this->initialiser();
		}

	function initialiser()
		{
			// initialisation de l'objet
			$requete = "SELECT * FROM astuces_sophie WHERE id_astuce='1'";
			$resultats = T_LAETIS_site::requeter($requete);
			if ($resultats[0])
				{
				foreach ($resultats[0] as $nomChamp => $valeur)
					{
					$this->$nomChamp = stripslashes($valeur);
					}
				}			
		}
	
	function Tbq_client()
		{
		$this->__construct();
		}
	
	function enregistrer($content)
		{
			$requete = "UPDATE astuces_sophie SET content = '".$content."' ";
			$requete .= " WHERE id_astuce=1";
			$resSql = T_LAETIS_site::requeter($requete);
		} 
	
	function get()
		{		
		$resultats = array();
		$requete = "SELECT content FROM astuces_sophie WHERE id_astuce=1";
		$resSql = T_LAETIS_site::requeter($requete);				
		return ($resSql);
		}

	}
?>