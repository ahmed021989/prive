<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'DGSS-RH' );
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
$titre = "Message supprimer";
$active_menu = "index";
$header = array('message');
if ($user->type =='administrateur' or 'Admin_dsp' or 'DGSS-RH'){
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
                
                 
                  
    <!-- START CONTENT FRAME -->
                <div class="content-frame">                                    
                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">                        
                        <div class="page-title">                    
                            <h2><span class="fa fa-envelope"></span> Messagerie sirhsp </h2>
                        </div>                                                                                
                        
                                              
                    </div>
                    <!-- END CONTENT FRAME TOP -->
                    
                    <!-- START CONTENT FRAME LEFT -->
                    <div class="content-frame-left">
                        <div class="block">
                            <a href="nouv_mess.php" class="btn btn-info btn-block btn-lg"><span class="fa fa-edit"></span> Nouveau message</a>
                        </div>
                       <div class="block">
                            <div class="list-group border-bottom">
                                <a href="message.php" class="list-group-item active"><span class="fa fa-inbox"></span> Boite de réception <span class="badge badge-success"></span></a>
                                 <a href="mess_env.php" class="list-group-item"><span class="fa fa-rocket"></span> Messages envoyés</a>
                                  <a href="mess_supp.php" class="list-group-item"><span class="fa fa-trash-o"></span> Messages supprimer <span class="badge badge-default"></span></a>                            
                            </div>                        
                        </div>
                      
                    </div>
                    <!-- END CONTENT FRAME LEFT -->
                    
                    <!-- START CONTENT FRAME BODY -->
                    <div class="content-frame-body">
                        <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    <h3 class="panel-title"> Messages supprimer </h3>
                                                                   
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable table-striped">
                                        <thead>
                                            <tr>
											
											<th>personne</th>
												<th>objet </th>
												 <th>Date réçu message</th>
										
                                                   <th>message</th>
												      <th>date suprime</th>
                                               
											
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
									
										$messaages=Message :: trouve_tous_supp_des($user);
							foreach($messaages as $message){
										
									
										
									
								?>
                                             <tr  style=" font-weight:bold" id="<?php echo $message->id_mess; ?>">
										
										
									
									
										 <td> De : <?php $personne = Personne:: trouve_par_id($message->id_expediteur ); echo html_entity_decode($personne->nom_compler()); ?></td>
											
											<td><span style="color:blue"><?php echo html_entity_decode($message->objet); ?></td>
										     <td style="color:green"><span class=""><?php echo  html_entity_decode($message->dat_env); ?></span></td>
											<td><span style=""><?php echo html_entity_decode($message->message); ?></td>
									<td>
										 <span style="color:red"><?php echo html_entity_decode($message->date_supp_des); ?>	</td>
										 
                                    </tr>
                                   <?php
								}
                                 ?>  




                               <?php
										
										$messaages=Message :: trouve_tous_supp_exp($user);
						     	foreach($messaages as $message){
										
									
								  ?>
                                             <tr  style=" font-weight:bold" id="<?php echo $message->id_mess; ?>">
										
										
									
									
										 <td> à :<?php $personne = Personne:: trouve_par_id($message-> id_destinataire); echo html_entity_decode($personne->nom_compler()); ?></td>
											
											<td><span style="color:blue"><?php echo html_entity_decode($message->objet); ?></td>
										     <td style="color:green"><span class=""><?php echo  html_entity_decode($message->dat_env); ?></span></td>
											<td><span style=""><?php echo html_entity_decode($message->message); ?></td>
									<td>
										 <span style="color:red"><?php echo html_entity_decode($message->date_supp_exp); ?>	</td>
										 
                                    </tr>
                                   <?php
								}
                                 ?> 




								 </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    <!-- END CONTENT FRAME BODY -->
                </div>
                <!-- END CONTENT FRAME --> 
                          
                                    
                                    
                         
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
 
     
    <!-- END SCRIPTS -->           
    </body>
</html>




