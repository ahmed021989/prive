<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page  ccsdcsdc";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 
}
?>
<?php
$id=0;

	if ( (isset($_GET['id_employe'])) && (is_numeric($_GET['id_employe'])) ) { 
		 $id = $_GET['id_employe'];
		  if($user->type!='administrateur'){
			  $wilaya=Wilayas::trouve_par_Nom($user->wilaya);
			  
		  $SQL = $bd->requete("SELECT * FROM employer,personne where employer.wilaya=".$wilaya->id_w." and id_employe=".$id."");
$count=$bd->num_rows($SQL);
				
			if($count==0){
		echo '<script>document.location.href="index.php";</script>';	//header('location:ajouter_autre_employe.php?id_employe='.$i.'');
			//	readresser_a("index.php");
			}
			}
		 $edit =  Employe::trouve_par_id($id);
	 } elseif ( (isset($_POST['id_employe'])) &&(is_numeric($_POST['id_employe'])) ) { 
		 $id = $_POST['id_employe'];
		 $edit =  Employe::trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
	if(isset($_POST['submit'])){
		
		
	$errors = array();
	// new object document
	
	$employer=Employe::trouve_par_id($_GET['id_employe']);
	$transfere = new Transfere();
	$transfere->id_employe = $employer->id_employe;
	
	  $transfere->adrs = $employer->adrs;
	$transfere->commune_installation = $employer->commune_installation;
	$transfere->type_etablissement = $employer->type_etablissement;
	$transfere->identite_jurdique = $employer->identite_jurdique;
	$transfere->numero_agriment = $employer->numero_agriment;
	$transfere->date_agriment = $employer->date_agriment;
	$transfere->date_instal =$employer->date_instal;
	$transfere->date_creation = $employer->date_creation;
	$transfere->date_trans =(htmlspecialchars(trim(addslashes($_POST['date_trans']))));
	
	
	$transfere->save();
	
	
	
	
	
	
    $edit->adrs = (htmlspecialchars(trim(addslashes($_POST['adrs']))));
	$edit->commune_installation = (htmlspecialchars(trim($_POST['commune_installation'])));
	$edit->type_etablissement = (htmlspecialchars(trim($_POST['type_etablissement'])));
	$edit->identite_jurdique = (htmlspecialchars(trim($_POST['identite_jurdique'])));
		$edit->numero_agriment = (htmlspecialchars(trim($_POST['numero_agriment'])));
	$edit->date_agriment = (htmlspecialchars(trim($_POST['date_agriment'])));
		//$edit->date_instal = (htmlspecialchars(trim($_POST['date_instal'])));
	$edit->date_creation = (htmlspecialchars(trim($_POST['date_trans'])));
	$SQL = $bd->requete("SELECT * FROM `employer` where type_employe='".$id."' ");
		while ($rows = $bd->fetch_array($SQL)){
	$bd->requete("UPDATE employer SET commune_installation='".(htmlspecialchars(trim($_POST['commune_installation'])))."' ,  type_etablissement='".(htmlspecialchars(trim($_POST['type_etablissement'])))."' ,  identite_jurdique='". (htmlspecialchars(trim($_POST['identite_jurdique'])))."' ,  numero_agriment='". (htmlspecialchars(trim($_POST['numero_agriment'])))."',  date_agriment='". (htmlspecialchars(trim($_POST['date_agriment'])))."' , date_creation='".(htmlspecialchars(trim($_POST['date_trans'])))."' where id_employe=".$rows["id_employe"]."");
		}
														
	
	
	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit->save()){
		$msg_positif .= '<p style= "font-size: 20px; ">  Il a été transfere .    </p><br />';
														
														
		}else{
		$msg_error = "<h1>Une erreur dans le programme ! </h1>
		              <h1>Aucune mise à jour ..??? ! </h1>
                   <p class=\"error\" style= \"font-size: 20px; \" >  S'il vous plaît re- mise à jour à nouveau !!</p>";
		}
 		
 		}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
		}
	
}

