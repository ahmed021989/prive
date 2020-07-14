<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' );
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
$titre = "Accueil";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp' or "DGSS-RH"){
	require_once("composit/header.php");
}

?>

 <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>                    
                    <li class="active">Tableau de bord > Statistique</li>
                </ul>
                <!-- END BREADCRUMB -->                       
           
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
				
				
				 <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info  push-down-20" ><img src="img/actualites.gif" width="100" height="40">
							  <button type="button" class="close" data-dismiss="alert">×</button>
                                <?php    $SQL = $bd->requete("SELECT * FROM  `actualite` where `publier` = '1'") ;
																				while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<strong><h3><span style="color: #FFF500;"> '.$rows["nom_act"].' </span></h3><p><h4>"'.$rows["contenu"].'"</h4></p></strong>';
														} ?>
                              
                            </div>
                        </div>
                    </div>
				
				  <?php if  ($user->type == 'administrateur' || $user->type == 'DGSS-RH')   {  ?>   
				
				
				
                      <!-- START WIDGETS -->                    
                    <div class="row">
					
					 <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                               <div class="widget widget-danger widget-padding-sm widget-item-icon" style="background:#229954;" >
                                <div class="widget-item-left">
								<span class="fa fa-group"></span> </div>

                                <div class="widget-data">
                                         <div class="widget-int num-count"><strong><?php  $SQL = $bd->requete("SELECT * FROM  `employer`") ;
																			$nbr = mysqli_num_rows($SQL);
																			echo $nbr;
											?></strong></div>
                                    <div class="widget-title">Employées</div>
                                   
                                </div>                         
                            </div>                            
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
					
					
					
                        <div class="col-md-3">
                            
                            <!-- START WIDGET SLIDER -->
                          <div class="widget widget-danger widget-padding-sm widget-item-icon" style="background:#2980B9;">
                                <div class="widget-item-left" >
                                    <span class="fa fa-building-o"></span>

                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><strong><?php  $SQL = $bd->requete("SELECT * FROM  `employer` where `type_employe` = '-1' or `type_employe` = '0'") ;
																			$nbr = mysqli_num_rows($SQL);
																			echo $nbr;
											?></strong></div>
                                    <div class="widget-title" > Structures </div>
                                    
                                </div>      
                               
                            </div>    
                            <!-- END WIDGET SLIDER -->
                            
                        </div>
                        <div class="col-md-3">

                            
                            <!-- START WIDGET MESSAGES -->
                          <div class="widget widget-danger widget-padding-sm widget-item-icon" style="background:#F4D03F;">
                                <div class="widget-item-left">
                                   <span class="fa fa-user"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><strong><?php  $SQL = $bd->requete("SELECT * FROM  `personne`") ;
																			$nbr = mysqli_num_rows($SQL);
																			echo $nbr;
											?></strong></div>
                                    <div class="widget-title">Utilisateurs</div>
                                   
                                </div>      
                            </div>  						
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                       
                       <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                               <div class="widget widget-danger widget-padding-sm widget-item-icon" style="background:#F87507;" onclick="location.href='ajouter_etab.php';">
                                <div class="widget-item-left">
							<span class="fa fa-home"></span>  </div>
                                <div class="widget-data">
                                         <div class="widget-int num-count"><strong><?php  $SQL = $bd->requete("SELECT * FROM  `etablissement`") ;
																			$nbr = mysqli_num_rows($SQL);
																			echo $nbr;
											?></strong></div>
                                    <div class="widget-title">Type  d'etablissements</div>
                                
                                </div>                         
                            </div>                            
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
                    </div>
					
					

                    <!-- END WIDGETS -->                    

					<?php 
			//$employers = Employe::trouve_tous();
		?>				
               <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Listes des employés</strong></h3>
								<li><a  href="export_excel_filtre.php?var=tous|tous|tous" class="btn btn-danger " ><i class="fa fa-bars"></i> Export Excel</a></li>
                                    <ul class="panel-controls">

                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    
										
                                    </ul>                                
                                </div>
                                <div class="panel-body">
                                    <table id="table0" class="table datatable scrollable table-striped">
                                        <thead>
                                            <tr>
                                         
                                                <th>Numéro  </th>
                                                <th>Nom Wilaya</th>
												<th>Nbr Structures</th>
													<th>Nbr Employées</th>
											

											
                                                
                                            </tr>
                                        </thead>
										 <tbody>
										 <?php 
										 
										 for($i=1;$i<49;$i++){
											 ?>
											 <tr style="font-weight:bold">
											 <?php
											  $SQL0 = $bd->requete("SELECT * FROM  wilayas where id_w=".$i."") ;
											  $nom_wil="";
					                    while($row=mysqli_fetch_array($SQL0)){
										$nom_wil=$row['nom'];	
										}
										 
                                      $SQL1 = $bd->requete("SELECT * FROM  `employer`,wilayas where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya") ;
					                     $nbr_employe = mysqli_num_rows($SQL1);
										 
										 $SQL2 = $bd->requete("SELECT * FROM  `employer`,wilayas where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and(employer.type_employe=-1 or employer.type_employe=0)") ;
					                     $nbr_structure = mysqli_num_rows($SQL2);
										 
										 
										 
										 echo "<td>".$i."</td> <td>".$nom_wil."</td>"."<td>".$nbr_structure."</td>"."<td>".$nbr_employe."</td>";
										  
										// echo $nbr_employe ." et ".$nbr_structure." i ".$i."<br>";
										?>
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
            </div>            
            <!-- END PAGE CONTENT -->
                <!-- END PAGE CONTENT WRAPPER -->                                                
                    
            <!-- ************************************************************************ -->
     	
		<?php }   else if ($user->type == 'Admin_dsp')  {   ?>
		       
				                
                    
                            		  <?php 
		
			
		?>				
               <div class="page-content-wrap"> 


   <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                      <!-- START WIDGETS -->                    
                    <div class="row">
					
					 <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                               <div class="widget widget-danger widget-padding-sm widget-item-icon" style="background:#229954;" >
                                <div class="widget-item-left">
								<span class="fa fa-group"></span> </div>

                                <div class="widget-data">
                                         <div class="widget-int num-count"><strong><?php $wilaya=Wilayas::trouve_par_Nom($user->wilaya);  $SQL = $bd->requete("SELECT * FROM  `employer` where wilaya='".$wilaya->id_w."' ") ;
																			$nbr1 = mysqli_num_rows($SQL);
																			echo $nbr1;
											?></strong></div>
                                    <div class="widget-title">Employées</div>
                                   
                                </div>                         
                            </div>                            
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
					
					
					
                        <div class="col-md-3">
                            
                            <!-- START WIDGET SLIDER -->
                          <div class="widget widget-danger widget-padding-sm widget-item-icon" style="background:#2980B9;">
                                <div class="widget-item-left" >
                                    <span class="fa fa-building-o"></span>

                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><strong><?php $wilaya=Wilayas::trouve_par_Nom($user->wilaya);  $SQL = $bd->requete("SELECT * FROM  `employer` where (`type_employe` = '-1' or `type_employe` = '0') and wilaya='".$wilaya->id_w."'") ;
																			$nbr = mysqli_num_rows($SQL);
																			echo $nbr;
											?></strong></div>
                                    <div class="widget-title" > Structures </div>
                                    
                                </div>      
                               
                            </div>    
                            <!-- END WIDGET SLIDER -->
                            
                        </div>
                      
                       
                      
                    </div>
					
					

                    <!-- END WIDGETS -->  




               
             
		       
				                
                    
                            		  <?php 
			
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
                                    
									 <h3 class="panel-title"><strong>Listes des employées</strong></h3>
								
                                    <ul class="panel-controls">

                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    
										
                                    </ul>                                
                                </div>
								<!-- DEBUT FORM-->
								 <form class="form-horizontal" role="form"  name="liste_employe2"   id = "liste_employe2"  action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
								<!--select pour type de filtrage ASC ou DESC>-->
								
								<div class="row" style="color:blue">
<div class="col-md-4">
								
								<B style="color:green"></B><select  class="btn btn-info select" data-live-search="true" id="diplome" name="diplome[]" multiple="multiple"  >
								
								<option selected  value='tous'>tous les diplomes</option>
								 <?php 
									$sql=$bd->requete('select * from diplome order by nom_diplome');
									while($row=$bd->fetch_array($sql)){
										?>
										
									<option id="<?php echo $row['id_diplome']; ?>" value='<?php echo $row['id_diplome']; ?>'><?php echo $row['nom_diplome'];  ?></option>	
										
									<?php }?>
								</select>
								</div>
								
								<!--select pour type de filtrage speclaiteC>-->
								<div class="col-md-4">
							
								<B style="color:blue"></B><select  class="btn btn-info select" data-live-search="true" id="specialite" name="specialite[]" multiple="multiple">
								
									<option selected  value='tous'>tous les spécialités</option>
								 <?php 
									$sql=$bd->requete('select * from specialite nom_specialite');
									while($row=$bd->fetch_array($sql)){
										?>
										
									<option id="<?php echo $row['id_specialite']; ?>" value='<?php echo $row['id_specialite']; ?>'><?php echo $row['nom_specialite'];  ?></option>	
										
									<?php }?>
								</select>
							
								</div>
								<!--FIN select pour type de filtrage ASC ou DESC>-->
								<!--select pour taille de filtrage>-->
																<button type="submit" name="submit2" class="btn btn-info pull-right" >FILTRER</button>

								
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
								function filtre($taille,$user,$diplome,$specialite,$wilaya){
									
									
									
										$employers = Employe::trouve_tous_filtre($taille,$diplome,$specialite,$wilaya);
											
//******************************											
	$d='';									
if($diplome[0]!="tous"){
	$diplom=Diplome::trouve_par_id($diplome[0]);

		$d.=''.htmlspecialchars(trim($diplom->nom_diplome)).'"';
}
if($diplome[0]=="tous"){
		$d.="tous";
		
}

if(sizeof($diplome)>1){
		for($i=1;$i<sizeof($diplome);$i++){
			$diplom=Diplome::trouve_par_id($diplome[$i]);
			$d.=' et '.htmlspecialchars(trim($diplom->nom_diplome)).'"';
		}
	}

//*********************************											
	$s='';									
if($specialite[0]!="tous"){
	$specialit=Specialite::trouve_par_id($specialite[0]);
	
		$s.=''.htmlspecialchars(trim($specialit->nom_specialite)).'"';
}
if($specialite[0]=="tous"){
		$s.="tous";
		
}

if(sizeof($specialite)>1){
		for($i=1;$i<sizeof($specialite);$i++){
			$specialit=Specialite::trouve_par_id($specialite[$i]);
			$s.=' et '.htmlspecialchars(trim($specialit->nom_specialite)).'"';
		}
	}
	
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
								<center><label class="alert alert-success" id="liste" style="font-size:12px;background:#14de29"><span class='pull-left'>Resultat de filtrage  de </span><?php echo " diplome :<span style='color:blue'>" .$d."</span>&nbsp;&nbsp;&nbsp;&nbsp; specialite :<span style='color:blue'>".$s."</span>&nbsp;&nbsp;&nbsp;&nbsp; wilaya :<span style='color:blue'>".$w."</span>"; ?>
							<a  href='export_excel_filtre.php?var=<?php foreach($diplome as $dd){ echo $dd.",";} echo "|"; foreach($specialite as $ss){ echo $ss.",";} echo "|" ; $wilaya=Wilayas::trouve_par_Nom($user->wilaya); { echo $wilaya->id_w.",";}  ?>' class='btn btn-danger pull-right' ><img width="20" src="img/icons/xls.png"> Export excel</a>
								</label></center>
                                <div class="panel-body">
								
						<div class="scrollable" id="scrol" >                                   
								   <table id="table0" class="table datatable " >
									
                                        <thead>
                                            <tr>
                                         
                                                <th>Numéro  </th>
                                                <th>Nom d'employer </th>
												<th>Prenom d'employer </th>
												<th>Date de naissance</th>
												<th>sexe</th>
												<th>lieu de naissance</th>
                                                <th>Diplome</th>
												  <th>Specialite</th>
												 <th>Wilaya</th>
												  <th>Commune d'installation</th>
												   <th>Type d'établissement</th>
												 <th>Identite juridique</th>

												 <th style="width:50px !important;text-align:right !important">Mise à jour</th>
                                                
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									$i1=1;
								foreach($employers as $employer){
									
									if($employer->type_employe==-1){
																				$erreur=0;
$date=date('Y');	
$date_n=substr($employer->date_nais_employe,0,4);	

if(($date-$date_n)<18 or ($date-$date_n)>70){
$erreur=1;	
}
										?>
										  <strong><tr style="<?php  if($erreur==1){ ?> color:#fff; background:#982c2c;  <?php }else {?>color:rgb(255,255,255);background:#04B4AE;<?php } ?>font-weight:bold" id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>"> 
											 <td><?php echo $i1; ?></td>
											    <td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
                                                <td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
                                                <td <?php if($erreur==1){ ?> style="color:red; background:#fff;" class="fa fa-warning"  <?php } ?>><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
												 <td><?php echo htmlspecialchars_decode($employer->sexe_employe); ?></td>
												 
												<td><?php 
												$commune=Communes::trouve_par_code_postal($employer->commune_nais);
												echo htmlspecialchars_decode($commune->nom_com); ?></td>
												 <td><?php 
													$diplome=Diplome::trouve_par_id($employer->diplome);
												 echo (htmlspecialchars_decode($diplome->nom_diplome)); ?></td> 
													<td><?php
														$specialite=Specialite::trouve_par_id($employer->specialite);
													echo (htmlspecialchars_decode($specialite->nom_specialite)); ?></td> 												 
												  <td><?php 
														$wilaya=Wilayas::trouve_par_id($employer->wilaya);
												  echo htmlspecialchars_decode($wilaya->nom); ?></td>
												<td><?php
												$commune2=Communes::trouve_par_code_postal($employer->commune_installation);
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
												<td><?php
												$etablissement=Etablissement::trouve_par_id($employer->type_etablissement);
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
										
												  <td><?php echo stripcslashes(htmlspecialchars_decode($employer->identite_jurdique)); ?></td> 
												  
                                              
                                               
                                                <td style="float:right;text-align:right !important">
												<?php  if($user->type=="Admin_dsp" ){?>
												<span style="width:30px !important"><a style="color:#01DF01;font-size:20px" href="ajouter_autre_employe.php?id_employe=<?php echo $employer->id_employe;?>" class="fa fa-plus-square"></a> &nbsp &nbsp
												 <a style="color:#FFFF00;font-size:20px" href="edit_employer_pere.php?id_employe=<?php echo $employer->id_employe;?>" class="fa fa-pencil"> </a>&nbsp &nbsp
												<a style="color:#ff0000;font-size:20px" onClick="delete_row('<?php echo $employer->id_employe;?>');change_message_per();" class="fa fa-trash-o"></a></span>
												<?php  }?>

												</td>
                                            </tr></strong>
									<?php ++$i1;  }

                                  if($employer->type_employe==0){
									  										$erreur=0;
$date=date('Y');	
$date_n=substr($employer->date_nais_employe,0,4);	

if(($date-$date_n)<18 or ($date-$date_n)>70){
$erreur=1;	
}
	?>
										  <b><tr style="<?php  if($erreur==1){ ?> color:#fff; background:#982c2c;  <?php }else {?>color:rgb(255,255,255);background:#04B4AE;<?php } ?>font-weight:bold" id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>"> 
											 <td><?php echo $i1;?></td>
											   <td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
                                                <td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
                                                <td <?php if($erreur==1){ ?> style="color:red; background:#fff;" class="fa fa-warning"  <?php } ?>><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
												 <td><?php echo htmlspecialchars_decode($employer->sexe_employe); ?></td>
												 
												<td><?php 
												$commune=Communes::trouve_par_code_postal($employer->commune_nais);
												echo htmlspecialchars_decode($commune->nom_com); ?></td>
												 <td><?php 
													$diplome=Diplome::trouve_par_id($employer->diplome);
												 echo (htmlspecialchars_decode($diplome->nom_diplome)); ?></td> 
													<td><?php
														$specialite=Specialite::trouve_par_id($employer->specialite);
													echo (htmlspecialchars_decode($specialite->nom_specialite)); ?></td> 												 
												  <td><?php 
														$wilaya=Wilayas::trouve_par_id($employer->wilaya);
												  echo htmlspecialchars_decode($wilaya->nom); ?></td>
												<td><?php
												$commune2=Communes::trouve_par_code_postal($employer->commune_installation);
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
												<td><?php
												$etablissement=Etablissement::trouve_par_id($employer->type_etablissement);
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
										
												  <td><?php echo stripcslashes(htmlspecialchars_decode($employer->identite_jurdique)); ?></td> 
												  
                                              
                                              
                                               
                                                <td style="text-align:right !important">
												
												<?php  if($user->type == 'Admin_dsp'){?>
											 <span> <a style="color:#FFFF00;font-size:20px"  href="edit_employer.php?id_employe=<?php echo $employer->id_employe;?>" class="fa fa-pencil"> </a>&nbsp &nbsp
                                             <a style="color:#ff0000;font-size:20px" onClick="delete_row('<?php echo $employer->id_employe;?>');change_message();" class="fa fa-trash-o"></a></span>
												<?php  }?>
												</td>
											
										<?php
										++$i1;
}


  if($employer->type_employe!=0 &&  $employer->type_employe!=-1){
									
										
																$erreur=0;
$date=date('Y');	
$date_n=substr($employer->date_nais_employe,0,4);	

if(($date-$date_n)<18 or ($date-$date_n)>70){
$erreur=1;	
}				
											
											
										
									?>
                                      
                                            <tr  style="<?php  if($erreur==1){ ?> color:#fff; background:#982c2c;  <?php }else {?>color:blue;background:RGB(209,242,235);<?php  } ?> font-weight:bold" id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>">
											 <td><?php echo $i1; ?></td>
											    <td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
                                                <td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
                                                <td <?php if($erreur==1){ ?> style="color:red; background:#fff;" class="fa fa-warning"  <?php } ?>><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
												 <td><?php echo htmlspecialchars_decode($employer->sexe_employe); ?></td>
												 
												<td><?php 
												$commune=Communes::trouve_par_code_postal($employer->commune_nais);
												echo htmlspecialchars_decode($commune->nom_com); ?></td>
												 <td><?php 
													$diplome=Diplome::trouve_par_id($employer->diplome);
												 echo (htmlspecialchars_decode($diplome->nom_diplome)); ?></td> 
													<td><?php
														$specialite=Specialite::trouve_par_id($employer->specialite);
													echo (htmlspecialchars_decode($specialite->nom_specialite)); ?></td> 												 
												  <td><?php 
														$wilaya=Wilayas::trouve_par_id($employer->wilaya);
												  echo htmlspecialchars_decode($wilaya->nom); ?></td>
												<td><?php
												$commune2=Communes::trouve_par_code_postal($employer->commune_installation);
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
												<td><?php
												$etablissement=Etablissement::trouve_par_id($employer->type_etablissement);
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
										
												  <td><?php echo stripcslashes(htmlspecialchars_decode($employer->identite_jurdique)); ?></td> 
												  
                                              
                                              
                                               
                                                <td style="text-align:right !important">
												<?php  if($user->type == 'Admin_dsp'){?>
												
											   <a style="color:#FFFF00;font-size:20px"  href="edit_employer.php?id_employe=<?php echo $employer->id_employe;?>" class="fa fa-pencil"> </a>&nbsp &nbsp
                                             <a style="color:#ff0000;font-size:20px" onClick="delete_row('<?php echo $employer->id_employe;?>');change_message();" class="fa fa-trash-o"></a>
												<?php }?>
												</td>
                                            </tr>
                                  <?php
								  
								++$i1;
								}

								}
								
                                 ?>  
                                        </tbody>
										
                                    </table>
									</div>
									
									
<?php }	
                                 ?>  
                                        </tbody>
                                   
									<?php 
									$SQL = $bd->requete("SELECT * FROM  `employer` where wilaya='".$user->wilaya."' ") ;
																			$nbr1 = mysqli_num_rows($SQL);

if(isset($_POST['submit2'])){



	$diplome="";
	if($_POST['diplome']=="Selectioner diplome"){
	$diplome="tous";	
	}else{ $diplome= $_POST['diplome'] ;
	
	}
	$specialite="";
	if($_POST['specialite']=="Selectioner Specialite"){
	$specialite="tous";	
	}else{ $specialite=($_POST['specialite']) ;}

	
	$wilay=$user->wilaya;	
	$wila=Wilayas::trouve_par_Nom($wilay);
	$wilaya=$wila->id_w;

	if($diplome!="tous" | $specialite!="tous" ){
	filtre(0,$user,$diplome,$specialite,$wilaya);
							
 } else {
	
	filtre(100,$user,"tous","tous",$wilaya);
	 
}

}
		}
	?>
	    </table>
                                </div>
                            </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
                </div>
				  
				  
				  
                </div>
                <!-- END PAGE CONTENT WRAPPER -->    
                                            
                                                         
                     
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
function change_message_per(){
        var message=document.getElementById('supr');
		message.innerHTML=" <b style='color:red'>Attention Procedure trés dangereuse et Irreversible</b><br><b style='color:red'> si vous supprimer cette employée toute les employées de cette structure seront supprimées</b>"
		}
		function change_message(){
        var message=document.getElementById('supr');
		message.innerText="Etes Vous Sure De Vouloir Supprimer Cette ligne";
		}
        </script>		
					
		
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
        <script type="text/javascript" src="js/actions.js"></script>     <style>
	
    .scrollable {
      float: right;
      width: 100%;
      overflow-x: scroll !important;

    }
	
	</style>
    

        <!-- END TEMPLATE -->      
    <!-- END SCRIPTS -->                   
    </body>
</html>
