<?
/**
* Classe permettant la gestion des formulaires
*
* @author  Christophe Raffy <christophe.raffy@laetis.fr>
*/
class Tformulaire extends T_LAETIS_site
	{

	/** 
	* @var array $documentTypes Type de documents
	* @access private 
	*/
	var $documentTypes = array(
							'doc'	=> 'application/msword',
							'bin'	=> 'application/octet-stream',
							'pdf'	=> 'application/pdf',
							'ps'	=> 'application/postscript',
							'rtf'	=> 'application/rtf',
							'xls'	=> 'application/vnd.ms-excel',
							'gz'	=> 'application/x-gzip',
							'tar'	=> 'application/x-tar',
							'xml'	=> 'application/xml',
							'mp3'	=> 'audio/mp3',
							'css'	=> 'text/css',
							'html'	=> 'text/html',
							'htm'	=> 'text/html',
							'txt'	=> 'text/plain',
							'csv'	=> 'text/csv',						
							'zip'	=> 'application/x-zip-compressed');

	/** 
	* @var string $site Nom du site
	* @access private 
	*/
	var $site = "Fraish";	

	/** 
	* @var string $dossierSauvegardeMail Chemin du dossier dans lequel on conserve les emails envoyés
	* @access private 
	*/
	var $dossierSauvegardeMail = "../../admin/archivesFormulaires/sauves/";

	/** 
	* @var string $dossierSauvegardePJ Chemin du dossier dans lequel on conserve les pièces jointes
	* @access private 
	*/
	var $dossierSauvegardePJ = "../../admin/archivesFormulaires/pieces_jointes/";

	/** 
	* @var string $fichierModeleAR L'adresse du ficher modèle d'accusé de réception
	* @access private 
	*/
	var $fichierModeleAR = "../../includes/plugins/formulaires/Library/modele_accuse_reception.html";

	/** 
	* @var string $dossierImagesModeles L'adresse du dossier dans lequel se trouvent les images des modèles
	* @access private 
	*/
	var $dossierImagesModeles = "../../includes/plugins/formulaires/images/";

	/** 
	* @var string $emailDefaut Email par défaut
	* @access private 
	*/
	var $emailDefaut = "davy@fraish.fr";

	/** 
	* @var array $infosFormulaire Informations sur les différents types de formulaires
	* @access private 
	*/
	var $infosFormulaire = array();


	/** 
	* Constructeur de l'objet
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tformulaire l'objet créé
	* @access  public 
	*/
	function __construct($ID = 0)
		{
		$this->ID = $ID;

		if($ID != 0)
			{ }
		}
	
	/** 
	* Alias du constructeur (compatibilité PHP4)
	* @param int $ID (facultatif) ID de l'element à initialiser (si non renseigné, aucune initialisation)
	* @return Tformulaire l'objet créé
	* @see Tformulaire::__construct()
	* @access  public 
	*/
	function Tformulaire($ID = 0)
		{
		$this->__construct($ID);
		}


	/** 
	* Traitement d'un formulaire de contact
	* @param array $valeurs Le tableau POST
	* @return 
	* @access  public 
	*/
	function traiterFormulaire($valeurs)
		{
		if ($valeurs['email'])
			{
			// Formulaire "Newsletter - Recevoir des infos de..."
			if ($valeurs['fonction'] == 'newsletter') 
				{
				$this->infosFormulaire['titre'] = 'Newsletter';
				$this->infosFormulaire['fichierModele'] = '../../includes/plugins/formulaires/Library/modele_envoi.html';
				$this->infosFormulaire['mailDest'] = $this->emailDefaut;
				$this->infosFormulaire['typeDocument'] = 'newsletter_';
				
				$this->traiterFormulaireNewsletter($valeurs);
				}			
			// Formulaire de contact/questions
			else if (($valeurs['fonction'] == 'contact')  || ($valeurs['fonction'] == 'avis'))
				{
				$this->infosFormulaire['titre'] = 'Contact via le site Internet';
				$this->infosFormulaire['fichierModele'] = '../../includes/plugins/formulaires/Library/modele_envoi.html';
				$this->infosFormulaire['mailDest'] = $this->emailDefaut;
				$this->infosFormulaire['typeDocument'] = 'contact_';
				
				$this->traiterFormulaireContact($valeurs);
				}
			// Formulaire "Envoyez cette page à un ami"
			else if ($valeurs['fonction'] == 'envoi_ami') 
				{
				$this->infosFormulaire['titre'] = 'Un ami vous conseille cette page';
				$this->infosFormulaire['fichierModele'] = '../../includes/plugins/formulaires/Library/modele_page_ami.html';
				$this->infosFormulaire['mailDest'] = $this->emailDefaut;
				$this->infosFormulaire['typeDocument'] = 'envoi_ami_';
				
				$this->traiterFormulaireEnvoiAmi($valeurs);
				}
			// Formulaire par défaut
			else
				{
				$this->infosFormulaire['titre'] = 'Contact via le site Internet';
				$this->infosFormulaire['fichierModele'] = '../../includes/plugins/formulaires/Library/modele_envoi.html';
				$this->infosFormulaire['typeDocument'] = 'contact_';
				$this->infosFormulaire['mailDest'] = $this->emailDefaut;
				
				$this->traiterFormulaireContact($valeurs);
				}
			} // FIN if ($valeurs['email'])
		} // FIN function traiterFormulaire($valeurs)


	/** 
	* Traitement d'un formulaire de contact
	* @param array $valeurs Le tableau POST
	* @return 
	* @access  public 
	*/
	function traiterFormulaireContact($valeurs)
		{
		if ($valeurs['email'])
			{	
			// Si des pièces jointes, on les récupère
			if ($valeurs['listeFichiersJoints'])
				{
				$valeurs['listeFichiersJoints'] = unserialize(urldecode($valeurs['listeFichiersJoints']));
				}

			// Envoyer un mail contenant les infos au webmaster du site
			$valeurs['mailGenere'] = $this->envoyerEmail($valeurs);

			// Enregistrer le contact et ses criteres en base
			$this->enregistrerContact($valeurs);
			// Enregistrer le contact dans le logiciel Mailservice
			//$this->enregistrerMailService($valeurs);
			// Envoyer un mail de confirmation à l'utilisateur
			$this->envoyerAccuseReception($valeurs);
			// Enregistrer une copie physique (fichier) du mail
			//$this->enregistrerCopieMail($valeurs);
			} // FIN if ($valeurs['email'])
		} // FIN function traiterFormulaireContact($valeurs)


	/** 
	* Traitement d'un formulaire "d'envoi à un ami"
	* @param array $valeurs Le tableau POST
	* @return 
	* @access  public 
	*/
	function traiterFormulaireEnvoiAmi($valeurs)
		{
		if ($valeurs['email'])
			{	
			// Enregistrer le contact et ses criteres en base
			$this->enregistrerContact($valeurs);
			// Enregistrer le contact dans le logiciel Mailservice
			//$this->enregistrerMailService($valeurs);
			// Envoyer le mail aux amis
			$this->envoyerEmailAmi($valeurs);
			} // FIN if ($valeurs['email'])
		} // FIN function traiterFormulaireEnvoiAmi($valeurs)


	/** 
	* Traitement d'un formulaire "newsletter"
	* @param array $valeurs Le tableau POST
	* @return 
	* @access  public 
	*/
	function traiterFormulaireNewsletter($valeurs)
		{
		if ($valeurs['email'])
			{	
			$valeurs['mailing']=1;
			$valeurs['message']='Abonnement newsletter';

			// Enregistrer le contact et ses criteres en base
			$this->enregistrerContact($valeurs);
			// Enregistrer le contact dans le logiciel Mailservice
			//$this->enregistrerMailService($valeurs);

			} // FIN if ($valeurs['email'])
		}
		
		
	/** 
	* Enrigistrer les infos du contact en base
	* @param array $valeurs Le tableau POST
	* @return 
	* @access  public 
	*/
	function enregistrerContact($valeurs)
		{
		// AJOUT DU CONTACT DANS LA BASE
		$contact = new Tcontact_criteres_specifiques();
		$ID_contact = $contact->enregistrer($valeurs);		
		} // FIN function enregistrerContact($valeurs)


	/** 
	* Envoyer un mail contenant les infos au webmaster du site
	* @param array $valeurs Le tableau POST
	* @return string $contenuTout Le contenu du mail
	* @access  public 
	*/
	function envoyerEmail($valeurs)
		{
		// Lecture du fichier modèle de courrier
		$fpapier = fopen($this->infosFormulaire['fichierModele'], "r");
		
		while ( $contenuPapier = fgets($fpapier, 1024) )
			{ $contenuTout .= $contenuPapier; }

		$contenuTout = str_replace("<date>", date("d/m/Y - H:i:s"), $contenuTout);
		$contenuTout = str_replace("<nom>", $valeurs['nom'], $contenuTout);
		$contenuTout = str_replace("<prenom>", $valeurs['prenom'], $contenuTout);
		$contenuTout = str_replace("<adresse1>", $valeurs['adresse1'], $contenuTout);
		$contenuTout = str_replace("<adresse2>", $valeurs['adresse2'], $contenuTout);
		$contenuTout = str_replace("<codePostal>", $valeurs['codePostal'], $contenuTout);
		$contenuTout = str_replace("<ville>", $valeurs['ville'], $contenuTout);
		$contenuTout = str_replace("<telephone>", $valeurs['telephone'], $contenuTout);
		$contenuTout = str_replace("<email>", $valeurs['email'], $contenuTout);
		$contenuTout = str_replace("<message>", nl2br(stripslashes($valeurs['message'])), $contenuTout);
		$contenuTout = str_replace("<organisme>", $valeurs['organisme'], $contenuTout);

		$contenuTout = stripslashes($contenuTout);

		//$contenuTexte = "Ce message est au format HTML. \n Si vous n'arrivez pas à le lire, veuillez contacter le webmestre du site \n".$this->site;

		$sujetDemandeur = stripslashes($this->site." - ".$this->infosFormulaire['titre']);
		
		$objMailDemandeur = new htmlMimeMail();
		$objMailDemandeur->setFrom($valeurs['email']);
		$objMailDemandeur->setSubject($sujetDemandeur); 
		$objMailDemandeur->setHtml($contenuTout, $contenuTexte, $this->dossierImagesModeles);
		
		//$dest = array($this->infosFormulaire['mailDest'],'christophe.raffy@laetis.fr');		
		$dest = array($this->infosFormulaire['mailDest']);
		$result = $objMailDemandeur->send($dest, 'smtp');
		
		return $contenuTout;
		} // FIN function envoyerEmail($valeurs)


	/** 
	* Envoyer le mail aux amis
	* @param array $valeurs Le tableau POST
	* @return 
	* @access  public 
	*/
	function envoyerEmailAmi($valeurs)
		{
		// Lecture du fichier modèle de courrier
		$fpapier = fopen($this->infosFormulaire['fichierModele'], "r");
		
		while ( $contenuPapier = fgets($fpapier, 1024) )
			{ $contenuTout .= $contenuPapier; }
		
		$contenuTout = str_replace("<prenom>", $valeurs['prenom'], $contenuTout);
		$contenuTout = str_replace("<nom>", $valeurs['nom'], $contenuTout);
		$contenuTout = str_replace("<urlAmi>", $valeurs['urlAmi'], $contenuTout);
		$contenuTout = str_replace("<message>", nl2br($valeurs['message']), $contenuTout);
		$contenuTout = stripslashes($contenuTout);

		$contenuTexte = $valeurs['prenom']." ".$valeurs['nom']." vous conseille de visiter la page suivante : \n".$valeurs['urlAmi']."\n\n Cette personne vous adresse le message ci-dessous : \n.".$valeurs['message']."\n\n".$this->site;

		// Envoi du(des) message(s) aux amis
		$mail = new htmlMimeMail();
		$mail->setFrom($valeurs["email"]);
		$mail->setSubject($this->site." - ".$this->infosFormulaire['titre']);
		$mail->setHtml($contenuTout, $contenuTexte, $this->dossierImagesModeles);		
		
		$emailDest=$valeurs["emailDest"];
		for ($i=1;$i<=3;$i++)
			{
			if ($emailDest[$i]!="")
				{
				$result = $mail->send(array('<'.$emailDest[$i].'>'), 'smtp');
				}
			} // FIN for ($i=1;$i<=3;$i++)	
		} // FIN function envoyerEmailAmi($valeurs)


	/** 
	* Enregistrement du contact dans la base de données du MailService
	* @param array $valeurs Données du contact passées en POST
	* @access  public 
	*/
	function enregistrerMailService($valeurs)
		{
		// AJOUT DU CONTACT DANS LE LOGICIEL MAILSERVICE
		if ($valeurs['mailing'] == 1)
			{
			$emailing = new Tmail_service_class();
			$emailing->ajouterContact($valeurs);
			}
		} // FIN function enregistrerMailService($valeurs)
		
		
	/** 
	* On conserve une copie du message
	* @access  public 
	*/
	function enregistrerCopieMail($valeurs)
		{
		$filename = $this->infosFormulaire['typeDocument'].$valeurs['nom']."_".$valeurs['prenom']."_".date("Y_m_d_H_i_s").".html";
		$filename = str_replace(' ','_',$this->filtrerCaracteresSpeciaux($this->supprimerAccents($filename)));
		$fp = fopen($this->dossierSauvegardeMail.$filename, "w");
		fwrite($fp, $valeurs['mailGenere']);
		fclose($fp);		
		} // FIN function enregistrerCopieMail($valeurs)


	/** 
	* Envoyer un mail d'accusé de réception au demandeur
	* @access  public 
	*/
	function envoyerAccuseReception($valeurs)
		{
		// Lecture du fichier modèle de courrier
		$fpapierAR = fopen($this->fichierModeleAR, "r");

		while ( $contenuPapierAR = fgets($fpapierAR, 1024) )
			{ $contenuToutAR .= $contenuPapierAR; }
		
		$contenuToutAR = stripslashes($contenuToutAR);

		$contenuTexte = "Votre message a bien été adressé au contact du site ".$this->site.".\n Son traitement sera initialisé après  vérification  d'authenticité. \n Nous vous remercions pour votre contribution. \n\n".$this->site;

		$sujetDemandeurAR = stripslashes($this->site." - Accusé de réception");
		
		$objMailAR = new htmlMimeMail();
		$objMailAR->setFrom($this->infosFormulaire['mailDest']);
		$objMailAR->setSubject($sujetDemandeurAR); 
		$objMailAR->setHtml($contenuToutAR, $contenuTexte, $this->dossierImagesModeles);
		$result = $objMailAR->send(array($valeurs['email']), 'smtp');
		} // FIN function envoyerAccuseReception($valeurs)


	/** 
	* Ajouter une pièce jointe
	* @param array $valeurs $_FILES
	* @param array $listeFichiersJoints Listes des fichiers déjà joints
	* @return array $listeFichiersJoints Listes des fichiers joints
	* @access  public 
	*/
	function ajouterPieceJointe($valeurs, $listeFichiersJoints)
		{	
		if (!empty($valeurs['join']['name']))
			{
			if (is_uploaded_file($valeurs['join']['tmp_name']))
				{
				$nomPJ = str_replace(' ','_',$this->filtrerCaracteresSpeciaux($this->supprimerAccents($valeurs['join']['name'])));
				$nb = '';
				$ext = strrchr($nomPJ, '.');
				$nom = substr($nomPJ, 0, strrpos($nomPJ, '.'));

				while (file_exists($this->dossierSauvegardePJ.$nom.$nb.$ext))
					{
					$nb += 1;
					}
	
				$nouveauNom = $nom.$nb.$ext;
				$res = move_uploaded_file($valeurs['join']['tmp_name'], $this->dossierSauvegardePJ.$nouveauNom);

				if ($res)
					{
					$listeFichiersJoints[] = array(
					'nom' => $nouveauNom, 
					'lien' => $nouveauNom, 
					'taille' => $valeurs['join']['size']);
					chmod($this->dossierSauvegardePJ.$nouveauNom, 0644);
					}
				} // FIN if (is_uploaded_file($valeurs['join']['tmp_name']))
			} // Fin if (!empty($_FILES['join']['name']))
			
		return $listeFichiersJoints;
		} // FIN function ajouterPieceJointe($valeurs, $listeFichiersJoints)


	/** 
	* Supprimer une pièce jointe
	* @param array $unattach Numéro de la pièce jointe à supprimer (dans le tableau listeFichiersJoints)
	* @param array $listeFichiersJoints Listes des fichiers déjà joints
	* @return array $listeFichiersJoints Listes des fichiers joints
	* @access  public 
	*/
	function supprimerPieceJointe($unattach, $listeFichiersJoints)
		{	
		$ficASup = $listeFichiersJoints[$unattach]['nom'];
		array_splice($listeFichiersJoints, $unattach, 1);
		@unlink($this->dossierSauvegardePJ.$ficASup);
		return $listeFichiersJoints;
		} // FIN function supprimerPieceJointe($unattach, $listeFichiersJoints)

	}
?>