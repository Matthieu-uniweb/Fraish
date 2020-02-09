<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

$appro1 = new Tbq_approvisionnement(3645);
$appro1->setValide(0);

$client = new Tbq_client(1168);
$client->debiterSoldeCompte(20);
?>