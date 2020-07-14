<?php
require_once("includes/initialiser.php");
ini_set('max_execution_time', 0); 
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp'  or 'DGSS-RH');
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
$titre = "Densite";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
	
}

?>

 <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>                    
                    <li class="active">Tableau de bord > Etat densite</li>
                </ul>
                <!-- END BREADCRUMB -->                       
             <?php if  ($user->type == 'administrateur' or $user->type=="DGSS-RH")   {  ?>   
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                      <!-- START WIDGETS -->                    
                   
					
					

                    <!-- END WIDGETS -->                    

					<?php 
			
		?>				
               <div class="page-content-wrap">                
                <br>
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Etat Densité </strong></h3>
								
                                    <ul class="panel-controls">

                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    
										
                                    </ul>                                
                                </div>
								<!-- DEBUT FORM-->
								 <form class="form-horizontal" role="form"  name="liste_employe"   id = "liste_employe"  action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
								
								<div class="row">
							
								<div class="col-md-4 ">
								<b style="color:blue"></b>
								
								<select  class="select" data-live-search="true" id="wilaya" name="wilaya[]" multiple="multiple" title="Selectioner Wilayas" >
							
									<option   value='tous'>tous les wilayas</option>
								   <?php 
									$wilayas=Wilayas::trouve_tous();
									foreach($wilayas as $wilaya){
										?>
										
									<option id="<?php echo $wilaya->id_w; ?>" value='<?php echo $wilaya->id_w; ?>'><?php echo $wilaya->nom;  ?></option>	
										
									<?php }?>
								</select>
								</div>
								<div class="col-md-4">
							
								<B style="color:blue"></B><select  class=" select" data-live-search="true" id="specialite" name="specialite[]" multiple="multiple" title="Selectioner spécialités">
							
									<option   value='tous'>tous les spécialités</option>
								 <?php 
									$sql=$bd->requete('select * from specialite order by nom_specialite');
									while($row=$bd->fetch_array($sql)){
										?>
										
									<option id="<?php echo $row['id_specialite']; ?>" value='<?php echo $row['id_specialite']; ?>'><?php echo $row['nom_specialite'];  ?></option>	
										
									<?php }?>
								</select>
							
								</div>	
								<div class="col-md-2">
								<button type="submit" name="submit" style="border-radius:10px;background:#20820d" class="btn btn-success btn-lg fa fa-search pull-right" onClick="return tester();" > afficher</button>

								</div>
														

								</div> <!--FIN row>-->
								<br>
								<!--FIN select pour taille de filtrage>-->
								
								
								</div>
								</form>
								<!--FIN FORM-->
								</br>
								<hr>
								
								<?php 
							
								//CREATION DE LA FOUNCTION FILTRE
								function filtre($taille,$user,$wilaya,$specialite){
									
									$specialites=Specialite::trouve_specialite($specialite);
									
									
									
											
//******************************											
	
	
	//*********************************											
	$w='';									
if($wilaya[0]!="tous"){
	$wilay=Wilayas::trouve_par_id($wilaya[0]);
		
		$w.=''.htmlspecialchars(trim($wilay->nom)).'"';
} 
if($wilaya[0]=="tous"){
		$w.="tous";
		
}

if(sizeof($wilaya)>1){
		for($i=1;$i<sizeof($wilaya);$i++){
			$wilay=Wilayas::trouve_par_id($wilaya[$i]);
			$w.=' et '.htmlspecialchars(trim($wilay->nom)).'"';
		}
	}

	
									?>
							
                                <div class="panel-body">
								<center><label class="alert alert-success" id="liste" style="font-size:12px;background:#14de29"><span class='pull-left'>Etat pour  </span><?php echo " wilaya :<span style='color:blue'>".$w."</span>"; ?>
							<?php if($user->type!="DGSS-RH"){?>	
						<a  href='export_densite.php?var=<?php  foreach($specialite as $ss){ echo $ss.",";} echo "|" ; foreach($wilaya as $ww) { echo $ww.",";}  ?>' class='btn btn-danger pull-right' ><img width="20" src="img/icons/xls.png"> Export excel</a>
							<?php }?>
						</label>
								</center>
						<div  class="scrollable" id="scrol" >                                   
								 <table id="table00" class="table table-striped" style="background:#0f9a1a2e;color:#000;">
	
                                        <thead>
                                            <tr>
                                              
													  
													    <th>Wilaya</th>
													    <th>Population</th>
								<?php
								foreach($specialites as $specialite){
								?>
								<th><?php echo $specialite->nom_specialite; ?></th>	
								<?php }?>		
												
											     
                                            </tr>
                                        </thead>
										 <tbody>
										
										<?php 
									
										if($w=="tous"){
											
											for($i=1;$i<49; $i++){ 
										$wila=Wilayas::trouve_par_id($i);
										?>
										 <tr>	
											<td><?php echo $wila->nom;?></td>
											<td style="text-align:right"><?php echo number_format($wila->pop_wil,0,'',' ');?></td>
											<?php 
												foreach($specialites as $specialite){
													global $bd;
													$employer = Employe::trouve_par_specialite($specialite->id_specialite,$wila->id_w);
														$sql1=$bd->requete("select count(*) as sum from employer WHERE specialite=".$specialite->id_specialite." and wilaya=".$wila->id_w ." and archive=0");
										while($row=mysqli_fetch_array($sql1)){
												echo "<td style='text-align:right'>".$row['sum']."</td>";
										}
										 }
												
												
											?>
											</tr>
										<?php }
											
										}
										else{
										foreach($wilaya as $ww){ 
										$wila=Wilayas::trouve_par_id($ww);
										?>
										 <tr>	
											<td><?php echo $wila->nom;?></td>
											<td style="text-align:right"><?php echo number_format($wila->pop_wil,0,'',' ');?></td>
											<?php 
												foreach($specialites as $specialite){
													global $bd;
													if($employer = Employe::trouve_par_specialite($specialite->id_specialite,$ww));
																	$sql1=$bd->requete("select count(*) as sum from employer WHERE specialite=".$specialite->id_specialite." and wilaya=".$ww ." and archive=0");
										while($row=mysqli_fetch_array($sql1)){
												echo "<td style='text-align:right'>".$row['sum']."</td>";
										}
													
													//$result = $employer->count_specialite($specialite->id_specialite,$ww);
?>													
											
											
												<?php 
												
												}
											?>
											</tr>
										<?php }
										}


										?>
										
							
								
                          
										
									
																 
                                        </tbody>
										
                                    </table>
									<br>
									<!--<h4 class="alert alert-success">Nombre total :<span ><?php// echo  $total;  ?></span></h4>
										
									</div>
									
									
<?php }

if(isset($_POST['submit'])){
	
	
	
	$wilaya="";
	if(empty($_POST['wilaya'])){
	$wilaya="tous";	
	}
	else{ $wilaya= ($_POST['wilaya']) ;}
	$specialite="";
	if(empty($_POST['specialite'])){
	$specialite="tous";	
	}
	else{ $specialite= ($_POST['specialite']) ;}
	
	if( $wilaya!="tous" && $specialite!="tous" ){
		if( !empty($_POST['wilaya']) && !empty($_POST['specialite'])){
	filtre(0,$user,$wilaya,$specialite);
		}else {}					
 } else {
	if( !empty($_POST['specialite']) &&  !empty($_POST['wilaya'])){
	filtre(100,$user,"tous","tous","tous");
			}
	 
}

}
	?>
                                </div>
                            </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
                </div>
				  
				  
                    				  
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
                <!-- END PAGE CONTENT WRAPPER -->                                                
                  
            <!-- ************************************************************************ -->
     	
		<?php }   else if ($user->type == 'Admin_dsp')  {  

		?>
		       		              
                    
                            		  <?php 
			
			$wilaya=Wilayas::trouve_par_Nom($user->wilaya);
		?>				
               <div class="page-content-wrap"> 


   <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                      <!-- START WIDGETS -->                    
                  
					
					

                    <!-- END WIDGETS -->  




               
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Etat numérique par spécialité</strong></h3>
								
                                    <ul class="panel-controls">

                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    
										
                                    </ul>                                
                                </div>
								<!-- DEBUT FORM-->
									<!-- DEBUT FORM-->
								 <form class="form-horizontal" role="form"  name="liste_employe"   id = "liste_employe"  action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
								
								<div class="row">
							
								<div class="col-md-6 ">
								<b style="color:blue"></b>
								
								<select  class="btn btn-info select" data-live-search="true" id="commune" name="commune[]" multiple="multiple" title="Selectioner communes" >
							
									<option   value='tous'>tous les communes</option>
								   <?php 
									$communes=Communes::trouve_tous_wilaya($wilaya->id_w);
									foreach($communes as $commune){
										?>
										
									<option id="<?php echo $commune->id_com; ?>" value='<?php echo $commune->code_postal; ?>'><?php echo $commune->nom_com;  ?></option>	
										
									<?php }?>
								</select>
								</div>
								<div class="col-md-4">
							
								<B style="color:blue"></B><select  class="btn btn-info select" data-live-search="true" id="specialite" name="specialite[]" multiple="multiple" title="Selectioner spécialités">
							
									<option   value='tous'>tous les spécialités</option>
								 <?php 
									$sql=$bd->requete('select * from specialite order by nom_specialite');
									while($row=$bd->fetch_array($sql)){
										?>
										
									<option id="<?php echo $row['id_specialite']; ?>" value='<?php echo $row['id_specialite']; ?>'><?php echo $row['nom_specialite'];  ?></option>	
										
									<?php }?>
								</select>
							
								</div>
					<div class="col-md-2">								
									<button type="submit" name="submit2" class="btn btn-info btn-lg fa fa-search pull-right"  > afficher</button>
							</div>	

								</div> <!--FIN row>-->
								<br>
								<!--FIN select pour taille de filtrage>-->
								
								
								</div>
								</form>
								<!--FIN FORM-->
								</br>
								<hr>
								
								<?php 
								//CREATION DE LA FOUNCTION FILTRE
								function filtre2($taille,$user,$wilaya,$commune,$specialite){
								
								$specialites=Specialite::trouve_specialite($specialite);
							
										
									
									
											
//******************************											
	
	//*********************************											
	$com='';									
if($commune[0]!="tous"){
	$comm=Communes::trouve_par_id($commune[0]);
		
		$com.=''.htmlspecialchars(trim($comm->nom_com)).'"';
} 
if($commune[0]=="tous"){
		$com.="tous";
		
}

if(sizeof($commune)>1){
		for($i=1;$i<sizeof($commune);$i++){
			$comm=Communes::trouve_par_id($commune[$i]);
			$com.=' et '.htmlspecialchars(trim($comm->nom_com)).'"';
		}
	}

	

	
									?>
							
                                <div class="panel-body">
								
						<div  class="scrollable0" id="scrol" >    
<center><label class="alert alert-success" id="liste" style="font-size:12px;background:#0D9E1C"><span class='pull-left'>Etat numérique pour  </span><?php echo " communes :<span style='color:blue'>".$com."</span>"; ?>
								</label>

								</center>						
								   <table id="table1" class="table datatable table-striped" style="background:#0f9a1a2e;color:#000;font-weight:bold">
										
                                        <thead>
                                            <tr>
                                              
													    <th>Specialite</th>
													    <th>Nbre</th>
														<th>Homme</th>
														<th>Femme</th>
														<th><25 Ans</th>
														<th>25-34</th>
														<th>35-44</th>
														<th>45-54</th>
														<th>55-64</th>
														<th>>65 Ans</th>
													
													 
															
                                               
                                               
												
												
												
											
                                               
												
												
												
												  
												

												
                                                
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									$total=0;
									
								foreach($specialites as $specialite){
									
									if($employer = Employe::trouve_par_specialite_dsp($specialite->id_specialite,$wilaya,$commune)){
										$result=$employer->count_specialite_dsp_interval_age($specialite->id_specialite,$wilaya,$commune);
									?>
									<tr>
									<td><?php echo $specialite->nom_specialite;   ?></td>
										<td style="text-align:right"><?php echo number_format($result[8], 0, ',', ' '); 
										//$total+= $employer->count_specialite_dsp($specialite->id_specialite,$wilaya,$commune); 
										?></td>
										
										<td style="text-align:right"><?php echo number_format($result[6], 0, ',', ' '); ?></td>
										<td style="text-align:right"><?php echo number_format($result[7], 0, ',', ' '); ?></td>
										
										<td style="text-align:right"><?php echo number_format($result[0], 0, ',', ' '); ?></td>
										<td style="text-align:right"><?php echo number_format($result[1], 0, ',', ' '); ?></td>
										<td style="text-align:right"><?php echo number_format($result[2], 0, ',', ' '); ?></td>
										<td style="text-align:right"><?php echo number_format($result[3], 0, ',', ' '); ?></td>
										<td style="text-align:right"><?php echo number_format($result[4], 0, ',', ' '); ?></td>
										<td style="text-align:right"><?php echo number_format($result[5], 0, ',', ' '); ?></td>	
									</tr>
									
									
									
									
								

								<?php 
								}else{ ?>
								<tr>
									<td><?php echo $specialite->nom_specialite;   ?></td>
										<td style="text-align:right">0</td>
										
										<td style="text-align:right">0</td> 
										<td style="text-align:right">0</td>
										<td style="text-align:right">0</td>
										<td style="text-align:right">0</td>
										<td style="text-align:right">0</td> 
										<td style="text-align:right">0</td>
										<td style="text-align:right">0</td>
										<td style="text-align:right">0</td>
										
									</tr>
								<?php } }
								
                                 ?> 
										
									
																 
                                        </tbody>
										
                                    </table>
									<br>
									<!--<h4 class="alert alert-success">Nombre total :<span ><?php //echo  $total;  ?></span></h4>
										
									</div>
									
									
<?php }
                                 ?>  
                                        </tbody>
                                   
									<?php 
									


		

	if(isset($_POST['submit2'])){
	
	$commune="";
	if(empty($_POST['commune'])){
	$commune="tous";	
	}
	else{ $commune= ($_POST['commune']) ;}
	$specialite="";
	if(empty($_POST['specialite'])){
	$specialite="tous";	
	}
	else{ $specialite= ($_POST['specialite']) ;}
	
	if( $commune!="tous" and $specialite!="tous"){
		if( !empty($_POST['commune']) && !empty($_POST['specialite'])){
		
$wilaya=Wilayas::trouve_par_Nom($user->wilaya);
	
	filtre2(0,$user,$wilaya->id_w,$_POST['commune'],$specialite);
	
		}else {}	
	
	
	
							
 
	}
	

		}
		
		
	?>

									 </div>		
                               
                            </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
                </div>
				  

				  
                </div>
                <!-- END PAGE CONTENT WRAPPER -->    
                                            
		<?php  } ?>                                          
                     
            <!-- --------------------------------------------------------------------------- -->
     	
		       

                    
                    <!-- START DASHBOARD CHART -->
					<div class="chart-holder" id="dashboard-area-1" style="height: 200px;"></div>
					<div class="block-full-width">
                                                                       
                    </div>                    
                    <!-- END DASHBOARD CHART -->
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

          
        <!-- MESSAGE BOX-->
			
			<script>
			function affiche_box(){
			
        var box=document.getElementById('mb-affiche');
		
		box.style.display = "block";
		
		}
			
			
