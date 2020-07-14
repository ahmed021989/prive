<?php
require_once("includes/initialiser.php");


	$employe_p=Employe::trouve_par_id($_POST['id']);
	
$employe_p->archive=0;
if($employe_p->save()){
	echo "employé déclassé";
}





?>