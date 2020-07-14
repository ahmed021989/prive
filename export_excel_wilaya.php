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
$excel .=  "Id\tNom\tPrenom\tDate Naissance\tSexe\tcommune Naissance\tDiplome\tSpecialite\twilaya\tCommune Installation\tType Etablissement\tIdentite juridique Commercial\type_employe \n";
 if  ($user->type == 'Admin_dsp')   {   
              
              
                    
	$employers = Employe::trouve_par_wilaya($user->wilaya);
			$i=1;
			foreach($employers as $employer){
									
									if($employer->type_employe==-1){
				
					
$excel .="".$i."\t".utf8_decode(html_entity_decode($employer->nom_employe))."\t".utf8_decode(html_entity_decode($employer->prenom_employe))."\t".html_entity_decode($employer->date_nais_employe)."\t".html_entity_decode($employer->sexe_employe)."\t".utf8_decode(html_entity_decode($employer->commune_nais))."\t".stripcslashes(utf8_decode(html_entity_decode($employer->diplome)))."\t".stripcslashes(utf8_decode(html_entity_decode($employer->specialite)))."\t".utf8_decode(html_entity_decode($employer->wilaya))."\t".utf8_decode(html_entity_decode($employer->commune_installation))."\t".stripcslashes(utf8_decode(html_entity_decode($employer->type_etablissement)))."\t".stripcslashes(utf8_decode(html_entity_decode($employer->identite_jurdique)))."\n";

$employer_cliniques=Employe::trouve_employe_type($employer->id_employe);
$j=1;
										foreach($employer_cliniques as $employer_clinique){
			$excel .="".$i."--".$j."\t".utf8_decode(html_entity_decode($employer_clinique->nom_employe))."\t".utf8_decode(html_entity_decode($employer_clinique->prenom_employe))."\t".html_entity_decode($employer_clinique->date_nais_employe)."\t".html_entity_decode($employer->sexe_employe)."\t".utf8_decode(html_entity_decode($employer_clinique->commune_nais))."\t".stripcslashes(utf8_decode(html_entity_decode($employer_clinique->diplome)))."\t".stripcslashes(utf8_decode(html_entity_decode($employer_clinique->specialite)))."\t".utf8_decode(html_entity_decode($employer_clinique->wilaya))."\t".utf8_decode(html_entity_decode($employer_clinique->commune_installation))."\t".stripcslashes(utf8_decode(html_entity_decode($employer_clinique->type_etablissement)))."\t".stripcslashes(utf8_decode(html_entity_decode($employer_clinique->identite_jurdique)))."\n";		
			++$j;
			}   }

                                  if($employer->type_employe==0){
									  $excel .="".$i."\t".utf8_decode(html_entity_decode($employer->nom_employe))."\t".utf8_decode(html_entity_decode($employer->prenom_employe))."\t".html_entity_decode($employer->date_nais_employe)."\t".html_entity_decode($employer->sexe_employe)."\t".utf8_decode(html_entity_decode($employer->commune_nais))."\t".stripcslashes(utf8_decode(html_entity_decode($employer->diplome)))."\t".stripcslashes(utf8_decode(html_entity_decode($employer->specialite)))."\t".utf8_decode(html_entity_decode($employer->wilaya))."\t".utf8_decode(html_entity_decode($employer->commune_installation))."\t".stripslashes(utf8_decode(html_entity_decode($employer->type_etablissement)))."\t".stripcslashes(utf8_decode(html_entity_decode($employer->identite_jurdique)))."\n";					

 /* $data = array(
  for($i=0;$i<20;$i++){
  array("id employe" => html_entity_decode($employer->id_employe),"nom" => html_entity_decode($employer->nom_employe),"prenom" => html_entity_decode($employer->prenom_employe) )}
  );*/
  

  //foreach($newReservations as $row) {
    
  }
  ++$i;
  }}
 
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=liste-employee.xls");

print $excel;
exit;
?>