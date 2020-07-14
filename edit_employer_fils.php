<?php
require_once("includes/initialiser.php");
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

	if ( (isset($_GET['id_employe'])) && (is_numeric($_GET['id_employe'])) ) { 
		 $id_employe = $_GET['id_employe'];
		   if($user->type!='administrateur'){
			    $wilaya=Wilayas::trouve_par_Nom($user->wilaya);
		 $SQL = $bd->requete("SELECT * FROM employer,personne where employer.wilaya=".$wilaya->id_w." and id_employe=".$id_employe."");
$count=$bd->num_rows($SQL);
				
			if($count==0){
		echo '<script>document.location.href="index.php";</script>';	//header('location:ajouter_autre_employe.php?id_employe='.$i.'');
			//	readresser_a("index.php");
			}
			}
		 $edit =  Employe::trouve_par_id($id_employe);
	 } elseif ( (isset($_POST['id_employe'])) &&(is_numeric($_POST['id_employe'])) ) { 
		 $id_employe = $_POST['id_employe'];
		 $edit =  Employe::trouve_par_id($id_employe);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
	if(isset($_POST['submit'])){
		
		
	$errors = array();
	
	
	$edit->nom_employe = htmlspecialchars(trim($_POST['nom_employe']));
	$edit->prenom_employe = (htmlspecialchars(trim($_POST['prenom_employe'])));
	$edit->date_nais_employe = htmlspecialchars(trim($_POST['date_nais_employe']));
	$edit->commune_nais = (htmlspecialchars(trim($_POST['commune_nais'])));
	$edit->sexe_employe = (htmlspecialchars(trim($_POST['sexe'])));
  
	$edit->diplome = (htmlspecialchars(trim(addslashes($_POST['diplome']))));
 
	$edit->specialite = (htmlspecialchars(trim(addslashes($_POST['specialite']))));
	$edit->fonction = (htmlspecialchars(trim(addslashes($_POST['fonction']))));
		
	$edit->date_creation = (htmlspecialchars(trim($_POST['date_creation'])));
	//echo "<script>alert(".$_POST['commune_installation'].")</script>";
	$sql=$bd->requete('select * from communes where nom_com="'.$_POST['commune_installation'].'"');
	$code_commune=0;
	while($row=$bd->fetch_array($sql)){
		$code_commune=$row['code_postal'];
	}
	$edit->commune_installation = (htmlspecialchars(trim($code_commune)));
	$edit->epoux = htmlspecialchars(trim($_POST['epoux']));
	$etablissement=Etablissement::trouve_par_type($_POST['type_etablissement']);
	$edit->type_etablissement = $etablissement->Id_etab;  
	$edit->identite_jurdique = (htmlspecialchars(trim(addslashes($_POST['identite_jurdique']))));
	$edit->adrs = htmlspecialchars(trim($_POST['adrs']));
    $edit->date_instal = (htmlspecialchars(trim($_POST['date_instal'])));

	
	if(isset($_POST['date_nais_employe_ok'])){
		$edit->nais_valide = 1;
	}
	else{
	$edit->nais_valide = 0;	
	}
	
	
	
	
	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit->save()){
		$msg_positif .= '<p style= "font-size: 20px; ">  Il a été mis à jour  ' . (htmlspecialchars_decode($edit->nom_employe)) .'    </p><br />';
														
														
		}else{
		$msg_error = "<h1>Une erreur dans le programme ! </h1>
		              <h1>Aucune mise à jour ..??? ! </h1>
                   <p class=\"error\" style= \"font-size: 20px; \" >  S'il vous plaît re- mise à jour à nouveau !!</p>";
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
$titre = "Modifier Employé ";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
}

?>
<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">Employé </a></li>
                    <li class="active"><?php echo $titre ?></li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap" > 
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_direction"  id = "ajouter_direction" action="<?php echo $_SERVER['PHP_SELF'].'?id_employe='.$id_employe;?>" method="post">
                            <div class="panel panel-default">
                              
                                <div class="panel-body">
                                  <?php 
								  
								   $employer =  Employe::trouve_par_id($id_employe);
								  
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
                                </div>
								
                               <div class='row' style="border:1px solid green">          
<br>	
<div class='row'>
<div class="col-md-12">
  <div class="form-group" style ="dir:ltr;">
                                                <label class="col-md-3 control-label " style ="dir:ltr;color:green">TYPE D'ETABLISSEMENT</label>
                                                <div class="col-md-9">                                                                                            
                                              
<input class="form-control " id="type_etablissement"  name="type_etablissement"  required style= "text-align:left;color :#666;font-size:16px"  readonly value="<?php $etab=Etablissement::trouve_par_id($employer->type_etablissement); echo $etab->type_etab; ?>" />														   
																	
                                                 
													
                                                </div>
												
                                            </div>
											</div>
											</div>
									
                                    <!--<div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label">WILAYA INSTALLATION</label>	    
                                          <div class="col-md-6 col-xs-12">                                                                                            
                                              
												<select class="form-control select" id="id"  name="wilaya"   />
															
														<?php 
														$id_wilaya=0;
														$SQL = $bd->requete("SELECT * FROM personne,wilayas  where wilayas.nom=personne.wilaya and login='".$user->login."' ");
															while ($rows = $bd->fetch_array($SQL))
														{
														$id_wilaya=$rows["id_w"];
														echo '<option  value = "'.$rows["wilaya"].'" >'.$rows["wilaya"].'</option>';
														}
														
														?>															   	
                                                   </select>														   
														
                                                 
													
                                                </div>                                           
                                        </div>-->
										<br>
								<div class='row'>		
                             <div class="col-md-12">
							      <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label pull-left" style="color:green">IDENTITE JURIDIQUE COMMERCIELLE</label>	    
                                        <div class="col-md-9 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                <input type="text" name="identite_jurdique" class="form-control"  required style= "text-align:left;color : #666;font-size:16px" readonly  value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id_employe."");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo stripcslashes(htmlspecialchars_decode($rows["identite_jurdique"]));
														}
														
														?>" />
                                            </div>                                            
                                        </div>
										
                                    </div>
							     </div><!-- fin col 6-->
							</div>
								
								 <br>
								 <div class='row'>
                                   <div class="col-md-6">
                                   <div class="form-group">
								 	
                                                <label class="col-md-6 control-label" style="color:green">COMMUNE D'INSTALLATION</label>
                                                <div class="col-md-6">                                                                                            
                                                <input class="form-control select" id="commune_installation"  name="commune_installation" required style= "text-align:left;color : #666;font-size:16px" value="<?php if($commune=Communes::trouve_par_code_postal($employer->commune_installation)) echo $commune->nom_com;?>"readonly  />
																									   
														
                                                 
													
                                                </div>
												
                                            </div> 
                                           </div>
										   
									<div class="col-md-6">
												 <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-5 control-label pull-left" style="color:green">DATE CREATION </label>	    
                                        <div class="col-md-7 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                             <input type="text" name="date_creation" class="form-control" readonly  value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id_employe."");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo stripcslashes(htmlspecialchars_decode($rows["date_creation"]));
														}
														
														?>" />						
                                            </div>                                            
                                        </div>
										</div>
                                    </div>
									