?>
<?php
$titre = "Transfere ";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
}

?>
<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">Employé </a></li>
                    <li class="active"><?php echo $titre ?></li>
                </ul>
                <!-- END BREADCRUMB -->
                 
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap" > 
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_direction"  id = "ajouter_direction" action="<?php echo $_SERVER['PHP_SELF'].'?id_employe='.$id;?>" method="post">
                            <div class="panel panel-default">
                              
                                <div class="panel-body">
                                  <?php 
								  
								   $edit =  Employe::trouve_par_id($id);
								  
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
                                </div>
								<?php  
							$employer=Employe::trouve_par_id($id);
								?>
								
								
					 <div class='row' style="border:1px solid blue"> 
<div class="row">					 
<div class="col-md-4">
<b>NOM: </b><span style="font-size:14px"><?php echo $employer->nom_employe?></span>
</div>
<div class="col-md-4">
<b>PRENOM: </b><span style="font-size:14px"><?php echo $employer->prenom_employe; ?></span>
</div>
<div class="col-md-4">
<?php $spec=Specialite::trouve_par_id($employer->specialite); ?>

<b>SPECIALITE: </b><span style="font-size:14px"><?php echo $spec->nom_specialite; ?></span>
</div>
</div><!--fin row-->
<br>
<div class="row">
<div class="col-md-4">
<?php $comm=Communes::trouve_par_code_postal($employer->commune_installation); ?>
<b>COMMUNE INSTALLATION: </b><span style="font-size:14px"><?php echo $comm->nom_com; ?></span>
</div>
<div class="col-md-6">
<?php $etab=Etablissement::trouve_par_id($employer->type_etablissement) ;?>

<b>TYPE ETABLISSEMENT: </b><span style="font-size:14px"><?php echo $etab->type_etab; ?></span>
</div>
</div> <!--fin row-->
<br>
					 </div>
								
							<br>	
                               <div class='row' style="border:1px solid green">          
<br>

			<div class="row">
									
									<div class="col-md-6 " >
									  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-6 control-label" style="color:green">DATE TRANSFERT</label>	    
                                        <div class="col-md-6 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                <input type="date" name="date_trans" class="form-control" required />
                                            </div>  
											</div>											
                                       
										</div>
										
                                    </div>
									
									
									</div><!--fin row 3-->
									<br>


	
<div class='row'>
<div class="col-md-12">
  <div class="form-group" style ="dir:ltr;">
                                                <label class="col-md-3 control-label " style ="dir:ltr;color:green">TYPE D'ETABLISSEMENT</label>
                                                <div class="col-md-9">                                                                                            
                                              
												<select class="form-control select" id="type_etablissement"  name="type_etablissement" data-live-search="true" required / >
															 <option value = "-1">Séléctionné  Type Etablissement</option>
														<?php $SQL = $bd->requete("SELECT * FROM `etablissement` order by type_etab ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["Id_etab"].'" >'.$rows["type_etab"].'</option>';
														}
														
														?>															   	
                                                   </select>														   
														
                                                 
													
                                                </div>
												
                                            </div>
											</div>
											</div>
									
                                    <!--	
															
														<?php 
														$id_wilaya=0;
														$SQL = $bd->requete("SELECT * FROM personne,wilayas  where wilayas.nom=personne.wilaya and login='".$user->login."' ");
															while ($rows = $bd->fetch_array($SQL))
														{
														$id_wilaya=$rows["id_w"];
														echo '<option  value = "'.$rows["wilaya"].'" >'.$rows["wilaya"].'</option>';
														}
														
														?>															   	
                                                   </select>														   
														
                                                 
													
                                                </div>                                           
                                        </div>-->
										<br>
								<div class='row'>		
                             <div class="col-md-12">
							      <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label pull-left" style="color:green">IDENTITE JURIDIQUE COMMERCIELLE</label>	    
                                        <div class="col-md-9 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                <input type="text" name="identite_jurdique" class="form-control"  required  />
                                            </div>                                            
                                        </div>
										
                                    </div>
							     </div><!-- fin col 6-->
							</div>
								
								 <br>
								 <div class='row'>
                                   <div class="col-md-12">
                                   <div class="form-group">
                                                <label class="col-md-3 control-label" style="color:green">COMMUNE D'INSTALLATION</label>
                                                <div class="col-md-9">                                                                                            
                                              
												<select class="form-control select" id="commune_installation"  name="commune_installation" data-live-search="true" required  />
															 <option value="-2">Selectionné commune installation</option>
																										<?php 
																										$SQL="";
																										if($user->type=="administrateur"){
																										$SQL = $bd->requete("SELECT * FROM communes order by nom_com");
																										}
																										else
																										{
																										$SQL = $bd->requete("SELECT * FROM communes  where wilaya_id=".$id_wilaya." order by nom_com");	
																										}
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["code_postal"].'" >'.$rows["nom_com"].' / '.$rows["code_postal"].'</option>';
														}
														
														?>			   	
                                                   </select>														   
														
                                                 
													
                                                </div>
												
                                            </div> 
                                            </div>
										
											
											
											
											
