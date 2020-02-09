<?php
require_once ('./class/commun/mysql.class.php');

class client
{
	
	var $ID;
	var $codeEntreprise;
	var $dateInscription;
	var $civiliteFacturation;
	var $nomFacturation;
	var $prenomFacturation;
	var $adresseFacturation;
	var $adresseFacturation2;
	var $codePostalFacturation;
	var $villeFacturation;
	var $emailFacturation;
	var $telFacturation;
	var $societe;
	var $newsletter;
	var $motDePasse;
	var $dateDeNaissance;
	var $ID_pointDeVentePrefere;
	var $soldeCompte;
	

function __construct($ID=0)
	{
		$this->ID = $ID;
		$this->initialiser($ID);
		//echo "construction objet client";
	}
	
function initialiser($ID)
	{
		
	$rqt = new mysql ;	
	//si on a donn� un parametre, on instancie par rapport � la base
	if ( $this->ID>0 )
		{
			
		// initialisation de l'objet
		$requete = "SELECT * FROM boutique_obj_client WHERE ID='".$this->ID."'";
		//$resultats = T_LAETIS_site::requeter($requete);
		$resultats = $rqt->query($requete);	
		$resultat	= mysql_fetch_array($resultats);		
		
		if ($resultat)
		{			
			foreach ($resultat as $nomChamp => $valeur)
			{
				$this->$nomChamp = stripslashes($valeur);
			}
		}
	}
}	
	
	
function getlastCommandes()
		{
		$requete = "SELECT ID FROM boutique_obj_commande 	
								WHERE statut = 'livree' 
								AND ID_client = '".$this->ID."'
								ORDER BY dateCommande DESC LIMIT 0 , 3";
		$resSql = T_LAETIS_site::requeter($requete);		
		return ($resSql);
		}
		
function getlastCommandesEnCours()
		{
		$requete = "SELECT ID FROM boutique_obj_commande 	
								WHERE statut = 'en_cours' 
								AND ID_client = '".$this->ID."'
								ORDER BY dateCommande DESC LIMIT 0 , 3";
		$resSql = T_LAETIS_site::requeter($requete);		
		return ($resSql);
		}
	

function enregistrer($valeurs)
		{		
		$rqt = new mysql ;
		//si l'ID est renseign�, on modifie, sinon, on insere
		$attributs = get_object_vars($this);
		// on donne les champs � mettre � jour (meme syntaxe pour le UPDATE et le INSERT)
		$contenuRequete = "";
		//Modif jb du 22/06/2014 : les clients qui éditent leur compte voient le solde de leur compte remis à zero ...
		$champsNonEnregistres = array( "pointsFidelite", "codeEntreprise", "dateInscription", "civiliteFacturation", "societe", "ID_pointDeVentePrefere", "soldeCompte");
		
		foreach ($attributs as $nom=>$valeur)
			{
                            if ( !in_array( $nom, $champsNonEnregistres ) )
                            {
                                if($nom == 'motDePasse' && !empty($valeur)) {
                                    if($nom == 'motDePasse'){
                                        $valeur = md5($valeur);
                                    }
                                }
                                
                                if($nom != 'ID'){
                                    $valeur = "\"".addslashes($valeur)."\"";
                                    $contenuRequete .= " ,".$nom."=".$valeur;
                                }
                            }
			}
		
		// on enl�ve l'espace et la virgule du d�but		
		$contenuRequete = substr($contenuRequete,2);
		if ($this->ID>0)
			{
			// c'est un objet qui existe d�j� en BD
			$requete = "UPDATE boutique_obj_client SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
                        
			//$resSql = T_LAETIS_site::requeter($requete);			
			if(!empty($contenuRequete)) $resSql = $rqt->query($requete);			
			}
		else
			{
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_client SET ";
			$requete .= $contenuRequete;
			//T_LAETIS_site::requeter($requete);
			$resSql = $rqt->query($requete);		
			//$this->ID = T_LAETIS_site::last_insert_id();
			$this->ID = $rqt->insert_id();
			}
} 

function logger()
{
	$_SESSION['client']['id_client'] = $this->ID;	
}

function supprimer()
{
		$rqt = new mysql ;
		$requete = "DELETE FROM boutique_obj_client WHERE ID='".$this->ID."'";
		//T_LAETIS_site::requeter($requete);
		$rqt->query($requete);
		$this->ID = 0;
}

  
function lister()
{
		$rqt = new mysql ;		
		$resultats = array();
		$requete = "SELECT ID FROM boutique_obj_client ORDER BY nomFacturation ASC, prenomFacturation ASC";
		//$resSql = T_LAETIS_site::requeter($requete);
		$resSql = $rqt->query($requete);		
		foreach ($resSql as $ligne)
			{
			$resultats[] = new client($ligne['ID']);
			}			
		return ($resultats);
}

function verifierLogin($valeurs)
{
    if(empty($valeurs['email']) || empty($valeurs['motDePasse']))
        return false;
    
		$rqt = new mysql ;
		$requete = "SELECT ID FROM boutique_obj_client	
								WHERE emailFacturation = '".$valeurs['email']."' 
								AND motDePasse = MD5('".$valeurs['motDePasse']."')
								AND accesBloque!=1
								ORDER BY ID DESC";
                
                //var_dump($requete); die();
		//$resultats = T_LAETIS_site::requeter($requete);
		$resultats = $rqt->query($requete);
		$resultats	= mysql_fetch_array($resultats);

		$this->ID = $resultats['ID'];
		return ($resultats[0]['ID']);
}
	
function getCommandesEnCours()
{
		$rqt = new mysql ;
		$requete = "SELECT ID FROM boutique_obj_commande 	
								WHERE statut IN ('payee', 'validee cb', 'validee cheque', 'validee fax', 
								'validee virement') 
								AND ID_client = '".$this->ID."'
								ORDER BY dateCommande DESC";
		//$resSql = T_LAETIS_site::requeter($requete);
		$resSql = $rqt->query($requete);		
		//echo $requete;
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_commande($ligne['ID']);
			}
		return ($resultats);
}

