<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' );
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

	// verification de données 	
	if (!isset($_POST['login'])||empty($_POST['login'])){
		$errors[]='Le champ login est vide';
		}
	
	if (isset($_POST['passe'])&& !empty($_POST['passe'])){
	    if($_POST['passe'] != $_POST['passe2']){
		 $errors[]=' errors confirmer mot de pass !!!';
			
		 
		}
		}
		/*if (!isset($_POST['nom'])||empty($_POST['nom'])){
		$errors[]='Le champ nom est vide';
		}
		
		if (!isset($_POST['prenom'])||empty($_POST['prenom'])){
		$errors[]='Le champ prenom est vide';
		}*/
		
		
		
	// new object document
	$util = new Personne();
	
	$util->login = htmlspecialchars(trim($_POST['login']));
 	$util->nom = htmlspecialchars(trim($_POST['nom']));
 	$util->prenom = htmlspecialchars(trim($_POST['prenom']));



	  $util->type = htmlspecialchars(trim($_POST['type']));

	$util->mot_passe = SHA1($_POST['passe']);
 	$util->id = NULL;
 	$util->personne_id = $util->id;
	$util->date_der = mysql_datetime();
	$util->mot_passe = SHA1($_POST['passe']);
	$util->cpt = ($_POST['passe']);
   
	  $util->wilaya = htmlspecialchars(trim($_POST['wilaya']));
	
	   
	if (empty($errors)){
   		if ($util->existe()) {
			$msg_error = '<p style= "font-size: 20px; ">  utilisateur "' . htmlspecialchars_decode($util->login) . '"  existe Déja !!!</p><br />';
			
		}else{
			$util->save();
 		  $msg_positif = '<p style= "font-size: 20px; ">   Le utilisateur " ' .htmlspecialchars_decode($util->login) .'"  est bien ajouter  </p><br />';
		
		}
 		
 		}else{
		// errors occurred
		$msg_error = '<h1> !! error  </h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
    }
?>
<?php
$titre = "Ajouter Utilisateur";
$active_menu = "index";
$header = array('file','ckeditor');
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
                    <h2><span class="fa fa-plus-square"></span>  Ajouter Utilisateur  </h2>
                </div>   
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap"  >
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                           <form class="form-horizontal" role="form"  name="ajouter_util"   id = "ajouter_util"  action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
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
	                                     <label class="col-md-3 col-xs-12 control-label">Type  d'utilisteurs</label>
                                        <div class="col-md-6 col-xs-12" >     
										
                                            <select id='type' class="form-control select"required name="type" onchange="desactive();"  >
                                                <option value = "">Selectionner un Type</option>
	                                        <option value="administrateur" >Administrateur MSPRH</option>
                                            <option value="Admin_dsp" >Admin Dsp</option>
											 <option value="DGSS-RH" >DGSS-RH</option>
										
                                               
                                            </select> 
                                        </div>
			
                                    </div>
									
									<div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label">Wilaya</label>	    
                                          <div class="col-md-6 col-xs-12">                                                                                            
                                              
												<select class="form-control " id="wilaya"  name="wilaya" data-live-search="true" required>
															 <option value = "">Selectionner  wilaya </option>
														<?php $SQL = $bd->requete("SELECT * FROM `wilayas` ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["nom"].'" >'.$rows["nom"].'</option>';
														}
														
														?>															   	
                                                   </select>														   
														
                                                 
													
                                                </div>                                           
                                        </div>
								
                                    
                                    <div class="form-group"  style = "text-align: right;">
									 <label class="col-md-3 col-xs-12 control-label"> Logine : </label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name ="login" class="form-control"  required  />
                                            </div>                                            
                                        </div>
                                      
                                    </div>
                                    
                                    <div class="form-group"> 

                                       <label class="col-md-3 col-xs-12 control-label">Mot de passe</label>  									
                                        <div class="col-md-6 col-xs-12">
										
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                <input type="password" id="pass" name="passe" class="form-control"required  />
                                            </div> <button type="button" id="gener" onclick="generer();">Generer</button>            
                                        </div>
                                        
                                    </div>     
									<div class="form-group">   

                                      <label class="col-md-3 col-xs-12 control-label">Comfirmer le mot de passe</label>									
                                        <div class="col-md-6 col-xs-12">
								     	

                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                <input type="password"id="pass2" name="passe2" class="form-control"required  />
                                            </div>            
                                        </div>
                                    </div>
									
									<div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label">Nom </label>	    
                                        <div class="col-md-6 col-xs-12">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="nom" class="form-control"   />
                                            </div>                                            
                                        </div>
										
                                    </div>
									
									<div class="form-group" style ="dir:rtl;" >
									
									 <label class="col-md-3 control-label">Prenom </label>	
                                        <div class="col-md-6 col-xs-12"> 
										
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="prenom" class="form-control"   />
                                            </div>                                            
                                          
                                        </div>
										
                                    </div>
								
                                  
                                    
                                 
                                   
							
                                  
                                </div>
                              <div class="panel-footer">
								
								    <button class="btn btn-info pull-right"" type = "submit" name = "submit">Ajouter</button>  
                                    <a href="liste_util.php" class="btn btn-danger ">Retour</a> 
									
                                    
                                    
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                  
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                          
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
<script>
function select_commune(){
			
	var poste=document.getElementById('wilaya_nais').value;
	//alert(post);

tabl = new Array();

	$.ajax({
	method:"post",
	url:"ajax_commune.php",
	data: {poste:post},
	success:function(resultData){
	tabl=resultData.split('|');
	//alert(tabl);
$('#wilaya').empty();
	 for(i=0;i<tabl.length;i++){
		// alert(tabl[i]);
		 if(tabl[i]!=''){
//alert(tabl[i]);
		$("#wilaya").append(new Option(tabl[i],tabl[i])); 
		
		 }
	
		
	 }

		
	}
	
	})
	
}


function desactive(){
	var util=document.getElementById('type').value;
	
	if(util=='administrateur' | util=='DGSS-RH'){
		
		//var wilaya=document.getElementById('wilaya');
		//alert(wilaya);
		//$('#wilaya').append(new Option('msprh','msprh');
		document.getElementById('wilaya').options.length=0;
		//$("#wilaya").empty().append('whatever');
		$("#wilaya").append(new Option('MSPRH','MSPRH'));
		//$("#wilaya").attr('readonly', 'readonly');
		//alert(document.getElementById('wilaya').value);
		//document.getElementById('wilaya').style.display="none";
	}
	else{
		var wilaya= document.getElementById('wilaya').value;
	if(util=='Admin_dsp' && wilaya=="MSPRH"){	
	
	document.getElementById('wilaya').options.length=0;	
	document.location.href="ajouter_util.php";
	}
	}
}


function generer(){
   var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var string_length = 8;
        var randomstring = '';
        for (var i=0; i<string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum,rnum+1);
        }
document.getElementById('pass').value=randomstring;
document.getElementById('pass2').value=randomstring;

}



</script>		
        <!-- END TEMPLATE -->         
    </body>
</html>




