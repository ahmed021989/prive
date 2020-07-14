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
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = $_GET['id'];
		 $edit =  Direction::trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
		 $edit =  Direction::trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
	if(isset($_POST['submit'])){
		
	$errors = array();
	// new object document
	
	$edit->Nom_derc_ar = htmlentities(trim($_POST['Nom_derc_ar']));
	$edit->Nom_derc_fr = htmlentities(trim($_POST['Nom_derc_fr']));
	$edit->Add_derc_ar = htmlentities(trim($_POST['Add_derc_ar']));
	$edit->Add_derc_fr = htmlentities(trim($_POST['Add_derc_fr']));
	$edit->Num_tele_der = htmlentities(trim($_POST['Num_tele_der']));
	$edit->Num_fax = htmlentities(trim($_POST['Num_fax']));
	
	
	
	
	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit->save()){
		$msg_positif .= '<p style= "font-size: 20px; ">  Il a été mis à jour  ' . html_entity_decode($edit->Nom_derc_ar) .'    </p><br />';
														
														
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
$titre = "Modifier Direction ";
$active_menu = "index";
$header = array('direction');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
}

?>
<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">Direction </a></li>
                    <li class="active"><?php echo $titre ?></li>
                </ul>
                <!-- END BREADCRUMB -->
                <div class="page-title">                    
                    <h2><span class="fa fa-cogs"></span>  Modifier Direction  </h2>
                </div>   
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap"  
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_direction"  id = "ajouter_direction" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Modifier Direction   </strong></h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
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
                                </div>
								
                                <div class="panel-body">                                                                        
                                    
                                                                                   
                                    
                                    <div class="form-group" >
										<label class = "col-md-3 col-xs-12 control-label" >  Nom direction en français  (FR) :</label>

                                           <div class="col-md-6 col-xs-12">
										 
                                            <div class="input-group">
											
                                                <span class="input-group-addon">FR</span>
                                              
												 <input type="text" class="form-control" name ="Nom_derc_fr" required value ="<?php if (isset($edit->Nom_derc_fr)){ echo html_entity_decode($edit->Nom_derc_fr); } ?>" />
                                            </div> 
                                         </div> 											
                                       
                                    </div>
									
										<div class="form-group">                                        
                                       	<label class= "col-md-3 col-xs-12 control-label" >  Adresse Direction En Français (FR) : </label>
                                            <div class="col-md-6 col-xs-12">
											<div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
												 <input type="text" class="form-control" name ="Add_derc_fr" required  value ="<?php if (isset($edit->Add_derc_fr)){ echo html_entity_decode($edit->Add_derc_fr); } ?>" />
                                            </div>            
                                        </div>
								
                                    </div>
                                    
                                    <div class="form-group"  >
									       <label class= "col-md-3 col-xs-12 control-label" >  Nom Direction (AR) :  </label>
                                           <div class="col-md-6 col-xs-12">                                    
                                            <div class="input-group">
                                                <span class="input-group-addon">AR</span>
												 <input type="text" class="form-control" name ="Nom_derc_ar" required value ="<?php if (isset($edit->Nom_derc_ar)){ echo html_entity_decode($edit->Nom_derc_ar); } ?>" />
                                            </div>                                            
                                        </div>
                                    </div>
                              
								
									
									<div class="form-group" >
                                        
 									<label class= "col-md-3 col-xs-12 control-label" >    Adresse Direction En Arabe (AR) : </label>
                                              <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
                                                <input type="text" class="form-control" name ="Add_derc_ar" required  value ="<?php if (isset($edit->Add_derc_ar)){ echo html_entity_decode($edit->Add_derc_ar); } ?>" />
                                            </div>                                            
                                        </div>
                                    </div>
									
									<div class="form-group"  >
									    <label class="col-md-3 col-xs-12 control-label" > Numéro Téléphon : </label>
                                               <div class="col-md-6 col-xs-12">                                     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                                <input type="number" class="form-control" name ="Num_tele_der" required value ="<?php if (isset($edit->Num_tele_der)){ echo html_entity_decode($edit->Num_tele_der); } ?>" />
                                            </div>                                            
                                          
                                        </div>
										
                                    </div>
									
									
									
                                
     
									<div class="form-group">  
	                                    <label class="col-md-3 col-xs-12 control-label"> Numéro Fax  : </label>									
                                         <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-print"></span></span>
                                              <input type="number" class="form-control" name ="Num_fax" required value ="<?php if (isset($edit->Num_fax)){ echo html_entity_decode($edit->Num_fax); } ?>" /> 
											
                                            </div>
                                        </div>
									
                                    </div>
									
									
									 
								
									
                                  
                                </div> 
                                        
                                 <div class="panel-footer">
                                    <button class="btn btn-default"type = "reset">Vider les Champs</button>                                    
                                    <button class="btn btn-primary pull-right"type = "submit" name = "submit">Modifier</button>
                                    <?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
							   </div>
                            </div>
                        </form>
                    </div>
                    </div>                    
                    
                  
             
                <!-- END PAGE CONTENT WRAPPER -->                                
                       
            <!-- END PAGE CONTENT -->
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






