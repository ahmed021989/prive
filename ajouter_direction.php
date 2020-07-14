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
	if(isset($_POST['submit'])){
	$errors = array();
	

	// new object document
	$direction = new direction();

	$direction->Nom_derc_ar = htmlentities(trim($_POST['Nom_derc_ar']));
	$direction->Nom_derc_fr = htmlentities(trim($_POST['Nom_derc_fr']));
	$direction->Add_derc_ar = htmlentities(trim($_POST['Add_derc_ar']));
	$direction->Add_derc_fr = htmlentities(trim($_POST['Add_derc_fr']));
	$direction->Num_tele_der = htmlentities(trim($_POST['Num_tele_der']));
	$direction->Num_fax = htmlentities(trim($_POST['Num_fax']));
	

	
	if (empty($errors)){
   		if ($direction->existe()) {
			$msg_error = '<p style= "font-size: 20px; ">   direction  " '  . html_entity_decode($direction->Nom_derc_fr) . ' " existe Déja !!!</p><br />';
			
		}else{
			$direction->save();
 		  $msg_positif = '<p style= "font-size: 20px; ">   direction  "  ' .html_entity_decode($direction->Nom_derc_fr) . '  " est bien ajouter  </p><br />';
		
		}
 		 
 		}else{
		// errors occurred
		$msg_error = '<h1> !! err  </h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}

?>
<?php
$titre = "Ajouter direction";
$active_menu = "index";
$header = array('direction');
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
                
                <div class="page-title"  >                    
                    <h2><span class="fa fa-briefcase"></span>  Ajouter direction </h2>
                </div>   
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap"  >
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                           <form class="form-horizontal" role="form"  name="ajout_direction" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                   
                                    <ul class="panel-controls">
                                        <li> <h3 class="panel-title"><strong> Information sur direction </strong></h3></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                <?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="form-group"  style = "text-align: right;">
									 <label class="col-md-3 col-xs-12 control-label"> Nom direction en français  : </label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-briefcase"></span></span>
                                                <input type="text" name ="Nom_derc_fr" class="form-control" required />
                                            </div>                                            
                                        </div>
                                      
                                    </div>
									
									  <div class="form-group">   
                                     <label class="col-md-3 col-xs-12 control-label">Adresse direction en français : </label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-briefcase"></span></span>
                                                <input type="text" name="Add_derc_fr" class="form-control " required  />                                            
                                            </div>
                                        </div>
										
                                    </div>
                                    
                                   
                                     <div class="form-group">   
                                     <label class="col-md-3 col-xs-12 control-label">Nom direction en arabe : </label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-briefcase"></span></span>
                                                <input type="text" name="Nom_derc_ar" class="form-control " required  />                                            
                                            </div>
                                        </div>
										
                                    </div>
									 
								
                                     
									  <div class="form-group">   
                                     <label class="col-md-3 col-xs-12 control-label">Adresse direction en arabe : </label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-briefcase"></span></span>
                                                <input type="text" name="Add_derc_ar" class="form-control " required  />                                            
                                            </div>
                                        </div>
										
                                    </div>
								   
								   
									  <div class="form-group">   
                                     <label class="col-md-3 col-xs-12 control-label">Numéro téléphone : </label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-briefcase"></span></span>
                                                <input type="text" name="Num_tele_der" class="form-control " required  />                                            
                                            </div>
                                        </div>
										
                                    </div>
                                    
									  <div class="form-group">   
                                     <label class="col-md-3 col-xs-12 control-label">Numéro Fax : </label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-briefcase"></span></span>
                                                <input type="text" name="Num_fax" class="form-control " required  />                                            
                                            </div>
                                        </div>
										
                                    </div>
                                  
                                  
                                </div>
                                <div class="panel-footer">
								
								    <button class="btn btn-info pull-left" type = "submit" name = "submit">Ajouter</button>  
                                    <button class="btn btn-default pull-right" type = "reset">Vidé les champts</button> 
                                    
                                    
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
<?php 
			$directions = direction::trouve_tous();
		?>				
              <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Liste des directions </strong></h3>
									
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>                                
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                
                                                <th>Nom direction (FR)</th>
												<th>Nom direction (AR)</th>
												<th>Num téléphone</th>
                                                <th>Mise à jour</th>
                                                
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
								foreach($directions as $direction){
									?>
                                      
                                            <tr id ="<?php echo html_entity_decode($direction->Id_derc); ?>">
											
											    <td><?php echo html_entity_decode($direction->Nom_derc_fr); ?></td>
                                                <td><?php echo html_entity_decode($direction->Nom_derc_ar); ?></td>
                                                <td><?php echo html_entity_decode($direction->Num_tele_der); ?></td>
                                              
                                               
                                                <td>
												
												<button class="btn btn-danger btn-rounded " onClick="delete_row('<?php echo $direction->Id_derc;?>');"><span class="glyphicon glyphicon-trash"></span></button>
											  <a href="edit_direction.php?id=<?php echo $direction->Id_derc;?>"><button class="btn btn-info btn-rounded " style = "text-align: right;"><span class="fa fa-pencil"></span></button><a>

												</td>
                                            </tr>
                                  <?php
								  
								
								}
                                 ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
                     
            <!-- END PAGE CONTENT -->
        </div>
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
    <!-- END SCRIPTS -->                   
    </body>
</html>






