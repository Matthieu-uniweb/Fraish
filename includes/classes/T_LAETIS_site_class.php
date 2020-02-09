<?php
/**
* 
*  <p>Une classe représentant le site.
*  Un site possede 
*				- une base de données, la connection est automatique
*				- 
*
*
*/


class T_LAETIS_site extends PEAR
	{
	/**#@+
	* @access private
	* @var string
	*/
	
	
						
	var $baseActive='';

	var $repertoireLocal; // recupéré par getRepertoireLocal (renvoie le premier niveau)
	
	/**
	* le repertoire de travail du site par defaut situé dans includes/temp
	*  
	*
	*/
	
	var $repertoireTemp="/../temp";
	
	var $repertoireUploads="/../../uploads";
	
	/**
	*
	* alias provoire pour le developpement sur IKOULA 
	* ex: www.clc.fr
	*/
	var $repertoireDeveloppement=""; 
	
		/**
	* la langue
	*/
	var $langue="fr";
	
	/**
	* les langues possibles
	*
	*/
	var $langues=array('fr','gb');
	
	var $debug=true;
	
	/**
	* la connexion ftp
	*
	**/
	
	/*var $ftp=array('local'=> array('url' => 'natacha.laetis.loc',
									'login' => 'u1647',
									'password' => 'fDBI8fU6d',
									'racine' => 'httpdocs'),
					'distant' => array('url' => 'ftp.marc.ovh.laetis.net',
										'login' => 'u1647',
										'password' => 'fDBI8fU6d',
										'racine' => 'httpdocs')
					);
	*/
	var $ftp=array('local'=> array('url' => 'natacha.laetis.loc',
									'login' => 'u1647',
									'password' => 'fDBI8fU6d',
									'racine' => 'httpdocs'),
					'distant' => array('url' => 'ftp.marc.ovh.laetis.net',
										'login' => 'u1647',
										'password' => 'fDBI8fU6d',
										'racine' => 'httpdocs')
					);				
	var $typesImages=array('','gif','jpg','png','bmp','GIF','JPG','PNG','BMP'); // Attentin l'ordre est important
	
	var $mailWebmestre="technique@couleur-citron.com";
	
	function _LAETIS_site ()
		{
		$this->PEAR(); 
		
		/**
		* les initialisations
		*
		*/
		$this->repertoireTemp=dirname(__FILE__).$this->repertoireTemp;
		$this->repertoireUploads=dirname(__FILE__).$this->repertoireUploads;
		
		}	
		
		/**
		* une focntion qui renvoie le premier niveau du répertoire si le domaine est le doamine local
		*
		*
		*/
		
	function getRepertoireLocal ()
		{
		if (strrchr($_SERVER['HTTP_HOST'],'.')==".loc")
			{
			$rep=explode('/', $_SERVER['PHP_SELF']);
			$this->repertoireLocal=$rep[1];
			}
			
		return $this->repertoireLocal;
		}
		/**
		* une fonction qui determine si la page est en local ou pas
		*/
		function estLocal()
			{
			return strrchr($_SERVER['HTTP_HOST'],'.')==".loc";
			}

		/**
		* une fonction qui retourne le chemin à la racine
		*/	
		function getChemin()
			{
			if ($this->estLocal())
				{
				return $this->getProtocole().$_SERVER['HTTP_HOST'].'/'.$this->getRepertoireLocal();
				}
			return $this->getProtocole().$_SERVER['HTTP_HOST'];
			}

		/**
		* une fonction qui retourne le protocole
		*/	
		function getProtocole()
			{
			$result='http://';
			
			switch ($_SERVER['SERVER_PORT'])
				{
				case 443:
					$result='https://';
				break;
				}
			return $result;
			}

	/**
	* Connecte le site à la base de données active
	* Si un problème de connection survient, le script s'arrete sur un message d'erreur
	*
	* @param String $base Base de données à joindre (si vide se connecte sur local/distant)
	* @return DB|DB_Error Connection à la base de données
	* @author Adrien
	*/
	function connecterBDD($base='')
	{

						
		static $connectionBD = NULL;

		
		static $bases= array('local' => array(
										//'user' =>'u1647',
										//'pass' => 'fDBI8fU6d',
										//'host' => 'localhost',										
										/*'nomBDD' => 'db-fraish_fr_www-demo',*/ //'nomBDD' => 'db-fraish_fr_www',
										
										'user' =>'fraishfrdywww',
										'pass' => 'GsBj07190210',
										'host' => 'fraishfrdywww.mysql.db',		
										'nomBDD' => 'fraishfrdywww',
										
										'dsn'=>'',
										'bdd' =>''),
					'distant' => array('user' =>'',
										'pass' => '',
										'host' => '',
										'nomBDD' => '',
										'dsn'=>'',
										'bdd' =>'')
						);
								
		if ( is_null($connectionBD) && strcmp($base,'')==0 )
		{
			$base = 'local';
		}		
		if ( strcmp($base,'')!=0 )
		{
			$baseActive = $bases[$base];
			// les bases de données			
			// Data Source Name: This is the universal connection string
			$dsn = "mysql://".$baseActive['user'].":".$baseActive['pass']."@".$baseActive['host']."/".$baseActive['nomBDD'];
			// DB::connect will return a PEAR DB object on success
			// or an PEAR DB Error object on error
			$connectionBD = DB::connect($dsn);
			// With DB::isError you can differentiate between an error or
			// a valid connexion.
			if ( DB::isError($connectionBD) ) 
			{
				if ( T_LAETIS_site::estLocal() )
					{
					die ( $connectionBD->getMessage().'<br /><br />'.$connectionBD->getUserInfo() );
					}
				else
					{
					die ( $connectionBD->getMessage() );
					}
			}
		}
		
		$connectionBD->query("SET NAMES 'utf8'");
		
		return ($connectionBD);
	}
		
	/**
	* Envoie une requete à la base de données (nouvelle version)
	* Cette méthode peut s'appeller en statique : $resultats = T_LAETIS_site::requeter("SELECT...");
	*
	* @param String $sql Contenu de la requete
	* @param String $base Optionnel : Base de données à joindre si différent de local/distant
	* @return Array Tabelau contenant les resultats
	* @author Adrien
	*/
	function requeter($sql)
	{
		$bd = T_LAETIS_site::connecterBDD();
		$bd->setFetchMode(DB_FETCHMODE_ASSOC);
		$resultat = $bd->getAll($sql);
		if( DB::isError($resultat) )
		{
			if ( T_LAETIS_site::estLocal() )
				{
				die ( $sql.'<br /><br />'.$resultat->getMessage().'<br /><br />'.$resultat->getUserInfo() );
				}
			else
				{
				die ( $sql.'<br /><br />'.$resultat->getMessage() );
				}
		}
		else
		{
			$retour = $resultat;
		}
		return ($retour);
	}
	
	/**
	* Envoie une requete à la base de données active (ancienne version)
	* ATTENTION NE PLUS UTILISER !!!
	* Existe seulement pour la compatiblité avec les sites crées avec l'ancienne norme
	*
	* @param String Contenu de la requete
	* @return DB|DB_ERROR Objet résultat de la requete
	* @author Adrien
	*/
	function query($query)
	{
		$bdd = $this->connecterBDD();
		$res = $bdd->query($query);
		if ($this->debug)
		{
			if(DB::isError($res))
			{
				if ( $this->estLocal() )
				{
				die ( $query.'<br /><br />'.$res->getMessage().'<br /><br />'.$res->getUserInfo() );
				}
			else
				{
				die ( $query.'<br /><br />'.$res->getMessage() );
				}
			}
		}
		return ($res);
	}
	
	/**
	* Renvoie la dernière ID utilisée par la BD
	* @return String ID
	* @author Adrien
	*/
	function last_insert_id()
	{
		$sql = "SELECT last_insert_id() AS lastInsertID";
		$res = T_LAETIS_site::requeter($sql);
		$lastInsertID = $res[0]['lastInsertID'];
		return ($lastInsertID);
	}
	
	/**
	* Définit la base de données à laquelle s'adresse la connexion bdd
	* @param String Nom de la base
	* @access private
	*/
	function definirBase($base='local')
	{
		T_LAETIS_site::connecterBDD($base);
	}
		
	/**
	* une fonction qui determiner si le site est en production ou en debogage
	*
	*/
	function setDebug()
		{
		$this->debug=true;
		}
			
		/**
	* une fonction qui recherche dans le path le repertoire permettant de deduire la langue
	*
	*
	*
	*/
	function initialiserLangue()
		{
		$repertoires=explode('/',$_SERVER['SCRIPT_NAME']);
			
		for ($i=0;$i<sizeof($this->langues);$i++)
			{
			if (in_array($this->langues[$i],$repertoires) )
				{
				$this->langue=$this->langues[$i];
				break;
				}
			}
			
			
		}
		
		

		
			/**
		* une fonction qui converti une date du format 0000-00-00 auy format 00-00-0000 et inversement
		***/
		
	function convertirDate($date,$separateur='-')
		{
		$result=explode($separateur,$date);
			
		return $result[2].$separateur.$result[1].$separateur.$result[0];
		}
		
	function convertirDatelight($date,$separateur='-')
		{
		$result=explode($separateur,$date);
			
		return $result[2].$result[1].$result[0];
		}	
	/** 
	* Modifie l'objet, sans pour autant le modifier en base
	* Le tableau est de la forme $valeurs[$prefixe."nom_de_l_attribut"]
	* @param Array $valeurs Tableau contenant les nouvelles valeurs
	* @param string $prefixe (facultatif, '' par defaut) indique le préfixe devant le nom du champs dans l'index du tableau
	* @access public 
	*/
	function modifierAttributs($valeurs, $prefixe = '')
		{
		$listeAttributs = get_class_vars(get_class($this));
		reset($listeAttributs);
		while( list($attribut,$val) = each($listeAttributs) )
			{
			if(array_key_exists($prefixe.$attribut,$valeurs))
				{
				$this->$attribut = stripslashes($valeurs[$prefixe.$attribut]);
				}
			}
		}
		
	/** 
	* Affiche un select en fonction du tableau passé en parametre
	* @param string $nom Nom du select
	* @param Array $valeurs Tableau contenant les valeurs et ID
	* @param string $indexIndice Nom du champs du tableau contenant le parametre a metre dans le value
	* @param string $indexAffichage Nom du champs du tableau contenant le parametre a metre dans l'affichage
	* @param int $indiceSelectionne Indice selectionne (celui ci doit faire partie de $valeurs[0][$indexIndice]), nul par defaut
	* @param string $nomStyle Style à appliquer à l'objet, nul par defaut
	* @access public 
	*/
	function genererSelect($nom, $valeurs, $indexIndice, $indexAffichage, $indiceSelectionne = 0, $nomStyle = '', $comportements= '')
		{
		$html = '<select name="'.$nom.'"';
		if($nomStyle != '')
			{
			$html .= ' class="'.$nomStyle.'"';
			}
		$html .= ' '.$comportements.' >';
		for($i = 0 ; $i < sizeof($valeurs) ; $i++)
			{
			$html .= '<option value="'.$valeurs[$i][$indexIndice].'"';
			if($valeurs[$i][$indexIndice] == $indiceSelectionne)
				{
				$html .= ' selected';
				}
			$html .= '>'.$valeurs[$i][$indexAffichage].'</option>';
			}
		return $html.'</select>';
		}
	
	/**
	* une fonction qui supprime les accent contenus dans une chaine
	*
	**/
	function supprimerAccents($chaine) 
		{ 
		   $avecAccent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
		   $sansAccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
		   return strtolower(strtr(trim($chaine),$avecAccent,$sansAccent)); 
		} 
		
	/** 
	* Filtrage de la requête
	* Suppression des caractères spéciaux et espaces
	* @param string $requete Requetes tapée par l'utilisateur
	* @return string La requête filtrée
	* @access  public 
	*/
	function filtrerCaracteresSpeciaux($requete)
		{
		$requete = strtolower($requete); 								// on passe les mots recherchés en minuscules   
		$requete = str_replace("+", "", trim($requete)); 	// on remplace les + par des espaces
		$requete = str_replace("\"", "", $requete); 		// on remplace les " par des espaces
		$requete = str_replace(",", "", $requete); 			// on remplace les , par des espaces
		$requete = str_replace(":", "", $requete); 			// on remplace les : par des espaces
		$requete = str_replace("'", " ", $requete); 		// on remplace les ' par des espaces
		$requete = str_replace("’", " ", $requete); 		// on remplace les ' par des espaces
		$requete = str_replace("–", "-", $requete); 		// on remplace les % par des espaces
		$requete = str_replace("%", " ", $requete); 		// on remplace les % par des espaces
		$requete = str_replace("/", " ", $requete); 		// on remplace les / par des espaces
		$requete = str_replace(";", " ", $requete); 		// on remplace les ; par des espaces
		$requete = str_replace("\"", " ", $requete); 		// on remplace les " par des espaces		
		$requete = str_replace("«", "", $requete); 		// on remplace les " par des espaces		
		$requete = str_replace("»", "", $requete); 		// on remplace les " par des espaces		
		$requete = trim(stripslashes($requete));
		return $requete;
		}
		
	/**
	* une focntion envoyant le mail de log 
	*
	**/
	function envoyerMailLog()
		{
		$body="<html>
				<HEAD>
				<TITLE>CLC</TITLE>
				<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=iso-8859-1\">
				</HEAD>
				<body BGCOLOR=\"#FCFFDC\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">
				<table width=\"100%\" align=\"center\" height=\"100%\">
					<tr><td>";
		$body.=$this->mailLog['body'];
		$body.="</td></tr></table>
				</body>
				</html>";
		// on envoie un mail 
			require_once("mailler/htmlMimeMail.php");
			$obj_mail = new htmlMimeMail();
			$obj_mail->setHtml($body);
			//$obj_mail->setText($this->mailLog['body']);
			
			$obj_mail->setFrom($this->mailWebmestre);
			$obj_mail->setSubject($this->mailLog['subject']);
			// sur le site
						
			switch (strstr($_SERVER['HTTP_HOST'],'.'))
				{
				case ".laetis.loc":
					$destinataires=array($this->mailWebmestre);
					break;
				default:
				//	$destinataires=array($this->mailAdmin,$this->mailWebmestre);
					$destinataires=array($this->mailWebmestre);
						
				}
			$result = $obj_mail->send($destinataires,'smtp');
			
		}
		
	function initialiserSession()
		{
		session_start();
		}
		

	/**
	* Renvoie la date formatée en français d'une date mysql
	* @param date $mysqlDate Date mysql
	* @return String Date en francais
	* @author Christophe
	*/
	function dateEnFrancais($mysqlDate)
		{
		list($year, $month, $day) = explode("-", $mysqlDate);
		$jour = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
		$mois = array("","janvier", "février", "mars", "avril", "mai", "juin",
									"juillet", "août", "septembre", "octobre", "novembre", "décembre");
		$laDate=mktime(0,0,0,$month,$day,$year);
		return $jour[strftime("%w",$laDate)].' '.$day.'-'.$month.'-'.$year;
		} // FIN function dateEnFrancais($mysqlDate)


	/**
	* Renvoie la date formatée en français d'une date mysql
	* @param date $mysqlDate Date mysql
	* @return String Date en francais
	* @author Christophe
	*/
	function dateFormatFrancais($mysqlDate)
		{
		list($year, $month, $day) = explode("-", $mysqlDate);
		return $day.'-'.$month.'-'.$year;
		} // FIN function dateFormatFrancais($mysqlDate)


	/**
	* Renvoie l'heure formatée en français d'une heure mysql
	* @param date $mysqlHeure Heure mysql
	* @return String Heure formatée en français
	* @author Christophe
	*/
	function dateHeureFormatFrancais($mysqlDateHeure)
		{
		list($mysqlDate, $mysqlHeure) = explode(" ", $mysqlDateHeure);
		list($year, $month, $day) = explode("-", $mysqlDate);
		list($hour, $minute, $second) = explode(":", $mysqlHeure);
		return $day.'-'.$month.'-'.$year.' à '.$hour.'h'.$minute;
		} // FIN function dateHeureFormatFrancais($mysqlDateHeure)

	/**
	* Renvoie le nom mois correspondant au numéro
	* @param entier $vMois Numéro de mois
	* @return String Nom du mois
	* @author Adrien
	*/
	function mois($vMois)
		{
		$res = false;
		switch ($vMois)
			{
			case 1: 
				$res = "Janvier";
				break;
			case 2:
				$res = "Février";
				break;
			case 3:
				$res = "Mars";
				break;
			case 4:
				$res = "Avril";
				break;
			case 5:
				$res = "Mai";
				break;
			case 6:
				$res = "Juin";
				break;
			case 7:
				$res = "Juillet";
				break;
			case 8:
				$res = "Août";
				break;
			case 9:
				$res = "Septembre";
				break;
			case 10:
				$res = "Octobre";
				break;
			case 11:
				$res = "Novembre";
				break;
			case 12:
				$res = "Décembre";
				break;
			default:
				$res = "";
				break;
			}
		return ($res);
		}
	function getDifferencePourcent($a,$b)
		{
		$diff=(($b-$a)*100)/$a;
		return round($diff,2);
		}
	}
?>