</div>
<br>
<div class='row'>
<div class="col-md-12">											
										
											
											 <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label pull-left" style="color:green">ADRESSE <span style="color:red"> (Facultatif)  </span></label>	    
                                        <div class="col-md-9 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="adrs" class="form-control" placeholder="" style= "text-align:left;color : #666;font-size:16px"  value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id_employe."");while ($rows = $bd->fetch_array($SQL)){
echo htmlspecialchars_decode($rows["adrs"]);}?>"readonly />
                                            </div>                                            
                                        </div>
										
                                    </div>
									</div>
									</div>
									<br>
										
									<div class="row">
									
									<div class="col-md-6 " >
									  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-6 control-label" style="color:green">NUMERO AGREMENT<span style="color:red"> (Facultatif)  </span></label>	    
                                        <div class="col-md-6 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-file"></span></span>
                                                <input type="text" name="numero_agriment" class="form-control" readonly  value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id_employe."");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo stripcslashes(htmlspecialchars_decode($rows["numero_agriment"]));
														}
														
														?>" />
                                            </div>  
											</div>											
                                       
										</div>
										
                                    </div>
									<div class="col-md-6 ">
									  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-5 control-label " style="color:green">DATE AGREMENT<span style="color:red"> (Facultatif)  </span></label>	    
                                        <div class="col-md-7 ">   
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                               <input type="date" name="date_agriment" class="form-control" readonly  value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id_employe."");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo stripcslashes(htmlspecialchars_decode($rows["date_agriment"]));
														}
														
														?>" />
                                                                                       
                                        </div>
										</div>
										</div>
										
                                    </div>
									
									</div><!--fin row 3-->
									<br>
									</div>	
										
										<br>
									<br>
										<!--########################################"-->
										<div class="row" style='border:1px solid blue'>
										<br>
	                                 <div class="row">
									<div class="col-md-6 ">		

						  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-6 control-label" style="color:blue">NOM </label>	    
                                        <div class="col-md-6 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="nom_employe" class="form-control" placeholder="EN MAJUSCULE"  value="<?php echo $employer->nom_employe;  ?>" required  />
                                            </div>                                            
                                        </div>
										
                                    </div>
									</div>   <!-- fin col 6-->
                                  	<div class="col-md-6 ">	
                                    <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-5 control-label" style="color:blue">PRENOM</label>	    
                                        <div class="col-md-7 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="prenom_employe" class="form-control"  value="<?php echo $employer->prenom_employe;  ?>" placeholder="EN MAJUSCULE" required  />
                                            </div>                                            
                                        </div>
										</div>
										</div> <!-- fin col6-->
                                    </div> <!-- fin row 4-->
									<br>
									  <!--sexe-->	

										<div class='row'>
										<div class="col-md-6 ">		

						  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-6 control-label" style="color:blue">NOM  D'EPOUX </label>	    
                                        <div class="col-md-6 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="epoux" class="form-control" placeholder="EN MAJUSCULE"  value="<?php echo $employer->epoux;  ?>"   />
                                            </div>                                            
                                        </div>
										
                                    </div>
									</div>   <!-- fin col 6-->
										<div class='col-md-6'>
										 <div class="form-group">
                                                <label class="col-md-5 control-label" style="color:blue">SEXE</label>
                                               <div class="col-md-7"> 
											   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="sexe" id="option3" style="width:20px;height:20px;background-color:#399"  value="homme" <?php  if($employer->sexe_employe=="homme"){  echo 'checked="checked"';} ?>> HOMME
