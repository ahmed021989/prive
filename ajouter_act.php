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
	$actualite = new  Actualite();

	$actualite-> nom_act= htmlspecialchars(trim(addslashes($_POST['nom_act'])));
	$actualite-> contenu = htmlspecialchars(trim(addslashes($_POST['contenu'])));

	$actualite->publier=0;

	

	
	if (empty($errors)){
   		if ($actualite->existe()) {
			$msg_error = '<p style= "font-size: 20px; ">   Actualité " '  . (htmlspecialchars_decode($actualite->nom_act)) . ' " existe Déja !!!</p><br />';
			
		}else{
			$actualite->save();
 		  $msg_positif = '<p style= "font-size: 20px; ">   Actualité  "  ' .(htmlspecialchars_decode($actualite->nom_act)) . '  " est bien ajouter  </p><br />';
	
		
		}
 		 
 		}else{
		// errors occurred
		$msg_error = '<h3>  Erreur  !!??? </h3>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}

?>
<?php
$titre = "Actualité";
$active_menu = "index";
$header = array('actualite');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
}
?>
 
<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#"> Actualité</a></li>
                    <li class="active">Ajouter une  Actualité</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_stru" id = "ajouter_stru" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong> Actualité </strong></h3>
                                    
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
                                                <label class="col-md-3 col-xs-12 control-label">Nom Actualité : </label>
                                               <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name ="nom_act" required / >
                                                    </div>                                            
                                                 </div>
												
                                            </div>
											 <div class="form-group">
                                               <label class="col-md-3  control-label">Contenu :</label>
                                               <div class="col-md-4 ">                                           
                                                   
                                                        
                                                       <textarea class="form-control" name ="contenu" rows="5" required  ></textarea>
                                                                                            
                                                 </div>
											
                                            </div>
										
                                              
                                     

                                </div>
								
                                <div class="panel-footer">
                                    <button class="btn btn-default"type = "reset">Vider les Champs</button>                                    
                                    <button class="btn btn-info pull-right"type = "submit" name = "submit">Ajouter</button>
                                </div>
                            </div>
							 </div>
                        </form>
                            
                        </div>
                    </div>  
				
<?php 
		
		?>				
              <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Liste des  Actualités </strong></h3>
									
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
                                               
												
												<th>nom Actualité</th>
												<th>contenu </th>
												<th>Etat de Actualité </th>
                                                <th>Mise à jour</th>
												<th>Supprimer</th>
                                                
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									$actualite =  Actualite:: trouve_tous();	
								
								foreach($actualite as $actualite){
									
									?>
                                      
                                            <tr id ="<?php


											echo html_entity_decode($actualite->id_act); ?>">
											
                                                
												
												   <td><?php echo htmlspecialchars_decode($actualite->nom_act); ?></td>
                                                   <td><?php echo htmlspecialchars_decode($actualite->contenu); ?></td>
												  <td> <?php  if ($actualite->publier==1){ ?>
												   
												   <a  class="btn btn-success btn-sm"><span class="fa fa-check"></span>Publier </a> 
												   <?php  
												   } else if ($actualite->publier==0){ ?>
													  
												   <a  class="btn btn-danger btn-sm"><span class="fa fa-times-circle"></span>No publier </a> 
												   
												   
												   <?php  } ?>
												   
												   </td>
												   
                                                <td>
												     <?php  if ($actualite->publier==0){ ?>
												   
												   <a href="publier.php?id_act=<?php echo $actualite->id_act;?>" class="btn btn-info btn-sm"><span class="fa fa-check"></span>Publier </a>
												   <?php  
												   } else if ($actualite->publier==1){ ?>
													  
												   <a href="depublier.php?id_act=<?php echo $actualite->id_act;?>" class="btn btn-warning btn-sm"><span class="fa fa-times-circle"></span>Dépublier </a> 
												   
												   
												   <?php  } ?>
												   </td>
												   <td>
												   
												   	<a style="color:#ff0000;font-size:20px" onClick="delete_row('<?php echo $actualite->id_act;?>');" class="glyphicon glyphicon-trash"></a>
                                              
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
		<div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-row" >
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="glyphicon glyphicon-trash"></span> Supprimer <strong> les  Données </strong> !!??</div>
                    <div class="mb-content">
                        <p>Etes-vous sûr de vouloir supprimer cette ligne?</p>                    
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
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
				        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
		         <script type="text/javascript" src="js/demo_tables.js"></script> 
			       <script type="text/javascript" src="js/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>	
		<!-- END THIS PAGE PLUGINS -->       
        
        <!-- START TEMPLATE -->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                   
    </body>
</html>
