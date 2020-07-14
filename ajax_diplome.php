<?php
require_once("includes/initialiser.php");

$SQL="";
$diplome=Diplome::trouve_par_id($_POST['diplome']);

	$SQL = $bd->requete("select * from specialite where diplome=".$_POST['diplome']."");
if($bd->num_rows($SQL)==0){
	$SQL = $bd->requete("select * from specialite where diplome=0");
}
while ($row=$bd->fetch_array($SQL)){ 
if($row["id_specialite"]!=null){
echo $row["nom_specialite"].','.$row["id_specialite"].'|';
}
}


?>