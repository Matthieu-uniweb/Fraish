<?
class TmoteurRecherche extends T_LAETIS_site

{
var  $langues = array("fr"=>"Français", "it"=>"Italien", "gb"=>"Anglais", "de"=>"Allemand", "sp"=>"Espagnol", "ru"=>"Russe", "uk"=>"Anglais"); 
		
var $pageDeSortieAdmin="../../admin/admin.php";

var $configuration;
var $rowConfiguration;

var $requeteStatistiques;

function genererJavascriptStatistiques ()
	{
	$res="<script language='Javascript'>
		function quitter ()
    		{
    		window.location='".$this->pageDeSortieAdmin."';
    		}
			</script>";
	return $res;
	}
function enregistrerClick($requete,$click_url)
	{	
	if ($click_url)
		{	
		$req = "SELECT ID FROM moteur_recherche_statistiques WHERE requete='$requete' AND pageVisitee='$click_url'";
		$result = $this->query($req);
		$nb = $result->numRows();	
		
		// On est obligé d'enlever 1 occurence car la page est rechargée, et donc une nouvelle recherche est effectuée
		$reqmoins = "UPDATE moteur_recherche_statistiques SET nbOccurences = nbOccurences - 1 WHERE requete = '$requete' AND pageVisitee = 'total'";
		$resultmoins = $this->query($reqmoins);
			
		if ($nb != 0)
			{
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$id = $row["ID"];
			$requpd = "UPDATE moteur_recherche_statistiques SET nbOccurences = nbOccurences + 1, derniereDate = CURDATE() WHERE ID = '$id'";
			$resultupd = $this->query($requpd);
			}
		else
			{
			$reqajout = "INSERT INTO moteur_recherche_statistiques (requete, nbOccurences, derniereDate, pageVisitee) VALUES ('$requete', 1, CURDATE(), '$click_url')";
			$resultajout = $this->query($reqajout);
			}
	
			// on renvoi vers la page selectionnée
			// le location.replace permet de ne pas enregistrer dans l'historique cette redirection
			echo "<script language='Javascript'>\n
			          location.replace('".$click_url."');
				  </script>\n";
		}
	
	}

function genererSelectDates ($date,$class)
	{
	$options[0][valeur]="";
	$options[0][text]="Date Indifférente";
	$options[1][valeur]=3;
	$options[1][text]="Le ou les 3 derniers mois";
	$options[2][valeur]=6;
	$options[2][text]="Le ou les 6 derniers mois";
	$options[3][valeur]=12;
	$options[3][text]="L'année dernière";
	
	$select="<SELECT name=\"date\" class=\"".$class."\" >";
    for ($i=0;$i<sizeof($options);$i++)
		{
		$select.="<OPTION value=\"".$options[$i][valeur]."\"";
		if ($options[$i][valeur]==$date)
			{
			$select.=" selected ";
			}
		$select.=" >".$options[$i][text]."</OPTION>" ;
		}
    $select.="</SELECT>";
	
	
	return $select;	
	}
	/**
	*
	* une fonction qui renvoie les langues présentes sur le site 
	*
	*
	**/
function getLangues ()
	{
	$langues=array();
	$query = "SELECT DISTINCT(langue) AS abbreviation
			 FROM moteur_recherche_fichier 
			 WHERE langue != ''";
	$result = $this->query($query);
	
	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	      {
		  $row[nom]=$this->langues[$row[abbreviation]];
		  $langues[]=$row;		  
		  }
	return $langues;
	}
 /**
 *
 * une fonction qui genere les fonctions javascript à ajouter dans la page d'affichage des résultats
 *
 *
 */
 function genererJavascript ()
 	{
	$javascript="<script language='Javascript'>\n
					function affiche_info (url)\n
						{\n
						window.document.forms.formulaireRecherche.click_url.value = url;\n
						window.document.forms.formulaireRecherche.submit ();\n	
						}\n
				</script>\n";
	return $javascript;
	}
	
function genererFormulaire ($valeurs)
	{
	
	$this->enregistrerClick($valeurs[requete],$valeurs[click_url]);
	
	$confi = new Configuration();
	$formulaire="<link rel=\"stylesheet\" type=\"text/css\" href=\""."../../".$confi->getFeuilleDeStyles()."\" > ";
	
	$formulaire.="<form name=\"formulaireRecherche\" method=\"post\" action=\"\">
			<span class=\"moteur_recherche_description\" >Entrez un mot clé:</span><br>

            <input type=\"text\" name=\"requete\" size=\"30\" value=\"".stripslashes($valeurs[requete])."\"  class=\"moteur_recherche_inputtext\">
            <input type=\"submit\" value=\"Rechercher\" onClick=\"this.form.click_url.value='';this.form.debut.value='1';\" alt=\"Lancer la recherche!\" class=\"moteur_recherche_bouton\">
			<input type=\"hidden\" name=\"avancee\" value=\"".$valeurs[avancee]."\" >
			<input type=\"hidden\" name=\"langue\" value=\"".$valeurs[langue]."\" >
			<input type=\"hidden\" name=\"au_moins_un_mot\" value=\"0\" >
			<input type=\"hidden\" name=\"date\" value=\"".$valeurs[date]."\" >
			<input type=\"hidden\" name=\"debut\" value=\"".$valeurs[debut]."\" >
		 	<input type=\"hidden\" name=\"click_url\" value=\"\">

            <BR>";
	// L'utilisateur a cliqué sur un des liens
			// On va entrer le nom du lien cliqué dans la table des statistiques
			// Et ensuite rediriger la page sur le lien
	

			// Si on a cliqué sur le lien "Recherche avancée
            if ($valeurs[avancee] == 1)
                {
                $formulaire.="<span class=\"moteur_recherche_avancee\" >Rechercher dans :</span>";

                // CHOIX DES LANGUES DISPONIBLES
                $formulaire.="<input type=\"radio\" name=\"langue\" class=\"moteur_recherche_radio\"  value=\"\" "; 
																	if (!$valeurs[langue])
																		{
																		$formulaire.="checked";
																		}
																		$formulaire.=" ><span class=\"moteur_recherche_avancee\" >Toutes les pages</span>";
				$langues = $this->getLangues();     
	
	         	for ($i=0;$i<sizeof($langues);$i++)
			  		{ 
					$formulaire.="<input type=\"radio\" name=\"langue\" class=\"moteur_recherche_radio\"  value=\"".$langues[$i][abbreviation]."\""; 
																				if ($langues[$i][abbreviation]==$valeurs[langue]) 
																					{
																					$formulaire.="checked";
																					}
																				$formulaire.=" ><span class=\"moteur_recherche_avancee\" >Pages: ".$langues[$i][nom]."</span>"; 
					}
                // CHOIX AU MOINS UN DES MOTS
				$formulaire.="<BR><input type=\"checkbox\" name=\"au_moins_un_mot\" class=\"moteur_recherche_checkbox\" value=\"$valeurs[au_moins_un_mot]\""; 
																					if ($valeurs[au_moins_un_mot]) 
																					{
                  																	 $formulaire.=" checked"; 
																					} 	
																			$formulaire.="  onClick=\"if (this.checked){this.value='1';}	else {this.value='0';}\" ><span class=\"moteur_recherche_avancee\" >Rechercher au moins un des mots... </span>
                <BR><BR>";					
	
			$formulaire.= $this->genererSelectDates($valeurs[date],"moteur_recherche_select");
              } // Fin if ($avancee == 1) 
			 	else
				{
			$formulaire.="	
             <ul>
			 <input type=\"submit\" value=\"Recherche avancée\" onClick=\"this.form.avancee.value='1';this.form.click_url.value='';\" class=\"moteur_recherche_bouton\" >
             <BR>
             <A href=\"javascript:;\"  onClick=\"openPopup('/includes/plugins/moteur_recherche/aide/laetis_recherche_utilisation.php', 'aide', 530, 580)\" target=\"_self\" class=\"pageTexte\"><li> Aide </li></A>
             </ul>

         ";
			 }
			
       $formulaire.="
        <br>
      
";

// Si l'utilisateur a tapé une requete
if ($valeurs[requete])
	{	
    if ($valeurs[debut] == NULL)
        $valeurs[debut] = 1;    
	
    // On crée une instance de la classe Recherche
    $rech = new Recherche($valeurs[requete]);
		
	// On execute la requete
    $result = $rech->selectionBDD($valeurs[au_moins_un_mot], $valeurs[langue], $valeurs[date]);

    // On récupère les attributs utiles : la requete, et la configuration
    $requete = $rech->getRequete();
    $conf = $rech->getConfiguration();
		
    //$formulaire.="<link rel=\"stylesheet\" type=\"text/css\" href=\""."../../".$conf->getFeuilleDeStyles()."\" > ";

    $limit = $conf->getResultatsNbResultatsParPage();

    $nbrows = $result->numRows();
	$nombre = floor($nbrows/$limit); //ceil	

    if ($result)
        {
        if ( ($nbrows = $result->numRows()) == 0) 
		    {
			$formulaire.="<BR><p class=\"moteur_recherche_resultat\">Pas de Résultat</p><br>";
			} // Si il n'y a pas de résultats
        else
            {
            $formulaire.="<p class=\"moteur_recherche_resultat\" >Résultat(s)</p>";
			
			if ($nbrows == 0)
			    { 
               $formulaire.="<br><p class=\"moteur_recherche_titre1\">Votre recherche <b>".StripSlashes($valeurs[requete])."</b> n'a donné aucun résultat. Essayez d'élargir votre recherche en y mettant moins de mots ou vérifiez l'orthographe.</p><br>"; 
				} 
            else
			    { 
			    $fin = $valeurs[debut] + $limit - 1;			   
                $formulaire.="<p class=\"moteur_recherche_titre1\" >".$nbrows." résultats ont été trouvés pour  \"".StripSlashes($valeurs[requete])."\" ! </p><p class=\"moteur_recherche_titre2\" > Résultats ".$valeurs[debut]." à ".$fin.". </p>";
			    }
			
			for ($i = $valeurs[debut] - 1; $i < $valeurs[debut] + $limit - 1; $i++)	
                {
				$j = $i + 1;
				    
				$row = $result->fetchRow(DB_FETCHMODE_ORDERED, $i);
				
				if ($row[0] != NULL)
				    {
                    $url = $row[0];
					$numfic = $row[2];
					
					$chemin = "../../"."".str_replace("../", "", $url);
					
					$titre = $row[4];
					$reqMaj = ucwords($valeurs[requete]);
					
					if ($titre != "")
					    {
						// On met la première lettre du titre en majuscules 
						$titre = ucfirst($titre);
						}

					$formulaire.="
                    <p class=\"bouton\"><BR>
                      <span class=\"moteur_recherche_url\" >".$j." - <A href=\"#\" onClick=\"affiche_info('".$chemin."')\" class=\"moteur_recherche_url\">".$titre."</A></span><br>
					  ";

				   $formulaire.="
					  <span class=\"moteur_recherche_commentaire\"></span><span class=\"moteur_recherche_textetitre\">".$chemin."</span><br> ";
					  
  					$desc = $row[5];
					if ($desc != "")
					    {
						$desc = ucfirst($desc);
						$formulaire.="
					    <span class=\"moteur_recherche_commentaire\">Description : </span><span class=\"moteur_recherche_description\">".$desc."</span><br> ";
						}
						
						$formulaire.="					 
						  <span class=\"moteur_recherche_commentaire\" >Mot trouvé : </span><span class=\"moteur_recherche_mot\">";
																												if ($valeurs[au_moins_un_mot])
																													{					
																													$formulaire.= $row[1];
																													}
																													else
																													{
																													$formulaire.=StripSlashes($valeurs[requete]);
																													}
$dateFormat = substr($row[6], 4, 2)."-".substr($row[6], 0, 4)																								;

$formulaire.="</span><br> 
					  <span class=\"moteur_recherche_commentaire\">Pertinence : </span><span class=\"moteur_recherche_poids\" >".$row[3]."</span> - <span class=\"moteur_recherche_commentaire\" >Date : </span><span class=\"moteur_recherche_date\" >".$dateFormat."</span><br> ";
					}
				else
				    break;
					
					
                } // Fin for ($i = $debut - 1; $i < $debut + $limit - 1; $i++)
$formulaire.="
					</p>
                    <table border=\"0\" align=\"center\" ><tr>";
			if ($valeurs[debut] != '1')
			    {
				$temp = $valeurs[debut] - $limit;
				$formulaire.="<td><input type=\"submit\" value=\"début\" onClick=\"this.form.click_url.value='';this.form.debut.value='1';\" class=\"moteur_recherche_bouton\" ></td><td>
				<input type=\"submit\" value=\"précédent\" onClick=\"this.form.click_url.value='';this.form.debut.value='".$temp."';\" class=\"moteur_recherche_bouton\" ></td>
				";
				}
				else
				{
				$formulaire.="<td>&nbsp;</td><td>&nbsp;</td>";
				}
		
				
			if ( ($valeurs[debut] + $limit) <= $nbrows) 
			    {
			    $temp = $valeurs[debut] + $limit;
				$temp2 = $nombre * $limit + 1;
				
				if ($temp2 > $nbrows) // Dans le cas $temp2=20 par exemple
				    $temp2 = $temp2 - $limit;
					
				$formulaire.="<td><input type=\"submit\" value=\"suivant\" onClick=\"this.form.click_url.value='';this.form.debut.value='".$temp."'\" class=\"moteur_recherche_bouton\" ></td>
				<td><input type=\"submit\" value=\"fin\" onClick=\"this.form.click_url.value='';this.form.debut.value='".$temp2."';\" class=\"moteur_recherche_bouton\" ></td>
				";
				}
			else
			    {
			   $formulaire.="<td>&nbsp;</td><td>&nbsp;</td>";
				}
     $formulaire.="</tr></table>";   
		        $result->free();
            } // Fin else ($nbrows != $result->numRows()) == 0)
        } // Fin if ($result)
    } // Fin if ($requete)						

   $formulaire.=" </form>";
	return $formulaire;
}

