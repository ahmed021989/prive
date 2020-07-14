<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp');
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

if ((isset($_GET['id_employe'])) && (is_numeric($_GET['id_employe'])) ) {

list($id,$date_fin)=explode("|",$_GET['id_employe']);
}




if(isset($_POST['submit'])){
	
	$errors = array();
	if (isset($_POST['type_etablissement']) and  !empty($_POST['type_etablissement'])){
	if ($_POST['type_etablissement'] == '-1'){
		$errors[] = '<p style= "font-size: 20px; "> Sélectionné un type d\'etablissement !!??</p>';
	}
	}
	if (isset($_POST['specialite']) and  !empty($_POST['specialite'])){
	if ($_POST['specialite'] == '-5'){
		$errors[] = '<p style= "font-size: 20px; "> Sélectionné une specialite !!??</p>';
	}
	}
	if (isset($_POST['diplome']) and  !empty($_POST['diplome'])){
	if ($_POST['diplome'] == '-4'){
		$errors[] = '<p style= "font-size: 20px; "> Sélectionné un diplome !!??</p>';
	}
	}
	if (isset($_POST['commune_installation']) and  !empty($_POST['commune_installation'])){
	if ($_POST['commune_installation'] == '-2'){
		$errors[] = '<p style= "font-size: 20px; "> Sélectionné une commune installation !!??</p>';
	}
	}
	if (isset($_POST['commune_nais']) and  !empty($_POST['commune_nais'])){
	if ($_POST['commune_nais'] == '-3'){
		$errors[] = '<p style= "font-size: 20px; "> Sélectionné une commune naissance !!??</p>';
	}
	}


$id_wilaya="";

	if($user->type=="administrateur"){
		list($id,$date_fin)=explode("|",$_GET['id_employe']);
		$empl=Employe::trouve_par_id($id);
		$id_wilaya=$empl->wilaya;
		//list($nom_comun,$code_post)=explode("/", $_POST['commune_installation']);
	
		//$SQL = $bd->requete(" SELECT * FROM `personne` where  ");
	}
	else{
		$wilay=Wilayas::trouve_par_Nom($user->wilaya);
		$id_wilaya=$wilay->id_w;
	}

	
	
				list($id,$date_fin)=explode("|",$_GET['id_employe']);
$employer_p=Employe::trouve_par_id($id);
	// new object document
$employer = new Employe();
		  
	
 	$employer->nom_employe =htmlspecialchars(trim($_POST['nom_employe']));
 	$employer->prenom_employe = htmlspecialchars(trim($_POST['prenom_employe']));
 	$employer->date_nais_employe = htmlspecialchars(trim($_POST['date_nais_employe']));

$employer->diplome = (htmlspecialchars(trim(addslashes($_POST['diplome']))));		 

	$employer->commune_nais = (htmlspecialchars(trim(addslashes($_POST['commune_nais']))));
		$employer->sexe_employe = (htmlspecialchars(trim($_POST['sexe'])));
		$employer->epoux = (htmlspecialchars(trim(addslashes($_POST['epoux']))));	
		 	$employer->date_instal = htmlspecialchars(trim($_POST['date_instal']));

$employer->specialite = (htmlspecialchars(trim($_POST['specialite'])));
$employer->fonction = $_POST['fonction'];

	$employer->wilaya =$id_wilaya;
	$employer->commune_installation = $employer_p->commune_installation;
	$employer->adrs =$employer_p->adrs;


	$employer->type_etablissement = $employer_p->type_etablissement;
	$employer->identite_jurdique = $employer_p->identite_jurdique;
    $employer->type_employe = htmlspecialchars('-1'); 
	$employer->numero_agriment = $employer_p->numero_agriment;
	$employer->date_agriment = $employer_p->date_agriment;

	$employer->date_creation = $employer_p->date_creation;
	
	if (empty($errors)){
   		if ($employer->existe()) {
			$msg_error = '<p style= "font-size: 20px; ">   Employer  " '  . (htmlspecialchars_decode($employer->nom_employe)) . ' " existe Déja !!!</p><br />';
			
		}else{
			$employer->save();
			$emp=Employe::trouve_last();
		
			$sql=$bd->requete("update employer set type_employe=".$emp->id_employe." where type_employe=".$id."");
			
			
			$fin_relation = new  Fin_relation();
	
	$fin_relation-> date_fine= htmlspecialchars(trim(addslashes($date_fin)));

	$fin_relation-> id_emp = $employer_p->id_employe;
	$fin_relation-> commune_installation = $employer_p->commune_installation;
	$fin_relation-> adrs = $employer_p->adrs;
	$fin_relation-> type_etablissement = $employer_p->type_etablissement;
	$fin_relation-> identite_jurdique = $employer_p->identite_jurdique;
	$fin_relation-> numero_agriment = $employer_p->numero_agriment;
	$fin_relation-> date_agriment = $employer_p->date_agriment;
	$fin_relation-> date_instal = $employer_p->date_instal;
	$fin_relation-> date_creation = $employer_p->date_creation;
	$fin_relation-> diplome = $employer_p->diplome;
	$fin_relation-> specialite = $employer_p->specialite;
	$fin_relation->save();
				$sql=$bd->requete("update employer set archive=2 where id_employe=".$id."");
			
 		  $msg_positif = '<p style= "font-size: 20px; ">   Employer  "  ' .(htmlspecialchars_decode($employer->nom_employe)) . '  " est bien ajouter  </p><br />';
		
		   $SQL = $bd->requete("SELECT max(id_employe) as ma FROM employer GROUP BY id_employe");
		 $i=0;
															while ($rows = $bd->fetch_array($SQL))
														{
														
		$i=$rows["ma"];
													
														}
		
		}
 		 
 		}else{
		// errors occurred
		$msg_error = '<h1> !! erreur  </h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
	
	
	
}



?>
<?php
$titre = "Ajouter nouveau gerant";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
}
?>
       
         
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
					  <li><a href="index.php">Accueil</a></li>  
					  <li class="active"><?php echo $titre ?></li>  
                </ul>
                <!-- END BREADCRUMB -->                
                
                 
                <!-- PAGE CONTENT WRAPPER -->
                
                 
                  
					
                        <div class="col-md-12">
                            
                           <form class="form-horizontal" role="form"  name="ajouter_employer"   id = "ajouter_employer"  action="<?php echo $_SERVER['PHP_SELF']."?id_employe=".$_GET['id_employe'];?>" method="post">
                            <div class="panel panel-default">
                            <div class="panel-body">
                              <?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
                                        
   
									<!--******************************-->
										<div class="row" style='border:1px solid blue'>
										<br>
	                                 <div class="row">
									<div class="col-md-6 ">		

						  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-6 control-label" style="color:blue">NOM </label>	    
                                        <div class="col-md-6 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="nom_employe" id="nom_employe" class="form-control" placeholder="EN MAJUSCULE" required  />
                                            </div>                                            
                                        </div>
										
                                    </div>
									</div>   <!-- fin col 6-->
                                  	<div class="col-md-6 ">	
                                    <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-5 control-label" style="color:blue">PRENOM</label>	    
                                        <div class="col-md-7 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="prenom_employe" id="prenom_employe" class="form-control" placeholder="EN MAJUSCULE" required  />
                                            </div>                                            
                                        </div>
										</div>
										</div> <!-- fin col6-->
                                    </div> <!-- fin row 4-->
									<br>
									  <!--sexe-->	

										<div class='row'>
										<div class="col-md-6 ">		

						  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-6 control-label" style="color:blue">NOM  D'EPOUX </label>	    
                                        <div class="col-md-6 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="epoux" class="form-control" placeholder="EN MAJUSCULE"   />
                                            </div>                                            
                                        </div>
										
                                    </div>
									</div>   <!-- fin col 6-->
										<div class='col-md-6'>
										 <div class="form-group">
                                                <label class="col-md-5 control-label" style="color:blue">SEXE</label>
                                               <div class="col-md-7"> 
											   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="sexe" id="option3" style="width:20px;height:20px;background-color:#399"  value="homme" checked="checked"> HOMME
