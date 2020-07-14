<?php 
require_once("../includes/initialiser.php");

if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = $_GET['id'];
		 
 $SQL = $bd->requete(" DELETE FROM `gestiongds`.`prod_rientegre` WHERE `prod_rientegre`.`id_rin` ='$id' ");
	
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
?> 