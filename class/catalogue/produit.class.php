<?php
/**
 * Classe de manipulation de l'arbo
 *
 */
require_once ('./class/commun/mysql.class.php');

class produit {

	var $folderImg = 'media/produits/img/';
	var $folderPDF = 'media/produits/pdf/';

	function __construct() {
	}

	function listeProduitSsCat($id_ss_cat) {
		$rqt = new mysql;
		$rst = $rqt -> query("SELECT * FROM produits WHERE ss_categorie= $id_ss_cat");
		return $rst;
	}

	function listeProduitMarque($marque) {
		$rqt = new mysql;
		$rst = $rqt -> query("SELECT * FROM produits WHERE marque= $marque");
		return $rst;
	}

	function listeProduitCat($id_cat) {
		$rqt = new mysql;
		$rst = $rqt -> query("SELECT * FROM produits WHERE id_categorie = $id_cat");
		return $rst;
	}

	function createProduit($data) {


		$numero="0";
		$numeropdf="0";

		//traitement des photos
		if($_FILES['photo']['tmp_name'] != '') {
			//génération numéro aléatoire unique
			$chaine = "123456789";
			srand((double)microtime() * 1000000);
			for($i = 0; $i < 6; $i++) { $numero .= $chaine[rand() % strlen($chaine)];
			}
			// creation du fichier temporaire
			$tmp_file = $this -> folderImg . 'tmp.jpg';
			move_uploaded_file($_FILES['photo']['tmp_name'], $tmp_file);
			chmod($tmp_file, 0644);
			// creation du fichier final
			$dest_file = $this -> folderImg . $numero . '.jpg';
			$dest_vignette = $this -> folderImg . 'vi_' . $numero . '.jpg';
			$this -> creer_image($dest_file, $tmp_file, '1280', '1024');
			$this -> creer_image($dest_vignette, $tmp_file, '250', '187');
			chmod($dest_file, 0644);
			chmod($dest_vignette, 0644);
			// suppresion du fichier temporaire
			unlink($tmp_file);
		}

		//traitement du pdf
		if($_FILES['pdf']['tmp_name'] != '') {
			//génération numéro aléatoire unique
			$chaine2 = "123456789";
			srand((double)microtime() * 1000000);
			for($i = 0; $i < 6; $i++) { $numeropdf .= $chaine2[rand() % strlen($chaine2)];
			}
			// creation du fichier final
			$dest_file_pdf = $this -> folderPDF . "celians_" . $numeropdf . '.pdf';
			move_uploaded_file($_FILES['pdf']['tmp_name'], $dest_file_pdf);
			chmod($dest_file, 0644);
		}

		$rqt = new mysql;
		$rst1 = $rqt -> query("INSERT INTO produits (	marque, 
														categorie, 
														ss_categorie, 
														ref, 
														nom, 
														description, 
														photo,
														pdf														
														) VALUES (
														'" . $data[marque] . "',
														'" . $data[id_cat] . "',
														'" . $data[id_ss_cat] . "',
														'" . $data[ref] . "',
														'" . $data[nom] . "',
														'" . $data[description] . "',
														'" . $numero . "',
														'" . $numeropdf . "'
														)");
		return 1;
	}

	function deleteProduit($data) {
		$rqt = new mysql;
		$rst = $rqt -> query("DELETE FROM produits where id_produit='$data[id_produit]'");
		return 1;
	}

	function selectProduit($data) {
		$rqt = new mysql;
		$rst = $rqt -> query("SELECT * FROM produits where id_produit='$data[id_produit]'");
		return $rst;
	}	
	
	function selectProduitHazardCat($id_cat) {
		$rqt = new mysql;
		$rst = $rqt -> query("SELECT * FROM produits where categorie='$id_cat' AND photo != '0' ORDER BY RAND()");
		return $rst;
	}