&nbsp;&nbsp;
    <input type="radio" name="sexe" id="option4" style="width:20px;height:20px;background-color:#399"  value="femme" > FEMME

	                                    </div>
										</div>
										</div><!-- fin col6-->
										
											
									</div> <!-- fin row-->
									<br>
									
									  <div class="row">
									<div class="col-md-6 ">	
                                    <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-6 control-label" style="color:blue" >DATE DE NAISSANCE</label>	    
                                        <div class="col-md-6 col-xs-12">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                <input type="date" name="date_nais_employe" id="date_nais_employe"  class="form-control" required value="0000-00-00" />
                                            </div>                                            
                                        </div>
										
                                    </div>                 
                                </div> <!--fin col6-->

									<div class="col-md-6 ">	
                                    
                                   <div class="form-group">
                                                <label class="col-md-5 control-label " style="color:blue">COMMUNE DE NAISSANCE</label>
                                                <div class="col-md-7">                                                                                            
                                              
												<select class="form-control select " id="commune_nais"  name="commune_nais" data-live-search="true"  required />
															 <option value = "-3" >Selectionner Commune</option>
														<?php $SQL = $bd->requete("SELECT * FROM `communes` order by nom_com");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["code_postal"].'" >'.$rows["nom_com"].' / '.$rows["code_postal"].'</option>';
														}
														
														?>																			   	
																													   	
                                                   </select>														   
														
                                                 
													
                                                </div>
												
                                            </div> 
											</div> <!-- fin col6-->
											</div> <!-- fin row 4-->
											<br>
                                       	
                               <!-- diplome -->
                                      <div class="row">
									
									<div class="col-md-6 ">	
									<div class="form-group" style ="dir:rtl;">
                                      <label class="col-md-6 control-label" style="color:blue">FONCTION</label>	    
                                        <div class="col-md-6 ">  
                                            									
                                          
                                                
                                                <select class="form-control select" name="fonction" id="fonction" class="form-control" data-live-search="true"    />
												 <option value = "">Selectionner fonction</option>
												
												 <?php $SQL = $bd->requete("SELECT * FROM `fonction` order by nom_fonc");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value ='.$rows["id_fonc"].'>'.$rows["nom_fonc"].'</option>';
														}
														
														?>	
												</select>
                                       
										
                                    </div>  
									  </div>
									 </div>
								
									
									<div class="col-md-6" >
									  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-5 control-label" style="color:blue">DATE INSTALLATION</label>	    
                                        <div class="col-md-7 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                <input type="date" name="date_instal" class="form-control"  required />
                                            </div>  
											</div>											
                                       
										</div>
										
                                    </div>
								                                  
																	</div> <br>
																	
								
									<!-- fin col6-->
									
									 <div class='row'>
									<div class="col-md-12 ">	
									<div class="form-group">
                                      <label class="col-md-3 control-label" style="color:blue">DIPLOME</label>	    
                                        <div class="col-md-9 ">  
                                            									
                                          
                                                
                                                <select class="form-control select" name="diplome" id="diplome" class="form-control" data-live-search="true"  required  onchange="change_specialite();" />
												 <option value = "-4">Selectionner le diplome</option>
												
												 <?php $SQL = $bd->requete("SELECT * FROM `diplome` order by nom_diplome");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value ='.$rows["id_diplome"].'>'.$rows["nom_diplome"].'</option>';
														}
														
														?>	
												</select>
                                       
										
                                    </div>  
									</div>
									</div>
									</div>
									<br> <!-- fin col6-->
										 <!-- fin row 4-->
									 <!-- Specialite -->
									
									 <div class='row'>
									     <div class="col-md-12">
                                    <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label" style="color:blue">SPECIALITE</label>	    
                                        <div class="col-md-9 ">  
                                            									
                                         
                                                <select class="form-control select" name="specialite" id="specialite" data-live-search="true"  class="form-control"  required  >
												
													
												</select>
                                                                                     
                                         </div>
												
                                            </div> 
											</div>
											</div>
											<br>
											</div>
											
										
										
										
											
                                    
                                 
									
									
									
									<!--  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label">ACTIVITE</label>	    
                                        <div class="col-md-6 col-xs-12">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="activite" class="form-control" required  />
                                            </div>                                            
                                        </div>
										
                                    </div>-->
                                    
                                     <!-- prenom-->
                            
									
									
									
									
									
                                        
                                  
                                   <!-- END TEMPLATE -->
								   <div class="col-md-6">
								   
								   
								    <!-- MESSAGE BOX-->
		
								   <!--*************************-->
								   
      <!-- <div id="myModal" class="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg " role="dialog" >
        <div class="modal-content">
            <div class="modal-header">
               
            </div>
            <div class="modal-body">
               <div id="divmodal">
                <p id="supr_ln" style="font-size:23px"> Autres Employés de Cette Structure   </p>
                <p id="change_lag"> </p>
               </div>
             

   
              
            <div class="modal-footer">
     <center>            
           <button type="submit" id='oui_btn' name="oui_btn" class="btn btn-success" data-dismiss="modal" onclick="return ferme();return verif_date();">OUI</button>  
   <button type="submit" id='non_btn' class="btn btn-success" data-dismiss="modal" name="non_btn" onclick="return ferme();return verif_date();">NON</button>   
               </center>
            </div>
        </div>
    </div>
	
