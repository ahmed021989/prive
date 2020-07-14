<?php

require_once('bd.php');
require_once('fonctions.php');

class Employe {
	
	protected static $nom_table="employer";
	protected static $champs = array('id_employe','nom_employe','prenom_employe','epoux', 'date_nais_employe','nais_valide','sexe_employe','commune_nais','fonction','diplome','specialite', 'wilaya','commune_installation','adrs','type_etablissement','identite_jurdique','activite','type_employe','numero_agriment','date_agriment','archive','date_instal','date_creation');
	public $id_employe;
	public $nom_employe;
	public $prenom_employe;
	public $epoux;
	public $date_nais_employe;
	public $nais_valide;
	public $commune_nais;
	public $sexe_employe;
    public $fonction;
	public $diplome;
	public $specialite;
	public $wilaya;
    public $commune_installation;
	public $adrs;
	public $type_etablissement; 
	public $identite_jurdique;
	public $activite; 
    public $type_employe;
	public $numero_agriment;
	public $date_agriment;
	public $archive;
	public $date_instal;
		public $date_creation;
	
	
  public function nom_compler() {
    if(isset($this->nom_employe) && isset($this->prenom_employe)) {
      return $this->nom_employe . " " . $this->prenom_employe;
    } else {
      return "";
    }
  }

