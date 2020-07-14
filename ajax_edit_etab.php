<?php
require_once("includes/initialiser.php");


	$employe_p=Employe::trouve_par_id($_POST['id']);
	

//$mutation->employe='100';
$commun=Communes::trouve_par_code_postal($employe_p->commune_installation);
echo $commun->nom_com."|";
echo $employe_p->adrs."|";
echo $employe_p->numero_agriment."|";
echo $employe_p->date_agriment."|";
$etab=Etablissement::trouve_par_id($employe_p->type_etablissement);
echo $etab->type_etab."|";
echo $employe_p->identite_jurdique."|";
echo $employe_p->date_creation."|";





?>