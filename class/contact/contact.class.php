<?php 


class contact
{

		function __construct()
		{
		}
		
		function create($data)
		{									
			$rqt = new mysql;
			
			$rst 	= $rqt->query('INSERT INTO 
											contact (
												nom,
												prenom,
												adresse,
												ville,
												code_postal,
												pays,
												telephone,
												email,
												commentaires,
												mailing,
												date_inscription
											)VALUES (
												"'.$data['nom'].'",
												"'.$data['prenom'].'",
												"'.$data['adresse'].'",
												"'.$data['ville'].'",
												"'.$data['code_postal'].'",
												"'.$data['pays'].'",
												"'.$data['telephone'].'",
												"'.$data['email'].'",												
												"'.$data['commentaires'].'",												
												"'.$data['mailing'].'",
												"'.date('Y-m-d').'"
											)');	
			return $rst ;
		}		
		
		function desinscription($data)
		{
				$rqt = new mysql ;		
				$rst = $rqt->query("UPDATE contact SET mailing = '0' WHERE email = '$data[email]'");
				return $rst;
		}
		
		function select_by_email($data)
		{
			$rqt = new mysql ;
			$rst = $rqt->query("SELECT * FROM contact WHERE email = '".$data[email]."'");
			return $rst;
		}

		function creer_message_CrazyGame_lotNormal($message)
		{
			
			
			
			$rst = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
					<html><head>
					<style type="text/css">
					.texte{
						color: #000000;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
					}
					a.url {
						color: #e8b601;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
						text-decoration:none;
					}
					a.url:hover { 
						color: #e8b601;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
						text-decoration:underline;
					}
					</style>
					</head><body class="body">';			
			$rst .= '<table align="left" border="0" cellpadding="4" cellspacing="0" bgcolor="#ffffff" style="border:1px black solid;">
					<tr><td><img src="http://www.tutti-pizza.com/media/images/mail_top.jpg"></td></tr>
					<tr><td align="left">
					<br>
					<br>				
					'.$message.'			
					<br>
					<br>
					</td></tr></table><br>';		
			$rst .= '</div></body></html>';							
			return $rst ;
		}
		
		function creer_message_contact_fraish($data)
		{
			
			$rst = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
					<html><head>
					<style type="text/css">
					.texte{
						color: #000000;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
					}
					a.url {
						color: #e8b601;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
						text-decoration:none;
					}
					a.url:hover { 
						color: #e8b601;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
						text-decoration:underline;
					}
					</style>
					</head><body class="body">';			
			$rst .= '<table align="left" border="0" cellpadding="4" cellspacing="0" bgcolor="#ffffff" style="border:1px black solid;">
					<tr><td><img src="https://www.fraish.fr/styles/frontend/img/fraish_04.png" alt="Fraish" width="292" height="174"/></td></tr>
					<tr><td align="left">
					<b>Message de :</b> '.ucfirst(utf8_decode($data[prenom])).' '.ucfirst(utf8_decode($data[nom])).'<br><br>						
					<br>	<br>								
					<b>T&eacute;l&eacute;phone :</b> '.$data[tel].'<br><br>	
					<b>Email :</b> '.$data[email].'<br>	<br>	
					<b>Sujet :</b> '.utf8_decode($data[sujet]).'<br>	<br>					 
					<br>
					<b>Message :</b> '.utf8_decode(nl2br($data[message])).'					
					<br>
					<br>
					</td></tr></table><br>';		
			$rst .= '</div></body></html>';							
			return $rst ;
		}
		
		function creer_message_emploi_tutti($data)
		{
			
			$rst = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
					<html><head>
					<style type="text/css">
					.texte{
						color: #000000;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
					}
					a.url {
						color: #e8b601;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
						text-decoration:none;
					}
					a.url:hover { 
						color: #e8b601;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 9pt;
						text-decoration:underline;
					}
					</style>
					</head><body class="body">';			
			$rst .= '<table align="left" border="0" cellpadding="4" cellspacing="0" bgcolor="#ffffff" style="border:1px black solid;">
					<tr><td><img src="http://www.tutti-pizza.com/media/images/mail_top.jpg"</td></tr>
					<tr><td align="left">
					<b>Message de :</b> '.ucfirst(utf8_decode($data[prenom])).' '.ucfirst(utf8_decode($data[nom])).'<br><br>						
					<b>Qui demande un poste de : </b>';
					
					if ($data[poste1]!="") $rst .= $data[poste1].', ';
					if ($data[poste2]!="") $rst .= $data[poste2].', ';
					if ($data[poste3]!="") $rst .= $data[poste3].', ';
					if ($data[poste4]!="") $rst .= $data[poste4].', ';					
					
					$rst .= '<br>	<br>	
					<b>Dans les départements : </b>';
					
					if ($data[departement1]!="") $rst .= $data[departement1].', ';
					if ($data[departement2]!="") $rst .= $data[departement2].', ';
					if ($data[departement3]!="") $rst .= $data[departement3].', ';
					if ($data[departement4]!="") $rst .= $data[departement4].', ';
					if ($data[departement5]!="") $rst .= $data[departement5].', ';
					if ($data[departement6]!="") $rst .= $data[departement6].', ';
					
					
					$rst .= '<br>	<br>							
					<b>T&eacute;l&eacute;phone mobile :</b> '.$data[telmob].'<br><br>	
					<b>T&eacute;l&eacute;phone fixe :</b> '.$data[telfixe].'<br><br>
					<b>Adresse postale :</b> '.utf8_decode($data[adresse]).'<br><br>
					<b>CP et ville :</b> '.utf8_decode($data[cpville]).'<br><br>
					<b>Email :</b> '.$data[email].'<br>	<br>	
					<b>Commentaire :</b> '.utf8_decode($data[commentaire]).'<br><br>
							 
					<br>
						
					<br>
					<br>
					</td></tr></table><br>';		
			$rst .= '</div></body></html>';							
			return $rst ;
		}
    
		function send_mail($from,$to,$objet,$message)	
		{
			$mail = new mime_mail;	
			// headers
			$entetedate = date("D, j M Y H:i:s -0500");
			$entetemail .= "X-Mailer: PHP/" . phpversion() . "\n" ; 
			$entetemail .= "Date: $entetedate";
      
			$mail->headers = "$entetemail";
			// expéditeur
			$mail->from = $from; 
			// destinataire
			$mail->to = $to;	
			// objet		
			$mail->subject = stripslashes($objet);					
			// message
			$mail->body = stripslashes($message);
			// envoi du mail
			$rst = $mail->send();
			return $rst ;
		}
}
?>