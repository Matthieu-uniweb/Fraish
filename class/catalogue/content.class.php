<?php
/**
 * Enter description here...
 *
 */
require_once ('./class/commun/mysql.class.php');

class content
{

var $dimension_image 	= '200';
var $nb_photos_max 		= 0;

function __construct()
	{
	}

function calculerIdArticle($size)
	{
	    $chaine = "0123456789";
		srand((double)microtime()*1000000); 
		for ( $i = 0 ; $i < $size ; $i++) // Cl� de cryptage 
		{ 
		    $numero .= $chaine[rand()%strlen($chaine)];
					} 
		return $numero ;
	}
	
function create($data)
	{
			$rqt = new mysql ;			
			$rst1 = $rqt->query("INSERT INTO contents ( titre, texte, rubrique, ss_rubrique, date_gen, date_edit, online) VALUES ('".$data[titre]."','".$data[content]."','".$data[rubrique]."','".$data[ss_rubrique]."',NOW(),NOW(),'1')");			
						
			return ($idArticle);
	}
  
function createCategorie($data)
  {
      $rqt = new mysql ;      
      $rst1 = $rqt->query("INSERT INTO rubrique ( titre) VALUES ('".$data[titre]."')");            
      return 1;
  }  
  
function createSsCategorie($data)
  {
      $rqt = new mysql ;      
      $rst1 = $rqt->query("INSERT INTO ss_rubrique ( titre, id_rub) VALUES ('".$data[titre]."','".$data[id_rub]."')");            
      return 1;
  }
	
function liste()
	{
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT * FROM contents");
			return $rst;
	}
	
function detail($data)
	{
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT titre, texte, id_content FROM contents where rubrique='$data[id_rub]' and ss_rubrique='$data[id_ss_rub]'");
			
			return $rst;
	}

function detailSsRub($data)
  {
      $rqt = new mysql ;
      $rst = $rqt->query("SELECT titre, texte, id_content FROM contents where ss_rubrique='$data[ids]'");
      
      return $rst;
  }
  
function detailRub($data)
  {
      $rqt = new mysql ;
      $rst = $rqt->query("SELECT titre, texte, id_content FROM contents where rubrique='$data[id]'");
      
      return $rst;
  }
  
function listeSSrubParRub($idRub)
  {
      $rqt = new mysql;
      $rst = $rqt->query("SELECT titre,id_ss_rub FROM ss_rubrique where id_rub='$idRub' ORDER BY id_ss_rub DESC");
      return $rst;
  }

function listeRub ()
  {
      $rqt = new mysql;
      $rst = $rqt->query("SELECT titre,id_rub FROM rubrique ORDER BY id_rub ASC");
      return $rst;
  } 

function listeParSSRub($data)
	{
			$rqt = new mysql;
			$rst = $rqt->query("SELECT article.id,article.en_ligne,article.nom,article.description FROM article,rayon_article where rayon_article.rayon='$data[rayon]' and rayon_article.article=article.id order by nom");
			return $rst;
	}

function recherche($data)
	{
			$rqt = new mysql;
			$rst = $rqt->query("SELECT * FROM article WHERE nom LIKE '%".htmlentities($data[recherche],ENT_QUOTES)."%' OR description LIKE '%".htmlentities($data[recherche],ENT_QUOTES)."%' ORDER BY nom");
			return $rst;
	}
	

function update($data)
	{
			$rqt = new mysql ;		
			$rst = $rqt->query("UPDATE contents set titre='".$data[titre]."', texte='".$data[content]."', date_edit = NOW()  WHERE id_content='$data[id_content]' ");
			return ($rst);
	}
	
function update_en_ligne($data)
	{
			$rqt = new mysql ;		
			$rst = $rqt->query("UPDATE content SET online = '$data[online]' WHERE id_content = '$data[id_content]'");
			return $rst;
	}
	
function delete($data)
	{
			$rqt = new mysql ;
			$rst = $rqt->query("DELETE FROM article where id='$data[article]'");
						
			return ($rst);
	}

function deleteSsMenu($data)
  {
      $rqt = new mysql ;
      $rst = $rqt->query("DELETE FROM ss_rubrique where id_ss_rub='$data[id]'");
            
      return ($rst);
  }
}
?>