</div>
</div>-->

</div>

 <!-- The Modal document scanner -->
                              <div class="panel-footer">
								
								    <button   class="btn btn-info pull-right" type = "submit" name = "submit" onclick="return verif_date()">Ajouter</button>  
                                    <a href="index.php" class="btn btn-danger ">Retour</a> 
                                    
                                    
                                </div>
                            </div>
                            </form>
                            
                       
                                   
                 
				  
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                          
            <!-- END PAGE CONTENT -->

        <!-- END PAGE CONTAINER -->


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
        <script>
  webshims.setOptions('waitReady', false);
  webshims.setOptions('forms-ext', {types: 'date'});
  webshims.polyfill('forms forms-ext');
</script>
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
        <!-- END TEMPLATE -->    

        <!-- START TEMPLATE -->
        <script>
		
		function select_commune(){
			
	var post=document.getElementById('wilaya_nais').value;
	//alert(post);

tabl = new Array();

	$.ajax({
	method:"post",
	url:"ajax_commune.php",
	data: {poste:post},
	success:function(resultData){
	tabl=resultData.split('|');
	//alert(tabl);
$('#commune_nais').empty();
	 for(i=0;i<tabl.length;i++){
		// alert(tabl[i]);
		 if(tabl[i]!=''){
//alert(tabl[i]);
		$("#commune_nais").append(new Option(tabl[i],tabl[i])); 
		
		 }
	
		
	 }

		
	}
	
	})
	
}