   public function describe() {
    if(isset($this->nom_employe) && isset($this->prenom_employe)) {
    	$wilaya=Wilayas::trouve_par_id($this->wilaya );
      $ret=$wilaya->nom ;
      return $ret;
    } else {
      return "";
    }
  }
	public static function count_util(){
		global $bd;
		$q =  "SELECT count(*) FROM ".self::$nom_table;
		$q .= " WHERE type !='administrateur' "; 
		
		$result_array = $bd->requete($q);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
	public  function count_specialite($specialite,$wilaya){
		$w="";
		if($wilaya[0]=="tous"){$w.="wilaya like '%' ";}
		
		if($wilaya[0]!="tous"){$w.='wilaya = "'.htmlspecialchars(trim($wilaya[0])).'"';}	
	if(sizeof($wilaya)>1){
		for($i=1;$i<sizeof($wilaya);$i++){
			$w.=' or wilaya = "'.htmlspecialchars(trim($wilaya[$i])).'"';
		}
	}
		global $bd;
		$sq =  "SELECT * FROM ".self::$nom_table;
		$sq .= " WHERE specialite=".$specialite." and (".$w.") and archive=0"; 
		
		$result_array = $bd->requete($sq);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
	//*******************************************
		public  function count_specialite_dsp($specialite,$wilaya,$commune){
		$com="";
		if($commune[0]=="tous"){$com.="commune_installation like '%' and wilaya=".$wilaya." ";}
		
		if($commune[0]!="tous"){$com.='commune_installation = "'.$commune[0].'"';}	
	if(sizeof($commune)>1){
		for($i=1;$i<sizeof($commune);$i++){
			
			$com.=' or commune_installation = "'.$commune[$i].'"';
		}
	}
		global $bd;
		$sq =  "SELECT * FROM ".self::$nom_table;
		$sq .= " WHERE specialite=".$specialite." and (".$com.") and archive=0"; 
		
		$result_array = $bd->requete($sq);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
	
	//***********************
		//*******************************************count_specialite_dsp_homme
		public  function count_specialite_dsp_h($specialite,$wilaya,$commune){
		$com="";
		if($commune[0]=="tous"){$com.="commune_installation like '%' and wilaya=".$wilaya." ";}
		
		if($commune[0]!="tous"){$com.='commune_installation = "'.$commune[0].'"';}	
	if(sizeof($commune)>1){
		for($i=1;$i<sizeof($commune);$i++){
			
			$com.=' or commune_installation = "'.$commune[$i].'"';
		}
	}
		global $bd;
		$sq =  "SELECT * FROM ".self::$nom_table;
		$sq .= " WHERE specialite=".$specialite." and (".$com.") and sexe_employe='homme' and archive=0"; 
		
		$result_array = $bd->requete($sq);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
	
	//*************************count_specialite_dsp_femme
	public  function count_specialite_dsp_f($specialite,$wilaya,$commune){
		$com="";
		if($commune[0]=="tous"){$com.="commune_installation like '%' and wilaya=".$wilaya." ";}
		
		if($commune[0]!="tous"){$com.='commune_installation = "'.$commune[0].'"';}	
	if(sizeof($commune)>1){
		for($i=1;$i<sizeof($commune);$i++){
			
			$com.=' or commune_installation = "'.$commune[$i].'"';
		}
	}
		global $bd;
		$sq =  "SELECT * FROM ".self::$nom_table;
		$sq .= " WHERE specialite=".$specialite." and (".$com.") and sexe_employe='femme' and archive=0"; 
		
		$result_array = $bd->requete($sq);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
	
	//***********************count_specialite_dsp_interval_age
		//*************************
	public  function count_specialite_dsp_interval_age($specialite,$wilaya,$commune,$recherche){
		$r="";
			if($recherche=="s"){$r=" and (type_employe=-1 or type_employe=0)";}
		$com="";
		if($commune[0]=="tous"){$com.="commune_installation like '%'  ";}
		
		if($commune[0]!="tous"){$com.='commune_installation = "'.$commune[0].'"';}	
	if(sizeof($commune)>1){
		for($i=1;$i<sizeof($commune);$i++){
			
			$com.=' or commune_installation = "'.$commune[$i].'"';
		}
	}
		global $bd;
		$date_moins_25= date("Y")-24;
		
		$sq =  "SELECT * FROM ".self::$nom_table;
		$sq .= " WHERE specialite=".$specialite." and (".$com.")  and date_nais_employe>'".$date_moins_25."-01-01' ".$r." and archive=0"; 
		$result_array_25 = $bd->requete($sq);
		
		$date_entre_25= date("Y")-25;
		$date_entre_34= date("Y")-34;
		$sq1 =  "SELECT * FROM ".self::$nom_table;
		$sq1 .= " WHERE specialite=".$specialite." and (".$com.") and ( date_nais_employe<='".$date_entre_25."-12-31' and date_nais_employe>='".$date_entre_34."-01-01') ".$r." and archive=0"; 
		$result_array_25_34 = $bd->requete($sq1);
		
		$date_entre_35= date("Y")-35;
		$date_entre_44= date("Y")-44;
		$sq2 =  "SELECT * FROM ".self::$nom_table;
		$sq2 .= " WHERE specialite=".$specialite." and (".$com.")  and ( date_nais_employe<='".$date_entre_35."-12-31' and date_nais_employe>='".$date_entre_44."-01-01') ".$r." and archive=0"; 
		$result_array_35_44 = $bd->requete($sq2);
		
		$date_entre_45= date("Y")-45;
		$date_entre_54= date("Y")-54;
		$sq3 =  "SELECT * FROM ".self::$nom_table;
		$sq3 .= " WHERE specialite=".$specialite." and (".$com.")  and ( date_nais_employe<='".$date_entre_45."-12-31' and date_nais_employe>='".$date_entre_54."-01-01') ".$r." and archive=0"; 
		$result_array_45_54 = $bd->requete($sq3);
		
		$date_entre_55= date("Y")-55;
		$date_entre_64= date("Y")-64;
		$sq4 =  "SELECT * FROM ".self::$nom_table;
		$sq4 .= " WHERE specialite=".$specialite." and (".$com.")  and ( date_nais_employe<='".$date_entre_55."-12-31' and date_nais_employe>='".$date_entre_64."-01-01') ".$r." and archive=0"; 
		$result_array_55_60 = $bd->requete($sq4);
		
		$date_plus_65= date("Y")-65;
		
		$sq5 =  "SELECT * FROM ".self::$nom_table;
		$sq5 .= " WHERE specialite=".$specialite." and (".$com.")  and  date_nais_employe<='".$date_plus_65."-12-31' ".$r." and archive=0"; 
		$result_plus_65 = $bd->requete($sq5);
		
		$sq6 =  "SELECT * FROM ".self::$nom_table;
		$sq6 .= " WHERE specialite=".$specialite." and (".$com.") and sexe_employe='homme' ".$r." and archive=0"; 
		
		$result_array_h = $bd->requete($sq6);
		
		$sq7 =  "SELECT * FROM ".self::$nom_table;
		$sq7 .= " WHERE specialite=".$specialite." and (".$com.") and sexe_employe='femme' ".$r." and archive=0"; 
		
		$result_array_f = $bd->requete($sq7);
		
			$sq8 =  "SELECT * FROM ".self::$nom_table;
		$sq8 .= " WHERE specialite=".$specialite." and (".$com.") ".$r." and archive=0"; 
		
			$result_array_tous = $bd->requete($sq8);
		
			$liste[]= array();
			$liste[0] =  $bd->num_rows($result_array_25);
			$liste[1] = $bd->num_rows($result_array_25_34);
		    $liste[2] = $bd->num_rows($result_array_35_44);
			$liste[3] = $bd->num_rows($result_array_45_54);
			$liste[4] = $bd->num_rows($result_array_55_60);
			$liste[5] = $bd->num_rows($result_plus_65);
			$liste[6] = $bd->num_rows($result_array_h);
			$liste[7] = $bd->num_rows($result_array_f);
			$liste[8] = $bd->num_rows($result_array_tous);
		
		
		
		return $liste;
		//return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
	//#####################################"
	//#######################################
	
	//***********************
		//*******************************************count_specialite_administrateur_homme
		public  function count_specialite_h($specialite,$wilaya){
			$w="";
		if($wilaya[0]=="tous"){$w.="wilaya like '%' ";}
		
		if($wilaya[0]!="tous"){$w.='wilaya = "'.htmlspecialchars(trim($wilaya[0])).'"';}	
	if(sizeof($wilaya)>1){
		for($i=1;$i<sizeof($wilaya);$i++){
			$w.=' or wilaya = "'.htmlspecialchars(trim($wilaya[$i])).'"';
		}
	}
		global $bd;
		$sq =  "SELECT * FROM ".self::$nom_table;
		$sq .= " WHERE specialite=".$specialite." and (".$w.") and sexe_employe='homme' and archive=0"; 
		
		$result_array = $bd->requete($sq);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
	
	//*************************count_specialite_administrateur_femme
	public  function count_specialite_f($specialite,$wilaya){
				$w="";
		if($wilaya[0]=="tous"){$w.="wilaya like '%' ";}
		
		if($wilaya[0]!="tous"){$w.='wilaya = "'.htmlspecialchars(trim($wilaya[0])).'"';}	
	if(sizeof($wilaya)>1){
		for($i=1;$i<sizeof($wilaya);$i++){
			$w.=' or wilaya = "'.htmlspecialchars(trim($wilaya[$i])).'"';
		}
	}
		global $bd;
		$sq =  "SELECT * FROM ".self::$nom_table;
		$sq .= " WHERE specialite=".$specialite." and (".$w.") and sexe_employe='femme' and archive=0"; 
		
		$result_array = $bd->requete($sq);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
	
	//***********************count_specialite_administrateur_interval_age
		//*************************
	public  function count_specialite_interval_age($specialite,$wilaya,$recherche){
		$r="";
		if($recherche=="s"){ $r="and (type_employe=-1 or type_employe=0)" ;}
		$w="";
		if($wilaya[0]=="tous"){$w.="wilaya like '%' ";}
		
		if($wilaya[0]!="tous"){$w.='wilaya = "'.htmlspecialchars(trim($wilaya[0])).'"';}	
	if(sizeof($wilaya)>1){
		for($i=1;$i<sizeof($wilaya);$i++){
			$w.=' or wilaya = "'.htmlspecialchars(trim($wilaya[$i])).'"';
		}
	}
		global $bd;
		$date_moins_25= date("Y")-24;
		
		$sq =  "SELECT * FROM ".self::$nom_table;
		$sq .= " WHERE specialite=".$specialite." and (".$w.")  and date_nais_employe>'".$date_moins_25."-01-01' ".$r." and archive=0"; 
		$result_array_25 = $bd->requete($sq);
		
		$date_entre_25= date("Y")-25;
		$date_entre_34= date("Y")-34;
		$sq1 =  "SELECT * FROM ".self::$nom_table;
		$sq1 .= " WHERE specialite=".$specialite." and (".$w.") and ( date_nais_employe<='".$date_entre_25."-12-31' and date_nais_employe>='".$date_entre_34."-01-01' ) ".$r." and archive=0"; 
		$result_array_25_34 = $bd->requete($sq1);
		
		$date_entre_35= date("Y")-35;
		$date_entre_44= date("Y")-44;
		$sq2 =  "SELECT * FROM ".self::$nom_table;
		$sq2 .= " WHERE specialite=".$specialite." and (".$w.")  and ( date_nais_employe<='".$date_entre_35."-12-31' and date_nais_employe>='".$date_entre_44."-01-01' ) ".$r." and archive=0"; 
		$result_array_35_44 = $bd->requete($sq2);
		
		$date_entre_45= date("Y")-45;
		$date_entre_54= date("Y")-54;
		$sq3 =  "SELECT * FROM ".self::$nom_table;
		$sq3 .= " WHERE specialite=".$specialite." and (".$w.")  and ( date_nais_employe<='".$date_entre_45."-12-31' and date_nais_employe>='".$date_entre_54."-01-01') ".$r." and archive=0"; 
		$result_array_45_54 = $bd->requete($sq3);
		
		$date_entre_55= date("Y")-55;
		$date_entre_64= date("Y")-64;
		$sq4 =  "SELECT * FROM ".self::$nom_table;
		$sq4 .= " WHERE specialite=".$specialite." and (".$w.")  and ( date_nais_employe<='".$date_entre_55."-12-31' and date_nais_employe>='".$date_entre_64."-01-01') ".$r." and archive=0"; 
		$result_array_55_60 = $bd->requete($sq4);
		
		$date_plus_65= date("Y")-65;
		
		$sq5 =  "SELECT * FROM ".self::$nom_table;
		$sq5 .= " WHERE specialite=".$specialite." and (".$w.")  and  date_nais_employe<='".$date_plus_65."-12-31' ".$r." and archive=0"; 
		$result_plus_65 = $bd->requete($sq5);
		
		$sq6 =  "SELECT * FROM ".self::$nom_table;
		$sq6 .= " WHERE specialite=".$specialite." and (".$w.") and sexe_employe='homme' ".$r." and archive=0"; 
		
		$result_array_h = $bd->requete($sq6);
		
		$sq7 =  "SELECT * FROM ".self::$nom_table;
		$sq7 .= " WHERE specialite=".$specialite." and (".$w.") and sexe_employe='femme' ".$r." and archive=0"; 
		
		$result_array_f = $bd->requete($sq7);
		
			$sq8 =  "SELECT * FROM ".self::$nom_table;
		$sq8 .= " WHERE specialite=".$specialite." and (".$w.") ".$r." and archive=0"; 
		
			$result_array_tous = $bd->requete($sq8);
		
		$liste[]= array();
		 $liste[0] =  $bd->num_rows($result_array_25);
		  $liste[1] = $bd->num_rows($result_array_25_34);
		    $liste[2] = $bd->num_rows($result_array_35_44);
			$liste[3] = $bd->num_rows($result_array_45_54);
			$liste[4] = $bd->num_rows($result_array_55_60);
			$liste[5] = $bd->num_rows($result_plus_65);
			$liste[6] = $bd->num_rows($result_array_h);
			$liste[7] = $bd->num_rows($result_array_f);
			$liste[8] = $bd->num_rows($result_array_tous);
		
		
		
		return $liste;
	
	}
	//*********************
	//**********************
	
	
	//*********************
	//**********************
	
	
	
	
	
	public static function valider($login="", $mot_passe="") {
    global $bd;

    $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE login = '{$login}' ";
    $sql .= "AND mot_passe = '".SHA1($mot_passe)."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public function date_der(){
	global $bd;
     $sql  = "UPDATE ".self::$nom_table." SET ";
     $sql .= "date_der  = '".mysql_datetime()."' ";
	 $sql .= " WHERE id =".$this->id." ";
	 $sql .= "LIMIT 1 ";
	
	 $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public  function  existe(){
	 global $bd;
	 $sql  = 'SELECT * FROM '.self::$nom_table.' ';
    $sql .= 'WHERE nom_employe = "'.$this->nom_employe.'" ';
	 $sql .= 'and prenom_employe = "'.$this->prenom_employe.'" ';
	  $sql .= 'and date_nais_employe = "'.$this->date_nais_employe.'" ';
	 $sql .= 'and commune_nais = "'.$this->commune_nais.'" ';
	   
		
			
	
    $sql .= " LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	public  function  existe_classee(){
	 global $bd;
	 $sql  = 'SELECT * FROM '.self::$nom_table.' ';
    $sql .= 'WHERE nom_employe = "'.$this->nom_employe.'" ';
	 $sql .= 'and prenom_employe = "'.$this->prenom_employe.'" ';
	  $sql .= 'and date_nais_employe = "'.$this->date_nais_employe.'" ';
	 $sql .= 'and commune_nais = "'.$this->commune_nais.'" ';
	  $sql .= 'and archive =1 ';  
		
			
	
    $sql .= " LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public  function  login_email_existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE login = '".$this->login."' ";
	$sql .= "AND email = '".$this->email."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public  function  login_existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE login = '".$this->login."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
     
   
	
	public  function  mot_passe_existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE mot_passe = '".$this->mot_passe."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public  function  email_existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE email = '".$this->email."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	

	public static function count(){
	
	$users = self::not_admin();
	return count($users);
	}
	
	public static function not_sup_admin(){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type !='super_administrateur'";
    return  self::trouve_par_sql($q);
	}
	public static function ens(){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type ='Enseignant'";
    return  self::trouve_par_sql($q);
	}
	public static function eleve(){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type ='eleve'";
    return  self::trouve_par_sql($q);
	}
	
	
	public static function select_par_ordre1($order,$crois,$start,$display){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type !='administrateur'";
	$q .= " ORDER BY {$order} {$crois} ";
	$q .= " LIMIT {$start}, {$display} "; 
	return  self::trouve_par_sql($q);
	}
	
	public static function not_admin(){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type !='administrateur'";
    return  self::trouve_par_sql($q);
	}
	
	public static function trouve_par_type($type){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type_employe ='{$type}'";
    return  self::trouve_par_sql($q);
	}
	
	
	public static function select_par_ordre($order,$crois,$start,$display){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type !='administrateur'";
	$q .= " AND type !='super_administrateur'";
	$q .= " ORDER BY {$order} {$crois} ";
	$q .= " LIMIT {$start}, {$display} "; 
	return  self::trouve_par_sql($q);
	}
	
	public static function select_par_ordre_type($order,$crois,$start,$display,$type){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type ='{$type}'";
	$q .= " ORDER BY {$order} {$crois} ";
	$q .= " LIMIT {$start}, {$display} "; 
	return  self::trouve_par_sql($q);
	}
	
	public static function select_par_ordre_ens($order,$crois,$start,$display){
	$q =  "SELECT personne.* FROM personne,enseignant";
	$q .= " WHERE personne.id =enseignant.id_personne";
	$q .= " ORDER BY {$order} {$crois} ";
	$q .= " LIMIT {$start}, {$display} "; 
	return  self::trouve_par_sql($q);
	}
	
	
	// les fonction commun entre les classe
		public static function trouve_tous_filtre_voire($ancien_val) {
		
		
			//echo "<script>alert('".$diplome."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where  id_employe>'.$ancien_val.' and archive=0');
		
	}
		public static function trouve_recherche($valeur) {
		//echo "<script>alert('".$diplome."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where  (nom_employe like "%'.$valeur.'%" or  prenom_employe like "%'.$valeur.'%" or identite_jurdique like "%'.$valeur.'%") and archive=0');
	}
		public static function trouve_recherche_dsp($wilaya,$valeur) {
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where  (nom_employe like "%'.$valeur.'%" or  prenom_employe like "%'.$valeur.'%") and wilaya='.$wilaya.' and archive=0');
	}
	
	public static function trouve_tous_filtre($taill,$diplome,$specialite,$wilaya,$groupe,$etab) {
		$d='';
		$s='';
		$w='';
		$e='';
		
		
		
	
	if($diplome[0]=="tous"){$d.="diplome like '%' ";}
	
	if($etab[0]=="tous"){$e.="type_etablissement like '%' ";}
		if($specialite[0]=="tous"){
			if($groupe[0]!='tous'){
				//echo "<script>alert(".$groupe[0].")</script>";
				$specialite0=Specialite::trouve_par_groupe($groupe[0]);	
			
				$s.=' specialite= '.htmlspecialchars(trim($specialite0[0]->id_specialite));
				
				for($i=1;$i<sizeof($specialite0);$i++){
	$s.=' or specialite= '.htmlspecialchars(trim($specialite0[$i]->id_specialite));
				}
		for($i=1;$i<sizeof($groupe);$i++){
	$specialite1=Specialite::trouve_par_groupe($groupe[$i]);	
	foreach($specialite1 as $specialite1){
	$s.=' or specialite='.htmlspecialchars(trim($specialite1->id_specialite));
	}
		}
	}
	else{
			$s.="specialite like '%' ";
	}
			
			}
		if($wilaya[0]=="tous"){$w.="wilaya like '%' ";}
		
		
			if($diplome[0]!="tous"){$d.='diplome = "'.htmlspecialchars(trim($diplome[0])).'"';}	
	if(sizeof($diplome)>1){
		for($i=1;$i<sizeof($diplome);$i++){
			$d.=' or diplome = "'.htmlspecialchars(trim($diplome[$i])).'"';
		}
	}
	
		if($etab[0]!="tous"){$e.='type_etablissement = "'.htmlspecialchars(trim($etab[0])).'"';}	
	if(sizeof($etab)>1){
		for($i=1;$i<sizeof($etab);$i++){
			$e.=' or type_etablissement = "'.htmlspecialchars(trim($etab[$i])).'"';
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
		
		if($taill=="100"){
			//echo "<script>alert('".htmlspecialchars_decode(trim(stripslashes($diplome)))."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where ('.$d.') and ('.$e.') and specialite '.$egal2.' "'.htmlspecialchars(trim($specialite)).'" and wilaya '.$egal3.' "'.htmlspecialchars(trim($wilaya)).'"  and  archive=0 limit 100 ');
		
		}
		else{
			//echo "<script>alert('".$diplome."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where ('.$d.') and ('.$e.') and ('.$s.') and ('.$w.') and archive=0');
		}
	}
		public static function trouve_tous_filtre_dsp($taill,$diplome,$specialite,$wilaya,$groupe,$etab) {
		$d='';
		$s='';
		$w='';
		$e='';
		
		
	
	if($diplome[0]=="tous"){$d.="diplome like '%' ";}
	if($etab[0]=="tous"){$e.="type_etablissement like '%' ";}
			if($specialite[0]=="tous"){
			if($groupe[0]!='tous'){
				//echo "<script>alert(".$groupe[0].")</script>";
				$specialite0=Specialite::trouve_par_groupe($groupe[0]);	
			
				$s.=' specialite= '.htmlspecialchars(trim($specialite0[0]->id_specialite));
				
				for($i=1;$i<sizeof($specialite0);$i++){
	$s.=' or specialite= '.htmlspecialchars(trim($specialite0[$i]->id_specialite));
				}
		for($i=1;$i<sizeof($groupe);$i++){
	$specialite1=Specialite::trouve_par_groupe($groupe[$i]);	
	foreach($specialite1 as $specialite1){
	$s.=' or specialite='.htmlspecialchars(trim($specialite1->id_specialite));
	}
		}
	}
	else{
			$s.="specialite like '%' ";
	}
			
			}
		
		
		
			if($diplome[0]!="tous"){$d.='diplome = "'.htmlspecialchars(trim($diplome[0])).'"';}	
	if(sizeof($diplome)>1){
		for($i=1;$i<sizeof($diplome);$i++){
			$d.=' or diplome = "'.htmlspecialchars(trim($diplome[$i])).'"';
		}
	}
	
		if($etab[0]!="tous"){$e.='type_etablissement = "'.htmlspecialchars(trim($etab[0])).'"';}	
	if(sizeof($etab)>1){
		for($i=1;$i<sizeof($etab);$i++){
			$e.=' or type_etablissement = "'.htmlspecialchars(trim($etab[$i])).'"';
		}
	}
	
		if($specialite[0]!="tous"){$s.='specialite = "'.htmlspecialchars(trim($specialite[0])).'"';}	
	if(sizeof($specialite)>1){
		for($i=1;$i<sizeof($specialite);$i++){
			$s.=' or specialite = "'.htmlspecialchars(trim($specialite[$i])).'"';
		}
	}
	
	
		
		if($taill=="100"){
			//echo "<script>alert('".htmlspecialchars_decode(trim(stripslashes($diplome)))."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where ('.$d.')  and ('.$e.') and specialite '.$egal2.' "'.htmlspecialchars(trim($specialite)).'" and wilaya ='.$wilaya.'" and archive=0 limit 100 ');
		
		}
		else{
			//echo "<script>alert('".$diplome."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where ('.$d.') and ('.$e.')  and ('.$s.') and wilaya='.$wilaya.' and archive=0');
		}
	}
	
	
	//*****************    archive   **********
	
	
	public static function trouve_tous_filtre_archive($taill,$diplome,$specialite,$wilaya) {
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
		
		if($taill=="100"){
			//echo "<script>alert('".htmlspecialchars_decode(trim(stripslashes($diplome)))."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where '.$d.' and specialite '.$egal2.' "'.htmlspecialchars(trim($specialite)).'" and wilaya '.$egal3.' "'.htmlspecialchars(trim($wilaya)).'" and archive=1 limit 100 ');
		
		}
		else{
			//echo "<script>alert('".$diplome."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where ('.$d.') and ('.$s.') and ('.$w.')  and archive=1');
		}
  }
	
	//archive01
	
		public static function trouve_tous_filtre_archive1($taill,$diplome,$specialite,$wilaya) {
		$d='';
		$s='';
		
		
		
		
	
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
	

		
		if($taill=="100"){
			//echo "<script>alert('".htmlspecialchars_decode(trim(stripslashes($diplome)))."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where '.$d.' and specialite '.$egal2.' "'.htmlspecialchars(trim($specialite)).'" and wilaya '.$egal3.' "'.htmlspecialchars(trim($wilaya)).'" and archive=1 limit 100 ');
		
		}
		else{
			//echo "<script>alert('".$diplome."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where ('.$d.') and ('.$s.') and wilaya='.$wilaya.'  and archive=1');
		}
  }
	
	
	
	//*****************      fin de relation           **********
	
	// les fonction commun entre les classe
	public static function trouve_tous_filtre_fin_relation($taill,$diplome,$specialite,$wilaya) {
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
		
		if($taill=="100"){
			//echo "<script>alert('".htmlspecialchars_decode(trim(stripslashes($diplome)))."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where '.$d.' and specialite '.$egal2.' "'.htmlspecialchars(trim($specialite)).'" and wilaya '.$egal3.' "'.htmlspecialchars(trim($wilaya)).'" and archive=2 limit 100 ');
		
		}
		else{
			//echo "<script>alert('".$diplome."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where ('.$d.') and ('.$s.') and ('.$w.') and archive=2');
		}
  }
	//FIN DE RELATION01
	
		public static function trouve_tous_filtre_fin_relation1($taill,$diplome,$specialite,$wilaya) {
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
	

		
		if($taill=="100"){
			//echo "<script>alert('".htmlspecialchars_decode(trim(stripslashes($diplome)))."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where '.$d.' and specialite '.$egal2.' "'.htmlspecialchars(trim($specialite)).'" and wilaya '.$egal3.' "'.htmlspecialchars(trim($wilaya)).'" and archive=2 limit 100 ');
		
		}
		else{
			//echo "<script>alert('".$diplome."');</script>";
			return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where ('.$d.') and ('.$s.') and wilaya='.$wilaya.' and archive=2');
		}
  }
	
	//****************************
	
	
  	public static function trouve_tous() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." and archive=0");
  }
  public static function trouve_tous_pere($wilaya) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where type_employe=-1 and wilaya=".$wilaya." and archive=0");
  }
   public static function trouve_tous_pere2() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where type_employe=-1 and archive=0");
  }
  
  public static function trouve_employe_type($id) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where type_employe ={$id} and archive=0 order by id_employe");
  }
  
   public static function trouve_employe_type2($id,$diplome,$specialite) {
	   $egal1="=";$egal2="=";
	if($diplome=="tous"){$diplome="%";$egal1="like ";}
		if($specialite=="tous"){$specialite="%";$egal2="like ";}
	   
		return self::trouve_par_sql('SELECT * FROM '.self::$nom_table.' where type_employe ='.$id.' and diplome '.$egal1.' "'.htmlspecialchars(trim($diplome)).'" and specialite '.$egal2.' "'.htmlspecialchars(trim($specialite)).'" and archive=0  order by id_employe');
  }
  
  public static function trouve_par_id($id) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_employe ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function trouve_last() {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." order by id_employe DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  
    public static function trouve_par_existe($nom,$prenom,$date_nais,$commune_nais) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE nom_employe ='{$nom}' and prenom_employe ='{$prenom}' and date_nais_employe='{$date_nais}' and commune_nais={$commune_nais} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  
  
  
  
    public static function trouve_par_specialite($specialite,$wilaya) {
		$w="";
		if($wilaya[0]=="tous"){$w.="wilaya like '%' ";}
		
		if($wilaya[0]!="tous"){$w.='wilaya = "'.htmlspecialchars(trim($wilaya[0])).'"';}	
	if(sizeof($wilaya)>1){
		for($i=1;$i<sizeof($wilaya);$i++){
			$w.=' or wilaya = "'.htmlspecialchars(trim($wilaya[$i])).'"';
		}
	}
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE specialite =".$specialite." and (".$w.") LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  
  
    public static function trouve_par_specialite_dsp($specialite,$wilaya,$commune) {
	
	
		$com="";
		if($commune[0]=="tous"){$com.="commune_installation like '%' and wilaya=".$wilaya."";}
		
		if($commune[0]!="tous"){$com.='commune_installation = "'.$commune[0].'"';}	
	if(sizeof($commune)>1){
		for($i=1;$i<sizeof($commune);$i++){
			$com.=' or commune_installation = "'.$commune[$i].'"';
		}
	}
	
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE specialite =".$specialite."  and (".$com.") LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  
  
  
  public static function trouve_par_wilaya($wilaya) {
    return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE wilaya ='{$wilaya}'");
		//return !empty($result_array) ? array_shift($result_array) : false;
  }
    public static function trouve_par_wilaya_filtre($wilaya,$ordre,$taill) {
		if($taill=="tous"){
		 return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE wilaya ='{$wilaya}'  ORDER BY id_employe ".$ordre."");	
		}else{
		
    return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE wilaya ='{$wilaya}'  ORDER BY id_employe ".$ordre." LIMIT ".$taill."");
		}
		//return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  
  // pour que ne tompa dans des erreurs foux qu'on selection tous "SELECT * FROM" 
  public static function trouve_par_sql($sql='') {
    global $bd;
    $result_set = $bd->requete($sql);
    $object_array = array();
    while ($row = $bd->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
	/* // on peu utiliser la fonction predefinit mysqli_fetch_object
	   // mais dans le cas où il y a de jointure dans la requete.... 
	while ($object = $bd->fetch_object($result_set)){
	  $object_array[] = $object;
	}
	*/
    return $object_array;
  }

	private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->login 	= $record['login'];
		// $object->mot_passe 	= $record['mot_passe'];
		// $object->nom = $record['nom'];
		// $object->prenom 	= $record['prenom'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // get_object_vars returns an associative array with all attributes 
	  // (incl. private ones!) as the keys and their current values as the value
	  $object_vars = $this ->attributes();
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $object_vars);
	}

	public function save(){
	 // A new record won't have an id yet.
	 return isset($this->id_employe)? $this->modifier() : $this->ajouter();
	}
	
	protected function attributes(){
	// return an array of attribute keys and their values
	 $attributes = array();
	 foreach(self::$champs as $field){
	     if(property_exists($this, $field)){
		     $attributes[$field] = $this->$field; 
		 }
	 }
	 return $attributes;
	}
	
	protected function sanitized_attributes(){
	 global $bd;
	 $clean_attributes = array();
	 // sanitize the values before submitting
	 // note : does not alter the actual value of each attribute
	 foreach($this->attributes() as $key => $value){
	   $clean_attributes[$key] = $bd->escape_value($value);
	 }
	  return $clean_attributes;
	}
	
	public function ajouter(){
	 global $bd;
	 $attributes = $this->sanitized_attributes();
	 $sql = "INSERT INTO ".self::$nom_table."(";
	 $sql .= join(", ", array_keys($attributes));
	 $sql .= ") VALUES (' ";
	 $sql .= join("', '", array_values($attributes));
	 $sql .= "')";
	 if($bd->requete($sql)){
	     $this->id = $bd->insert_id();
		 return true;
	 }else{
	     return false;
	 }
	}
	
    public function modifier(){
global $bd;
$attributes = $this->sanitized_attributes();
$attribute_pairs = array();
foreach($attributes as $key => $value){
 $attribute_pairs[] = "{$key}='{$value}'";
}
$sql = "update ".self::$nom_table." SET ";
$sql .= join(", ", $attribute_pairs);
$sql .= " WHERE id_employe =". $bd->escape_value($this->id_employe) ;
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
}
	
	
public function supprime(){
global $bd;
$sql = "DELETE FROM ".self::$nom_table;
$sql .= " WHERE id_employe =". $bd->escape_value($this->id_employe) ;
$sql .=" LIMIT 1";
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
	}

	}


?>