</div>
<br>
<div class='row'>
<div class="col-md-12">											
										
											
											 <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label pull-left" style="color:green">ADRESSE <span style="color:red"> (Facultatif)  </span></label>	    
                                        <div class="col-md-9 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="adrs" class="form-control" placeholder=""    />
                                            </div>                                            
                                        </div>
										
                                    </div>
									</div>
									</div>
									<br>
										
									<div class="row">
									
									<div class="col-md-6 " >
									  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-6 control-label" style="color:green">NUMERO AGREMENT<span style="color:red"> (Facultatif)  </span></label>	    
                                        <div class="col-md-6 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-file"></span></span>
                                                <input type="text" name="numero_agriment" class="form-control"  />
                                            </div>  
											</div>											
                                       
										</div>
										
                                    </div>
									<div class="col-md-6 ">
									  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-5 control-label " style="color:green">DATE AGREMENT<span style="color:red"> (Facultatif)  </span></label>	    
                                        <div class="col-md-7 ">   
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                <input type="date" name="date_agriment" class="form-control"    />
                                                                                       
                                        </div>
										</div>
										</div>
										
                                    </div>
									
									</div><!--fin row 3-->
									
									<br><br>
									</div>	
										
								
									
									<!--******************************-->
									
						
                                        
                                 <div class="panel-footer">
                                  <a href="index.php" style="background:red" class="btn btn-danger ">Retour</a>                                    
                                    <button class="btn btn-primary pull-right" style="background:#20820d;" type = "submit" name = "submit" onclick="return  verif_date();">  Transférer</button>
                                    <?php echo '<input type="hidden" name="id_employe" value="' .$id . '" />';?>
							   </div>
                            </div>
                        </form>
                    </div>
                    </div>                    
                    
                  
             
                <!-- END PAGE CONTENT WRAPPER -->                                
                 </div>       
            <!-- END PAGE CONTENT -->
        
        <!-- END PAGE CONTAINER -->
        
        <!-- MESSAGE BOX-->
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
        
                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
  
        <!-- END THIS PAGE PLUGINS -->       
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
		<script>
		function verif_date(){
						
			var date_c = document.getElementById('date_creation').value;
		var date_t = document.getElementById('date_trans').value;
			alert(date_c);
		if(!date_c){
			document.getElementById('date_creation').style.background="red";
			document.getElementById('date_creation').style.color="#fff";
		return false;
		}
		if(!date_t){
			document.getElementById('date_trans').style.background="red";
			document.getElementById('date_trans').style.color="#fff";	
			return false;
		}
		else{
			return true;
			
		}
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
	// alert(resultData);
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
		</script>
    <!-- END SCRIPTS -->     
    <!-- END SCRIPTS -->                   
    </body>
</html>






