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

$excel = "";
$excel .=  "Id\tNom\tPrenom\tEpoux\tDate Naissance\tSexe\tAdresse\tcommune Naissance\tDiplome\tSpecialite\twilaya\tCommune Installation\tType Etablissement\tIdentite juridique Commercial\tNumero Agriment\tDate Agriment\ttype_employe \n";

 if  ($user->type == 'administrateur' or $user->type == 'Admin_dsp' or $user->type == 'DGSS-RH')   {   
        
         list($diplome1, $specialite1, $wilaya1,$recherche) = explode("|",$_GET['var']); 
  //$excel .= $diplome[0].$specialite[0]  ;

$diplome=  explode(",",$diplome1);
$specialite=  explode(",",$specialite1);
$wilaya=  explode(",",$wilaya1);
          	$d='';
		$s='';
		$w='';
		
		
		
	
	if($diplome[0]=="tous"){$d.="diplome like '%' ";}
		if($specialite[0]=="tous"){$s.="specialite like '%' ";}
		if($wilaya[0]=="tous"){$w.="wilaya like '%' ";}
		
		
			if($diplome[0]!="tous"){$d.='diplome = "'.htmlspecialchars(trim($diplome[0])).'"';}	
	if(sizeof($diplome)>1){
		for($i=1;$i<sizeof($diplome);$i++){
			$d.=' or diplome = "'.htmlspecialchars(trim($diplome[$i])).'"';
		}
	}
	
		if($specialite[0]!="tous"){$s.='specialite = "'.htmlspecialchars(trim($specialite[0])).'"';}	
	if(sizeof($specialite)>1){
		for($i=1;$i<sizeof($specialite);$i++){
			$s.=' or specialite = "'.htmlspecialchars(trim($specialite[$i])).'"';
		}
	}
	
	if($wilaya[0]!="tous"){$w.='wilaya = "'.htmlspecialchars(trim($wilaya[0])).'"';}	
	if(sizeof($wilaya)>1){
		for($i=1;$i<sizeof($wilaya);$i++){
			$w.=' or wilaya = "'.htmlspecialchars(trim($wilaya[$i])).'"';
		}
	}
		
	
			$i=1;
			$r="";
			if($recherche=="s"){$r=" and (type_employe=-1 or type_employe=0)";}
			$SQL = $bd->requete('SELECT * FROM employer where ('.$d.') and ('.$s.') and ('.$w.') '.$r.'  and archive=0');
				while ($rows = $bd->fetch_array($SQL))
														{
			//foreach($employers as $employer){
		//	$employer=Employer::trouve_par_id($rows['id_employe']);	
$commune_nais="";$diplom="";$specialit="";$commune_instal="";$wil="";
		
	if($commune=Communes::trouve_par_code_postal($rows['commune_nais']))
		$commune_nais=$commune->nom_com;
     if($diplome=Diplome::trouve_par_id($rows['diplome']))
	 $diplom=$diplome->nom_diplome;
     if($specialite=Specialite::trouve_par_id($rows['specialite'])){
		 $specialit=$specialite->nom_specialite;
	 }
	//echo $rows['wilaya']."<br>";
    if($wilaya=Wilayas::trouve_par_id((int)$rows['wilaya'])){
	    $wil=$wilaya->nom;
	}
	if($commune2=Communes::trouve_par_code_postal($rows['commune_installation']))
		$commune_instal=$commune2->nom_com;
			if($etablissement=Etablissement::trouve_par_id($rows['type_etablissement']))	
				$type_etab=$etablissement->type_etab;
				
					
$excel .="".$rows['id_employe']."\t".utf8_decode(htmlspecialchars_decode($rows['nom_employe']))."\t".utf8_decode(htmlspecialchars_decode($rows['prenom_employe']))."\t".utf8_decode(htmlspecialchars_decode($rows['epoux']))."\t".htmlspecialchars_decode($rows['date_nais_employe'])."\t".utf8_decode(htmlspecialchars_decode($rows['sexe_employe']))."\t".$rows['adrs']."\t".utf8_decode(htmlspecialchars_decode($commune_nais))."\t".stripcslashes(utf8_decode(htmlspecialchars_decode($diplom)))."\t".utf8_decode(htmlspecialchars_decode($specialit))."\t".utf8_decode(htmlspecialchars_decode($wil))."\t".utf8_decode(htmlspecialchars_decode($commune_instal))."\t".stripcslashes(utf8_decode(htmlspecialchars_decode(($type_etab))))."\t".stripcslashes(utf8_decode(htmlspecialchars_decode($rows['identite_jurdique'])))."\t".utf8_decode(htmlspecialchars_decode($rows['numero_agriment']))."\t".utf8_decode(htmlspecialchars_decode($rows['date_agriment']))."\t".$rows['type_employe']."\n";

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