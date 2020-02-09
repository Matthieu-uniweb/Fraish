<?php
     header('Content-Type: text/x-json; charset: UTF-8');
     include("../../includes/classes/func_calendrier.php");
     //On récupère le mois et l'année pour le traitement
     $mois=$_POST['mois'];
     $annee=$_POST['annee'];
     ///////////////////////////////////////////////////////////////////////////////////
     //   on va formater ici un flux JSON qui va pouvoir etre lu par le js client.
     //   Format du JSON:
     //   {
     //      "mois_en_cours" : $mois_en_cours
     //      "lien_precedent" : $lien_vers_le_mois_precedent ,
     //      "lien_suivant" : $lien_vers_le_mois_suivant ,
     //      "calendrier": [
     //            {
     //
     //               "fill": $contenu_a_afficher //(rien, jour du mois ou jour
     //                                           //du mois avec lien
     //            },
     //                    ]
     //   }
     //
     //
     //
     ///////////////////////////////////////////////////////////////////////////////////
     //
     //                    On prépare le début du retour au format JSON
     ///////////////////////////////////////////////////////////////////////////////////
     $retour_json='';
     ///////////////////////////////////////////////////////////////////////////////////
     //On détermine d'abord les liens "suivant" "precedent" et le "mois en cours" du calendrier
     ///////////////////////////////////////////////////////////////////////////////////
     $retour_json='{';
	 
     //mois en cours
     $mois_fr=getMois($mois);
     $titre=htmlentities($mois_fr." ".$annee,ENT_QUOTES);
     $retour_json.='"mois_en_cours" : "'.$titre.'" , ';
     //lien suivant
     $date_suivant=getSuivant($mois,$annee,1);
     $lien_suivant="tableau('".$date_suivant[mois]."','".$date_suivant[annee]."')";
	 $moisSuiv=$date_suivant[mois];
	 
	 if( 0 < $mois && $mois < 10 && strlen($mois) == 1)
			{	$moisA = '0'.$mois;	}
			else{
			$moisA = $mois;	}
	 $moisEnCoursNum=$moisA."-".$annee;
	 $retour_json.='"moisEnCoursNum" : "'.$moisEnCoursNum.'" , ';
	 
	 $retour_json.='"moisSuiv" : "'.$moisSuiv.'" , ';
     $retour_json.='"lien_suivant" : "'.$lien_suivant.'" , ';
     //lien précédent
     $date_precedent=getSuivant($mois,$annee,-1);
     $lien_precedent="tableau('".$date_precedent[mois]."','".$date_precedent[annee]."')";
	 $moisPrec=$date_precedent[mois];
	 $retour_json.='"moisPrec" : "'.$moisPrec.'" , ';
     $retour_json.='"lien_precedent" : "'.$lien_precedent.'" , ';

     //Maintenant, on peut peupler le calendrier sous forme d'un tableau de 6 lignes * 7 colonnes
     //On crée notre tableau de 6semaines*7jours soit 42 éléments.
     //On récupère le jour qui démmarre le mois
     //ON va stocker tous les jours du mois dans un tableau tab_jours php
     $tab_jours=array();

     $num_jour=getFirstDay($mois,$annee);
	 $retour_json.='"num_jour" : "'.$num_jour.'" , ';
     $compteur=1;
     $num_jour_courant=1;

     while($compteur<43){
    if($compteur<$num_jour){
          $tab_jours[$compteur]='';
     }else
     {
         //si la date existe, on affiche alors le jour dans la cellule du tableau
         if(checkdate($mois,$num_jour_courant,$annee)){
              $date=$annee."/".$mois."/".$num_jour_courant;
					 $lien='<a href=\"javascript:actualiseJour('.$num_jour_courant.'), afficheCalendrier()\">'.$num_jour_courant.'</a>';
                     $tab_jours[$compteur]=$lien;
              $num_jour_courant++;
        }
     }
       $compteur++;
     }
     
     ///////////////////////////////////////////////////////////////////////////////////
     // Maintenant que l'on a notre tableau d'évènements pour chaque jour du mois
     // On finit de construire la réponse JSON
     ///////////////////////////////////////////////////////////////////////////////////
     if(!empty($tab_jours)){
        $retour_json.=' "calendrier" : [ ';
        $compteur=1;
        while($compteur<43){
           if($compteur==42){
            $retour_json.=' { "fill" : "'.$tab_jours[$compteur].'" } ';
           }else
           {
            $retour_json.=' { "fill" : "'.$tab_jours[$compteur].'" } , ';
           }
        $compteur++;
        }
        $retour_json.=' ] ';
     }
     $retour_json.=' } ';

     echo $retour_json;

?>