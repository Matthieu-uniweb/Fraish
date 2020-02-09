<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/includes/classes/classes.inc.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/boutique/includes/classes/paquetage.inc.php';

//$tabClients = array('11','13','15','21','29','31','37','44','65','70','72','76','81','97','158','182','187','191','192','202','206','211','215','217','229','235','243','246','250','252','267','268','277','283','310','321','327','332','334','349','357','364','400','401','410','445','480','492','495','509','515','539','555','569','582','583','584','631','635','637','649','676','692','703','718','724','728','733','757','779','797','805','819','832','833','847','851','857','864','866','870','871','878','892','895','897','900','901','903','905','911','913','918','919','921','925','928','938','939','945','947','955','958','965','966','969','971','972','973','978','979','980','983','990','991','994','998','1008','1009','1010','1011','1013','1015','1016','1041');



foreach($tabClients as $ID_client)
	{
	$tabAppro = array('montant'=>10,'ID_typ_paiement'=>6,'valide'=>1,'ID_client'=>$ID_client);
	
	//print_r($appro);
	//ajouter un appro de type "offert"
	$appro = new Tbq_approvisionnement();
	$appro->enregistrer($tabAppro);
	$appro->valider();
	
	/*//augmenter le solde du client
	$client=new Tbq_client($ID_client);
	$requete = "UPDATE boutique_obj_client
				SET soldeCompte = soldeCompte -20
				WHERE ID='".$ID_client."'";
	T_LAETIS_site::requeter($requete);*/
	}
echo 'TERMINE';
?>