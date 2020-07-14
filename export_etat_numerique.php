<?php
 // namespace Chirp;

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.
require_once("includes/initialiser.php");
ini_set('max_execution_time', 0); 
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp'  or 'DGSS-RH'  );
	if( !in_array($user->type,$accestype)){ 
	
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 

 if  ($user->type == 'administrateur' or $user->type == 'Admin_dsp' or $user->type == 'DGSS-RH')   {   
        
         list($specialite1, $wilaya1,$recherche) = explode("|",$_GET['var']); 
  

$specialite=  explode(",",$specialite1);
$wilaya=  explode(",",$wilaya1);
$excel = "";
$excel .= "Spécialité \t Nbre\t Homme\t Femme\t <25 Ans\t 25-34\t 35-44\t 45-54\t 55-64\t >65 Ans\n";

									$total=0;
									$specialites=Specialite::trouve_specialite($specialite);	
								foreach($specialites as $specialite){
									
									if($employer = Employe::trouve_par_specialite($specialite->id_specialite,$wilaya)){
									//$total+= $employer->count_specialite($specialite->id_specialite,$wilaya);
$result=$employer->count_specialite_interval_age($specialite->id_specialite,$wilaya,$recherche);	
	$excel.=utf8_decode($specialite->nom_specialite)."\t". $result[8]."\t".$result[6]."\t".$result[7]."\t".$result[0]."\t".$result[1]."\t".$result[2]."\t".$result[3]."\t".$result[4]."\t".$result[5]."\n"; 
					
								}				
								else{ 
							 $excel.="". utf8_decode($specialite->nom_specialite)."\t0\t0\t0\t0\t0\t0\t0\t0\t0\n"; 
										
								} 
								
								}
								
                             
 }

header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Transfer-Encoding: text/xls\n"); 
header("Content-disposition: attachment; filename=etat numerique.xls");
header("Pragma: no-cache");
	header("Expires: 0");

print $excel;
exit;
?>