	function genererHTML ($valeurs)
		{
		$html=$this->genererJavascript();
		$html.=$this->genererFormulaire($valeurs);
		return $html;		
		}
		
	function genererHTMLStatistiques()
		{
		$html=$this->genererJavascriptStatistiques();
		return $html;
		}
	
	function genererHTMLStatistiquesSelection($selection)
	    {
	    $html = "<SELECT style=width:350 name='selection' onChange='document.forms.formulaireStat.submit()'>";
					   	
				if ($selection == '1') {
			        $html .= "<OPTION value='1' selected>Les requêtes les plus demandées</OPTION>";
				} else {
					$html .= "<OPTION value='1' >Les requêtes les plus demandées</OPTION>";
						 
				} if ($selection == '2') {
			        $html .= "<OPTION value='2' selected>Les requêtes les plus recentes</OPTION>";
				} else {
					$html .= "<OPTION value='2' >Les requêtes les plus récentes</OPTION>";
						   
				} if ($selection == '3') {
			        $html .= "<OPTION value='3' selected>Les pages les plus demandées</OPTION>";
				} else {
					$html .= "<OPTION value='3' >Les pages les plus demandées</OPTION>";
						   
				} if ($selection == '4') {
					$html .= "<OPTION value='4' selected>Grouper par requêtes les pages les plus demandées</OPTION>";
				} else {
					$html .= "<OPTION value='4' >Grouper par requêtes les pages les plus demandées</OPTION>";
				}
					   
				$html .= "</SELECT>";
		return $html;
		}
					   
