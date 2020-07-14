<?php
require_once("includes/initialiser.php");
ini_set('max_execution_time', 0); 
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
$titre = "Listes des Controles";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or $user->type =='Admin_dsp'){
	require_once("composit/header.php");
	
}

?>

 <!-- START BREADCRUMB -->
               <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
					  <li><a href="index.php">Accueil</a></li>  
					  <li class="active"><?php echo $titre ?></li>  
                </ul>
                <!-- END BREADCRUMB -->                
                
                
                <!-- PAGE CONTENT WRAPPER -->
				
				
				<?php  if ($user->type=='administrateur'){ ?>	
                   <div class="page-content-wrap"  >
				   
				   
				   
				    <div class="row">
                        <div class="col-md-12">
                            
                           
                                                            
                                
<div class="panel panel-warning">
                                
                                <div class="panel-body">
                                <?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
										
			                
						
								
															
								        <form class="form-horizontal" name="filtre" id = "filtre" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <div class="panel panel-info">
				
				 <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong> Controle </strong></h3>
									
                                                                   
                                </div>
						    <div class="panel-body">                                                                        
                                     <div class="row">
									 
					
      
                      
					
									<div class="col-md-4 " style="width:250px !important">
								<b style="color:green"></b>
								
								<select  class="btn  select" data-live-search="true" id="wilaya" name="wilaya[]" multiple="multiple" title="Selectioner Wilayas" >
							
									<option   value='tous'>tous les wilayas</option>
								   <?php 
									$wilayas=Wilayas::trouve_tous();
									foreach($wilayas as $wilaya){
										?>
										
									<option id="<?php echo $wilaya->id_w; ?>" value='<?php echo $wilaya->id_w; ?>'><?php echo $wilaya->nom;  ?></option>	
										
									<?php }?>
								</select>
								
								</div>
						
						
							
					
											
                                <div class="panel-footer">
                                                                       
                                    <button class="btn btn-success pull-right" type = "submit"   name = "submit"  onClick="return tester();" > <span class="fa fa-search"></span> Recherche</button>
                                </div>
								 </div><!-- FIN ROW -->
								 </div>
								  </div>
						  </form>
						  	
						  
<?php 

function filtre($wilaya){
	if($wilaya[0]=='tous'){
		$w=' wilaya like "%"';
	}
	else{
	$w=' wilaya in(';
	for($i=0;$i<sizeof($wilaya);$i++){
		
		if($i==sizeof($wilaya)-1){
		$w=$w.$wilaya[$i].')';	
		}
		else{
		$w=$w.$wilaya[$i].',';	
		}
		
	}
	}
global $bd;

?>

							
                                <div  class="scrollable1" id="scrol">
                                    <table class="table datatable ">
                                        <thead>
                                            <tr>
                                                <th>Nom  </th> 
												<th>Prénom  </th>
												<th> Date Naissance </th>
												 <th>Commun Naissance  </th>
					                            <th>Diplome </th>
										        <th>Spécialité </th>
                                     
												  <th>Type d'établissement</th>
												
                                                <th>Mis à jour</th>
                                                
                                            </tr>
                                        </thead>
										 <tbody>
								
								<?php
									
									$SQL = $bd->requete("SELECT * FROM  `employer`    where  ".($w)."  and (`employer`.`archive`='0') and ((date_nais_employe='0000-00-00')  or (diplome=0) or (specialite=0) or (type_etablissement=0) )   ") ;
									
									
									while ($rows = $bd->fetch_array($SQL))
								{
									$id_employe=$rows['id_employe'];	
								$nom_employe=$rows['nom_employe'];
									$prenom_employe=$rows['prenom_employe'];
										$date_nais_employe=$rows['date_nais_employe'];
											//$commune_nais=$rows['commune_nais'];
											
								if ($com=Communes::trouve_par_code_postal($rows['commune_nais'])){
												$commune_nais=$com->nom_com;} else { $commune_nais='Vide'; }
												
												if($dip=Diplome::trouve_par_id($rows['diplome'])){
												$diplome=$dip->nom_diplome;	}else{$diplome='Vide';}
												
												if($specia=Specialite::trouve_par_id($rows['specialite'])){
												$specialite=$specia->nom_specialite;}else {$specialite='Vide';}
												
												if ($etab=Etablissement::trouve_par_id($rows['type_etablissement'])){
												$type_etablissement=$etab->type_etab;}else{$type_etablissement='Vide';} 
								
								                $type_employe=$rows['type_employe'];
								?>
								
                                      
                                    
                                            <tr  <?php  if($type_employe!=0 && $type_employe!=-1) { ?> style="background:#fff;"  <?php }else if ($type_employe==0){ ?> style="background:#0f9a1a2e;" <?php }else if ($type_employe==-1) { ?> style="background:#0f9a1a2e;" <?php } ?>      >
											
								  <td <?php if($nom_employe==''){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> >	<?php   if ($nom_employe=''){   echo 'vide' ;}else { echo html_entity_decode($rows['nom_employe']); } ?></td>
											<td <?php if($prenom_employe==''){?> style="background:red;color:#fff;text-align:center "  <?php } ?>><?php  if ($prenom_employe=''){ echo 'vide' ;}else {echo html_entity_decode($rows['prenom_employe']);} ?></td>
											 <td <?php if($date_nais_employe=='0000-00-00'){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> ><?php  echo html_entity_decode(($rows['date_nais_employe'])); ?></td>
											 
											    
												 <td <?php if($commune_nais=='Vide'){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> ><?php  echo html_entity_decode($commune_nais); ?></td>
												     <td <?php if($diplome=='Vide'){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> ><?php  echo html_entity_decode($diplome); ?></td>
												
										 <td <?php if($specialite=='Vide'){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> ><?php  echo html_entity_decode($specialite); ?></td>
										 
									
										  <td  <?php if($type_etablissement=='Vide'){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> ><?php  echo html_entity_decode($type_etablissement); ?></td>
                                      <?php if($type_employe!=0 && $type_employe!=-1){?>    
										  <td style="background:#0D9E1C">
											<div class="btn-group" >
											<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
                                            <ul class="dropdown-menu" role="menu" style="">
												
												
											<li> <a style="font-size:12px" href="edit_employer.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé"> Modifier</a></li>
												
												<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
												<li><a style="font-size:12px" onClick="delete_row('<?php echo $id_employe;?>');change_message();" target="_blank" data-toggle="tooltip" title="archivé l'employé">Classé</a></li>
														<li><a style="font-size:12px"   href="fin_relation_fis.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>				
											</ul>
											</div>
											</td>
											
									       <?php   } else if($type_employe==0){ ?> 
									  
									    <td style="background:#0D9E1C">
											<div class="btn-group" >
											<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
                                            <ul class="dropdown-menu" role="menu" style="">
										   <li><a style="font-size:12px" href="ajouter_autre_employe.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Ajouter autre employés a cette structure ">Ajouter</a></li>
											
											<li> <a style="font-size:12px" href="edit_employer.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé"> Modifier</a></li>
											<li><a style="font-size:12px"   href="transfere.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Transfère de locale">Transfère </a></li>
											<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
												<li><a style="font-size:12px" onClick="delete_row('<?php echo $id_employe;?>');change_message();" target="_blank" data-toggle="tooltip" title="archivé l'employé">Classé</a></li>
														<li><a style="font-size:12px"   href="fin_relation.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>				
											</ul>
											</div>
											</td>
										   <?php } else if($type_employe==-1){?>
									      <td style="background:#0D9E1C">
											<div class="btn-group" >
											<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
                                            <ul class="dropdown-menu" role="menu" style="">
										   <li><a style="font-size:12px" href="ajouter_autre_employe.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Ajouter autre employés a cette structure ">Ajouter</a></li>
											
											<li> <a style="font-size:12px" href="edit_employer_pere.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé"> Modifier</a></li>
											<li><a style="font-size:12px"   href="transfere.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Transfère de locale">Transfère </a></li>
											<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
												<li><a style="font-size:12px" onClick="delete_row('<?php echo $id_employe;?>');change_message_per();" target="_blank" data-toggle="tooltip" title="archivé l'employé">Classé</a></li>
														<li><a style="font-size:12px"   href="fin_relation.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>				
											</ul>
											</div>
											</td>
									  
									  
										   <?php  } ?>
									  
									  
                                            </tr>
                                  <?php
								  
								
								}
                                 ?>  
                                        </tbody>
                                    </table>
									
									
									<?php  
}
	if(isset($_POST['submit'])){
	$errors = array();

	$wilaya=$_POST['wilaya'];

	
	filtre($wilaya);
	
	

	
	  
									  
	}
 ?>
                                </div>
                             
                            </div>
                     
                                            
                            </div>
										
									
                          
                            
                        </div>
                    </div>       
				   
				   
				   
			 
				
            
                <!-- END PAGE CONTENT WRAPPER -->                                                
                     
            <!-- ------------------------------------------------------Admin dsp ----------------------------------------------------------->
        </div>
				<?php }else if ($user->type=='Admin_dsp'){?>
		
		 <div class="page-content-wrap"  >
				   
				   
				   
				    <div class="row">
                        <div class="col-md-12">
                            
                           
                                                            
                                
<div class="panel panel-warning">
                                
                                <div class="panel-body">
                                <?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
										
			                
						
								
															
								 
<?php 
//$wilaya=Wilayas::trouve_par_Nom(addslashes($user->wilaya)); 
function filtre($wilaya){
global $bd;
	//$demande_analyse=Demande_analyse::trouve_tous();

?>
                                <div  class="scrollable1" id="scrol">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Nom  </th> 
												<th>Prénom  </th>
												<th> Date Naissance </th>
												 <th>Commun Naissance  </th>
					                            <th>Diplome </th>
										        <th>Spécialité </th>
                                     
												  <th>Type d'établissement</th>
												
                                                <th>Mis à jour</th>
                                                
                                            </tr>
                                        </thead>
										 <tbody>
								
								<?php
									
									$SQL = $bd->requete("SELECT * FROM  `employer`    where  wilaya=".$wilaya."  and (`employer`.`archive`='0') and ((date_nais_employe='0000-00-00') or (diplome=0)  or (specialite=0) or (type_etablissement=0) )   ") ;
									
									
									while ($rows = $bd->fetch_array($SQL))
								{
									$id_employe=$rows['id_employe'];	
								$nom_employe=$rows['nom_employe'];
									$prenom_employe=$rows['prenom_employe'];
										$date_nais_employe=$rows['date_nais_employe'];
											//$commune_nais=$rows['commune_nais'];
											
								if ($com=Communes::trouve_par_code_postal($rows['commune_nais'])){
												$commune_nais=$com->nom_com;} else { $commune_nais='Vide'; }
												
												if($dip=Diplome::trouve_par_id($rows['diplome'])){
												$diplome=$dip->nom_diplome;	}else{$diplome='Vide';}
												
												if($specia=Specialite::trouve_par_id($rows['specialite'])){
												$specialite=$specia->nom_specialite;}else {$specialite='Vide';}
												
												if ($etab=Etablissement::trouve_par_id($rows['type_etablissement'])){
												$type_etablissement=$etab->type_etab;}else{$type_etablissement='Vide';} 
								
								                $type_employe=$rows['type_employe'];  
								?>
								
                                      
                                            <tr  <?php  if($type_employe!=0 && $type_employe!=-1) { ?> style="background:#fff;"  <?php }else if ($type_employe==0){ ?> style="background:#0f9a1a2e;" <?php }else if ($type_employe==-1) { ?> style="background:#0f9a1a2e;" <?php } ?>     >
											
								  <td <?php if($nom_employe==''){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> >	<?php   if ($nom_employe=''){   echo 'vide' ;}else { echo html_entity_decode($rows['nom_employe']); } ?></td>
											<td <?php if($prenom_employe==''){?> style="background:red;color:#fff;text-align:center "  <?php } ?>><?php  if ($prenom_employe=''){ echo 'vide' ;}else {echo html_entity_decode($rows['prenom_employe']);} ?></td>
											 <td <?php if($date_nais_employe=='0000-00-00'){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> ><?php  echo html_entity_decode(($rows['date_nais_employe'])); ?></td>
											 
											    
												 <td <?php if($commune_nais=='Vide'){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> ><?php  echo html_entity_decode($commune_nais); ?></td>
												     <td <?php if($diplome=='Vide'){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> ><?php  echo html_entity_decode($diplome); ?></td>
												
										 <td <?php if($specialite=='Vide'){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> ><?php  echo html_entity_decode($specialite); ?></td>
										 
									
										  <td  <?php if($type_etablissement=='Vide'){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?> ><?php  echo html_entity_decode($type_etablissement); ?></td>
                                      <?php if($type_employe!=0 && $type_employe!=-1){?>    
										  <td style="background:#0D9E1C">
											<div class="btn-group" >
											<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
                                            <ul class="dropdown-menu" role="menu" style="">
												
												
											<li> <a style="font-size:12px" href="edit_employer.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé"> Modifier</a></li>
												
												<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
												<li><a style="font-size:12px" onClick="delete_row('<?php echo $id_employe;?>');change_message();" target="_blank" data-toggle="tooltip" title="archivé l'employé">Classé</a></li>
														<li><a style="font-size:12px"   href="fin_relation_fis.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>				
											</ul>
											</div>
											</td>
											
									       <?php   } else if($type_employe==0){ ?> 
									  
									    <td style="background:#0D9E1C">
											<div class="btn-group" >
											<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
                                            <ul class="dropdown-menu" role="menu" style="">
										   <li><a style="font-size:12px" href="ajouter_autre_employe.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Ajouter autre employés a cette structure ">Ajouter</a></li>
											
											<li> <a style="font-size:12px" href="edit_employer.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé"> Modifier</a></li>
											<li><a style="font-size:12px"   href="transfere.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Transfère de locale">Transfère </a></li>
											<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
												<li><a style="font-size:12px" onClick="delete_row('<?php echo $id_employe;?>');change_message();" target="_blank" data-toggle="tooltip" title="archivé l'employé">Classé</a></li>
														<li><a style="font-size:12px"   href="fin_relation.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>				
											</ul>
											</div>
											</td>
										   <?php } else if($type_employe==-1){?>
									      <td style="background:#0D9E1C">
											<div class="btn-group" >
											<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
                                            <ul class="dropdown-menu" role="menu" style="">
										   <li><a style="font-size:12px" href="ajouter_autre_employe.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Ajouter autre employés a cette structure ">Ajouter</a></li>
											
											<li> <a style="font-size:12px" href="edit_employer_pere.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé"> Modifier</a></li>
											<li><a style="font-size:12px"   href="transfere.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Transfère de locale">Transfère </a></li>
											<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
												<li><a style="font-size:12px" onClick="delete_row('<?php echo $id_employe;?>');change_message_per();" target="_blank" data-toggle="tooltip" title="archivé l'employé">Classé</a></li>
														<li><a style="font-size:12px"   href="fin_relation.php?id_employe=<?php echo $id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>				
											</ul>
											</div>
											</td>
									  
									  
										   <?php  } ?>
									  
									  
                                            </tr>
                                  <?php
								  
								
								}
                                 ?>  
                                        </tbody>
                                    </table>
									
									
									<?php  
}


	

	$wilaya=Wilayas::trouve_par_Nom($user->wilaya);
	filtre($wilaya->id_w);
	
	

	
	  
									  
	
 ?>
                                </div>
                             
                            </div>
                     
                                            
                            </div>
										
									
                          
                            
                        </div>
                    </div>       
				   
				   
				   
			 
				
            
                <!-- END PAGE CONTENT WRAPPER -->                                                
                     
            <!-- END PAGE CONTENT -->
        </div>
		
		
		
		
		
		
		
		
		
		
		
		
				<?php } ?>
		</div></div>
       
          
        <!-- MESSAGE BOX-->
			
			<script>
			function affiche_box(){
			
        var box=document.getElementById('mb-affiche');
		
		box.style.display = "block";
		
		}
			
			
function change_message_per(){
        var message=document.getElementById('supr');
		message.innerHTML=" <b style='color:red'>Attention Procedure trés dangereuse et Irreversible</b><br><b style='color:red'> si vous archiver cette employée toute les employées de cette structure seront archivées</b>"
		}
		function change_message(){
        var message=document.getElementById('supr');
		message.innerText="Etes Vous Sure De Vouloir Archivé l'employé";
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
                    <div class="mb-title"><span class="fa fa-archive"></span> Archivé <strong> Employé </strong> ??!!</div>
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
		
		   <div class="message-box animated fadeIn" data-sound="alert" id="mb-load">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> loading ... <strong></strong> ?</div>
                    <div class="mb-content">
                        <p></p>                    
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
		function transfert(id_t,employe,date_instal){
			document.getElementById('lab').innerHTML=id_t;
			
			document.getElementById('lab2').innerHTML=employe;
			alert(date_instal);
			document.getElementById('ancien_instal').value=date_instal;
		
			$('#mb-transfert').show();
			
		}
			$('.mb-control-close').on('click',function(){
			 	$('#mb-transfert').hide();  
		  })
		function ici(id_p){
			var date_ancien_instal=document.getElementById('ancien_instal').value;
			var date_fin_instal=document.getElementById('fin_instal').value;
			var date_nouvelle_instal=document.getElementById('nouvelle_instal').value;
			
			
			//alert(date_nouvelle_instal);
		if(!date_ancien_instal ){
				document.getElementById('ancien_instal').style.background="red";	
				document.getElementById('ancien_instal').style.color="#fff";
	
		}
		else
		if(!date_fin_instal){
				document.getElementById('fin_instal').style.background="red";	
				document.getElementById('fin_instal').style.color="#fff";
	
		} else
			if(!date_nouvelle_instal){
				document.getElementById('nouvelle_instal').style.background="red";	
				document.getElementById('nouvelle_instal').style.color="#fff";
	
		}
		else
		if(date_fin_instal<=date_ancien_instal){
			alert("la date d'instalation est inferieur a la date fin de contrat ");	
		}
			else
			if(date_nouvelle_instal<=date_fin_instal){
			alert("la  date fin de contrat est inferieur a la date nouvelle instalation ");	
		}
			
		
		
		//alert(date_ancien_instal.getFullYear());
		else{
			
			
			var id_t=document.getElementById('lab').innerText;
			
	
		$.ajax({
	method:"post",
	url:"ajax_mutation.php",
	data: {id_t:id_t,date_ancien_instal:date_ancien_instal,date_nouvelle_instal:date_nouvelle_instal,date_fin_instal:date_fin_instal,id_p:id_p},
	success:function(resultData){
		alert(resultData);
		$('#mb-transfert').hide();
		window.location.reload();
	}
	
		});
		}	
		
		}
		
	
	$(document).ready(function() {
 
 
    var table = $('#table0').DataTable( {
	 // fixedColumns:   {
          // leftColumns: 1,
		 
		
           
        // },
	 
		// "scrollX": "100%", 

		order: [[ 7, "asc" ]], 
		
	 columnDefs: [
            { width: 180, targets: 0 },
			
        ],
	
      
		
    } );
} );
	function tester(){
			
			var wilaya=document.getElementById('wilaya').value;
		
		
		
			if(wilaya.length==0){
				
			$('#wilaya').selectpicker('setStyle', 'btn-danger');
			
			alert('selectioner ou moins une wilaya');
			
			
			return false;
		}
		
		
		}
		function tester2(){
			var diplome=document.getElementById('diplome').value;
			var specialite=document.getElementById('specialite').value;
			
		if(diplome.length==0){
			$('#diplome').selectpicker('setStyle', 'btn-danger');
			alert('selectioner au moins  un diplome');
			
	
			return false;
		}
		
			if(specialite.length==0){
		$('#specialite').selectpicker('setStyle', 'btn-danger');
			alert('selectioner au moins une specialite');
		
			
			return false;
		}
			
		
		
		}
	


	
		
	
		
	//diplome on change /###################################	
		$("#diplome").on('change',function(){
			 var diplomes = [];
        $.each($("#diplome option:selected"), function(){            
            diplomes.push($(this).val());
        });
		if(diplomes[0]=='tous'){

	// $('#diplome').selectpicker('refresh');
	var elements = document.getElementById("diplome").options;
for(var i = 1; i < elements.length; ++i){
		//alert(elements[i]);
     elements[i].selected=false;

    }
	document.getElementById('gp').style.visibility="visible";
	 $('#diplome').selectpicker('refresh');
		}
		else{
			var elements = document.getElementById("specialite").options;
			   elements[0].selected=true;
for(var i = 1; i < elements.length; ++i){
		
     elements[i].selected=false;

    }
		 $('#specialite').selectpicker('refresh');
	//
		var elements2 = document.getElementById("groupe_specialite").options;
			   elements2[0].selected=true;
for(var i = 1; i < elements2.length; ++i){
		
     elements2[i].selected=false;

    }
		 $('#groupe_specialite').selectpicker('refresh');
			
			
		//document.getElementById('gp').style.visibility="hidden";	
		
		
		}
		
		 $('#diplome').selectpicker('refresh');
		
		});
		//#######################################
		
		//specialite on change /###################################	

	
	


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

	 $('#specialite').selectpicker('refresh');
	
		}
		else{
			
			var elements = document.getElementById("diplome").options;
			   elements[0].selected=true;
for(var i = 1; i < elements.length; ++i){
		
     elements[i].selected=false;

    }
		 $('#diplome').selectpicker('refresh');
	//
		var elements2 = document.getElementById("groupe_specialite").options;
			   elements2[0].selected=true;
for(var i = 1; i < elements2.length; ++i){
		
     elements2[i].selected=false;

    }
		 $('#groupe_specialite').selectpicker('refresh');

		}
		
		 $('#diplome').selectpicker('refresh');
		
		});
	///######################################
//specialite on change /###################################	
		$("#groupe_specialite").on('change',function(){
			 var diplomes = [];
        $.each($("#groupe_specialite option:selected"), function(){            
            diplomes.push($(this).val());
        });
		if(diplomes[0]=='tous'){

	var elements = document.getElementById("groupe_specialite").options;
for(var i = 1; i < elements.length; ++i){
	
     elements[i].selected=false;

    }

	 $('#groupe_specialite').selectpicker('refresh');
		}
		else{
			var elements = document.getElementById("diplome").options;
			   elements[0].selected=true;
for(var i = 1; i < elements.length; ++i){
		
     elements[i].selected=false;

    }
		 $('#diplome').selectpicker('refresh');
	//
		var elements2 = document.getElementById("specialite").options;
			   elements2[0].selected=true;
for(var i = 1; i < elements2.length; ++i){
		
     elements2[i].selected=false;

    }
		 $('#specialite').selectpicker('refresh');

		}
		
		 $('#diplome').selectpicker('refresh');
		
		});
	///######################################

	
		
		
		
//$("#scrol").scrollLeft(400);
</script>
      
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

	body{
z-index:1;
	}		
 
	
	</style>
    

        <!-- END TEMPLATE -->      
    <!-- END SCRIPTS -->                   
    </body>
</html>
