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
 $edit =  Personne::trouve_par_id($user->id);
 $id= $edit->id;
 
 
 
 
	if(isset($_POST['submit'])){
	$errors = array();
	
	// verification de données 	
	if (isset($_POST['passe'])&& !empty($_POST['passe'])){
	    if($_POST['passe'] != $_POST['passe2']){
		 $errors[]=' <p style= "font-size: 20px; "> Erreur dans l accent n a pas été modifié le mot de passe </p>'; 
		 } if($edit->mot_passe != SHA1($_POST['passe0'])){
		 $errors[]='<p style= "font-size: 20px; "> L ancian mot de passe erroné </p>'; 
		 }
		 else{
			 $edit->cpt = $_POST['passe'];
			 
		  $edit->mot_passe = SHA1($_POST['passe']);
		   
		}
		}
		
		

 	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
   		
 		if ($edit->save()){
		$msg_positif .= '<p style= "font-size: 20px; ">    Le mis à jour de mot de passe été réussite      </p><br />';
		}else{
		$msg_system .= "<h1>! Erreur </h1>
                  <p class=\"error\" style= \"font-size: 20px; \" >  S'il vous plaît re-mise à jour à nouveau !!<br/> !!  لم يتم التحديــث بنجاح نظراً لخطأ غير معين ، نحن نتأسف عن هذا الخطأ </p>";
		}
 		
 		}else{
		// errors occurred
		$msg_error = '<h1> Erreur !!  </h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
		}
	
}

?>
<?php
$titre = "Modification mot de passe";
$active_menu = "index";
$header = array('file','ckeditor');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
 }
?>
        

                 
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
					  <li><a href="index.php">Accueil </a></li>  
					  <li class="active"><?php echo $titre ?></li>  
                </ul>
                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2> <span class="fa fa-cogs"></span> Modification mot de passe</h2>
                </div>   
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap"  >
                 <div class="row">
                       
                        <div class="col-md-10">
                            
                           <form class="form-horizontal" role="form"  name="ajout_util" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                   
                                    <ul class="panel-controls">
                                        <li> <h3 class="panel-title"><strong> Informations sur l'utilisateur </strong></h3></li>
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
                                    
                                    <div class="form-group">                                        
                                         <label class="col-md-3 col-xs-12 control-label">Ancien mot de passe</label>
										<div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                            <input type="password" name="passe0" class="form-control"required  />
                                            <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                               
											</div>             
                                        </div>
                                       
                                    </div> 
									 <div class="form-group">   
											<label class="col-md-3 col-xs-12 control-label">Nouveau mot de passe</label>                                     
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <input type="password" name="passe" class="form-control"required  />
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                           
										   </div>             
                                        </div>
                                        
                                    </div>     
									<div class="form-group">  
										<label class="col-md-3 col-xs-12 control-label">Confirmer le nouveau mot de passe</label>									
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
					                            <input type="password" name="passe2" class="form-control"required  />
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>

                                            </div>            
                                        </div>
										
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default pull-right" type = "reset">Vider les Champs</button> 
                                    <button class="btn btn-info pull-left" type = "submit" name = "submit">Modifier</button>  
									<?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
                                    
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                     <div class="col-md-2">
						</div>
                  
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
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






