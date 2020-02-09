<?
/**
   *  Classe de gestion des contacts
   *
   * Permet de cr�er, modifier, supprimer des r�ponses au questionnaire, en int�raction 
   * avec la base de donn�es
   *
   * @author Christophe Raffy
   * @version 1.0
   * @access public
   * @copyright La�tis Cr�ations Multim�dias
   */

class Tbq_questionnaire
	{
	/** 
	* @var int $ID ID de l'element en base de donn�e
	* @access  private 
	*/
	var $ID;
	
	/** 
	* @var string $nom Nom du contact 
	* @access  private 
	*/
	var $nom;
	
	/** 
	* @var string $prenom Pr�nom du contact 
	* @access  private 
	*/
	var $prenom;

	/** 
	* @var string $email Email du contact
	* @access  private 
	*/
	var $email;

	/** 
	* @var string $pointVente Point de vente
	* @access  private 
	*/
	var $pointVente;

	/** 
	* @var string $notes Notes
	* @access  private 
	*/
	var $notes;
	
	/** 
	* @var string $commentaire Commentaire
	* @access  private 
	*/
	var $commentaire;

	/** 
	* @var int $mailing mailing
	* @access  private 
	*/
	var $mailing;

	/** 
	* @var date $dateQuestionnaire date du questionnaire
	* @access  private 
	*/
	var $dateQuestionnaire;


	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element � initialiser (si non renseign�, aucune initialisation)
	* @return Tbq_questionnaire l'objet cr��
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;
		$this->initialiser($ID);
		}


	function initialiser($ID)
		{
		//si on a donn� un parametre, on instancie par rapport � la base
		if ( $this->ID>0 )
			{
			// initialisation de l'objet
			$requete = "SELECT * FROM boutique_obj_questionnaire WHERE ID='".$this->ID."'";
			$resultats = T_LAETIS_site::requeter($requete);
			if ($resultats[0])
				{
				foreach ($resultats[0] as $nomChamp => $valeur)
					{
					$this->$nomChamp = stripslashes($valeur);
					}
				}
			}
		}


	/** 
	* Alias du constructeur (compatibilit� PHP4)
	* @param int $ID (facultatif) ID de l'element � initialiser (si non renseign�, aucune initialisation)
	* @return Tbq_questionnaire l'objet cr��
	* @see Tbq_questionnaire::__construct()
	* @access  public 
	*/
	function Tbq_questionnaire($ID = 0)
		{
		$this->__construct($ID);
		}


	/** 
	* Enregistre l'objet en base de donn�e
	* Si l'ID est renseign� ==> modification
	* Sinon ==> insertion
	* @access  public 
	*/
	function enregistrer($valeurs)
		{
		T_LAETIS_site::modifierAttributs($valeurs);
		
		//si l'ID est renseign�, on modifie, sinon, on insere
		$attributs = get_object_vars($this);
		// on donne les champs � mettre � jour (meme syntaxe pour le UPDATE et le INSERT)
		$contenuRequete = "";
		$champsNonEnregistres = array();
		
		foreach ($attributs as $nom=>$valeur)
			{
			if ( !in_array( $nom, $champsNonEnregistres ) )
				{
				$valeur = "\"".addslashes($valeur)."\"";
				$contenuRequete .= " ,".$nom."=".$valeur;
				}
			}
		
		// on enl�ve l'espace et la virgule du d�but
		
		$contenuRequete = substr($contenuRequete,2);
		if ($this->ID>0)
			{
			// c'est un objet qui existe d�j� en BD
			$requete = "UPDATE boutique_obj_questionnaire SET ";
			$requete .= $contenuRequete." WHERE ID=".$this->ID;
			$resSql = T_LAETIS_site::requeter($requete);
			}
		else
			{
			
			// c'est un objet qui n'existe pas en BD
			$requete = "INSERT INTO boutique_obj_questionnaire SET ";
			$requete .= $contenuRequete;
			T_LAETIS_site::requeter($requete);
			$this->ID = T_LAETIS_site::last_insert_id();
			}
		} // FIN function enregistrer()
		

	/** 
	* Supprime l'objet en base de donn�e
	* @access  public 
	*/
	function supprimer()
		{		
		$requete = "DELETE FROM boutique_obj_questionnaire WHERE ID='".$this->ID."'";
		T_LAETIS_site::requeter($requete);
		$this->ID = 0;
		}


	/** 
	* Liste les rubriques
	* @access  public 
	*/   
	function lister()
		{		
		$resultats = array();
		$requete = "SELECT ID FROM boutique_obj_questionnaire 
								ORDER BY dateQuestionnaire DESC, nom ASC, prenom ASC";
		$resSql = T_LAETIS_site::requeter($requete);
		foreach ($resSql as $ligne)
			{
			$resultats[] = new Tbq_questionnaire($ligne['ID']);
			}			
		return ($resultats);
		}


	/** 
	* Liste les rubriques
	* @access  public 
	*/   
	function afficherNotes()
		{
		$chaine = "";
		$tabNotes=explode('|',$this->notes);
		foreach($tabNotes as $note)
			{
			$chaine .= str_replace('-', ': ', ucfirst($note))."<br>";
			}
		return $chaine;
		} // FIN function afficherNotes()


	/** 
	* Liste les rubriques
	* @access  public 
	*/   
	function calculerNoteMoyenne()
		{
		$totalNote = 0;
		$tabNotes=explode('|',$this->notes);
		foreach($tabNotes as $note)
			{ 
			$noteFinale = explode('-',$note); 
			$totalNote += $noteFinale[1];
			}
		return number_format($totalNote/(sizeof($tabNotes)-1), 2,',','');
		} // FIN function calculerNoteMoyenne()


	function genererEmail()
		{
		require_once("htmlMimeMail/htmlMimeMail5.php");

		$pageSource = "/boutique/fr/emails/envoi-questionnaire/envoi-questionnaire.php";		
		
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, "https://".$_SERVER['HTTP_HOST'].$pageSource."?ID_questionnaire=".$this->ID);
		curl_setopt($curl, CURLOPT_HEADER, 0); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		// curl_setopt($curl, CURLOPT_POST, 1); 
		// curl_setopt($curl, CURLOPT_POSTFIELDS, $post); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        $contenu = curl_exec($curl);
		curl_close($curl);
		if(!$contenu){
			echo "Erreur d'envoi du mail";
		}
		
		/*
		$header="GET /".$pageSource."?ID_questionnaire=".$this->ID."   HTTP/1.0\r\n";
		$header.="Host: ".$_SERVER['HTTP_HOST']."\r\n";
		$header.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header.= "\r\n";
		$header.= "\r\n";
	
		$stream=fsockopen($_SERVER['SERVER_ADDR'], 80, $errno, $errstr,30);
		if(!$stream)
			{   
			 echo "$errstr ($errno)<br>\n";
			 exit($_SERVER['HTTP_HOST'].' erreur socket fsockopen');
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
			//on vire la reponse http ==> on commente ce qu'il y a avant le <html>
			$contenu = str_replace("<html","--><html ",$contenu);
			$contenu = str_replace("<HTML","--><HTML ",$contenu);
		
			fclose($stream);
			}
		*/
		// on met toutes les sources en chemin absolu
		$contenu = preg_replace( '/src=\"(.*)\"/i', 'src="http://' . $_SERVER['HTTP_HOST'] . '$1"', $contenu );
		$contenu = preg_replace( '/href=\"(.*)\"/i', 'href="http://' . $_SERVER['HTTP_HOST'] . '$1"', $contenu );
		$contenu = preg_replace( '/url\((.*)/i', 'url(http://' . $_SERVER['HTTP_HOST'] . '$1', $contenu );
		
		// envoi du mail		
		$sujet='Reponse au questionnaire sur le site Fraish';
		
		// Envoi du message
		$obj_mail = new htmlMimeMail();
		$obj_mail->setFrom('info@fraish.fr');
		$obj_mail->setSubject($sujet);
		$obj_mail->setHtml($contenu,'','./');
		
		$obj_mail->send(array('info@fraish.fr'),'smtp');
		$obj_mail->send(array('frederique@fraish.fr'),'smtp');
		$obj_mail->send(array('damien@fraish.fr'),'smtp');
		
		} // FIN function genererEmail()


	}
?>