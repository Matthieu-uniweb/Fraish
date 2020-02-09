<?php
/**
  Version : 2.3
  Pour Gestion Actus avec titre et photo, gestion des photos par numéro unique aléatoire
 * Gestion Si pas de photo, gestion vignettes pour accélérer affichage
 * Photo : uniquement jpeg
 * Gestion du dossier en séparé, pour changement rapide...
 */
 
 
require_once ('./class/commun/mysql.class.php');

class actus
{

var $folderImg  = 'media/actus/';

function __construct()
	{
	}

function create($data)
	{
		//$num= rand ('1','99999');    
    $numero ="";    
    
		//traitement des photos			
			if($_FILES['photo']['tmp_name'] != ''){
			  $chaine = "0123456789";
        srand((double)microtime()*1000000); 
        for ( $i = 0 ; $i < 6 ; $i++) { $numero .= $chaine[rand()%strlen($chaine)]; }    				
				// creation du fichier temporaire				
				$tmp_file = $this->folderImg.'tmp.jpg';
				move_uploaded_file($_FILES['photo']['tmp_name'], $tmp_file);				
				chmod($tmp_file,0644);				
				// creation du fichier final
				$dest_file = $this->folderImg.$numero.'.jpg';
        $dest_vignette = $this->folderImg.'vi_'.$numero.'.jpg';
				$this->creer_image($dest_file, $tmp_file, '1280', '1024');
        $this->creer_image($dest_vignette, $tmp_file, '250', '187');
				chmod($dest_file,0644);	
        chmod($dest_vignette,0644);   			
				// suppresion du fichier temporaire
				unlink($tmp_file);
			}	
		
		$rqt = new mysql ;			
		//$rst1 = $rqt->query("INSERT INTO actus (content, online) VALUES ('".htmlentities($data[content],ENT_QUOTES,'UTF-8')."', '1')");
		$rst1 = $rqt->query("INSERT INTO actus (titre, content, online, photo) VALUES ('".addslashes($data[titre])."','".addslashes($data[content])."', '1', '$numero')");
			
		return ($idArticle);
	}

function liste()
	{
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT * FROM actus");
			return $rst;
	}
	
	
	
function detail($data)
	{
			if ($data[id_actu]=="") {$data[id_actu]=$data[id];}
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT * FROM actus where id_actus='$data[id_actu]'");			
			return $rst;
	}

function listeEnLigne($data)
	{
			$rqt = new mysql;
			$rst = $rqt->query("SELECT * FROM actus WHERE online='1'");
			return $rst;
	}


function update($data)
	{		
		$rqt = new mysql ;
			//traitement des photos			
			if($_FILES['photo']['tmp_name'] != ''){
			  //génération numéro aléatoire unique
				 $chaine = "123456789";
		        srand((double)microtime()*1000000); 
		        for ( $i = 0 ; $i < 6 ; $i++) { $num .= $chaine[rand()%strlen($chaine)]; }   
				//supression de l'ancienne photo
				unlink($this->folderImg.$data[id_photo].'.jpg');
				unlink($this->folderImg.'vi_'.$data[id_photo].'.jpg');
				// creation du fichier temporaire
				$tmp_file = $this->folderImg.'tmp.jpg';
				move_uploaded_file($_FILES['photo']['tmp_name'], $tmp_file);
				chmod($tmp_file,0644);
				// creation du fichier final
				$dest_file = $this->folderImg.$numero.'.jpg';
		        $dest_vignette = $this->folderImg.'vi_'.$numero.'.jpg';
		        $this->creer_image($dest_file, $tmp_file, '1280', '1024');
		        $this->creer_image($dest_vignette, $tmp_file, '250', '187');
						chmod($dest_file,0644);
		        chmod($dest_vignette,0644);
				// suppresion du fichier temporaire
				unlink($tmp_file);
				$rst = $rqt->query("UPDATE actus set content='".addslashes($data[content])."' , photo='".$num."', titre='".addslashes($data[titre])."' where id_actus='$data[id_actu]'");	
			}			
			else 
			{
					
			//$rst = $rqt->query("UPDATE actus set content='".htmlentities($data[content],ENT_QUOTES,'UTF-8')."' where id_actus='$data[id_actu]'");	
			$rst = $rqt->query("UPDATE actus set content='".addslashes($data[content])."', titre='".addslashes($data[titre])."' where id_actus='$data[id_actu]'");	
			}
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
	
function up($data)
  {   
    $rqt = new mysql ;
    
    $rst1 = $rqt->query("SELECT ordre FROM actus WHERE id_actus='".$data[id_actu]."'");
    $L_actus = mysql_fetch_array ($rst1);
    
    $oo=$L_actus[ordre]-1;    
    $rst2 = $rqt->query("UPDATE actus SET ordre = ordre + 1 WHERE ordre='".$oo."'");
    
    $rst = $rqt->query("UPDATE actus SET ordre = ordre - 1 WHERE id_actus='".$data[id_actu]."'");
    
    
    
    return ($rst);
  }

function down($data)
  {   
    $rqt = new mysql ;
    
    $rst1 = $rqt->query("SELECT ordre FROM actus WHERE id_actus='".$data[id_actu]."'");
    $L_actus = mysql_fetch_array ($rst1);
    
    $oo=$L_actus[ordre]+1;    
    $rst2 = $rqt->query("UPDATE actus SET ordre = ordre - 1 WHERE ordre='".$oo."'");
    
    $rst = $rqt->query("UPDATE actus SET ordre = ordre + 1 WHERE id_actus='".$data[id_actu]."'");
    return ($rst);
  }

function ordreMax()
  {
      $rqt = new mysql ;      
      $rst1 = $rqt->query("SELECT ordre FROM actus ORDER BY ordre DESC LIMIT 0 , 1");
      $L_actus = mysql_fetch_array ($rst1);
      return ($L_actus[ordre]);
  }

function ordreMin()
  {
      $rqt = new mysql ;      
      $rst1 = $rqt->query("SELECT ordre FROM actus ORDER BY ordre ASC LIMIT 0 , 1");
      $L_actus = mysql_fetch_array ($rst1);
      return ($L_actus[ordre]);
  }	

function creer_image($img_dest, $img_src, $width, $height) 
	{ 
    	$size 		= GetImageSize($img_src);  
	   	$src_w 		= $size[0]; 
	   	$src_h 		= $size[1];
	   	$new_width 	= $width;
	   	$new_height = $height;
	   	
	   	// Teste les dimensions tenant dans la zone
	   	$test_h = round(($new_width / $src_w) * $src_h);
	   	$test_w = round(($new_height / $src_h) * $src_w);
	   	
	   	// Si Height final non précisé (0)
	   	if(!$new_height) 
	   		$new_height = $test_h;
	   		
	   	// Sinon Si Width final non précisé (0)
	   	elseif(!$new_width) 
	   		$new_width = $test_w;     
      	
	   	// Sinon teste quelles dimensions tienne dans la zone
	   	elseif($test_h > $new_height) 
	   		$new_width 	= $test_w;
	   	else 
	   		$new_height = $test_h;
	   		
	   		
	   	 //teste si la photo fournie est plus petite que la taille désirée au final :
     if($width >= $src_w )  $new_width  = $src_w;
     if($height >= $src_h ) $new_height = $src_h;  	
	   		
	   	
	   	// Redimensionnement
		$thumb 		= imagecreatetruecolor($new_width, $new_height);
		$image 		= imagecreatefromjpeg($img_src);
		$quality 	= 87;
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $new_width, $new_height, $src_w, $src_h);
		ImageJPEG ($thumb, $img_dest, $quality);
}

	
function redimensionner_image_affichage($img_src,$img_with) 
	{
		$size 		= GetImageSize($img_src);  
	   	$src_w 		= $size[0]; 
	   	$src_h 		= $size[1];
	   	$new_width 	= $img_with;
	   	$new_height = $img_with;
	   	
	   	// Teste les dimensions tenant dans la zone
	   	$test_h = round(($new_width / $src_w) * $src_h);
	   	$test_w = round(($new_height / $src_h) * $src_w);
	   	
	   	// Si Height final non précisé (0)
	   	if(!$new_height) 
	   		$new_height = $test_h;
	   		
	   	// Sinon Si Width final non précisé (0)
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