function change_message_per(){
        var message=document.getElementById('supr');
		message.innerHTML=" <b style='color:red'>Attention Procedure trés dangereuse et Irreversible</b><br><b style='color:red'> si vous supprimer cette employée toute les employées de cette structure seront supprimées</b>"
		}
		function change_message(){
        var message=document.getElementById('supr');
		message.innerText="Etes Vous Sure De Vouloir Supprimer Cette ligne";
		}
		
		
		
        </script>		
        <form class="form-horizontal" role="form"  name="ajouter_employer"   id = "ajouter_employer"  action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <!--MESSAGE BOX informations -->
        	
		<div class="message-box animated fadeIn" data-sound="alert" id="mb-affiche">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-alert"></span> Veillez Metre A Jour  Les Informations De Votre Compte  ??!!</div>
                    <div class="mb-content">
                        <h3><div id="mise_a_ajour"></div> </h3>                 
                        
                       Nom  <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="nom_user" class="form-control" placeholder="EN MAJUSCULE" required  />
                                            </div><br />
                                            <!-- prenom -->
                                           Prenom <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="prenom_user" class="form-control" placeholder="EN MAJUSCULE" required  />
                                            </div><br />
                                            <!--  telephone  -->
                                            Mobile<div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                                                <input type="text" name="telephone_user" class="form-control" placeholder="EN MAJUSCULE" required  />
                                            </div>
                                            
                                            
                                            
                        <h3><p>Remplir Puis Appuyez Sur <strong>Continué </strong> </p></h3>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="oui-ok" class="btn btn-success ">Continué</button>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        
        <!--FIN MESSAGE BOX Information-->
        <?php
			function TexteUnicode($texte){
$tab1 = array("à","è","é","ê","ù","»","«","°","œ","oeil");
$tab2 = array("&agrave;","&egrave;","&eacute;","&ecirc;","&ugrave;","&raquo;","&laquo;","&deg;","œ","œil");
$texte = str_replace($tab1,$tab2,$texte);
return $texte;
}		
?>
		
		<div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-row">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-trash-o"></span> Supprimer <strong> les données </strong> ??!!</div>
                    <div class="mb-content">
                        <h3><div id="supr"></div> </h3>                   
                        <h3><p>Appuyez sur Oui si vous sûr</p></h3>
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
		
		
		<div class="message-box animated fadeIn" data-sound="alert" id="mb-transfert">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-trash-o"></span> <label id="from_employer"> </label> <strong><label id="from_structure"></label></strong> ??!!</div>
                    <div class="mb-content">
                        <h3><div id="supr"></div> </h3>                   
                        <h3><p>Tranferer vers </p></h3>
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
		
		
		<script type="text/javascript" src="js/dataTables.fixedColumns.min.js"></script>
		
		<script>
		
	$("#specialite").on('change',function(){
			 var specialites = [];
        $.each($("#specialite option:selected"), function(){            
            specialites.push($(this).val());
        });

		if(specialites[0]=='tous'){

	var elements = document.getElementById("specialite").options;
for(var i = 1; i < elements.length; ++i){

     elements[i].selected=false;
	
    }
}
	 $('#specialite').selectpicker('refresh');
	});
	
	//#######################################
	$("#wilaya").on('change',function(){
			 var specialites = [];
        $.each($("#wilaya option:selected"), function(){            
            specialites.push($(this).val());
        });

		if(specialites[0]=='tous'){

	var elements = document.getElementById("wilaya").options;
for(var i = 1; i < elements.length; ++i){

     elements[i].selected=false;
	
    }
}
	 $('#wilaya').selectpicker('refresh');
	});
	
	//#######################################
		function tester(){
			var diplome=document.getElementById('diplome').value;
			var specialite=document.getElementById('specialite').value;
			var wilaya=document.getElementById('wilaya').value;
	
			if(wilaya.length==0){
			document.getElementById('wilaya').style.backgroundColor ="red";
			alert('selectioner ou moins une wilaya');
			return false;
		}
		
		}
		
		
	$(document).ready(function() {
		
		
		
	
		$('#table00').DataTable( {
    buttons: [
        'excel'
    ],
	  buttons: [
        {
            extend: 'excel',
            text: 'Save current page',
            exportOptions: {
                modifier: {
                    page: 'current'
                }
            }
        }
    ]
} );

		
    var table = $('#table0').DataTable( {
    order: [[ 12, "asc" ]],
        scrollX:        "200%",
       
        fixedColumns:   {
            leftColumns: 1,
            rightColumns: 1
        }
		
    } );
} );
//$("#scrol").scrollLeft(400);
</script>
        <script>// $(window).load(function() {  affiche_box();});</script>
             <style>
button[data-toggle="dropdown"].btn-success,
button[data-toggle="dropdown"] {
background-color: #0D9E1C !important;
color:#fff !important;
border: 2px solid #dce4ec;
}
 
   .scrollable {
      float: left !important;
      width: 100%;
      overflow-x: scroll !important ;
    
	  white-space: nowrap;
 
	  
    }

	  
 
	
	</style>
    

        <!-- END TEMPLATE -->      
    <!-- END SCRIPTS -->                   
    </body>
</html>
