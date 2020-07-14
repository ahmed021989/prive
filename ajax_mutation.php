<?php
require_once("includes/initialiser.php");


	$employe_p=Employe::trouve_par_id($_POST['id_p']);
	$SQL = $bd->requete("update employer set commune_installation=".$employe_p->commune_installation.",adrs='".$employe_p->adrs."',numero_agriment='".$employe_p->numero_agriment."',date_agriment='".$employe_p->date_agriment."',type_etablissement=".$employe_p->type_etablissement." , identite_jurdique='".$employe_p->identite_jurdique."', date_instal='".$_POST['date_nouvelle_instal']."' , type_employe=".$_POST['id_p']." where id_employe=".$_POST['id_t']."") ; 

	//$SQL1 = $bd->requete("insert into mutation value(16,".$_POST['id_p'].",".$employe_p->commune_installation.",'".$employe_p->adrs."','".$employe_p->numero_agriment."','0000-00-00',".$employe_p->type_etablissement.",'".$employe_p->identite_jurdique."','".$_POST['date_nouvelle_instal']."','0000-00-00','".$_POST['date_ancien_instal']."','".$_POST['date_ancien_instal']."'") ; 

$mutation = new Mutation();

//$mutation->employe='100';
$mutation->commune_installation=$employe_p->commune_installation;
$mutation->adrs=$employe_p->adrs;
$mutation->numero_agriment=$employe_p->numero_agriment;
$mutation->date_agriment=$employe_p->date_agriment;
$mutation->type_etablissement=$employe_p->type_etablissement;
$mutation->identite_jurdique=$employe_p->identite_jurdique;
$mutation->date_creation=$employe_p->date_creation;
$mutation->date_installation_ancien=$_POST['date_ancien_instal'];
$mutation->date_fin_instal=$_POST['date_fin_instal'];
$mutation->id_employe=$_POST['id_t'];

if($SQL and $mutation->save()){


	echo "Mutation avec succes";
}
else{
	echo "Mutation echoue".$_POST['id_t'];
}



?>