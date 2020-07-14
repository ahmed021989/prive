<?php  
require_once("includes/initialiser.php");
if(isset($session->id_utilisateur) ){
$user = Personne::trouve_par_id($session->id_utilisateur);
$id_ses=$session->getsession_id();
global $bd;
if($user->type=="administrateur" or $user->type=="Admin_dsp"){
	$req00=$bd->requete("select * from cpt_connectes where user='".$user->login."'");
if(mysqli_num_rows($req00)==0){
    $bd->requete('insert into cpt_connectes (ip, timestamp,user,session) values ("'.$_SERVER['REMOTE_ADDR'].'", "'.time().'","'.$user->login.'","'.$id_ses.'")');

}else{
	$bd->requete("update cpt_connectes set timestamp=".time()." where user='".$user->login."'");
}	
}		
					if($user->type=="administrateur"){
					$req=$bd->requete("select * from cpt_connectes ");
					while($row=mysqli_fetch_array($req)){
						if((time()-$row['timestamp'])>=20){
							$req1=$bd->requete("delete from cpt_connectes where timestamp=".$row['timestamp']."");
						}
					//echo "<script>alert(".(time()-$row['timestamp']).");</script>";
					}
					}
}

					?>