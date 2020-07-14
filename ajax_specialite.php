<?php
require_once("includes/initialiser.php");

$SQL="";
//$specilaite=Specilaite::trouve_par_id(2);
$ids="id_groupe_specialite=".$_POST['groupe'][0];
for($i=1;$i<sizeof($_POST['groupe']);$i++){
$ids=$ids." or id_groupe_specialite=".$_POST['groupe'][$i];
}
	$SQL = $bd->requete("select * from specialite where (".$ids.")");
echo "tous les specialite,tous|";
while ($row=$bd->fetch_array($SQL)){ 
if($row["id_specialite"]!=null){
echo $row["nom_specialite"].','.$row["id_specialite"].'|';
}
}


?>