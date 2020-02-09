<?php
/**
 * Enter description here...
 *
 */
require_once ('./class/commun/mysql.class.php');

class article
{

var $dimension_image 	= '200';
var $nb_photos_max 		= 1;

function __construct()
	{
	}

function calculerIdArticle($size)
	{
	    $chaine = "0123456789";
		srand((double)microtime()*1000000); 
		for ( $i = 0 ; $i < $size ; $i++) // Clé de cryptage 
		{ 
		    $numero .= $chaine[rand()%strlen($chaine)];
					} 
		return $numero ;
	}
	
function create($data)
	{
			$rqt = new mysql ;
			$idArticle = $this->calculerIdArticle('5') ;
			$rst1 = $rqt->query("INSERT INTO article (id, nom, date, description, texte, en_ligne) VALUES ('$idArticle','".htmlentities($data[nom],ENT_QUOTES)."', '".$data[date]."', '".utf8_encode(htmlentities($data[editor_1], ENT_QUOTES))."', '".utf8_encode(htmlentities($data[editor_2], ENT_QUOTES))."', '$data[en_ligne]')");
			$rst = $rqt->query("INSERT INTO rayon_article (rayon, article) VALUES ('$data[rayon]','$idArticle') ");
			
			//traitement des photos
			for ($i = 1; $i <= $this->nb_photos_max; $i++){
				if($_FILES['photo_'.$i]['tmp_name'] != ''){				
					// creation du fichier temporaire				
					$tmp_file = 'documents/articles/tmp.jpg';
					move_uploaded_file($_FILES['photo_'.$i]['tmp_name'], $tmp_file);				
					chmod($tmp_file,0644);				
					// creation du fichier final
					$dest_file = 'documents/articles/'.$data[article].'_'.$i.'.jpg';
					$this->creer_image($dest_file, $tmp_file);
					chmod($dest_file,0644);				
					// suppresion du fichier temporaire
					unlink($tmp_file);
				}	
			}
			
			//traitement du PDF
			if($_FILES['pdf']['tmp_name'] != ''){				
				// creation du fichier temporaire				
				$dest_file = 'documents/articles/'.$data[article].'.pdf';
				move_uploaded_file($_FILES['pdf']['tmp_name'], $dest_file);				
				chmod($dest_file,0644);
			}
			
			return ($idArticle);
	}

function lister_migration($table)
	{
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT * FROM $table WHERE sup != 'ok' ORDER BY id ASC");
			return $rst;
	}
		
function create_migration($data)
	{
			$rqt = new mysql ;
			$idArticle = $this->calculerIdArticle('5') ;
			$rst1 = $rqt->query("INSERT INTO article (id, nom, date, description, texte, en_ligne) VALUES ('$idArticle','".htmlentities($data[nom],ENT_QUOTES)."', '".$data[date]."', '".htmlentities($data[editor_1], ENT_QUOTES)."', '".htmlentities($data[editor_2], ENT_QUOTES)."', '$data[en_ligne]')");
			$rst = $rqt->query("INSERT INTO rayon_article (rayon, article) VALUES ('$data[rayon]','$idArticle') ");
			
			//traitement des photos
			for ($i = 1; $i <= $this->nb_photos_max; $i++){
				if($_FILES['photo_'.$i]['tmp_name'] != ''){				
					// creation du fichier temporaire				
					$tmp_file = 'documents/articles/tmp.jpg';
					move_uploaded_file($_FILES['photo_'.$i]['tmp_name'], $tmp_file);				
					chmod($tmp_file,0644);				
					// creation du fichier final
					$dest_file = 'documents/articles/'.$data[article].'_'.$i.'.jpg';
					$this->creer_image($dest_file, $tmp_file);
					chmod($dest_file,0644);				
					// suppresion du fichier temporaire
					unlink($tmp_file);
				}	
			}
			
			//traitement du PDF
			if($_FILES['pdf']['tmp_name'] != ''){				
				// creation du fichier temporaire				
				$dest_file = 'documents/articles/'.$data[article].'.pdf';
				move_uploaded_file($_FILES['pdf']['tmp_name'], $dest_file);				
				chmod($dest_file,0644);
			}
			
			return ($idArticle);
	}
	
function liste()
	{
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT * FROM article");
			return $rst;
	}
	
function detail($data)
	{
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT article.nom,article.id,article.description,article.texte,article.en_ligne,article.date,rayon.nom as idRayon, gamme.nom as idGamme FROM rayon, article, rayon_article, gamme, gamme_rayon where article.id='$data[article]' and rayon.id=rayon_article.rayon and rayon_article.article='$data[article]' and gamme_rayon.gamme=gamme.id and gamme_rayon.rayon=rayon.id");
			if ($rqt->num_rows() > 0) {
				$result = array ('id' => mysql_result($rst,0,'article.id') , 'nom' => mysql_result($rst,0,'article.nom') , 'date' => mysql_result($rst,0,'article.date') , 'description' => mysql_result($rst,0,'article.description'), 'texte' => mysql_result($rst,0,'article.texte'), 'rayon' => mysql_result($rst,0,'idRayon'), 'gamme' => mysql_result($rst,0,'idGamme'), 'en_ligne' => mysql_result($rst,0,'en_ligne')); 			
			}else{
				$result = array ('id' => '' , 'nom' => '' , 'description' => '', 'texte' => '', 'en_ligne' => '', 'date' => ''); 
			}
			return $result;
	}

function listeParRayonEnLigne($data)
	{
			$rqt = new mysql;
			$rst = $rqt->query("SELECT DISTINCT article.id,article.en_ligne,article.nom,article.description,article.texte FROM article,rayon_article where rayon_article.rayon='$data[rayon]' and article.en_ligne = '1' and rayon_article.article=article.id ORDER BY id DESC");
			return $rst;
	}

function listeParRayonEnLigneOrderByNom($data)
	{
			$rqt = new mysql;
			$rst = $rqt->query("SELECT DISTINCT article.id,article.en_ligne,article.nom,article.description,article.texte FROM article,rayon_article where rayon_article.rayon='$data[rayon]' and article.en_ligne = '1' and rayon_article.article=article.id ORDER BY nom ASC");
			return $rst;
	}

function listeParRayonEnLigneOrderByDate($data)
	{
			$rqt = new mysql;
			$rst = $rqt->query("SELECT DISTINCT article.id,article.en_ligne,article.nom,article.description,article.texte FROM article,rayon_article where rayon_article.rayon='$data[rayon]' and article.en_ligne = '1' and rayon_article.article=article.id ORDER BY date DESC, nom ASC");
			return $rst;
	}
		
function listeHebergementVicEnLigne($data)
	{
			$rqt = new mysql;
			$rst = $rqt->query("SELECT DISTINCT 
									article.id,article.en_ligne,
									article.nom,
									article.description,
									article.texte 
								FROM 
									article,rayon_article 
								WHERE 
									rayon_article.rayon='$data[rayon]' AND 
									article.en_ligne = '1' AND 
									rayon_article.article=article.id AND
									article.nom LIKE '%Vic-Fezensac%'
								ORDER BY article.nom ASC");
			return $rst;
	}
	
function listeHebergementAutreEnLigne($data)
	{
			$rqt = new mysql;
			$rst = $rqt->query("SELECT DISTINCT 
									article.id,article.en_ligne,
									article.nom,
									article.description,
									article.texte 
								FROM 
									article,rayon_article 
								WHERE 
									rayon_article.rayon='$data[rayon]' AND 
									article.en_ligne = '1' AND 
									rayon_article.article=article.id AND
									article.nom NOT LIKE '%Vic-Fezensac%'
								ORDER BY article.nom ASC");
			return $rst;
	}
	
function listeParRayon($data)
	{
			$rqt = new mysql;
			$rst = $rqt->query("SELECT DISTINCT article.id,article.en_ligne,article.nom,article.description FROM article,rayon_article where rayon_article.rayon='$data[rayon]' and rayon_article.article=article.id order by nom");
			return $rst;
	}

function recherche($data)
	{
			$rqt = new mysql;
			$rst = $rqt->query("SELECT * FROM article WHERE nom LIKE '%".htmlentities($data[recherche],ENT_QUOTES)."%' OR description LIKE '%".htmlentities($data[recherche],ENT_QUOTES)."%' ORDER BY nom");
			return $rst;
	}
	
function nom($id)
	{
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT nom FROM article where id='$id'");
			return mysql_result($rst,0,'nom');
	}

function update($data)
	{
			$rqt = new mysql ;		
			$rst1 = $rqt->query("UPDATE article set nom='".htmlentities($data[nom],ENT_QUOTES)."', date='".$data[date]."', description='".utf8_encode(htmlentities($data[editor_1], ENT_QUOTES))."', texte='".utf8_encode(htmlentities($data[editor_2], ENT_QUOTES))."',  en_ligne='$data[en_ligne]'  where id='$data[article]'");
			
			//traitement des photos
			for ($i = 1; $i <= $this->nb_photos_max; $i++){
				if($_FILES['photo_'.$i]['tmp_name'] != ''){				
					// crï¿½ation du fichier temporaire				
					$tmp_file = 'documents/articles/tmp.jpg';
					move_uploaded_file($_FILES['photo_'.$i]['tmp_name'], $tmp_file);				
					chmod($tmp_file,0644);				
					// crï¿½ation du fichier final
					$dest_file = 'documents/articles/'.$data[article].'_'.$i.'.jpg';
					$this->creer_image($dest_file, $tmp_file);
					chmod($dest_file,0644);				
					// suppresion du fichier temporaire
					unlink($tmp_file);
				}	
			}
			
			//traitement du PDF
			if($_FILES['pdf']['tmp_name'] != ''){				
				// crï¿½ation du fichier temporaire				
				$dest_file = 'documents/articles/'.$data[article].'.pdf';
				move_uploaded_file($_FILES['pdf']['tmp_name'], $dest_file);				
				chmod($dest_file,0644);
			}
					
			return ($rst OR $rst1);
	}
	
function update_en_ligne($data)
	{
			$rqt = new mysql ;		
			$rst = $rqt->query("UPDATE article SET en_ligne = '$data[en_ligne]' WHERE id = '$data[article]'");
			return $rst;
	}
	
function delete($data)
	{
			$rqt = new mysql ;
			$rst = $rqt->query("DELETE FROM article where id='$data[article]'");
			$rst1 = $rqt->query("DELETE FROM rayon_article where article='$data[article]'");
			
			//traitement des photos
			for ($i = 1; $i <= $this->nb_photos_max; $i++){
				$filename = 'documents/articles/'.$data[article].'_'.$i.'.jpg';
				if (file_exists($filename)) {
	   				$delete = unlink($filename);
				}	
			}
			
			return ($rst OR $rst1);
	}

function creer_image($img_dest, $img_src) 
	{ 
    	$size 		= GetImageSize($img_src);  
	   	$src_w 		= $size[0]; 
	   	$src_h 		= $size[1];
	   	$new_width 	= $this->dimension_image;
	   	$new_height = $this->dimension_image;
	   	
	   	// Teste les dimensions tenant dans la zone
	   	$test_h = round(($new_width / $src_w) * $src_h);
	   	$test_w = round(($new_height / $src_h) * $src_w);
	   	
	   	// Si Height final non prï¿½cisï¿½ (0)
	   	if(!$new_height) 
	   		$new_height = $test_h;
	   		
	   	// Sinon Si Width final non prï¿½cisï¿½ (0)
	   	elseif(!$new_width) 
	   		$new_width = $test_w;
	   		
	   	// Sinon teste quelles dimensions tienne dans la zone
	   	elseif($test_h > $new_height) 
	   		$new_width 	= $test_w;
	   	else 
	   		$new_height = $test_h;
	   	
	   	// Redimensionnement
		$thumb 		= imagecreatetruecolor($new_width, $new_height);
		$image 		= imagecreatefromjpeg($img_src);
		$quality 	= 87;
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $new_width, $new_height, $src_w, $src_h);
		ImageJPEG ($thumb, $img_dest, $quality);
}
	
function redimensionner_image($img_src,$img_with) 
	{
		$size 		= GetImageSize($img_src);  
	   	$src_w 		= $size[0]; 
	   	$src_h 		= $size[1];
	   	$new_width 	= $img_with;
	   	$new_height = $img_with;
	   	
	   	// Teste les dimensions tenant dans la zone
	   	$test_h = round(($new_width / $src_w) * $src_h);
	   	$test_w = round(($new_height / $src_h) * $src_w);
	   	
	   	// Si Height final non prï¿½cisï¿½ (0)
	   	if(!$new_height) 
	   		$new_height = $test_h;
	   		
	   	// Sinon Si Width final non prï¿½cisï¿½ (0)
	   	elseif(!$new_width) 
	   		$new_width = $test_w;
	   		
	   	// Sinon teste quelles dimensions tienne dans la zone
	   	elseif($test_h > $new_height) 
	   		$new_width 	= $test_w;
	   	else 
	   		$new_height = $test_h;
	   		
	   	$rst = 'width="'.$new_width.'" height="'.$new_height.'"';	   	
	   	return $rst;
	}
}
?>