&nbsp;&nbsp;
    <input type="radio" name="sexe" id="option4" style="width:20px;height:20px;background-color:#399"  value="femme" <?php  if($employer->sexe_employe=="femme"){  echo 'checked="checked"';} ?>> FEMME

	                                    </div>
										</div>
										</div><!-- fin col6-->
										
											
									</div> <!-- fin row-->
									<br>
									
									  <div class="row">
									<div class="col-md-6 ">	
                                    <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-6 control-label" style="color:blue" >DATE DE NAISSANCE</label>	    
                                        <div class="col-md-6 col-xs-12">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                <input type="date" name="date_nais_employe" id="date_nais_employe"  class="form-control" required value="<?php echo $employer->date_nais_employe;  ?>" />
                                            </div>    
												<div class="col-md-12 col-xs-0" id="juste" style="visibility:hidden">
													<span style="color:red">Cette date est correcte </span><input style="width:15px;height:15px;" type="checkbox" name="date_nais_employe_ok" id="date_nais_employe_ok" <?php if($employer->nais_valide==1){ ?> checked="checked" <?php }   ?>  value="date juste"  />
											    </div>												
                                        </div>
										
                                    </div>                 
                                </div> <!--fin col6-->

									<div class="col-md-6 ">	
                                    
                                   <div class="form-group">
                                                <label class="col-md-5 control-label " style="color:blue">COMMUNE DE NAISSANCE</label>
                                                <div class="col-md-7">                                                                                            
                                              
												<select class="form-control select" id="commune_nais"  name="commune_nais" data-live-search="true"  required />
														<option  value = "<?php if($commune=Communes::trouve_par_code_postal($employer->commune_nais)){ echo $commune->code_postal;}  ?>"><?php if($commune=Communes::trouve_par_code_postal($employer->commune_nais)){ echo $commune->nom_com;}  ?></option>
													<?php $SQL = $bd->requete("SELECT * FROM `communes` order by nom_com");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["code_postal"].'" >'.$rows["nom_com"].' / '.$rows["code_postal"].'</option>';
														}
														
														?>																			   	
																													   	
                                                   </select>														   
														
                                                 
													
                                                </div>
												
                                            </div> 
											</div> <!-- fin col6-->
											</div> <!-- fin row 4-->
											<br>
                                       	
                                    <!-- diplome -->
                                    <div class="row">
									<div class="col-md-6 ">	
									<div class="form-group">
                                      <label class="col-md-6 control-label" style="color:blue">FONCTION</label>	    
                                        <div class="col-md-6 ">  
                                            									
                                          
                                                
                                                <select class="form-control select" name="fonction" id="fonction" class="form-control" data-live-search="true"    />
												 <option value = "<?php $employer->fonction;   ?>"><?php if($employer->fonction!=0){$fonction=Fonction::trouve_par_id($employer->fonction); echo $fonction->nom_fonc;}else echo "Selectionner fonction";   ?><option>
												
												 <?php $SQL = $bd->requete("SELECT * FROM `fonction` order by nom_fonc");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value ='.$rows["id_fonc"].'>'.$rows["nom_fonc"].'</option>';
														}
														
														?>	
												</select>
                                       
										
                                    </div>  
									</div>
									
									</div>
									<div class="col-md-6" >
									  <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-5 control-label" style="color:blue">DATE INSTALLATION</label>	    
                                        <div class="col-md-7 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                <input type="date" name="date_instal" class="form-control"  required  value="<?php echo $employer->date_instal;  ?>"  />
                                            </div>  
											</div>											
                                       
										</div>
										
                                    </div>


  </div>
