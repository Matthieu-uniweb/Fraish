<?php
/***************************************************************************************
* Warning !! CMCIC_Config contains the key, you have to protect this file with all     *   
* the mechanism available in your development environment.                             *
* You may for instance put this file in another directory and/or change its name       *
***************************************************************************************/
/*paiement cb normal*/

define ("CMCIC_CLE", "BA92D52F74C01F4BC6BE51B74E448EBD761F249A");
define ("CMCIC_TPE", "0364873");
define ("CMCIC_VERSION", "3.0");
define ("CMCIC_SERVEUR", "https://ssl.paiement.cic-banques.fr/");
define ("CMCIC_CODESOCIETE", "fraish");
/*define ("CMCIC_URLOK", "http://www.fraish.fr/retourcommandeok.html");
define ("CMCIC_URLKO", "http://www.fraish.fr/retourcommandenotok.html");*/
define ("CMCIC_URLOK", "http://".$_SERVER['HTTP_HOST']."/retourcommandeok.html");
define ("CMCIC_URLKO", "http://".$_SERVER['HTTP_HOST']."/retourcommandenotok.html");
?>