	function choixRequete($selection, $chercherequete)
	    {
		// L'utilisateur cherche une requete en particulier
		if ($chercherequete)
		    {
			$this->requeteStatistiques = "SELECT * FROM moteur_recherche_statistiques WHERE requete='$chercherequete' ORDER BY nbOccurences DESC, pageVisitee DESC";
			}
        else
		    {					   
			switch ($selection) 
			    {
                case 1 : 
				    {
                    $this->requeteStatistiques = "SELECT * FROM moteur_recherche_statistiques WHERE pageVisitee='total' ORDER BY nbOccurences DESC, requete";
                    break;
                    }
                 case 2 : 
					{
                    $this->requeteStatistiques = "SELECT * FROM moteur_recherche_statistiques WHERE pageVisitee='total' ORDER BY derniereDate DESC, requete";
                    break;
                    }
                 case 3 : 
				    {
                    $this->requeteStatistiques = "SELECT pageVisitee, count(*) FROM moteur_recherche_statistiques WHERE pageVisitee!='total' GROUP BY pageVisitee";
                    break;
                    }
                 case 4 :
				    {
                    $this->requeteStatistiques = "SELECT * FROM moteur_recherche_statistiques WHERE pageVisitee!='total' ORDER BY requete, nbOccurences DESC";
                    break;
                    }
				 default :
				    {
					$this->requeteStatistiques = "SELECT * FROM moteur_recherche_statistiques WHERE pageVisitee='total' ORDER BY nbOccurences DESC, requete";
                    break;
					}
                 }
			 }
        }
					   
