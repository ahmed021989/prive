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
if ((isset($_GET['id_employe'])) && (is_numeric($_GET['id_employe'])) ) {
$id = $_GET['id_employe'];
$employ=Employe::trouve_par_id($id);
if($employ->archive==2){
	echo "<script>alert('employé déja en fin de contrat');window.close();</script>";
}
}


	if(isset($_POST['submit123'])){
	$errors = array();
	
	
	
	
	
	$employer=Employe:: trouve_par_id($_GET['id_employe']);

	// new object document
	$fin_relation = new  Fin_relation();

	$fin_relation-> date_fine= htmlspecialchars(trim(addslashes($_POST['date_fine'])));
	
	$fin_relation-> id_emp = ($_GET['id_employe']);
	$fin_relation-> commune_installation = $employer->commune_installation;
	$fin_relation-> adrs = $employer->adrs;
	$fin_relation-> type_etablissement = $employer->type_etablissement;
	$fin_relation-> identite_jurdique = $employer->identite_jurdique;
	$fin_relation-> numero_agriment = $employer->numero_agriment;
	$fin_relation-> date_agriment = $employer->date_agriment;
	$fin_relation-> date_instal = $employer->date_instal;
	$fin_relation-> date_creation = $employer->date_creation;
		$fin_relation-> diplome = $employer->diplome;
	$fin_relation-> specialite = $employer->specialite;
	
	
		
	
	
	
	
	
	
  if (empty($errors)){
   		
		if ($fin_relation->save()){
			$sql=$bd->requete("update employer set archive=2 where id_employe=".$_GET['id_employe']."");

$employer1=Employe:: trouve_par_type($_GET['id_employe']);
	foreach ($employer1 as $employer1) {
	$fin_relation = new  Fin_relation();

	$fin_relation-> date_fine= $_POST['date_fine'];
	
	$fin_relation-> id_emp = $employer1->id_employe;
	$fin_relation-> commune_installation = $employer1->commune_installation;
	$fin_relation-> adrs = $employer1->adrs;
	$fin_relation-> type_etablissement = $employer1->type_etablissement;
	$fin_relation-> identite_jurdique = $employer1->identite_jurdique;
	$fin_relation-> numero_agriment = $employer1->numero_agriment;
	$fin_relation-> date_agriment = $employer1->date_agriment;
	$fin_relation-> date_instal = $employer1->date_instal;
	$fin_relation-> date_creation = $employer1->date_creation;
	
		$fin_relation-> diplome = $employer1->diplome;
	$fin_relation-> specialite = $employer1->specialite;
	
	$fin_relation->save();
			$sql=$bd->requete("update employer set archive=2 where id_employe=".$employer->id_employe."");
	}
	
			
		 $msg_positif = '<p style= "font-size: 20px; ">   fin  de contrat"  ' .html_entity_decode($fin_relation->date_fine) . '  " est bien ajouter  </p><br />';
		
		echo "<script>alert('fin de contrat est bien ajouter  . '); window.close();</script>";
 		// readresser_a("liste_employe.php");
 			}else{
		// errors occurred
		$msg_error = '<h3>  Erreur  !!??? </h3>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
	
}} 




?>
<?php
$titre = "Fin de contrat";
$active_menu = "index";
$header = array('fin_relation');
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
                
                 
                <!-- PAGE CONTENT WRAPPER -->
                
                 
                  
					
                        <div class="col-md-12">
                            
                           <form class="form-horizontal" role="form"  name="fin_relation"  id = "fin_relation"  action="<?php echo $_SERVER['PHP_SELF']."?id_employe=".$_GET['id_employe']; ?>" method="post">
                            <div class="panel panel-default">
                            <div class="panel-body">
                              <?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
                                        
						<div class='row' style="border:1px solid red">          

						
						<div class="panel-body">                                                                        
                                    
                                 
								 
								 
								 
                                            
                                            
                                           <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">DATE FIN CONTRAT : </label>
                                               <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="date" class="form-control" name ="date_fine" id ="date_fine" onkeyup='return verif(event);' onkeypress='return verif(event);' required / >
                                                    </div>                                            
                                                 </div>
												
                                            </div>
											
											
												
												
												
                                            </div>
                                              
                                     

                                </div>
						
						
						
						
						
						
						
									</div>	
										
								
									
									
                                        
                     

                              <div class="panel-footer">
								
								    <button   class="btn btn-info pull-right" type = "button" name = "submit1" onClick="verfi_fin();" >Fin contrat</button>  
                                
                                    
                                    
                                </div>
                            </div>
							<div class="message-box animated fadeIn"  data-sound="alert" id="mb-relation">
           <br><br><br><br>
		  <br><br><br><br>
		  <br><br><br><br>
                <div class="mb-middle col-sm-8 col-sm-offset-2" style="background:#000;color:#fff; box-shadow: 10px 10px 10px #333;border-raduis:10px">
				<br>
                    <div class="mb-title" style="font-size:24px"><span class="fa fa-archive"></span>  Fin ou Changement Type de Contrat  </div>
                    <center><div class="mb-content">
                      <table>
<tr>					  
                        <td style="text-align:right"><h4 style="color:#fff;"> Fermeture structure Appuyez  </h4></td><td> <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" id='submit' name="submit123" class="fa fa-check btn-sm" style="border:0;font-size:15px;background:green" data-dismiss="modal"></button></p><br></td> 
 </tr>
 <br>
 <?php $sql=$bd->requete("select * from employer where type_employe=".$_GET['id_employe']."");
$nbr = mysqli_num_rows($sql); 
if($nbr>0){
?>
<tr>
						 <td style="text-align:right"><h4 style="color:#fff;"> Choix d'un Gérant parmi les employés de la structure </h4></td><td><p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id='btn' class="fa fa-check btn-sm" style="border:0;font-size:15px;background:#ff6a00 " data-dismiss="modal" name="btn" onClick="change_gerant();" > </button></p><br></td> 
 </tr>
<?php } ?>
 <br>
<tr>
						  <td style="text-align:right"><h4 style="color:#fff;"> Nouveau Gérant de la structure Appuyez  </h4></td><td> <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" onClick="trouve_id(<?php echo $_GET['id_employe'];?>)"  id='btn' class="fa fa-check btn-sm" style="border:0;font-size:15px;background:#36c1f7" data-dismiss="modal" name="btn" > </button>  </p></td>     

 </tr>
 </table>
                    </div></center>
                    <div class="mb-footer">
                        <div class="pull-right">
                          <center>      
<script>  dt=document.getElementById('date_fine'); </script>						  
            
			</center>
                        </div>
                    </div>
                </div>
          
        </div>
		
		
		
		
				<div class="message-box animated fadeIn"  data-sound="fail" id="mb-change" style="background:#fff;">
           <div class="pull-right">
						<div>
						<br><br>
                           <button class="btn btn-danger fa fa-times btn-lg mb-control-close" onClick="fermer();"></button> 
						   </div>
                        </div>
						<br><br>
                
								
                                <div class="panel-body">
								
						<div  class="scrollable0" id="scrol" >                                   
								   <table id="table1" class="table  datatable table-striped" style="Maw-width:none !important;direction:rtl;text-align:left" >
										
                                        <thead>
                                            <tr>
										
													   <th>Gérant</th>
													    <th>Diplome</th>
														
															<th>sexe</th>
															<th>Date de naissance</th>
															<th>Prenom d'employer </th>
															 <th>Nom d'employer </th>
															  <th>Numéro  </th>
                                               
                                               
                                            </tr>
                                        </thead>
										 <tbody>
<?php  $employer=Employe::trouve_par_type($_GET['id_employe'])  ;
foreach ($employer as $employer) {
$i1=1;
?>										 
												
													<tr style="font-weight:bold" id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>"> 
											<td style="background:#fff">
											 <button style="font-size:20px" id="<?php echo $employer->id_employe;?>"  class=" btn btn-info fa fa-user
" data-toggle="tooltip" title="choisi cet Gérant  " onClick="gerant(<?php echo $employer->id_employe; ?>);"> choisi cet Gérant </button> &nbsp &nbsp
	
											
												</td>	
												 <td><?php echo stripcslashes(htmlspecialchars_decode($employer->identite_jurdique)); ?></td> 
											<td><?php
												if($etablissement=Etablissement::trouve_par_id($employer->type_etablissement))
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
											<td><?php
												if($commune2=Communes::trouve_par_code_postal($employer->commune_installation))
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
											
											
                                            <td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
											<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>

											<td><?php echo $i1;?></td>	
											</tr>
							
						<?php
						++$i1;}
						
						?>
						
						<tbody></table>        



  </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                          <center>            
          
			</center>
                        </div>
                    </div>
                
		


							
                            </form>
                            
                       
                                   
                 
				  
                </div>
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
  function verif(e){
	 if(e.keyCode === 13){
return false;
	 } 
  }
 $('.form-horizontal').bind('keyup keypress', function(e) {
	alert('hhh');
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});

  
  function verfi_fin(){
	  var date_fine=document.getElementById('date_fine').value;
	
	  if(!date_fine){
	  document.getElementById('date_fine').style.background='red';
	  document.getElementById('date_fine').style.color='#fff';
	  }else{ $('#mb-relation').show();  }
	  
	  
	  
	  
  }  
  
  
  function change_gerant(){
	
	   $('#mb-change').show(); 
	   
	   $('#mb-relation').hide(); 
	   }
	   
	   function trouve_id(id){
	   var dt=document.getElementById('date_fine').value;
	  // alert(id);
	   location.href="ajouter_nouveau_gerant.php?id_employe="+id+"|"+dt+"";
	   }
	   
	  function fermer(){
			 	$('#mb-change').hide();  
		  }
	  
function gerant(id){
	 var date_fine=document.getElementById('date_fine').value;
	
	$.ajax({
	method:"post",
	url:"ajax_gerant.php",
	data: {id:id,date_fine:date_fine},
	success:function(resultData){
		alert(resultData);
		$('#mb-change').hide();
		window.location.replace("liste_employe.php");
	}
	
		});
	
	
	
	
	
}	  
	  
  
  
  
  
  
  
  
  
  
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




