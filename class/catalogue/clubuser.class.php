<?php
/**
  Version : 2.3
  Pour Gestion Actus avec titre et photo, gestion des photos par numéro unique aléatoire
 * Gestion Si pas de photo, gestion vignettes pour accélérer affichage
 * Photo : uniquement jpeg
 * Gestion du dossier en séparé, pour changement rapide...
 */
 
 
require_once ('./class/commun/mysql.class.php');

class clubUser
{


function __construct()
	{
	}

function create($data)
	{
		$rqt = new mysql ;

		list($jour, $mois, $annee) = explode('/', $data[datenaissance]);
    	$madate = $annee."-".$mois."-".$jour;

		$rst1 = $rqt->connect();

		$rst1 = $rqt->query("INSERT INTO club_users (
												civilite,
												nom,
												prenom,
												adresse,
												cpostal,
												tel,
												email,
												date_naissance,
												tutti_pref,
												ville,
												mdpass
                                                ) VALUES (
                                                '".$data[civilite]."',
                                                '".mysql_real_escape_string(addslashes($data[nom]))."',
                                                '".mysql_real_escape_string(addslashes($data[prenom]))."',
                                                '".mysql_real_escape_string(addslashes($data[adresse]))."',
                                                '".mysql_real_escape_string(addslashes($data[cp]))."',
                                                '".mysql_real_escape_string(addslashes($data[tel]))."',
                                                '".mysql_real_escape_string(addslashes($data[email]))."',
                                                '".$madate."',
                                                '".$data[tuttipref]."',
                                                '".mysql_real_escape_string(addslashes($data[ville]))."',
                                                '".addslashes($data[mdp])."'
                                                )");	
		return ($rqt->insert_id());
		
		
		
		
		
		
	}

function liste()
	{
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT * FROM club_users");
			return $rst;
	}


function detail($data)
	{			
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT * FROM club_users where id_users='$data[id_user]'");			
			return $rst;
	}

	
function recupmdp($data)
  {     
      $rqt = new mysql ;
      $rst = $rqt->query("SELECT mdpass FROM club_users where email='$data[email]'");     
      $franchise  = mysql_fetch_array($rst);
      return $franchise[mdpass];
  }

function update($data)
	{		
		$rqt = new mysql ;
    
    
		$rst = $rqt->query("UPDATE adherents set		
		                           numero_adh='".$data[numero_adh]."',                            
                               civilite='".$data[civilite]."', 
                               nom='".$data[nom]."', 
                               prenom='".$data[prenom]."', 
                               date_naissance='".$data[date_naissance]."', 
                               adresse_perso='".$data[adresse_perso]."', 
                               cp_perso='".$data[cp_perso]."', 
                               ville_perso='".$data[ville_perso]."', 
                               tel_perso='".$data[tel_perso]."', 
                               grade='".$data[grade]."', 
                               indice='".$data[indice]."', 
                               perimetre='".$data[perimetre]."', 
                               adresse_pro='".$data[adresse_pro]."', 
                               cp_pro='".$data[cp_pro]."', 
                               ville_pro='".$data[ville_pro]."', 
                               num_departement='".$data[num_departement]."', 
                               tel_pro='".$data[tel_pro]."', 
                               email='".$data[email]."',
                               etat_adh=1,
                               autorise='".$data[autorise]."'
		                           where id_adh='$data[id_adh]'");
		return ($rst);
	}
	
	
function delete($data)
	{
			$rqt = new mysql ;
      
      //Supression des fichiers photos associés
      $rst = $rqt->query("SELECT photo FROM actus WHERE id_actus='$data[idactu]'");
      while ($L_pix = mysql_fetch_array ($rst)){ unlink ($this->folderImg.$L_pix[photo]); unlink ($this->folderImg.'vi_'.$L_pix[photo]);}        
      
			$rst = $rqt->query("DELETE FROM actus where id_actus='$data[idactu]'");
			return ($rst);
	}


}
?>