<?php
/***************************************************************************
             ____  _   _ ____  _              _     _  _   _   _
            |  _ \| | | |  _ \| |_ ___   ___ | |___| || | | | | |
            | |_) | |_| | |_) | __/ _ \ / _ \| / __| || |_| | | |
            |  __/|  _  |  __/| || (_) | (_) | \__ \__   _| |_| |
            |_|   |_| |_|_|    \__\___/ \___/|_|___/  |_|  \___/
            
                       mysql.inc.php  -  A Mysql Class
                             -------------------
    begin                : Sat Oct 20 2001
    copyright            : (C) 2001 PHPtools4U.com - Mathieu LESNIAK
    email                : support@phptools4u.com

***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

DEFINE ("SQL_HOST","mon serveur sql");
DEFINE ("SQL_BDD","ma base de donnees");
DEFINE ("SQL_USER","monlogin");
DEFINE ("SQL_PASSWORD","monpassword");

class mysql {


        //var $Host 		= 'localhost';    	// Hostname of our MySQL server
        //var $Database 	= 'agapej';		// Logical database name on that server
        //var $User 		= 'root';		// Database user
        //var $Password 	= 'root';	// Database user's password
        
        //var $Host 		= 'sql.yellis.net';    	// Hostname of our MySQL server
        //var $Database 	= 'k24008_db14';		// Logical database name on that server
        //var $User 		= 'k24008';		// Database user
        //var $Password 	= 'lyau1Jy4';	// Database user's password
        
        var $Host     = 'fraishfrdywww.mysql.db';     // Hostname of our MySQL server
        var $Database   = 'fraishfrdywww';    // Logical database name on that server
        var $User     = 'fraishfrdywww';   // Database user
        var $Password   = 'GsBj07190210'; // Database user's password
       
        

        var $Link_ID    = 0;           // Result of mysql_connect()
        var $Query_ID	= 0;           // Result of most recent mysql_query()
        var $Record		= array();     // Current mysql_fetch_array()-result
        var $Row;                      // Current row number
        var $Errno 		= 0;           // Error state of query
        var $Error 		= "";

	#
	# Connexion au serveur de base de données
	# Allow to call $var = new DB($otherhost,$otherDB,$otheruser,$otherpass);
	# where $other* are connections vars different from 
	# $this->Host, etc
	#
        
	function DB($altHost = "",$altDB = "",$altUser = "",$altPassword = "") {
		if ($altHost == "")
			$altHost = $this->Host;
		if ($altDB == "")
			$altDB = $this->Database;
		if ($altUser == "")
			$altUser = $this->User;
		if ($altPassword == "")
			$altPassword = $this->Password;

		$this->Host = $altHost;
		$this->Database = $altDB;
		$this->User = $altUser;
		$this->Password = $altPassword;
	}

    #
    # Stop the execution of the script
    # in case of error
    # $msg : the message that'll be printed
    #
    
    
    
    function halt($msg) {
    	$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
		
		$message="<h1>".$_SERVER['HTTP_HOST']."</h1><br /><br />Url de la page en cours : ".$monUrl;
		$message.="<br /><br />Url de la page précédente : ".$_SERVER["HTTP_REFERER"] ;
		$message.="<br /><br />Database error : ".$msg;
		$message.="<br /><br />Mysql error : $this->Errno ($this->Error)";
		
		$this-> send_mail("raphael@couleur-citron.com", "raphael@couleur-citron.com", "Alerte Monitoring - ".$_SERVER['HTTP_HOST'],$message);		
		
        echo("<FONT COLOR=\"#FFFFFF\"><B>Database error:</B> $msg<BR>\n");
        echo("<B>MySQL error</B>: 
        	$this->Errno ($this->Error)<BR>
        	<br /></FONT><H1>Le site est actuellement en maintenance... 
        	Merci de repasser plus tard</H1>\n");
        die("Session halted.");
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
	#
	# Connexion � la base de donn�e Intranet JGO
	#
	
	function connect() {
		global $DBType;
		
		if($this->Link_ID == 0) {
			$this->Link_ID = mysql_connect($this->Host, 
											$this->User, 
											$this->Password);
			if (!$this->Link_ID) {
				$this->halt("Link_ID == false, connect failed");
            }
            $SelectResult = mysql_select_db($this->Database, $this->Link_ID);
			if(!$SelectResult) {
				$this->Errno = mysql_errno($this->Link_ID);
				$this->Error = mysql_error($this->Link_ID);
				$this->halt("cannot select database <I>".$this->Database."</I>");
			}
		}
		return true;
	}
	
	#
    # Faire une requ�te
    # $Query_String = the query
    #
    
    function query($Query_String) {
		
		$this->connect();
		$this->Query_ID = mysql_query($Query_String,$this->Link_ID);
        $this->Row = 0;
        $this->Errno = mysql_errno();
        $this->Error = mysql_error();
        if (!$this->Query_ID) {
			$this->halt("Invalid SQL: ".$Query_String);
		}
		return $this->Query_ID;
	}

	#
	# return the next record of a MySQL query
	# in an array
	#
	
    function next_record() {
		$this->Record = mysql_fetch_array($this->Query_ID);
		$this->Row += 1;
		$this->Errno = mysql_errno();
		$this->Error = mysql_error();
		$stat = is_array($this->Record);
		if (!$stat) {
			mysql_free_result($this->Query_ID);
			$this->Query_ID = 0;
		}
		return $this->Record;
    }

	#
	# Return the number of rows affected by a query
	# (except insert and delete query)
	#
	
	function num_rows() {
		return mysql_num_rows($this->Query_ID);
	}

	#
	# Return the number of affected rows
	# by a UPDATE, INSERT or DELETE query
	#
	
    function affected_rows() {
		return mysql_affected_rows($this->Link_ID);
	}
    
    #
    # Return the id of the last inserted element
    #
    
	function insert_id() {
		return mysql_insert_id($this->Link_ID);
	}

	#
	# Optimize a table
	# $tbl_name : the name of the table
	#
	
	function optimize($tbl_name) {
		$this->connect();
		$this->Query_ID = @mysql_query("OPTIMIZE TABLE $tbl_name",$this->Link_ID);
	}

	#
	# Free the memory used by a result
	#
	
	function clean_results() {
		if($this->Query_ID != 0) mysql_freeresult($this->Query_ID);
	}

	#
	# Close the link to the MySQL database
	#
	
	function close() {
		if($this->Link_ID != 0) mysql_close($this->Link_ID);
	}
}
?>