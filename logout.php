<?php 
require_once("includes/initialiser.php"); 

$user = Personne::trouve_par_id($session->id_utilisateur);
    $session->logout($user);
    
	
    readresser_a("login.php");

?>
