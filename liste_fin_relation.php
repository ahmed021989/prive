<?php
require_once("includes/initialiser.php");
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
$titre = "liste Fin de relation";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp' or 'DGSS-RH'){
	require_once("composit/header.php");
	
}

?>

 <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>                    
                    <li class="active">Tableau de bord  </li>
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
                                    
									 <h3 class="panel-title"><strong>Liste des employés en fin de contrat</strong></h3>
								
                                    <ul class="panel-controls">

                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    
										
                                    </ul>                                
                                </div>
								<!-- DEBUT FORM-->
								 <form class="form-horizontal" role="form"  name="liste_employe"   id = "liste_employe"  action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
								
								<div class="row">
								<div class="col-md-4">
								
								<B style="color:green"></B><select  class=" select" data-live-search="true" id="diplome" name="diplome[]" multiple="multiple" title="Selectioner diplomes" >
								
								<option   value='tous'>tous les diplomes </option>
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
							
								<B style="color:blue"></B><select  class="select" data-live-search="true" id="specialite" name="specialite[]" multiple="multiple" title="Selectioner spécialités">
							
									<option   value='tous'>tous les spécialités</option>
								 <?php 
									$sql=$bd->requete('select * from specialite order by nom_specialite');
									while($row=$bd->fetch_array($sql)){
										?>
										
									<option id="<?php echo $row['id_specialite']; ?>" value='<?php echo $row['id_specialite']; ?>'><?php echo $row['nom_specialite'];  ?></option>	
										
									<?php }?>
								</select>
							
								</div>
								<!--FIN select pour type de filtrage ASC ou DESC>-->
								<!--select pour taille de filtrage>-->
								
								
								
								
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
									<button type="submit" name="submit" style="border-radius:10px;background:#20820d" class="btn btn-success  fa fa-search pull-right" onClick="return tester();" > FILTRER</button>
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
								function filtre($taille,$user,$diplome,$specialite,$wilaya){
									
									
									
										$employers = Employe::trouve_tous_filtre_fin_relation($taille,$diplome,$specialite,$wilaya);
											
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
								<center><label class="alert alert-success" id="liste" style="font-size:12px;background:#0D9E1C"><span class='pull-left'>Resultat de filtrage  de </span><?php echo " diplome :<span style='color:withe'>" .$d."</span>&nbsp;&nbsp;&nbsp;&nbsp; specialite :<span style='color:withe'>".$s."</span>&nbsp;&nbsp;&nbsp;&nbsp; wilaya :<span style='color:withe'>".$w."</span>"; ?>
								</label></center>
								
								
								<div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
								    <ul class="panel-controls">

                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    
										
                                    </ul>                                
                                </div>
                                <div class="panel-body">
								
						<div  class="scrollable0" id="scrol" >                                   
								   <table id="table2" class="table datatable table-striped" style="Maw-width:none !important;direction:rtl;text-align:left" >
										
                                        <thead>
                                            <tr>
										  <th>Nouvelle contrat</th>
												 <th>Identite juridique</th>
												  <th>Type d'établissement</th>
												    <th>Commune d'installation</th>
												
													   <th>Specialite</th>
													    <th>Diplome</th>
														
															<th>Date de naissance</th>
															<th>Prenom d'employer </th>
															 <th>Nom d'employer </th>
															 <th>date fin contrat </th>
															  <th>Numéro  </th>
                                               
                                               
												
												
												
											
                                               
												
												
												
												  
												

												
                                                
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									
									//$employer=Employe::trouve_tous_pere2_archive();
									$i1=1;
								foreach($employers as $employer){
									$fin_relation=Fin_relation::trouve_par_id($employer->id_employe);
									if($employer->type_employe==-1){
											

										?>
										  <strong><tr  id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>"> 
													
								<td><a  class="  fa fa-file-text"  style="font-size:20px;color:#fe970a" href="nouvel_cont_pere.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" title="Nouvelle Contrat"> </a>
								    <a  class="   fa fa-folder-open" style="font-size:20px;color:blue" href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" target="_blank" title="Detail">  </a>
								</td>

                                               
												  <td><?php echo stripcslashes(htmlspecialchars_decode($fin_relation->identite_jurdique)); ?></td> 
												  <td>												
												<?php
												if($etablissement=Etablissement::trouve_par_id($fin_relation->type_etablissement))
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
												  	<td><?php
												if($commune2=Communes::trouve_par_code_postal($fin_relation->commune_installation))
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
												
												  <td><?php
														if($specialite=Specialite::trouve_par_id($fin_relation->specialite))
													echo (htmlspecialchars_decode($specialite->nom_specialite)); ?></td>
													<td><?php 
													if($diplome=Diplome::trouve_par_id($fin_relation->diplome))
												 echo (htmlspecialchars_decode($diplome->nom_diplome)); ?></td> 
											
											    <td ><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
                                                <td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
											    <td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
                                                 <td><?php echo htmlspecialchars_decode($fin_relation->date_fine); ?></td>
											<td><?php echo $i1; ?></td>
												 
												 
												
												
																									 
												  
												
												
                                              
                                               
                                                
                                            </tr></strong>
									<?php ++$i1;  }

                                  if($employer->type_employe==0){

	?>
										  <b><tr <?php echo htmlspecialchars_decode($employer->id_employe); ?>> 
									<td><a  class="  fa fa-file-text"  style="font-size:20px;color:#fe970a" href="nouvel_cont_pere.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" title="Nouvelle Contrat"> </a>
								    <a  class="   fa fa-folder-open" style="font-size:20px;color:blue" href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" target="_blank" title="Detail">  </a>
								</td>
												 <td><?php echo stripcslashes(htmlspecialchars_decode($fin_relation->identite_jurdique)); ?></td> 
											<td><?php
												if($etablissement=Etablissement::trouve_par_id($fin_relation->type_etablissement))
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
											<td><?php
												if($commune2=Communes::trouve_par_code_postal($fin_relation->commune_installation))
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
											
											<td><?php
														if($specialite=Specialite::trouve_par_id($fin_relation->specialite))
													echo (htmlspecialchars_decode($specialite->nom_specialite)); ?></td>
											<td><?php 
													if($diplome=Diplome::trouve_par_id($fin_relation->diplome))
												 echo (htmlspecialchars_decode($diplome->nom_diplome)); ?></td> 
										
											<td ><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
                                            <td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
											<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
												<td><?php echo htmlspecialchars_decode($fin_relation->date_fine); ?></td>
											<td><?php echo $i1;?></td>
												
												 
												
												 
													 												 
												  
												
												
										
												 
												  
                                              
                                              
                                               
                                                
											
										<?php
										++$i1;
}

//$employer= Employe::trouve_tous_archive();
  if($employer->type_employe!=0 &&  $employer->type_employe!=-1){
									
	
						
									?>
                                      
                                            <tr <?php echo htmlspecialchars_decode($employer->id_employe); ?>>
										<td><a  class="  fa fa-file-text"  style="font-size:20px;color:#fe970a" href="nouvel_cont_pere.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" title="Nouvelle Contrat"> </a>
								    <a  class="   fa fa-folder-open" style="font-size:20px;color:blue" href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" target="_blank" title="Detail">  </a>
								</td>

								<td><?php echo stripcslashes(htmlspecialchars_decode($fin_relation->identite_jurdique)); ?></td> 
												<td><?php
												if($etablissement=Etablissement::trouve_par_id($fin_relation->type_etablissement))
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
											<td><?php
												if($commune2=Communes::trouve_par_code_postal($fin_relation->commune_installation))
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
											
											<td><?php
														if($specialite=Specialite::trouve_par_id($fin_relation->specialite))
													echo (htmlspecialchars_decode($specialite->nom_specialite)); ?></td>
											<td><?php 
													if($diplome=Diplome::trouve_par_id($fin_relation->diplome))
												 echo (htmlspecialchars_decode($diplome->nom_diplome)); ?></td>
											
											  <td ><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
                                            <td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
											<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
												  <td><?php echo htmlspecialchars_decode($fin_relation->date_fine); ?></td>
											<td><?php echo $i1; ?></td>
												
												 
												
												  
													 												 
												 
												
												
										
												  
                                              
                                              
                                               
                                               
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

if(isset($_POST['submit'])){
	
	
	$diplome="";
	if(empty($_POST['diplome'])){
	$diplome="tous";	
	}else{ $diplome= ($_POST['diplome']) ;}
	$specialite="";
	if(empty($_POST['specialite'])){
	$specialite="tous";	
	}else{ $specialite=($_POST['specialite']) ;}
	$wilaya="";
	if(empty($_POST['wilaya'])){
	$wilaya="tous";	
	}
	else{ $wilaya= ($_POST['wilaya']) ;}
	if($diplome!="tous" | $specialite!="tous" | $wilaya!="tous"){
		if( !empty($_POST['diplome']) &&  !empty($_POST['specialite']) &&  !empty($_POST['wilaya'])){
	filtre(0,$user,$diplome,$specialite,$wilaya);
		}else {}					
 } else {
	if( !empty($_POST['diplome']) &&  !empty($_POST['specialite']) &&  !empty($_POST['wilaya'])){
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
                  
					
					

                    <!-- END WIDGETS -->  




               
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Listes des employés en fin de relation</strong></h3>
								
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
								
								<B style="color:green"></B><select  class=" select" data-live-search="true" id="diplome" name="diplome[]" multiple="multiple" title="Selectioner Diplomes" >
								
								<option   value='tous'>tous les diplomes</option>
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
							
								<B style="color:blue"></B><select  class="select" data-live-search="true" id="specialite" name="specialite[]" multiple="multiple" title="Selectioner Spécilaités">
								
									<option   value='tous'>tous les spécialités</option>
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
																<button type="submit" name="submit2" style="border-radius:10px;background:#20820d"  class="btn btn-success btn-lg fa fa-search pull-right" onClick="return tester2();"> FILTRER</button>

								
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
									
									
									
										$employers = Employe::trouve_tous_filtre_fin_relation1($taille,$diplome,$specialite,$wilaya);
											
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
	
	

	$wil=Wilayas::trouve_par_id($wilaya);
	$w=$wil->nom;
									?>
								<center><label class="alert alert-success" id="liste" style="font-size:12px;background:#0D9E1C"><span class='pull-left'>Resultat de filtrage  de </span><?php echo " diplome :<span style='color:withe'>" .$d."</span>&nbsp;&nbsp;&nbsp;&nbsp; specialite :<span style='color:withe'>".$s."</span>&nbsp;&nbsp;&nbsp;&nbsp; wilaya :<span style='color:withe'>".$w."</span>"; ?>
							</label></center>
							
							
							
								<div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
								    <ul class="panel-controls">

                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    
										
                                    </ul>                                
                                </div>
                                <div class="panel-body">
								
						<div class="scrollable00" id="scrol" >                                   
								   <table id="table" class="table datatable table-striped" style="Maw-width:none !important;direction:rtl;text-align:left"  >
									
                                        <thead>
                                            <tr>
													<th>Nouvelle contrat</th>
												 <th>Identite juridique</th>
												  <th>Type d'établissement</th>
												    <th>Commune d'installation</th>
												
													   <th>Specialite</th>
													    <th>Diplome</th>
															
															<th>Date de naissance</th>
															<th>Prenom d'employer </th>
															 <th>Nom d'employer </th>
															 	 <th>Date fin relation </th>
															  <th>Numéro  </th>

												
                                                
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									$i1=1;
								
								foreach($employers as $employer){
									if($fin_relation=Fin_relation::trouve_par_id($employer->id_employe)){
									
									if($employer->type_employe==-1){
	

										?>
										  <strong><tr   id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>" >
												
											<td><a  class="  fa fa-file-text"  style="font-size:20px;color:#fe970a" href="nouvel_cont_pere.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" title="Nouvelle Contrat"> </a>
								            <a  class="   fa fa-folder-open" style="font-size:20px;color:blue" href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" target="_blank" title="Detail">  </a>
								          </td>
												  <td><?php echo stripcslashes(htmlspecialchars_decode($fin_relation->identite_jurdique)); ?></td> 
												  <td>												
												<?php
												if($etablissement=Etablissement::trouve_par_id($fin_relation->type_etablissement))
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
												  	<td><?php
												if($commune2=Communes::trouve_par_code_postal($fin_relation->commune_installation))
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
												
												  <td><?php
														if($specialite=Specialite::trouve_par_id($fin_relation->specialite))
													echo (htmlspecialchars_decode($specialite->nom_specialite)); ?></td>
													<td><?php 
												if(	$diplome=Diplome::trouve_par_id($fin_relation->diplome))
												 echo (htmlspecialchars_decode($diplome->nom_diplome)); ?></td> 
												
											   <td ><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
                                            <td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
											<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
												<td><?php	echo htmlspecialchars_decode($fin_relation->date_fine); ?></td>
											<td><?php echo $i1; ?></td>
                                            </tr></strong>
									<?php ++$i1;  }
								}
                                  if($employer->type_employe==0){
	
	?>
										  <b><tr  id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>"> 
											<td><a  class="  fa fa-file-text"  style="font-size:20px;color:#fe970a" href="nouvel_cont_pere.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" title="Nouvelle Contrat"> </a>
								    <a  class="   fa fa-folder-open" style="font-size:20px;color:blue" href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" target="_blank" title="Detail">  </a>
								</td>
												 <td><?php echo stripcslashes(htmlspecialchars_decode($fin_relation->identite_jurdique)); ?></td> 
											<td><?php
												if($etablissement=Etablissement::trouve_par_id($fin_relation->type_etablissement))
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
											<td><?php
												if($commune2=Communes::trouve_par_code_postal($fin_relation->commune_installation))
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
				
											<td><?php
													if($specialite=Specialite::trouve_par_id($fin_relation->specialite))
													echo (htmlspecialchars_decode($specialite->nom_specialite)); ?></td>
											<td><?php 
													if($diplome=Diplome::trouve_par_id($fin_relation->diplome))
												 echo (htmlspecialchars_decode($diplome->nom_diplome)); ?></td> 
											
										<td ><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
                                            <td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
											<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
											<td><?php	echo htmlspecialchars_decode($fin_relation->date_fine); ?></td>
											<td><?php echo $i1;?></td>
											
										<?php
										++$i1;
}


  if($employer->type_employe!=0 &&  $employer->type_employe!=-1){
									
										
				
											
											
										
									?>
                                      
                                            <tr  id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>">
											<td><a  class="  fa fa-file-text"  style="font-size:20px;color:#fe970a" href="nouvel_cont_pere.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" title="Nouvelle Contrat"> </a>
								    <a  class="   fa fa-folder-open" style="font-size:20px;color:blue" href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>"  data-toggle="tooltip" target="_blank" title="Detail">  </a>
								</td>
												  <td><?php echo stripcslashes(htmlspecialchars_decode($fin_relation->identite_jurdique)); ?></td> 
												<td><?php
											if($etablissement=Etablissement::trouve_par_id($fin_relation->type_etablissement))
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
											<td><?php
												if($commune2=Communes::trouve_par_code_postal($fin_relation->commune_installation))
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
											 
											<td><?php
														if($specialite=Specialite::trouve_par_id($fin_relation->specialite))
													echo (htmlspecialchars_decode($specialite->nom_specialite)); ?></td>
											<td><?php 
												if(	$diplome=Diplome::trouve_par_id($fin_relation->diplome))
												 echo (htmlspecialchars_decode($diplome->nom_diplome)); ?></td>
											
											 <td ><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
                                            <td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
											<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
													<td><?php	echo htmlspecialchars_decode($fin_relation->date_fine); ?></td>
											<td><?php echo $i1; ?></td>
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
		}
		
                                 ?>  
                                        </tbody>
                                   
									<?php 
									$SQL = $bd->requete("SELECT * FROM  `employer` where wilaya='".$user->wilaya."' ") ;
																			$nbr1 = mysqli_num_rows($SQL);

if(isset($_POST['submit2'])){



	$diplome="";
	if(empty($_POST['diplome'])){
	$diplome="tous";	
	}else{ $diplome= $_POST['diplome'] ;
	
	}
	$specialite="";
	if(empty($_POST['specialite'])){
	$specialite="tous";	
	}else{ $specialite=($_POST['specialite']) ;}

	
	$wilay=$user->wilaya;	
	$wila=Wilayas::trouve_par_Nom($wilay);
	$wilaya=$wila->id_w;

	if($diplome!="tous" | $specialite!="tous" ){
	filtre(0,$user,$diplome,$specialite,$wilaya);
							
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
				  
                </div>
                <!-- END PAGE CONTENT WRAPPER -->    
                                            
                                                         
                     
          

                    
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
		$("#diplome").on('change',function(){
			 var specialites = [];
        $.each($("#diplome option:selected"), function(){            
            specialites.push($(this).val());
        });

		if(specialites[0]=='tous'){

	var elements = document.getElementById("diplome").options;
for(var i = 1; i < elements.length; ++i){

     elements[i].selected=false;
	
    }
}
	 $('#diplome').selectpicker('refresh');
	});
	
	//#######################################
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
		function transfert(id_t,employe){
			document.getElementById('lab').innerHTML=id_t;
			
			document.getElementById('lab2').innerHTML=employe;
		
			$('#mb-transfert').show();
			
		}
			$('.mb-control-close').on('click',function(){
			 	$('#mb-transfert').hide();  
		  })
		function ici(id_p){
			var id_t=document.getElementById('lab').innerText;
	
		$.ajax({
	method:"post",
	url:"ajax_transfert.php",
	data: {id_p:id_p,id_t:id_t},
	success:function(resultData){
		alert(resultData);
		$('#mb-transfert').hide();
		window.location.reload();
	}
	
		});
		}
		
	

	function tester(){
			var diplome=document.getElementById('diplome').value;
			var specialite=document.getElementById('specialite').value;
			var wilaya=document.getElementById('wilaya').value;
		if(diplome.length==0){
			$('#diplome').selectpicker('setStyle', 'btn-danger');
			alert('selectioner au moins  un diplome');
			
	
			return false;
		}
		
			if(specialite.length==0){
		$('#specialite').selectpicker('setStyle', 'btn-danger');
			alert('selectioner au moins une specialate');
		
			
			return false;
		}
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
			alert('selectioner au moins une specialate');
		
			
			return false;
		}
			
		
		
		}
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
