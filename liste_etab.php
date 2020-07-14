<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur','umc');
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
	
	if(isset($_POST['submit'])){
	$errors = array();
	// new object document
		$etablissement = new etablissement();
	
	
	
	$edit->Nom_etab_fr = htmlentities(trim($_POST['Nom_etab_fr']));
	$edit->Nom_etab_ar = htmlentities(trim($_POST['Nom_etab_ar']));
	$edit->Add_etab_fr = htmlentities(trim($_POST['Add_etab_fr']));
	$edit->Add_etab_ar = htmlentities(trim($_POST['Add_etab_ar']));
	$edit->Num_tele_01 = htmlentities(trim($_POST['Num_tele_01']));
	$edit->Num_tele_02 = htmlentities(trim($_POST['Num_tele_02']));
	$edit->Num_fax = htmlentities(trim($_POST['Num_fax']));
	$edit->Add_mail_etab = htmlentities(trim($_POST['Add_mail_etab']));
	
	
	
	
	
	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit->save()){
		$msg_positif .= '<p style= "font-size: 20px; ">  Il a été mis à jour  ' . html_entity_decode($edit->Nom_etab_fr) .'    </p><br />';
														
														
		}else{
		$msg_system .= "<h1>Une erreur dans le programme ! </h1>
                  // <p class=\"error\" style= \"font-size: 20px; \" >  S'il vous plaît re- mise à jour à nouveau !!</p>";
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
$titre = " Ajouter Etablissement ";
$active_menu = "index";
$header = array('voiture');
if ($user->type =='administrateur' or 'umc'){
	require_once("composit/header.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Personne::not_admin();
}
?>

<?php 
			$SQL = $bd->requete("SELECT * FROM `etablissement` ");  
		 	$nbr_agence = mysqli_num_rows($SQL);
			 while    ($row = $bd->fetch_array($SQL))
								{
									$Nom_etab_fr = $row['Nom_etab_fr'];
									$Nom_etab_ar = $row['Nom_etab_ar'];
									$Add_etab_fr = $row['Add_etab_fr'];
									$Add_etab_ar = $row['Add_etab_ar'];
									$Num_tele_01 = $row['Num_tele_01'];
									$Num_tele_02 = $row['Num_tele_02'];
									$Num_fax = $row['Num_fax'];
									$Add_mail_etab = $row['Add_mail_etab'];
									
								}
			
		?>
		
		
<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">Etablissement </a></li>
                    <li class="active"><?php echo $titre ?></li>
                </ul>
                <!-- END BREADCRUMB -->
                <div class="page-title">                    
                    <h2>Ajouter Etablissement <span class="fa fa-plus-square"></span> </h2>
                </div>   
                <!-- PAGE CONTENT WRAPPER -->
                
						
						
						
				
                <!-- END PAGE CONTENT WRAPPER -->  
				
				
				<?php 
			$etablissment = Etablissement::trouve_tous();
		?>				
              <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Listes Des Etablissements </strong></h3>
									
                                        <ul class="panel-controls">
                                        <li><a href="" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>  

										
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable table-striped" style="background:#0f9a1a2e;color:#000">
                                        <thead>
                                            <tr>
                                                <th>ID Etablissements</th>
                                                <th>Nom Etablissements(FR)</th>
												<th>Nom Etablissements(AR)</th>
												<th>Mise à jour </th>
                                            </tr>
                                        </thead>
										<tbody>
										
									<?php
								foreach($etablissment as $etablissment){
									?>
                                        
                                            <tr id ="<?php echo html_entity_decode($etablissment->Id_etab); ?>"> 
											
                                                <td><?php echo html_entity_decode($etablissment->Id_etab); ?></td>
                                                <td><?php echo html_entity_decode($etablissment->Nom_etab_fr); ?></td>
                                                <td><?php echo html_entity_decode($etablissment->Nom_etab_ar); ?></td>
                                               
												<td>
												<a href="edit_etab.php?id=<?php echo $etablissment->Id_etab;?>"><button class="btn btn-info btn-rounded " style = "text-align: right;"><span class="fa fa-pencil"></span></button><a>
												
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