<br>
									<!-- fin col6-->
									
									 <div class="row">
									<div class="col-md-12">	
									<div class="form-group">
                                      <label class="col-md-3 control-label" style="color:blue">DIPLOME</label>	    
                                        <div class="col-md-9">  
                                            									
                                          
                                                
                                                <select class="form-control select" name="diplome" id="diplome" class="form-control" data-live-search="true" onchange="change_specialite()"  required  />
												 <option value = "<?php if($diplome=Diplome::trouve_par_id($employer->diplome)){  echo $employer->diplome;} ?>" > <?php if($diplome=Diplome::trouve_par_id($employer->diplome)){  echo $diplome->nom_diplome;} ?> </option>
												
												 <?php $SQL = $bd->requete("SELECT * FROM `diplome` order by nom_diplome");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value ='.$rows["id_diplome"].'>'.$rows["nom_diplome"].'</option>';
														}
														
														?>	
												</select>
                                       
										
                                    </div>  
									</div>
									</div> <!-- fin col6-->
										</div>
                                         
										 <!-- fin row 4-->
									 <!-- Specialite -->
									 </br>
									 <div class='row'>
									     <div class="col-md-12">
                                    <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label" style="color:blue">SPECIALITE</label>	    
                                        <div class="col-md-9 ">  
                                            									
                                         
                                                <select class="form-control select" name="specialite" id="specialite" data-live-search="true"  class="form-control"  required  >
												<option value = "<?php if($specialite=Specialite::trouve_par_id($employer->specialite)){  echo $employer->specialite ;}?>"><?php if($specialite=Specialite::trouve_par_id($employer->specialite)){  echo $specialite->nom_specialite ;}?> </option>
												
													
												</select>
                                                                                     
                                         </div>
												
                                            </div> 
											</div>
											</div>
											
											<br>
											</div>	
											
											</div>
									
									 
								
									
                                  
                                </div> 
                                        
                                 <div class="panel-footer">
                                                                   
                                    <button class="btn btn-primary pull-right"type = "submit" style="background:#20820d;" name = "submit" onclick="return  verif_date()" >  Modifier</button>
                                    <?php echo '<input type="hidden" name="id_employe" value="' .$id_employe . '" />';?>
							   </div>
                            </div>
                        </form>
                    </div>
                    </div>                    
                    
                  
             
                <!-- END PAGE CONTENT WRAPPER -->                                
                 </div>       
            <!-- END PAGE CONTENT -->
        
		
		<div class="message-box sm animated fadeIn" data-sound="alert" id="mb-liste_etab" style="background:#fff">
            <div class="pull-right">
						<div>
						<br><br>
                           <button class="btn btn-danger fa fa-times btn-lg mb-control-close"></button> 
						   </div>
                        </div>
						<br><br><br>
             
                  <?php    
				
				  ?>
                        <h3><div id="supr"></div> </h3>                   
                        <center><h3><p> </p></h3></center>
						  <table id="table3" class="table datatable " style="Maw-width:none !important;direction:rtl;text-align:left" >
									
                                        <thead>
                                            <tr>
                                          <th >Action</th>
												 <th>Identite juridique</th>
												  <th>Type d'établissement</th>
												    <th>Commune d'installation</th>
															
															<th>Prenom d'employer </th>
															 <th>Nom d'employer </th>
															  <th>Numéro  </th>

												
                                                
                                            </tr>
                                        </thead>
										 <tbody>
						<?php 
						$wilaya=Wilayas::trouve_par_Nom($user->wilaya);
						if($user->type=="Admin_dsp"){
						$employer_peres=Employe::trouve_tous_pere($wilaya->id_w);
						}
						else{
						$employer_peres=Employe::trouve_tous_pere2();
	
						}
						$i1=1;
						foreach($employer_peres as $employer){
							?>
						<tr style="color:rgb(255,255,255);background:green;font-weight:bold" id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>"> 
											<td style="background:#fff">
											 <button style="color:#green;font-size:20px" id="<?php echo $employer->id_employe;?>"  class=" btn btn-success fa fa-home
" data-toggle="tooltip" title="choisi cette etablissement" onClick="ici(<?php echo $employer->id_employe; ?>);">Choisi</button> &nbsp &nbsp
	
											
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
                    
                    <div class="mb-footer">
                        <div class="pull-right">
                         
                        </div>
                    </div>
            
            
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
		
		
		
		
		  <div class="message-box animated fadeIn" data-sound="alert" id="mb-ouverture" ">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Modification <strong></strong> ?</div>
                    <div class="mb-content">
                        <p>quelque</p>                    
                        <p>modification de structure</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="edit_employer.php" class="btn btn-success btn-lg">Oui</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		
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
                <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>   

                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
  
        <!-- END THIS PAGE PLUGINS -->       
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
		<script>
	 window.onload=	verif_date();
		function verif_date(){
						
			var date_n = document.getElementById('date_nais_employe').value;
		
			var anne=date_n.substring(0,4);
			var d= new Date();
			d2=d.getFullYear();
		if(d2-anne<18 | d2-anne>70){
			$('#juste').css("visibility", "visible");
			if(document.getElementById("date_nais_employe_ok").checked == true){
				document.getElementById('date_nais_employe').style.background='#d9534f';
document.getElementById('date_nais_employe').style.color='white';	
a=0;	
			//return true;
			}
			else{
						document.getElementById('date_nais_employe').style.background='#d9534f';
document.getElementById('date_nais_employe').style.color='white';
			//return false;	
			a=1;
			
			}
		if(a==0){  return true; } else { return false; }
			
		}
		else{
		
			return true;
		}
			}
		
		function liste_etab(){
		
$('#mb-liste_etab').show();
			
		}
		$('.mb-control-close').on('click',function(){
			 	$('#mb-liste_etab').hide();  
		  })
		
		function change_specialite(){
	var diplome=document.getElementById('diplome').value;
	//alert(diplome);
$('#specialite').selectpicker('refresh');
tabl = new Array();

	$.ajax({
	method:"post",
	url:"ajax_diplome.php",
	data: {diplome:diplome},
	success:function(resultData){
		
	tabl=resultData.split('|');
	// alert(resultData);
$('#specialite').empty();
	 for(i=0;i<tabl.length;i++){
		 if(tabl[i]!=''){
	specia=tabl[i].split(',');
		$("#specialite").append(new Option(specia[0], specia[1])  ); 
		$('#specialite').selectpicker('refresh');
		 }
	
		
	 }

		
	}
	
	})
	
}
//fin change_specialite()

		</script>
    <!-- END SCRIPTS -->     
    <!-- END SCRIPTS -->                   
    </body>
</html>






