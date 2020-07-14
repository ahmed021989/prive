
<?php 
require_once("../includes/initialiser.php");

if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = $_GET['id'];
		 $employer =  Employe::trouve_par_id($id);
		 
		$SQL2 = $bd->requete("update `employer` set archive=1 WHERE `id_employe` =  '$id'") ;
		$SQL2 = $bd->requete("update `employer` set archive=1 WHERE `type_employe` =  '$id'") ;	
	
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	
		
?> 
                               