	function updateProduit($data) {
		$rqt = new mysql;
		
		
		//traitement des photos
		if($_FILES['photo']['tmp_name'] != '') {
			//génération numéro aléatoire unique
			$chaine = "123456789";
			srand((double)microtime() * 1000000);
			for($i = 0; $i < 6; $i++) { $num .= $chaine[rand() % strlen($chaine)];
			}
			//supression de l'ancienne photo
			
			if(file_exists($this -> folderImg . $data[id_photo] . '.jpg'))
				unlink($this -> folderImg . $data[id_photo] . '.jpg');	
			if(file_exists($this -> folderImg . 'vi_' . $data[id_photo] . '.jpg'))
				unlink($this -> folderImg . 'vi_' . $data[id_photo] . '.jpg');			
			
			// creation du fichier temporaire
			$tmp_file = $this -> folderImg . 'tmp.jpg';
			move_uploaded_file($_FILES['photo']['tmp_name'], $tmp_file);
			chmod($tmp_file, 0644);
			// creation du fichier final
			$dest_file = $this -> folderImg . $num . '.jpg';
			$dest_vignette = $this -> folderImg . 'vi_' . $num . '.jpg';
			$this -> creer_image($dest_file, $tmp_file, '1280', '1024');
			$this -> creer_image($dest_vignette, $tmp_file, '250', '187');
			chmod($dest_file, 0644);
			chmod($dest_vignette, 0644);
			// suppresion du fichier temporaire
			unlink($tmp_file);
			$rstphoto = " ,photo='" . $num . "'";
		} 

		//traitement du pdf
		if($_FILES['pdf']['tmp_name'] != '') {
			//supression de l'ancien pdf si existant
			
			if(file_exists($this -> folderPDF . "celians_" .$data[id_pdf] . '.jpg'))
				unlink($this -> folderPDF . "celians_" .$data[id_pdf] . '.jpg');			
			//génération numéro aléatoire unique
			$chaine2 = "123456789";
			srand((double)microtime() * 1000000);
			for($i = 0; $i < 6; $i++) { $numeropdf .= $chaine2[rand() % strlen($chaine2)];
			}
			// creation du fichier final
			$dest_filepdf = $this -> folderPDF . "celians_" . $numeropdf . '.pdf';
			move_uploaded_file($_FILES['pdf']['tmp_name'], $dest_filepdf);
			chmod($dest_filepdf, 0644);
			$rstpdf = " ,pdf='" . $numeropdf . "'";
		}
			
		
		
		$rst = $rqt -> query("UPDATE produits set 
		marque='" . $data[marque] . "',
		ref='" . $data[ref] . "',
		nom='" . $data[nom] . "',
		description='" . $data[description] . "'".
		$rstphoto. 
		$rstpdf."
		
		
		WHERE id_produit='$data[id_produit]' ");
		return ($rst);
	}
	
	function creer_image($img_dest, $img_src, $width, $height) {
		$size = GetImageSize($img_src);
		$src_w = $size[0];
		$src_h = $size[1];
		$new_width = $width;
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
			$new_width = $test_w;
		else
			$new_height = $test_h;

		//teste si la photo fournie est plus petite que la taille désirée au final :
		if($width >= $src_w)
			$new_width = $src_w;
		if($height >= $src_h)
			$new_height = $src_h;

		// Redimensionnement
		$thumb = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($img_src);
		$quality = 87;
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $new_width, $new_height, $src_w, $src_h);
		ImageJPEG($thumb, $img_dest, $quality);
	}

	function redimensionner_image_affichage($img_src, $img_with, $img_height) {
		$size = GetImageSize($img_src);
		$src_w = $size[0];
		$src_h = $size[1];
		$new_width = $img_with;
		$new_height = $img_height;

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
			$new_width = $test_w;
		else
			$new_height = $test_h;

		$rst = 'width="' . $new_width . '" height="' . $new_height . '"';
		return $rst;
	}

}
?>