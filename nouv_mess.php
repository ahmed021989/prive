<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'Admin_psd'  or 'Admin_psc'  or 'Admin_msprh');
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
	

	$dest=$_POST['id_destinataire'];
	//echo "<script>alert(".$dest.");</script>";
	if($dest[0]=="tous"){
		$pers=Personne::trouve_tous();
	foreach($pers as $pers) {
if($pers->type!="administrateur"){
	
	// new object document
	$message = new  Message();
	
	$message-> id_destinataire=$pers->id;
	
	$message-> objet = htmlspecialchars(trim(addslashes($_POST['objet'])));
	$message-> message = htmlspecialchars(trim(addslashes($_POST['message'])));
	

	$dat=date('Y-m-d  H:i');
	$message-> dat_env =$dat;
	$message->id_expediteur =$user->id;
    $message->message_supp=0;
	 
	 
	 if(!empty($_FILES)){

	
	
//var_dump($_FILES['lien_pdf']);
$fichier=$_FILES['lien_pdf']['name'];
$fichier_tmp=$_FILES['lien_pdf']['tmp_name'];
//$fich_exten=strchr($fichier,'.');
$extensions = array('.pdf', '.xls','.doc','xlsx','.docx','jpg' , 'jpeg' , 'gif' , 'png');
$extension = strrchr($fichier, '.'); 
//Début des vérifications de sécurité...
//if(in_array($extension,$extensions)){ //Si l'extension n'est pas dans le tableau

   
$dest='doc_pdf/'.$fichier;

     if( move_uploaded_file($fichier_tmp,$dest)){
	 $message-> lien_pdf = $fichier;
     
		
	 }
	
	 
	 
	 
	 if (empty($errors)){
   		$message->save();
 		  $msg_positif = '<p style= "font-size: 20px; ">  Votre message a été envoyé ...  <span class="fa fa-envelope"></span>    </p><br />';
		
		
 		 
 		}else{
		// errors occurred
		$msg_error = '<h3>  Erreur  !!??? </h3>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
	 
	
	 }
	 }
	}	
//******\\\\\	
	}
	
	
	else{
		for($i=0;$i<sizeof($dest);$i++) {
	
	
	// new object document
	$message = new  Message();
	
	$message-> id_destinataire= htmlspecialchars(trim(addslashes($dest[$i])));
	
	$message-> objet = htmlspecialchars(trim(addslashes($_POST['objet'])));
	$message-> message = htmlspecialchars(trim(addslashes($_POST['message'])));
	

	$dat=date('Y-m-d  H:i');
	$message-> dat_env =$dat;
	$message->id_expediteur =$user->id;
    $message->message_supp=0;
	 
	 
	 if(!empty($_FILES)){

	
	
//var_dump($_FILES['lien_pdf']);
$fichier=$_FILES['lien_pdf']['name'];
$fichier_tmp=$_FILES['lien_pdf']['tmp_name'];
//$fich_exten=strchr($fichier,'.');
$extensions = array('.pdf', '.xls','.doc','xlsx','.docx','jpg' , 'jpeg' , 'gif' , 'png');
$extension = strrchr($fichier, '.'); 
//Début des vérifications de sécurité...
//if(in_array($extension,$extensions)){ //Si l'extension n'est pas dans le tableau

   
$dest='doc_pdf/'.$fichier;

     if( move_uploaded_file($fichier_tmp,$dest)){
	 $message-> lien_pdf = $fichier;
     
		
	 }
	
	 
	 
	 
	 if (empty($errors)){
   		$message->save();
 		  $msg_positif = '<p style= "font-size: 20px; ">  Votre message a été envoyé ...  <span class="fa fa-envelope"></span>    </p><br />';
		
		
 		 
 		}else{
		// errors occurred
		$msg_error = '<h3>  Erreur  !!??? </h3>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
	 
	
	 }
		}
}
	}

?>
<?php
$titre = "Nouveau message";
$active_menu = "index";
$header = array('file','ckeditor');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'Admin_psd'  or 'Admin_psc'  or 'Admin_msprh' ){
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
                          <h2><span class="fa fa-envelope"></span> Messagerie SIRHSP </h2>
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
                                  <a href="mess_supp.php" class="list-group-item"><span class="fa fa-trash-o"></span> Messages Supprimer <span class="badge badge-default"></span></a>                            
                            </div>                        
                        </div>
                      
                    </div>
                    <!-- END CONTENT FRAME LEFT -->
                    
                    <!-- START CONTENT FRAME BODY -->
                    <div class="content-frame-body">
                        <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    <h3 class="panel-title"> Nouveau message</h3>
                                                                   
                                </div>
                                <div class="panel-body">
								
								  <?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										}elseif(!empty($msg_warn)){ 
											echo system_message($msg_warn);
										}
										?>
                               
                                       <form role="form" class="form-horizontal"   name="messagerie" id = "id" action="<?php echo $_SERVER['PHP_SELF']?>" method="post"  enctype="multipart/form-data">
                                           <div class="form-group">
                                               
                                               <div class="col-md-12 ">                                             
                                                  
                                                    <select class="form-control select" id="id_destinataire"   name="id_destinataire[]"   multiple="multiple" title="Selectioner un destinataire" required />
													
                                                       <?php
if($user->type=="administrateur"){
	echo "<option  value = 'tous' >tous</option>";
}
													   $SQL = $bd->requete("SELECT * FROM `personne` ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["id"].'" >'.$rows["nom"].' &nbsp '.$rows["prenom"].' / '.$rows["wilaya"].'</option>';
														}
														
														?>															
														</select>                                               
                                                 </div>
												
                                            </div>
											
											
											 <div class="form-group">
                                            
                                               <div class="col-md-12 col-xs-12">                                           
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa fa-archive"></span></span>
                                                        <input type="text" class="form-control" name ="objet" placeholder="Objet" required /  >
                                                    </div>                                            
                                                 </div>
											
                                            </div>
										
										
										   <textarea class="form-control" name ="message"  placeholder="MESSAGE" rows="10"  required ></textarea>
                                          
									
								  <br>
								   <div class="form-group">
                               
                                <div class="col-md-12">                                        
                                    <input type="file" class="file" name="lien_pdf"   data-filename-placement="inside"/>
                                </div>                                
                            </div>
							<br>
							
							
							

								  
								   <div class="form-group">
                                <div class="col-md-12">
                                   
                                    <div class="pull-right">
                                        <button class="btn btn-danger" type = "submit" name = "submit"><span class="fa fa-envelope"></span> Envoyé Message</button>
                                    </div>                                    
                                </div>
                            </div>
								  
								  
								  </form>
								  
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
		    <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <!-- END THIS PAGE PLUGINS -->       
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>   
<script>
$("#id_destinataire").on('change',function(){
			 var destinataire = [];
        $.each($("#id_destinataire option:selected"), function(){            
            destinataire.push($(this).val());
        });
		//alert(destinataire[0]);
		if(destinataire[0]=='tous'){

	// $('#diplome').selectpicker('refresh');
	var elements = document.getElementById("id_destinataire").options;
for(var i = 1; i < elements.length; ++i){
		//alert(elements[i]);
     elements[i].selected=false;

    }
	//document.getElementById('gp').style.visibility="visible";
	 $('#id_destinataire').selectpicker('refresh');
		}
		else{
		//document.getElementById('gp').style.visibility="hidden";	
		
		}
		
		 $('#id_destinataire').selectpicker('refresh');
		
		});

</script>		
        <!-- END TEMPLATE -->    

        <!-- START TEMPLATE -->
  
     
    <!-- END SCRIPTS -->           
    </body>
</html>




