<?php
require_once("includes/initialiser.php");
if(isset($session->id_utilisateur) ){
global $bd;

$user = Personne::trouve_par_id($session->id_utilisateur);
 $SQL = $bd->requete("SELECT * FROM personne,message where   message.id_destinataire=personne.id and personne.id=".$user->id." and lire_mess=0 ") ;
	$nbr = mysqli_num_rows($SQL);
	echo $nbr;
}
else{
	echo "<script>document.location.href='login.php';</script>";
}
	
	?>