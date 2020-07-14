<?php
require_once("includes/initialiser.php");


	$employe_p=Employe::trouve_par_id($_POST['id']);
	
	$fin_relation = new  Fin_relation();

	$fin_relation-> date_fine= $_POST['date_fine'];
	
	$fin_relation-> id_emp = $employe_p->type_employe;
	$fin_relation-> commune_installation = $employe_p->commune_installation;
	$fin_relation-> adrs = $employe_p->adrs;
	$fin_relation-> type_etablissement = $employe_p->type_etablissement;
	$fin_relation-> identite_jurdique = $employe_p->identite_jurdique;
	$fin_relation-> numero_agriment = $employe_p->numero_agriment;
	$fin_relation-> date_agriment = $employe_p->date_agriment;
	$fin_relation-> date_instal = $employe_p->date_instal;
		$fin_relation-> diplome = $employer_p->diplome;
	$fin_relation-> specialite = $employer_p->specialite;
	
	if ($fin_relation->id_emp==-1){
	  }
   		else{
		
		$fin_relation->save();
			$sql=$bd->requete("update employer set archive=2 where id_employe=".$employe_p->type_employe." ");
			$sql2=$bd->requete("update employer set type_employe=-1  where id_employe=".$_POST['id']." ");
			$employer=Employe::trouve_par_type($employe_p->type_employe);
			foreach ($employer as $employer){
				
				if ($employer->id_employe!=$_POST['id']){
					
					$employer->type_employe= ($_POST['id']);
					$employer->save();
					
				}
				
				
			}
			
		echo "Gérant choisi avec succes ."	;
	  }	
	




?>