    function selection3()
	    {
        $result = $this->query($this->requeteStatistiques);
		$nb = $result->numRows();
						   
		for ($i = 0; $i < $nb; $i++)
		    {
			$j = $i + 1;				
			$row = $result->fetchRow(); 
			$html.="							
				    <TR>
				        <TD ALIGN=LEFT ><FONT class=moteur_recherche_titre2>
				        ".$j." - ".$row[0]."</FONT></TD>
						<TD ALIGN=LEFT ><FONT class=moteur_recherche_titre2>
						".$row[1]."</FONT></TD>
					</TR>   
					"; 
			}
		return $html;
		}
		
	function selectionAutre()
	    {
        $result = $this->query($this->requeteStatistiques);
		$nb = $result->numRows();
		
		for ($i = 0; $i < $nb; $i++)
		    {
			$j = $i + 1;				
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC); 
			$html.="
			        <TR>
			            <TD ALIGN=LEFT ><FONT class=moteur_recherche_titre2>
				        ".$j." - ".$row["requete"]."</FONT></TD>
				        <TD ALIGN=LEFT ><FONT class=moteur_recherche_titre2>
				        ".$row["nbOccurences"]."</FONT></TD>
				        <TD ALIGN=LEFT ><FONT class=moteur_recherche_titre2>
				        ".$row["derniereDate"]."</FONT></TD>
				        <TD ALIGN=LEFT ><FONT class=moteur_recherche_titre2>
				        ".$row["pageVisitee"]."</FONT></TD>						   
				    </TR>						   	   
				    "; 
			 }						  
        return $html;	
        }

	function genererHTMLadmin($valeurs)
		{

	$this->configuration = new Configuration();
	
	if ($valeurs[defaut] == '1')
	    {
		// On a cliqué sur Valeur par défaut
		$this->configuration->setDefault();
		$this->configuration->enregistreConfiguration();
		
		$valeurs[defaut] = 0;	
	    }
	
	if ($valeurs[valider] == '1')
	    {
		// On a cliqué sur valider, on enregistre les valeurs entrés dans le formulaire dans la base	
		$this->configuration->setIndexationTypeFichier($valeurs[format]);
		$this->configuration->setIndexationRepertoireAExclure($valeurs[repexclu]);

        // Traitement des checkbox
        $tmpTypes=$valeurs[type] ;
		if ($tmpTypes[0] == "typetitle")
		    $this->configuration->setIndexationTypeTitle(1);
		else
		    $this->configuration->setIndexationTypeTitle(0);
		
		if ( ($tmpTypes[0] == "typecontenu") || ($tmpTypes[1] == "typecontenu") )
		    $this->configuration->setIndexationTypeContenu(1);
		else
		    $this->configuration->setIndexationTypeContenu(0);
			
	    if ($tmpTypes[0] == "ficpoint")
		    $this->configuration->setIndexationFichierPoint(1);			
		else
		    $this->configuration->setIndexationFichierPoint(0);

		$tmpACocher=$valeurs[acocher] ;
	    if ($tmpACocher[0] == "ficpoint")
		     $this->configuration->setIndexationFichierPoint(1);			
		else
		     $this->configuration->setIndexationFichierPoint(0);

		if ( ($tmpACocher[0] == "logindex") || ($tmpACocher[1] == "logindex") )
		    $this->configuration->setIndexationLog(1);
		else
		    $this->configuration->setIndexationLog(0);
			
		if ( ($tmpACocher[0] == "logreq") || ($tmpACocher[1] == "logreq") || ($tmpACocher[2] == "logreq") )	
		    $this->configuration->setRequeteLog(1);
		else
		    $this->configuration->setRequeteLog(0);

		$this->configuration->setIndexationRepertoireRacine($valeurs[repracine]);
		$this->configuration->setIndexationPoidsTitle($valeurs[poidstitle]);
		$this->configuration->setIndexationPoidsNomFichier($valeurs[poidsnom]);
		$this->configuration->setFeuilleDeStyles($valeurs[formeres]);
		$this->configuration->setResultatsNbResultatsParPage($valeurs[nbres]);
		$this->configuration->setRequeteTri($valeurs[tri]);
		$this->configuration->setIndexationLangues($valeurs[indexLangues]);
		$this->configuration->setNomTableFichier($valeurs[tablefichier]);
		$this->configuration->setNomTableMotFichier($valeurs[tablemotfichier]);
		$this->configuration->setFichierConnexionBDD($valeurs[cheminBDD]);
		$this->configuration->setMotsVides($valeurs[motvide]);
		
		$this->configuration->setRepertoireLocal($valeurs[repertoireLocal]);
		$this->configuration->setRepertoireDistant($valeurs[repertoireDistant]);
		
		$this->configuration->enregistreConfiguration();				
		
	    $valeurs[valider] = 0;
	    }

    if ($valeurs[index] == 1)
        {
		// On lance immédiatement l'indexation
        $indexation = new Indexation();
        }
		

		$req = "SELECT * FROM moteur_recherche_configuration";					
	    // on execute la requête SQL.
		$result = $this->query($req);
		$this->rowConfiguration = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
	return $html;
	}	
	
	function genererCron($valeurs)
	 	{	 
	    if ($valeurs[cron] == 1)
	        {	
		    $url="http://".$_SERVER['HTTP_HOST']."/".$this->getCheminPlugin()."laetis_recherche_indexation.php";
	 		
            // L'utilisateur a cliqué sur le bouton "Générer CRON"
		    $valeurs[cron]=$valeurs[minute]." ".$valeurs[heure]." ".$valeurs[jourMois]." ".$valeurs[mois]." ".$valeurs[jourSemaine]." wget ".$url;
		
		    return "Voici la ligne à utiliser pour configurer le  CRON :<br><br>".$valeurs[cron];
		    }
		}
		
	/**
	*
	* une focntion qui renvoie le chemin du pugin à partir de la racine
	*
	*
	*/
	function getCheminPlugin()
		{
		return "includes/plugins/moteur_recherche/";
		}
		
	function getCheminMoteurJavascript()
		{
		return "../../includes/plugins/moteur_recherche/includes/javascript/laetis_moteur_recherche.js"."";
		}
	
	function getCheminStyle()
		{
		return "../../includes/plugins/moteur_recherche/includes/styles/style.css"."";
		}
		
	function getCheminImageHautBlanc()
		{	
		return "../../includes/plugins/moteur_recherche/images/haut_blanc.gif"."";
		}
		
	function getCheminImageFiletG()
		{	
		return "../../includes/plugins/moteur_recherche/images/filet_g.gif"."";
		}
	
	function getCheminImageSepar()
		{	
		return "../../includes/plugins/moteur_recherche/images/separ.gif"."";
		}
		
	function getCheminImageFiletD()
		{	
		return "../../includes/plugins/moteur_recherche/images/filet_d.gif"."";
		}
	
	function getCheminImageBasBlanc()
		{	
		return "../../includes/plugins/moteur_recherche/images/bas_blanc.gif"."";
		}

}

?>