function getCommandesLivrees()
{
		$rqt = new mysql ;
		$requete = "SELECT ID FROM boutique_obj_commande 	
								WHERE statut = 'livree' 
								AND ID_client = '".$this->ID."'
								ORDER BY dateCommande DESC";
		//$resSql = T_LAETIS_site::requeter($requete);
		$resSql = $rqt->query($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_commande($ligne['ID']);
			}
		return ($resultats);
}
	
function getCommandesAbandonnees()
{
		$rqt = new mysql ;
		$requete = "SELECT ID FROM boutique_obj_commande 	
								WHERE statut IN ('abandonnee', 'non validee') 
								AND ID_client = '".$this->ID."'
								ORDER BY dateCommande DESC";
		//$resSql = T_LAETIS_site::requeter($requete);
		$resSql = $rqt->query($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_commande($ligne['ID']);
			}
		return ($resultats);
}


function setCommandesAbandonnees()
{
		$rqt = new mysql ;
		$requete = "UPDATE `boutique_obj_commande` 
								SET `statut`= 'abandonnee' 
								WHERE `statut` = 'validee' and `dateCommande` < DATE_SUB(NOW(), INTERVAL 1 MONTH)";
		//T_LAETIS_site::requeter($requete);
		$rqt->query($requete);		
}	

function peutCommander()
{
		$retour = true;
		if($this->soldeCompte<0)
			{
			$retour = false;
			}
		return($retour);
}

function debiterSoldeCompte($montant)
		{
			
			$rqt = new mysql ;
		$requete = "UPDATE boutique_obj_client SET soldeCompte = soldeCompte - ".$montant."
					WHERE ID = '".$this->ID."'";
		$rqt->query($requete);	
		}



function envoyerLoginInscription()
		{
		// Préparation du courrier
		$pageSource = "/boutique/fr/emails/envoi-codes/envoi-codes-inscription.php";
		
		$pointDeVente = new Tbq_user($this->ID_pointDeVentePrefere);
		
		$post="login=".$this->emailFacturation."&motDePasse=".$this->motDePasse."&email=".$this->emailFacturation."&nom=".$this->nomFacturation."&prenom=".$this->prenomFacturation."&dateNaissance=".$this->dateDeNaissance."&telephone=".$this->telFacturation."&societe=".$this->societe."&adresse=".$this->adresseFacturation."&adresse2=".$this->adresseFacturation2."&codePostal=".$this->codePostalFacturation."&ville=".$this->villeFacturation."&pointDeVentePrefere=".$pointDeVente->pointDeVente."&codeEntreprise=".$this->codeEntreprise;
		
		
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, "https://".$_SERVER['HTTP_HOST'].$pageSource);
		curl_setopt($curl, CURLOPT_HEADER, 0); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_POST, 1); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        $contenu = curl_exec($curl);
		curl_close($curl);
		if(!$contenu){
			echo "Erreur d'envoi du mail";
		}
		/*
		$header="POST /".$pageSource."   HTTP/1.0\r\n";
		$header.="Host: ".$_SERVER['HTTP_HOST']."\r\n";
		$header.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header.= "Content-Length: ".strlen($post)."\r\n";
		$header.= "\r\n";
		$header.= $post."\r\n";
		$header.= "\r\n";
		
		$stream = fsockopen($_SERVER['SERVER_ADDR'], 80, $errno, $errstr,30);
		if(!$stream)
			{   
			echo "$errstr ($errno)<br>\n";
			exit($_SERVER[HTTP_HOST].' erreur socket fsockopen');
			} 
		else
			{
			$contenu="<!--";
			fputs($stream, $header);
			while (!feof($stream)) 
				{
				// Traitement ligne � ligne du fichier 
				$contenu.= fgets($stream, 10000);               
				}
			// On vire la reponse http ==> on commente ce qu'il y a avant le <html>
			$contenu = str_replace("<html","--><html ",$contenu);
			$contenu = str_replace("<HTML","--><HTML ",$contenu);
			fclose($stream);
			}
		*/
		$contenuTexte='Login : '.$this->emailFacturation.' Mot de passe : '.$this->motDePasse;
		
		// Envoi du message
		$obj_mail = new htmlMimeMail();
		$obj_mail->setFrom('fraishlabege@gmail.com');
		$obj_mail->setSubject("Vos codes d'accés client au site fraish.fr"); 
		$obj_mail->setHtml($contenu,$contenuTexte,'../../../boutique/fr/emails/envoi-codes-v2/');
		
		// Envoi � l'utilisateur
		$obj_mail->send(array($this->emailFacturation),'smtp');
		
		return $contenu;
		} // FIN function envoyerLogin($valeurs)
}
?>