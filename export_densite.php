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
        
         list($specialite1, $wilaya1) = explode("|",$_GET['var']); 
  

$specialite=  explode(",",$specialite1);
$wilaya=  explode(",",$wilaya1);
$excel = "";
$excel .= "Wilaya \t Poppulation ";
$specialites=Specialite::trouve_specialite($specialite);
								foreach($specialites as $specialite){
							
								$excel .="\t".utf8_decode($specialite->nom_specialite); 	
								}
								$excel .="\n";
								
			$wila=Wilayas::trouve_wilaya($wilaya);				
	 foreach($wila as $ww){ 

	
	$excel.=utf8_decode($ww->nom)."\t";
	$excel.=$ww->pop_wil."\t";
	
	foreach($specialites as $specialite){
													$employer = Employe::trouve_par_specialite($specialite->id_specialite,$ww->id_w);
														$sql1=$bd->requete("select count(*) as sum from employer WHERE specialite=".$specialite->id_specialite." and wilaya=".$ww->id_w ." and archive=0");
										while($row=mysqli_fetch_array($sql1)){
													
$excel.=$row['sum']."\t";
													}

	}
	$excel .="\n";
	 }
 }
	 
								
								
								
								
								
								
								



header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Transfer-Encoding: text/xls\n"); 
header("Content-disposition: attachment; filename=etat densite.xls");
header("Pragma: no-cache");
	header("Expires: 0");

print $excel;
exit;
?>