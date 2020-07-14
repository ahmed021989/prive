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
$msg_positif= '';
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
	
	$edit->nom_employe = (htmlspecialchars(trim($_POST['nom_employe'])));
	$edit->prenom_employe = (htmlspecialchars(trim($_POST['prenom_employe'])));
	$edit->date_nais_employe = htmlspecialchars(trim($_POST['date_nais_employe']));
	$comm=Communes::trouve_par_nom($_POST['commune_nais']);
	$edit->commune_nais = $comm->code_postal;
	$edit->sexe = (htmlspecialchars(trim($_POST['sexe'])));
 
$edit->diplome = (htmlspecialchars(trim(addslashes($_POST['diplome']))));	
 $edit->epoux = (htmlspecialchars(trim(addslashes($_POST['epoux']))));
 $edit->adrs = (htmlspecialchars(trim(addslashes($_POST['adrs']))));
	$edit->specialite = (htmlspecialchars(trim(addslashes($_POST['specialite']))));
	$edit->fonction = (htmlspecialchars(trim(addslashes($_POST['fonction']))));
	
	$edit->commune_installation = (htmlspecialchars(trim($_POST['commune_installation'])));
	$edit->type_etablissement = (htmlspecialchars(trim($_POST['type_etablissement'])));
	$edit->identite_jurdique = (htmlspecialchars(trim($_POST['identite_jurdique'])));
		$edit->numero_agriment = (htmlspecialchars(trim($_POST['numero_agriment'])));
	$edit->date_agriment = (htmlspecialchars(trim($_POST['date_agriment'])));
		$edit->date_instal = (htmlspecialchars(trim($_POST['date_instal'])));
	$edit->date_creation = (htmlspecialchars(trim($_POST['date_creation'])));
	
	
	
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit->save()){
					$sql=$bd->requete("UPDATE employer SET archive=0 and type_employe=0 where id_employe=".$_GET['id_employe']."");

		$msg_positif .= '<p style= "font-size: 20px; ">  Il a été crée la nouvelle contrat pour  ' . (htmlspecialchars_decode($edit->nom_employe)) .'    </p><br />';
														
														
		}else{
		$msg_error = "<h1>Une erreur dans le programme ! </h1>
		              <h1>Aucune mise action..??? ! </h1>
                   <p class=\"error\" style= \"font-size: 20px; \" >  S'il vous plaît réesaie de nouveau !!</p>";
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
$titre = "Nouvelle contrat ";
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
                               <div class='row' style="border:1px solid green">          
<br>	
<div class='row'>
<div class="col-md-12">
  <div class="form-group" style ="dir:ltr;">
                                                <label class="col-md-3 control-label " style ="dir:ltr;color:green">TYPE D'ETABLISSEMENT</label>
                                                <div class="col-md-9">                                                                                            
                                              
												<select class="form-control select" id="type_etablissement"  name="type_etablissement" data-live-search="true" required / >
															 <option value = "-1">Selectionner type etablissement</option>
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
									
                                    <!--<div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label">WILAYA INSTALLATION</label>	    
                                          <div class="col-md-6 col-xs-12">                                                                                            
                                              
												<select class="form-control select" id="id"  name="wilaya"   />
															
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
                                                <input type="text" name="identite_jurdique" class="form-control" required  />
                                            </div>                                            
                                        </div>
										
                                    </div>
							     </div><!-- fin col 6-->
							</div>
								
								 <br>
								 <div class='row'>
                                   <div class="col-md-6">
                                   <div class="form-group">
                                                <label class="col-md-6 control-label" style="color:green">COMMUNE D'INSTALLATION</label>
                                                <div class="col-md-6">                                                                                            
                                              
												<select class="form-control select" id="commune_installation"  name="commune_installation" data-live-search="true" required  />
															 <option value = "-2">Selectionner commune_installation</option>
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
											<div class="col-md-6 " >
									  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-5 control-label" style="color:green">DATE CREATION</label>	    
                                        <div class="col-md-7 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                             
												   <input type="date" name="date_creation"  id="date_creation" class="form-control" placeholder=""   />
                                            </div>  
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
                                                <input type="text" name="numero_agriment" class="form-control"    />
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
                                                <input type="date" name="date_agriment" class="form-control"   />
                                                                                       
                                        </div>
										</div>
										</div>
										
                                    </div>
									
									</div><!--fin row 3-->
									<br>
									</div>	
										
										<br>
									<br>
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
                                                <input type="text" name="nom_employe" class="form-control" readonly placeholder="EN MAJUSCULE"  value="<?php echo $employer->nom_employe;  ?>" required  />
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
                                                <input type="text" name="prenom_employe" class="form-control" readonly  value="<?php echo $employer->prenom_employe;  ?>" placeholder="EN MAJUSCULE" required  />
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
                                                <input type="text" name="epoux" class="form-control" placeholder="EN MAJUSCULE"  value="<?php echo $employer->epoux;  ?>"   />
                                            </div>                                            
                                        </div>
										
                                    </div>
									</div>   <!-- fin col 6-->
										<div class='col-md-6'>
										 <div class="form-group">
                                                <label class="col-md-5 control-label" style="color:blue">SEXE</label>
                                               <div class="col-md-7"> 
											   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="sexe" id="option3" style="width:20px;height:20px;background-color:#399"  value="homme" <?php  if($employer->sexe_employe=="homme"){  echo 'checked="checked"';} ?>> HOMME
&nbsp;&nbsp;
    <input type="radio" name="sexe" id="option4" style="width:20px;height:20px;background-color:#399"  value="femme" <?php  if($employer->sexe_employe=="femme"){  echo 'checked="checked"';} ?>> FEMME

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
                                                <input type="date" name="date_nais_employe" id="date_nais_employe" readonly class="form-control" required value="<?php echo $employer->date_nais_employe;  ?>" />
                                            </div>                                            
                                        </div>
										
                                    </div>                 
                                </div> <!--fin col6-->

									<div class="col-md-6 ">	
                                    
                                   <div class="form-group">
                                                <label class="col-md-5 control-label " style="color:blue">COMMUNE DE NAISSANCE</label>
                                                <div class="col-md-7">                                                                                            
                                              
												<input class="form-control " id="commune_nais"  name="commune_nais" data-live-search="true"  value="<?php if($commune=Communes::trouve_par_code_postal($employer->commune_nais)) echo $commune->nom_com; ?>" required readonly />
															
														
                                                 
													
                                                </div>
												
                                            </div> 
											</div> <!-- fin col6-->
											</div> <!-- fin row 4-->
											<br>
                                       	
                                    <!-- diplome -->
                                    <div class="row">
									
									<div class="col-md-6 ">	
									<div class="form-group">
                                      <label class="col-md-6 control-label" style="color:blue">FONCTION</label>	    
                                        <div class="col-md-6 ">  
                                            									
                                          
                                                
                                                <select class="form-control select" name="fonction" id="fonction" class="form-control" data-live-search="true"    />
												 <option value = "<?php $employer->fonction;   ?>"><?php if($employer->fonction!=0){$fonction=Fonction::trouve_par_id($employer->fonction); echo $fonction->nom_fonction;}else echo "Selectionner fonction";   ?><option>
												
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
									
									
										<div class="col-md-6 " >
									  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-5 control-label" style="color:blue">DATE INSTALLATION</label>	    
                                        <div class="col-md-7 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                             
												   <input type="date" name="date_instal" class="form-control" placeholder="" value="<?php echo $employer->date_instal;  ?>"   />
                                            </div>  
											</div>											
                                       
										</div>
										
                                    </div>
									</div><br> <!-- fin col6-->
									 <div class="row">
									<div class="col-md-12">	
									<div class="form-group">
                                      <label class="col-md-3 control-label" style="color:blue">DIPLOME</label>	    
                                        <div class="col-md-9">  
                                            									
                                          
                                                
                                                <select class="form-control select" name="diplome" id="diplome" class="form-control" data-live-search="true" onchange="change_specialite()"  required  />
												 <option value = "<?php echo $employer->diplome;  ?>" > <?php $diplome=Diplome::trouve_par_id($employer->diplome) ; echo $diplome->nom_diplome; ?> </option>
												
												 <?php $SQL = $bd->requete("SELECT * FROM `diplome` order by nom_diplome");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value ='.$rows["id_diplome"].'>'.$rows["nom_diplome"].'</option>';
														}
														
														?>	
												</select>
                                       
										
                                    </div>  
									</div>
									</div> <!-- fin col6-->
										</div> <!-- fin row 4-->
									 <!-- Specialite -->
									 </br>
									 <div class='row'>
									     <div class="col-md-12">
                                    <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label" style="color:blue">SPECIALITE</label>	    
                                        <div class="col-md-9 ">  
                                            									
                                         
                                                <select class="form-control select" name="specialite" id="specialite" data-live-search="true"  class="form-control"  required  >
												 <option value = "<?php echo $employer->specialite;  ?>"><?php $specialite=Specialite::trouve_par_id($employer->specialite) ; echo $specialite->nom_specialite ?> </option>
												
													
												</select>
                                                                                     
                                         </div>
												
                                            </div> 
											</div>
											</div>
											<br>
											</div>
						
                                        
                                 <div class="panel-footer">
                                  <a href="index.php" class="btn btn-danger ">Retour</a>                                    
                                    <button class="btn btn-primary pull-right"type = "submit" name = "submit" onclick="return  verif_date()">  Ajouter</button>
                                    <?php echo '<input type="hidden" name="id_employe" value="' .$id . '" />';?>
							   </div>
                            </div>
                        </form>
                    </div>
                    </div>                    
                    
                  
             
                <!-- END PAGE CONTENT WRAPPER -->                                
                 </div>       
            <!-- END PAGE CONTENT -->
        
		
		  <!-- --------------------------------------------------------------------------- -->
     	 <div class="message-box animated fadeIn" data-sound="alert" id="mb-ouverture" >
		  <br><br><br><br>
		  <br><br><br><br>
		  <br><br><br><br>
                <div class="col-sm-8 col-sm-offset-2" style="background:#000; box-shadow: 10px 10px 10px #333;">
                   <div class="mb-title" ><h1 style="color:#fff"><span class="fa fa-briefcase"></span> Nouvelle Contrat </h1> </div>
                    <div class="mb-content">
					 <center><div class="row">
					<table>
					<tr>
                       <td> <h3 style="color:#fff;text-align:right"><p>Changement Structure Appuyer </h3></td><td><a  href="nouvel_contrat_fils.php?id_employe= <?php echo $_GET['id_employe'];?>" class="fa fa-check-square btn-lg pull-right" style="font-size:30px;color:#0D9E1C "></a></td>
 </p>
 </tr>
 </tr>
						<td><h3 style="color:#fff;text-align:right"> <p>Ouverture d'une Structure Appuyer </h3></td><td><a   class="btn-lg fa fa-check-square  mb-control-close pull-right" style="font-size:30px;color:#fe970a "></a></td>
					
</tr>
</table>
					
</div>					
<div class="row">					
</p></h3>


						</div>
						<div class="col-md-6">
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
					
                        </div>
                    </div></center>
                </div>
            </div>
			
        
		  </div>
		       
		
		
		
		
		
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
		
				 window.onload=ouverture();
		function ouverture(){
			<?php   if($msg_positif==''){ ?>
			$('#mb-ouverture').show();
			<?php } ?>
		}
		
		
			function affiche_box2(){
			
        var box=document.getElementById('mb-ouverture');
		
		box.style.display = "block";
		
		}
		
		
		
		$('.mb-control-close').on('click',function(){
			 	//$('#mb-liste_etab').hide(); 
             $('#mb-ouverture').hide();				
		  })
		
		
		function verif_date(){
						
			var date_n = document.getElementById('date_nais_employe').value;
		
			var anne=date_n.substring(0,4);
			var d= new Date();
			d2=d.getFullYear();
		if(d2-anne<18 | d2-anne>70){
		document.getElementById('date_nais_employe').style.background='red';
document.getElementById('date_nais_employe').style.color='white';		
//alert("verifier date naissance");
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






