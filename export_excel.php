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
 if  ($user->type == 'administrateur'  or $user->type == 'DGSS-RH')   {   
              
              
                    
	//$employers = Employe::trouve_tous();
	
			$i=1;
			$SQL = $bd->requete(" SELECT * FROM `employer`");
				while ($rows = $bd->fetch_array($SQL))
														{
			//foreach($employers as $employer){
									
									
				
					
$excel .="".$rows['id_employe']."\t".utf8_decode(htmlspecialchars_decode($rows['nom_employe']))."\t".utf8_decode(htmlspecialchars_decode($rows['prenom_employe']))."\t".htmlspecialchars_decode($rows['date_nais_employe'])."\t".utf8_decode(htmlspecialchars_decode($rows['sexe_employe']))."\t".utf8_decode(htmlspecialchars_decode($rows['commune_nais']))."\t".stripcslashes(utf8_decode(htmlspecialchars_decode($rows['diplome'])))."\t".utf8_decode(htmlspecialchars_decode($rows['specialite']))."\t".utf8_decode(htmlspecialchars_decode($rows['wilaya']))."\t".utf8_decode(htmlspecialchars_decode($rows['commune_installation']))."\t".stripcslashes(utf8_decode(htmlspecialchars_decode($rows['type_etablissement'])))."\t".stripcslashes(utf8_decode(htmlspecialchars_decode($rows['identite_jurdique'])))."\t".$rows['type_employe']."\n";

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