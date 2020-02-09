<?php
/*
* Ici d�claration des classes globales � tout le site
* Si des groupes de classes ne sont utiles qu'� une partie ou fonctionnalit� du site, d�couper en paquetage
*/
require_once 'DB.php';

include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/T_LAETIS_site_class.php';
?>