function change_specialite(){
	var diplome=document.getElementById('diplome').value;
	//alert(diplome);

$('#specialite').selectpicker('refresh');
tabl = new Array();

	$.ajax({
	method:"post",
	url:"ajax_diplome.php",
	data: {diplome:diplome},
	success:function(resultData){
		
	tabl=resultData.split('|');
	
$('#specialite').empty();
	 for(i=0;i<tabl.length;i++){
		 if(tabl[i]!=''){
			specia=tabl[i].split(',');
		$("#specialite").append(new Option(specia[0], specia[1])  ); 
		$('#specialite').selectpicker('refresh');
		 }
	
		
	 }

		
	}
	
	})
	
}
//fin change_specialite()

		function choix(){
			var modal = document.getElementById('myModal');
   modal.style.display = "block";
			//('#myModal').show;
			var idselect=document.getElementById("type_etablissment").value;
			//alert(idselect);
			
		}
		function ferme(){
			var modal = document.getElementById('myModal');
   modal.style.display = "none";
			//('#myModal').show;
			//var idselect=document.getElementById("type_etablissment").value;
			//alert(idselect);
			
		}
			function verif_date(){
				var type_etab = document.getElementById('type_etablissement').value;
				
				 if(type_etab==-1){
 $('#type_etablissement').selectpicker('setStyle', 'btn-danger');
 return false;
				 }else{
$('#type_etablissement').selectpicker('setStyle', 'btn-danger',"remove");
				 }

 var identite_jurdique = document.getElementById('identite_jurdique').value; 
				 if(identite_jurdique==''){
				document.getElementById('identite_jurdique').style.background='#d9534f';
document.getElementById('identite_jurdique').style.color='white';	 
				 }else{
					document.getElementById('identite_jurdique').style.background='#fff';
document.getElementById('identite_jurdique').style.color='black'; 
				 }
				 
var commune_instal = document.getElementById('commune_installation').value;
				 if(commune_instal==-2){
 $('#commune_installation').selectpicker('setStyle', 'btn-danger');
 return false;
				 }else{
					 $('#commune_installation').selectpicker('setStyle', 'btn-danger',"remove"); 
				 }
				 
				  var nom_employe = document.getElementById('nom_employe').value; 
				 if(nom_employe==''){
				document.getElementById('nom_employe').style.background='#d9534f';
document.getElementById('nom_employe').style.color='white';	 
				 }else{
					document.getElementById('nom_employe').style.background='#fff';
document.getElementById('nom_employe').style.color='black'; 
				 }
				   var prenom_employe = document.getElementById('prenom_employe').value; 
				 if(prenom_employe==''){
				document.getElementById('prenom_employe').style.background='#d9534f';
document.getElementById('prenom_employe').style.color='white';	 
				 }else{
					document.getElementById('prenom_employe').style.background='#fff';
document.getElementById('prenom_employe').style.color='black'; 
				 }
				 var commune_nais = document.getElementById('commune_nais').value;
				 if(commune_nais==-3){
 $('#commune_nais').selectpicker('setStyle', 'btn-danger');
 return false;
				 }else{
					 $('#commune_nais').selectpicker('setStyle', 'btn-danger',"remove"); 
				 }
				 
				  var diplome = document.getElementById('diplome').value;
				 if(diplome==-4){
 $('#diplome').selectpicker('setStyle', 'btn-danger');
 return false;
				 }else{
					 $('#diplome').selectpicker('setStyle', 'btn-danger',"remove"); 
				 }
				 
				
				 
			var date_n = document.getElementById('date_nais_employe').value;
		
			var anne=date_n.substring(0,4);
			var d= new Date();
			d2=d.getFullYear();
		if(d2-anne<18 | d2-anne>70){
		document.getElementById('date_nais_employe').style.background='#d9534f';
document.getElementById('date_nais_employe').style.color='white';		
//alert("verifier date naissance");
return false;
		}
		else{
			choix();
			return true;
		}
			}
			
		
		
		</script>
     
    <!-- END SCRIPTS -->           
    </body>
</html>




