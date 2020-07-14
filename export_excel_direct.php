<?php
 // namespace Chirp;

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' );
	if( !in_array($user->type,$accestype)){ 
	
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 

$excel = "";
$excel .=  "Id\tNom\tPrenom\tDate Naissance\tcommune Naissance\tDiplome\twilaya\tCommune Installation\tType Etablissement\tIdentite juridique Commercial \n";
 if  ($user->type == 'administrateur')   {   
              
              
                    
	//$employers = Employe::trouve_tous();
	
			$i=1;
			$SQL = $bd->requete(" SELECT * FROM `employer`");
				while ($rows = $bd->fetch_array($SQL))
														{
			//foreach($employers as $employer){
									
									if($rows['type_employe']==-1){
				
					
$excel .="".$i."\t".utf8_decode(html_entity_decode($rows['nom_employe']))."\t".utf8_decode(html_entity_decode($rows['prenom_employe']))."\t".html_entity_decode($rows['date_nais_employe'])."\t".utf8_decode(html_entity_decode($rows['commune_nais']))."\t".stripcslashes(utf8_decode(html_entity_decode($rows['diplome'])))."\t".utf8_decode(html_entity_decode($rows['wilaya']))."\t".utf8_decode(html_entity_decode($rows['commune_installation']))."\t".stripcslashes(utf8_decode(html_entity_decode($rows['type_etablissement'])))."\t".stripcslashes(utf8_decode(html_entity_decode($rows['identite_jurdique'])))."\n";

//$employer_cliniques=Employe::trouve_employe_type($rows['id_employe']);
$j=1;

$SQL1 = $bd->requete(" SELECT * FROM `employer` where type_employe=".$rows['id_employe']."");
				while ($rows1 = $bd->fetch_array($SQL1))
														{
										
			$excel .="".$i."--".$j."\t".utf8_decode(html_entity_decode($rows1['nom_employe']))."\t".utf8_decode(html_entity_decode($rows1['prenom_employe']))."\t".html_entity_decode($rows1['date_nais_employe'])."\t".utf8_decode(html_entity_decode($rows1['commune_nais']))."\t".stripcslashes(utf8_decode(html_entity_decode($rows1['diplome'])))."\t".utf8_decode(html_entity_decode($rows1['wilaya']))."\t".utf8_decode(html_entity_decode($rows1['commune_installation']))."\t".stripcslashes(utf8_decode(html_entity_decode($rows1['type_etablissement'])))."\t".stripcslashes(utf8_decode(html_entity_decode($rows1['identite_jurdique'])))."\n";		
			++$j;
			}   }

                                  if($rows['type_employe']==0){
									  $excel .="".$i."\t".utf8_decode(html_entity_decode($rows['nom_employe']))."\t".utf8_decode(html_entity_decode($rows['prenom_employe']))."\t".html_entity_decode($rows['date_nais_employe'])."\t".utf8_decode(html_entity_decode($rows['commune_nais']))."\t".stripcslashes(utf8_decode(html_entity_decode($rows['diplome'])))."\t".utf8_decode(html_entity_decode($rows['wilaya']))."\t".utf8_decode(html_entity_decode($rows['commune_installation']))."\t".stripcslashes(utf8_decode(html_entity_decode($rows['type_etablissement'])))."\t".stripcslashes(utf8_decode(html_entity_decode($rows['identite_jurdique'])))."\n";					

 /* $data = array(
  for($i=0;$i<20;$i++){
  array("id employe" => html_entity_decode($employer->id_employe),"nom" => html_entity_decode($employer->nom_employe),"prenom" => html_entity_decode($employer->prenom_employe) )}
  );*/
  

  //foreach($newReservations as $row) {
    
  }
  ++$i;
  }}

	
 
 
header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Transfer-Encoding: text/xls\n"); 
header("Content-disposition: attachment; filename=liste-employee.xls");
header("Pragma: no-cache");
	header("Expires: 0");

print $excel;
exit;
?>