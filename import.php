<?php
require_once("includes/initialiser.php");
ini_set('max_execution_time', 0); 
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 
?>
<?php
$titre = "importer excel";
$active_menu = "index";
$header = array('file','ckeditor');
if ($user->type =='administrateur'){
	require_once("composit/header.php");
}
?>
<form class="form-horizontal" name="form1"  id="form1" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
<br />&nbsp;&nbsp;<br />
<div class="row">
   <div class="col-md-6 col-xs-0">  
<input type="file" name="excelFile" class="form-control" /><span style="color:#00C">Fichier CSV(separateur;point-virgule)(*.csv)</span> </div><div class="col-md-6 col-xs-0">   <input class="btn btn-info" type="submit" name="importa"  value="Importer les données"/>
   </div>
</div>
</form>
<?php
if(isset($_POST['importa'])){
if(!empty($_FILES["excelFile"]["tmp_name"])){
$filename=explode(".",$_FILES["excelFile"]["name"]);
if($filename[1]=="csv"){
	echo "Traitement !...";
	//$sql=mysqli_connect("localhost","root","");
	//$db=mysqli_select_db($sql,"sirhcp");

	$file=$_FILES["excelFile"]["tmp_name"];
	$openfile=fopen($file,"r");
	$pere="";
	 $type="";
	while($dataFile=fgetcsv($openfile,30000)){
		 
		list($id,$nom,$prenom,$epoux,$date_naissance,$sexe,$commune_nais,$fonction,$diplome,$specialite,$wilaya,$commune_instal,$adrs,$type_etab,$identite,$activite,$type_employe,$num_agriment,$date_agriment)=explode(";",$dataFile[0]);
	//	echo $nom." ".$prenom." ".$date_naissance." ".$commune_nais." ".$diplome." ".$commune_instal." ".$type_etab." ".$identite."<br>";
	try{
		
		$employer = new Employe();
      //  $employer->id_employe=$id;
		$employer->nom_employe=utf8_encode($nom);
		$employer->prenom_employe=utf8_encode($prenom);
$employer->epoux=utf8_encode(addslashes($epoux));
$date_nais="";
if($date_naissance==null){
	$date_nais="0000-00-00";
}else{
		$date_nais = date('Y-m-d', strtotime(str_replace('/', '-', $date_naissance)));	
}		
		$employer->date_nais_employe=$date_nais;
		$employer->commune_nais=utf8_encode(addslashes($commune_nais));
$employer->sexe_employe=utf8_encode(addslashes($sexe));
		$employer->diplome=utf8_encode(addslashes($diplome));
$employer->specialite=utf8_encode(addslashes($specialite));		
		$employer->wilaya=utf8_encode(str_replace("'","",$wilaya));
		
		$type=$type_employe;
		if(($type_employe==-1 or $type_employe==0) and $type_employe!=null){
			//echo "le pere est ".$pere. "<br>";
			$employer->commune_installation=$commune_instal;
$employer->adrs=utf8_encode(addslashes($adrs));
		$employer->type_etablissement=$type_etab;
		$employer->identite_jurdique=utf8_encode(addslashes($identite));
$employer->numero_agriment=utf8_encode(addslashes($num_agriment));

$date_agri="";
if($date_agriment==null){
	$date_agri="0000-00-00";
}else{
$date_agri = date('Y-m-d', strtotime(str_replace('/', '-', $date_agriment)));
}
$employer->date_agriment=utf8_encode(addslashes($date_agri));		
		$employer->type_employe=$type_employe;
		}
		
		else {
			$structure=Employe::trouve_par_id($pere);
			
			$employer->commune_installation=$structure->commune_installation;
			$employer->type_etablissement=$structure->type_etablissement;
			$employer->identite_jurdique=$structure->identite_jurdique;
			$employer->adrs=$structure->adrs;
			$employer->date_agriment=$structure->date_agriment;
			
			$employer->numero_agriment=$structure->numero_agriment;
			
		    $employer->type_employe=$pere;	
		// echo "le pere est ".$pere. "<br>";
		}
		
		if ($nom!="nom_employe" and $nom!=null and $prenom!=null ) {
			if ($employer->existe()) {
				if($employer->type_employe==-1){
					$date_nais="";
if($date_naissance==null){
	$date_nais="0000-00-00";
}else{
		$date_nais = date('Y-m-d', strtotime(str_replace('/', '-', $date_naissance)));	
}
					$empl_existe=Employe::trouve_par_existe($nom,$prenom,$date_nais);
					$pere=$empl_existe->id_employe;
				}
				echo "<p style='color:red'>".$nom." ".$prenom." ".$date_naissance.""." existe </p>";
			}else{
				//$employer->save();
				if($employer->save()){
					if($type=="-1"){
						$SQL = $bd->requete("SELECT max(id_employe) as ma FROM employer GROUP BY id_employe");
		
															while ($rows = $bd->fetch_array($SQL))
														{
														
		$pere=$rows["ma"];
		
													
														}
													//	echo "<br>ICI  ".$pere;
	
		
			
 		 
						
						
					}
					
					
				echo "<p style='color:green'>".$nom." ".$prenom." ".$date_naissance.""." importer avec succes </p>";
				}
				else{
				echo "<p style='color:red;font-size:24px'>  ".$id.""." ce code existe </p>";	
				}
			}
		}
		else{
			
		}
	}catch(MySQLException  $e){
		echo "<p style='color:red'>".$nom." ".$prenom." ".$date_naissance.""."   existe </p>";
	}
	//	$requet="insert into employer values(".$id.",'".$nom."','".$prenom."','".$date_naissance."','".$commune_nais."','".$diplome."','".$wilaya."','".$commune_instal."','".$type_etab."','".$identite."','',";
		//mysqli_query($sql,$requet) or die ('Erreur SQL !'.'<br />'.mysqli_error($sql));
	}
}
	else{
		echo "Erreur de fichier <p style='color:red'> s'il vous plait selectionez un fichier  de type CSV(separateur;point-virgule)(*.csv)</p>";
	}

}

}


	
//UPLOAD DU FICHIER CSV, vérification et insertion en BASE
/*if(isset($_FILES["file"]["type"]) != "application/vnd.ms-excel"){
    die("Ce n'est pas un fichier de type .csv");
}
elseif(is_uploaded_file($_FILES['file']['tmp_name'])) {
    //$row = 1;
    if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
        fgetcsv($handle);
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            for ($c=0; $c < $num; $c++) {
                $col[$c] = $data[$c];
            }

            $col1 = $col[0];
            $col2 = $col[1];
            $col3 = $col[2];
            $col4 = $col[3];
            $col5 = $col[4];
            $col6 = $col[5];
            $col7 = $col[6];
            $col8 = $col[7];
            $col9 = $col[8];
            $col10 = $col[9];
            $col11 = $col[10];

            $req = $pdo->prepare('INSERT INTO employer (id_employer, nom_employe, prenom_employe, date_nais_employe, commune_nais, diplome, wilaya, commune_installation,
type_etablissement, identite_jurdique, activite, type_employe) VALUES(?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

            $req->execute(array('',$col1, $col2, $col3,$col4, $col5, $col6, $col7,$col8, $col9, $col10, $col11));

        }
        fclose($handle);

    }
}*/
?>



       <!-- MESSAGE BOX-->
		<div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-row">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-trash-o"></span> Supprimer <strong> les données </strong> ??!!</div>
                    <div class="mb-content">
                        <p>Etes-vous sûr de vouloir supprimer cette ligne?? </p>                    
                        <p>Appuyez sur Oui si vous sûr</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button class="btn btn-success btn-lg mb-control-yes">Oui</button>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Déconnexion <strong></strong> ?</div>
                    <div class="mb-content">
                        <p>Êtes-vous sûr vous déconnecter?</p>                    
                        <p>Appuyez sur Non si vous souhaitez continuer à travailler. Appuyez sur Oui pour déconnecter l'utilisateur actuel</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="logout.php" class="btn btn-success btn-lg">Oui</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
         <!-- END MESSAGE BOX-->
  <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->                
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>                
        <!-- END PLUGINS -->
        
        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
              <script type="text/javascript" src="js/demo_tables.js"></script>          
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>   
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <!-- END THIS PAGE PLUGINS -->       
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        