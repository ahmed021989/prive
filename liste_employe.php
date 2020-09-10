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

$titre = "Listes des employés";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
	
}

?>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="index.php">Accueil</a></li>                    
	<li class="active">Tableau de bord > Listes des employés</li>
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
				<div class="col-xs-12">

					<!-- START DEFAULT DATATABLE -->
					<div class="panel panel-default">
						<div class="panel-heading">                                

							<h3 class="panel-title"><strong>Liste des employés</strong></h3>

							<ul class="panel-controls">

								<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
								<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>


							</ul>                                
						</div>
						<!-- DEBUT FORM-->
						<form class="form-horizontal" role="form"  name="liste_employe"   id = "liste_employe"  action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

							<div class="row">
								

								<div class="col-xs-4" style="width:250px !important">

									<select  class="btn  select" data-live-search="true" id="specialite" name="specialite[]" multiple="multiple" title="Selectioner spécialités">

										<option   value='tous' selected>tous les spécialités</option>
										<?php 
										$sql=$bd->requete('select * from specialite order by nom_specialite');
										while($row=$bd->fetch_array($sql)){
											?>

											<option id="<?php echo $row['id_specialite']; ?>" value='<?php echo $row['id_specialite']; ?>'><?php echo $row['nom_specialite'];  ?></option>	

										<?php }?>
									</select>

								</div>
								
								
								
								<div class="col-xs-4" style="width:250px !important">

									<select  class="btn  select" data-live-search="true" id="diplome" name="diplome[]" multiple="multiple" title="Selectioner diplomes" >

										<option   value='tous' selected>tous les diplomes </option>
										<?php 
										$sql=$bd->requete('select * from diplome order by nom_diplome');
										while($row=$bd->fetch_array($sql)){
											?>

											<option id="<?php echo $row['id_diplome']; ?>" value='<?php echo $row['id_diplome']; ?>'><?php echo $row['nom_diplome'];  ?></option>	

										<?php }?>
									</select>
								</div>
								<div class="col-xs-4" id="gp" style="width:250px !important">

									<B style="color:blue"></B><select  class="btn select" data-live-search="true" id="groupe_specialite" name="groupe_specialite[]" multiple="multiple" title="Selectioner groupe spécialités">

										<option   value='tous' selected>tous les groupe </option>
										<?php 
										$sql=$bd->requete('select * from groupe_specialite order by groupe_specialite');
										while($row=$bd->fetch_array($sql)){
											?>

											<option id="<?php echo $row['id_groupe_specialite']; ?>" value='<?php echo $row['id_groupe_specialite']; ?>'><?php echo $row['groupe_specialite'];  ?></option>	

										<?php }?>
									</select>

								</div>
								

								
								<div class="col-xs-4" id="gp" style="width:250px !important">

									<B style="color:blue"></B><select  class="btn select" data-live-search="true" id="recherche" name="recherche"   >

										<option   value='tous' selected>Recherche Tous </option>
										<option   value='s'>Recherche Structures </option>

									</select>

								</div>

								<div class="col-xs-4" style="width:250px !important">

									<select  class="btn  select" data-live-search="true" id="etablissement" name="etablissement[]" multiple="multiple" title="Selectioner les type d'établissement" >

										<option   value='tous' selected>tous les types d'établissements </option>
										<?php 
										$sql=$bd->requete('select * from etablissement order by type_etab');
										while($row=$bd->fetch_array($sql)){
											?>

											<option id="<?php echo $row['Id_etab']; ?>" value='<?php echo $row['Id_etab']; ?>'><?php echo $row['type_etab'];  ?></option>	

										<?php }?>
									</select>
								</div>	

								
								<!--select pour type de filtrage specialite>-->

								
								<div class="col-xs-4 " style="width:250px !important">
									<b style="color:green"></b>

									<select  class="btn  select" data-live-search="true" id="wilaya" name="wilaya[]" multiple="multiple" title="Selectioner Wilayas" >

										<option   value='tous' selected>toutes les wilayas</option>
										<?php 
										$wilayas=Wilayas::trouve_tous();
										foreach($wilayas as $wilaya){
											if($wilaya->id_w!=49){
												?>

												<option id="<?php echo $wilaya->id_w; ?>" value='<?php echo $wilaya->id_w; ?>'><?php echo $wilaya->nom;  ?></option>	

												<?php
											}
										}
										?>
									</select>

								</div>
								
								
								<!--FIN select pour type de filtrage ASC ou DESC>-->
								<!--select pour taille de filtrage>-->
								
								
							</div>
							<br>
							
							<div class='row'>
								<div class="col-xs-12 ">
									<button type="submit" id="submit" name="submit" style="border-radius:10px;background:#20820d" class="btn btn-success fa fa-search pull-right " onClick="return tester();" > FILTRER</button>
								</div>


							</div> <!--FIN row>-->
							<br>
							<!--FIN select pour taille de filtrage>-->



						</form>
						<!--FIN FORM-->
					</br>
					<hr>

					<?php 

								//CREATION DE LA FOUNCTION FILTRE
					function filtre($taille,$user,$diplome,$specialite,$wilaya,$groupe,$recherche,$etab){
						$employers = Employe::trouve_tous_filtre($taille,$diplome,$specialite,$wilaya,$groupe,$etab);

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
							if($groupe[0]!="tous"){
								$specialite0=Specialite::trouve_par_groupe($groupe[0]);
								foreach($specialite0 as $specialite0){
									$s.=' '.htmlspecialchars(trim($specialite0->nom_specialite)).'"';
								}
								for($i=1;$i<sizeof($groupe);$i++){
									$specialite1=Specialite::trouve_par_groupe($groupe[$i]);	
									foreach($specialite1 as $specialite1){
										$s.=' et '.htmlspecialchars(trim($specialite1->nom_specialite)).'"';
									}
								}
							}
							else{
								$s.=" tous ";
							}

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
						$r="";
						if($recherche=="tous"){ $r="Recherche tous";} else { $r="Recherche structures";}

						?>
						<center><label class="alert alert-success" id="liste" style="font-size:12px;background:#0D9E1C"><span class='pull-left'>Resultat de filtrage  de </span><?php echo " <strong>diplome :</strong> <span style='color:#fff'>" .$d."</span>&nbsp;&nbsp;&nbsp;&nbsp; <strong>specialite : </strong><span style='color:#fff'>".$s."</span>&nbsp;&nbsp;&nbsp;&nbsp; <strong>wilaya :</strong> <span style='color:#fff'>".$w."</span>    &nbsp;&nbsp;".$r; ?>
						<?php if($user->type!="DGSS-RH"){?>
							<a  href='export_excel_filtre.php?var=<?php  echo $diplome[0]; for($i=1;$i<sizeof($diplome);$i++){ echo ",".$diplome[$i];} echo "|";if($specialite[0]=="tous"){ if($groupe[0]!="tous"){
								$specialite0=Specialite::trouve_par_groupe($groupe[0]);
								for($i=0;$i<sizeof($specialite0)-1;$i++){
									echo htmlspecialchars(trim($specialite0[$i]->id_specialite)).',';
								}
								echo htmlspecialchars(trim($specialite0[sizeof($specialite0)-1]->id_specialite)).'|';
								for($i=1;$i<sizeof($groupe)-1;$i++){
									$specialite1=Specialite::trouve_par_groupe($groupe[$i]);	

									for($i=0;$i<sizeof($specialite1)-1;$i++){
										echo htmlspecialchars(trim($specialite1[$i]->id_specialite)).',';
									}
									echo htmlspecialchars(trim($specialite1[sizeof($specialite1)-1]->id_specialite)).'|';
								}
							}
							else{
								echo "tous|";
							} } else { echo $specialite[0]; for($i=1;$i<sizeof($specialite);$i++){ echo ",".$specialite[$i];} echo "|" ; } echo $wilaya[0] ;for($i=1;$i<sizeof($wilaya);$i++) { echo ",".$wilaya[$i];} echo "|".$recherche ;?>' class='btn btn-danger pull-right' ><img width="20" src="img/icons/xls.png"> Export excel</a>
						<?php }?>
					</label></center>
					<div class="panel-body">

						<div  class="scrollable0" id="scrol" >                                   
							<table id="table0" class="table table-responsive" style="direction:rtl;text-align:left;marging-bottom:50px !important" >

								<thead>
									<tr>
										<?php  if($user->type=="administrateur"){?>
											<th >Mouvement</th>
										<?php  }?>
										<?php  if($user->type=="DGSS-RH"){?>
											<th >Dossier</th>
										<?php  }?>
										<th>Photo</th>
										<th>Type d'établissement</th>
										<th>Specialite</th>
										<th>Diplome</th>
										<th>Date de naissance</th>
										<th>Prenom d'employé </th>
										<th>Nom d'employé </th>
										<th>N°ord </th>

									</tr>
								</thead>
								<tbody>
									<?php
									$i1=1;
									$len = count($employers);
									foreach($employers as $employer){

										if($employer->type_employe==-1){
											$erreur=0;			$erreur1=0;	$erreur2=0;$erreur3=0;$erreur4=0;

											$date=date('Y');	
											$date_n=substr($employer->date_nais_employe,0,4);	

											if(($date-$date_n)<18 or ($date-$date_n)>70){
												$erreur1=1;	
											}				
											if($employer->diplome==0 ){
												$erreur2=2;	
											}
											if($employer->specialite==0){
												$erreur3=3;	
											}
											if($employer->type_etablissement==0){
												$erreur4=4;	
											}	
											?>
											<strong><tr style="<?php  if($erreur==1 or $erreur==2 or $erreur==3 or $erreur==4){ ?> color:#000; background:#0f9a1a2e;  <?php }else {?>color:#000;background:#0f9a1a2e;<?php } ?>" id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>"> 
												<?php  if($user->type=="DGSS-RH"){?>
													<td><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></td>
												<?php }?>

												<?php  if($user->type=="administrateur"){?>
													<?php 
													global $bd;
													$query=$bd->requete('select * from employer where type_employe='. $employer->id_employe.'');
													?>
													<td style="background:#0D9E1C">
														<div class="btn-group" >
															<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
															<ul class="dropdown-menu" role="menu" style="">

																<li><a style="font-size:12px" href="ajouter_autre_employe.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Ajouter autre employés a cette structure ">Ajouter</a></li>
																<li> <a style="font-size:12px" href="edit_employer_pere.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé"> Modifier</a></li>
																<li><a style="font-size:12px"   href="affiliation.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Photo et affiliation">Photo et affiliation </a></li>
																<li><a style="font-size:12px"   href="transfere.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Transfère de locale">Transfère </a></li>


																<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
																<li><a style="font-size:12px;cursor: pointer;" onClick="delete_row('<?php echo $employer->id_employe;?>');change_message_per();" target="_blank" data-toggle="tooltip" title="archivé l'employé">Classé</a></li>
																<li><a style="font-size:12px"   href="fin_relation.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>

																<li><a style="font-size:12px;cursor: pointer;"   onclick="get_fils(<?php echo $employer->id_employe;?>)" target="_blank" data-toggle="tooltip" title="liste des employés dans la structure">Emplyés de la structure (<?php echo mysqli_num_rows($query); ?>)
																</a></li>			
															</ul>
														</div>
													</td>
												<?php  }?>

												  <td>
													<?php 
													$src_photo="";
													if($affiliation=Affiliation::trouve_par_id($employer->id_employe))
													{
														$src_photo="doc_pdf/".$affiliation->photo;
													}
													?>
												<img class='img-responcive pull-right'    type='image' id='photo' src='<?php if($src_photo!=''){ echo $src_photo; }  else { ?> http://placehold.it/100 <?php } ?>'  width='40' height='40'  onClick='affiche(this)'/>
													
													</td>  

												<td <?php if($erreur4==4){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?>>												
													<?php
													if($etablissement=Etablissement::trouve_par_id($employer->type_etablissement))
														echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); else echo "VIDE"; ?></td>

													<td <?php if($erreur3==3){ ?> style="background:red;color:#fff;text-align:center " <?php } ?>  > <?php
													if($specialite=Specialite::trouve_par_id($employer->specialite))
														echo (htmlspecialchars_decode($specialite->nom_specialite)); else echo "VIDE"; ?></td>
													<td <?php if($erreur2==2){ ?> style="background:red;color:#fff;text-align:center "<?php } ?>><?php 
													if($diplome=Diplome::trouve_par_id($employer->diplome))
														echo (htmlspecialchars_decode($diplome->nom_diplome)); else echo "VIDE"; ?></td> 

													<td <?php if($erreur1==1 and $employer->nais_valide==0){ ?> style="color:#fff; background:red;"   <?php } ?>><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
													<td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
													<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>

													<td><?php echo $i1; ?></td>











												</tr></strong>
												<?php ++$i1;  }

												if($employer->type_employe==0){
													$erreur=0;		$erreur1=0;	$erreur2=0;$erreur3=0;$erreur4=0;

													$date=date('Y');	
													$date_n=substr($employer->date_nais_employe,0,4);	

													if(($date-$date_n)<18 or ($date-$date_n)>70){
														$erreur1=1;	
													}				
													if($employer->diplome==0 ){
														$erreur2=2;	
													}
													if($employer->specialite==0){
														$erreur3=3;	
													}
													if($employer->type_etablissement==0){
														$erreur4=4;	
													}	
													?>
													<b><tr style=" <?php  if($erreur==1 or $erreur==2 or $erreur==3 or $erreur==4){ ?> color:#000; background:#0f9a1a2e;  <?php }else { ?> color:#000;background:#0f9a1a2e; <?php } ?>" id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>"> 
														<?php  if($user->type=="DGSS-RH"){?>
															<td><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></td>
														<?php }?>
														<?php  if($user->type == 'administrateur'){?>
															<td style="background:#0D9E1C">
																<span>
																	<div class="btn-group" >
																		<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
																		<ul class="dropdown-menu" role="menu" style="">

																			<li><a style="font-size:12px" href="ajouter_autre_employe.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Ajouter autre employés a cette structure ">Ajouter</a></li>

																			<li><a style="font-size:12px"  href="edit_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé">Modifier</a></li>
																			<li><a style="font-size:12px"   href="affiliation.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Photo et affiliation">Photo et affiliation </a></li>

																			<li><a style="font-size:12px"   href="transfere.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Transfère de locale">Transfère </a></li>

																			<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
																			<li><a style="font-size:12px" onClick="delete_row('<?php echo $employer->id_employe;?>');change_message();" target="_blank" data-toggle="tooltip" title="Classé l'employé">Classé</a></li>				
																			<li><a style="font-size:12px"   href="fin_relation.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>
																		</ul>
																	</div>
																</td>
															<?php  }?>		
															  <td>
													<?php 
													$src_photo="";
													if($affiliation=Affiliation::trouve_par_id($employer->id_employe))
													{
														$src_photo="doc_pdf/".$affiliation->photo;
													}
													?>
												<img class='img-responcive pull-right'    type='image' id='photo' src='<?php if($src_photo!=''){ echo $src_photo; }  else { ?> http://placehold.it/100 <?php } ?>'  width='40' height='40'  onClick='affiche(this)'/>
													
													</td> 										

															<td <?php if($erreur4==4){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?>>												
																<?php
																if($etablissement=Etablissement::trouve_par_id($employer->type_etablissement))
																	echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); else echo "VIDE"; ?></td>

																<td <?php if($erreur3==3){ ?> style="background:red;color:#fff;text-align:center " <?php } ?>  > <?php
																if($specialite=Specialite::trouve_par_id($employer->specialite))
																	echo (htmlspecialchars_decode($specialite->nom_specialite)); else echo "VIDE"; ?></td>
																<td <?php if($erreur2==2){ ?> style="background:red;color:#fff;text-align:center "<?php } ?>><?php 
																if($diplome=Diplome::trouve_par_id($employer->diplome))
																	echo (htmlspecialchars_decode($diplome->nom_diplome)); else echo "VIDE"; ?></td> 

																<td <?php if($erreur1==1 and $employer->nais_valide==0){ ?> style="color:#fff; background:red;"   <?php } ?>><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
																<td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
																<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>

																<td><?php echo $i1;?></td>
















																<?php
																++$i1;
															}

															if($recherche=="tous"){
																if($employer->type_employe!=0 &&  $employer->type_employe!=-1){




																	$erreur1=0;	$erreur2=0;$erreur3=0;$erreur4=0;$erreur=0;	

																	$date=date('Y');	
																	$date_n=substr($employer->date_nais_employe,0,4);	

																	if(($date-$date_n)<18 or ($date-$date_n)>70){
																		$erreur1=1;	
																	}				
																	if($employer->diplome==0 ){
																		$erreur2=2;	
																	}
																	if($employer->specialite==0){
																		$erreur3=3;	
																	}
																	if($employer->type_etablissement==0){
																		$erreur4=4;	
																	}						
																	?>

																	<tr  style="<?php  if($erreur==1 or $erreur==2 or $erreur==3 or $erreur==4){ ?> color:#000; background:#fff;  <?php }else {?> color:#000; background:#fff;<?php } ?> " id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>">
																		<?php  if($user->type=="DGSS-RH"){?>
																			<td><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></td>
																		<?php }?>
																		<?php  if($user->type == 'administrateur'){?>
																			<td style="background:#0D9E1C">
																				<div class="btn-group" >
																					<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
																					<ul class="dropdown-menu" role="menu" >

																						<li> <a style="font-size:12px"  href="edit_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé">Modifier</a></li>
																						<li><a style="font-size:12px"   href="affiliation.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Photo et affiliation">Photo et affiliation </a></li>
																						<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
																						<li><a style="font-size:12px" onClick="delete_row('<?php echo $employer->id_employe;?>');change_message();" target="_blank" data-toggle="tooltip" title="Classé l'employé">Classé</a></li>
																						<li><a style="font-size:12px"   href="fin_relation_fis.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>

																					</ul>
																				</div>
																			</td>
																		<?php }?>
																		  <td>
													<?php 
													$src_photo="";
													if($affiliation=Affiliation::trouve_par_id($employer->id_employe))
													{
														$src_photo="doc_pdf/".$affiliation->photo;
													}
													?>
												<img class='img-responcive pull-right'    type='image' id='photo' src='<?php if($src_photo!=''){ echo $src_photo; }  else { ?> http://placehold.it/100 <?php } ?>'  width='40' height='40'  onClick='affiche(this)'/>
													
													</td> 

																		<td <?php if($erreur4==4){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?>>												
																			<?php
																			if($etablissement=Etablissement::trouve_par_id($employer->type_etablissement))
																				echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); else echo "VIDE"; ?></td>

																			<td <?php if($erreur3==3){ ?> style="background:red;color:#fff;text-align:center " <?php } ?>  > <?php
																			if($specialite=Specialite::trouve_par_id($employer->specialite))
																				echo (htmlspecialchars_decode($specialite->nom_specialite)); else echo "VIDE"; ?></td>
																			<td <?php if($erreur2==2){ ?> style="background:red;color:#fff;text-align:center "<?php } ?>><?php 
																			if($diplome=Diplome::trouve_par_id($employer->diplome))
																				echo (htmlspecialchars_decode($diplome->nom_diplome)); else echo "VIDE"; ?></td> 

																			<td <?php if($erreur1==1 and $employer->nais_valide==0){ ?> style="color:#fff; background:red;"   <?php } ?>><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
																			<td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
																			<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
																			<td><?php echo $i1; ?></td>














																		</tr>
																		<?php

																		++$i1;

																	}
																}
															}
								/*if($i1>=$len-1){
								echo "<script> alert(".$i1.");</script>";	
								}
								if($i1<$len-1){
							//	echo "<script> document.getElementById('mb-load').style.visibility='visible';</script>";	
								}*/
								
								?>  
							</tbody>

						</table>
					</div>


					<?php 

				}


				if(isset($_POST['submit'])){


					$diplome="";
					if(empty($_POST['diplome'])){
						$diplome="tous";	
					}else{ $diplome= ($_POST['diplome']) ;}
					$specialite="";
					if(empty($_POST['specialite'])){
						$specialite="tous";	
					}else{ $specialite=($_POST['specialite']) ;}

					$groupe="";
					if(empty($_POST['groupe_specialite'])){
						$groupe="tous";	
					}else{ $groupe=($_POST['groupe_specialite']) ;}

					$etablissement="";
					if(empty($_POST['etablissement'])){
						$etablissement="tous";	
					}else{ $etablissement=($_POST['etablissement']) ;}


					$wilaya="";
					if(empty($_POST['wilaya'])){
						$wilaya="tous";	
					}
					else{ $wilaya= ($_POST['wilaya']) ;}
					if($diplome!="tous" | $specialite!="tous" | $wilaya!="tous" | $groupe!="tous"){
						if( !empty($_POST['diplome']) &&  !empty($_POST['specialite']) &&  !empty($_POST['wilaya']) &&  !empty($_POST['groupe_specialite'])){
							filtre(0,$user,$diplome,$specialite,$wilaya,$groupe,$_POST['recherche'],$etablissement);
						}else {}					
					} else {
						if( !empty($_POST['diplome']) &&  !empty($_POST['specialite']) &&  !empty($_POST['wilaya'])){
							filtre(100,$user,"tous","tous","tous","tous",$_POST['recherche'],$etablissement);
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

<?php }   else if ($user->type == 'Admin_dsp')  {   ?>



	<?php 


	?>				
	<div class="page-content-wrap"> 


		<!-- PAGE CONTENT WRAPPER -->
		<div class="page-content-wrap">
			<!-- START WIDGETS -->                    




			<!-- END WIDGETS -->  






			<div class="row">
				<div class="col-xs-12">

					<!-- START DEFAULT DATATABLE -->
					<div class="panel panel-default">
						<div class="panel-heading">                                

							<h3 class="panel-title"><strong>Liste des employés</strong></h3>

							<ul class="panel-controls">

								<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
								<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>


							</ul>                                
						</div>
						<!-- DEBUT FORM-->
						<form class="form-horizontal" role="form"  name="liste_employe2"   id = "liste_employe2"  action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
							<!--select pour type de filtrage ASC ou DESC>-->

							<div class="row" style="color:blue">
								<div class="col-xs-4">

									<B style="color:blue"></B><select  class="btn  select" data-live-search="true" id="specialite" name="specialite[]" multiple="multiple" title="Selectioner Spécilaités">

										<option   value='tous' selected>toutes les spécialités</option>
										<?php 
										$sql=$bd->requete('select * from specialite nom_specialite');
										while($row=$bd->fetch_array($sql)){
											?>

											<option id="<?php echo $row['id_specialite']; ?>" value='<?php echo $row['id_specialite']; ?>'><?php echo $row['nom_specialite'];  ?></option>	

										<?php }?>
									</select>

								</div>
								<div class="col-xs-4">

									<select  class="btn  select" data-live-search="true" id="diplome" name="diplome[]" multiple="multiple" title="Selectioner Diplomes" >

										<option   value='tous' selected>tous les diplomes</option>
										<?php 
										$sql=$bd->requete('select * from diplome order by nom_diplome');
										while($row=$bd->fetch_array($sql)){
											?>

											<option id="<?php echo $row['id_diplome']; ?>" value='<?php echo $row['id_diplome']; ?>'><?php echo $row['nom_diplome'];  ?></option>	

										<?php }?>
									</select>
								</div>
								
								<div class="col-xs-4" id="gp">

									<B style="color:blue"></B><select  class="btn  select" data-live-search="true" id="groupe_specialite" name="groupe_specialite[]" multiple="multiple" title="Selectioner groupe spécialités">

										<option   value='tous' selected>tous les groupes</option>
										<?php 
										$sql=$bd->requete('select * from groupe_specialite order by groupe_specialite');
										while($row=$bd->fetch_array($sql)){
											?>

											<option id="<?php echo $row['id_groupe_specialite']; ?>" value='<?php echo $row['id_groupe_specialite']; ?>'><?php echo $row['groupe_specialite'];  ?></option>	

										<?php }?>
									</select>

								</div>
								
							</div><!-- fin row 1-->
							<div class="row">
								
								<div class="col-xs-4" id="gp" >

									<B style="color:blue"></B><select  class="btn select" data-live-search="true" id="recherche" name="recherche"   >

										<option   value='tous' selected>Recherche Tous </option>
										<option   value='s'>Recherche Structures </option>

									</select>

								</div>
								
								<div class="col-xs-4" style="width:250px !important">

									<select  class="btn  select" data-live-search="true" id="etablissement" name="etablissement[]" multiple="multiple" title="Selectioner les type d'établissement" >

										<option   value='tous' selected>tous les types d'établissements </option>
										<?php 
										$sql=$bd->requete('select * from etablissement order by type_etab');
										while($row=$bd->fetch_array($sql)){
											?>

											<option id="<?php echo $row['Id_etab']; ?>" value='<?php echo $row['Id_etab']; ?>'><?php echo $row['type_etab'];  ?></option>	

										<?php }?>
									</select>
								</div>
								
							</div>
							<br>
							<!--select pour type de filtrage speclaiteC>-->



							<!--FIN select pour type de filtrage ASC ou DESC>-->
							<!--select pour taille de filtrage>-->
							<button type="submit" name="submit2" style="background:#20820d;border-radius:10px"   class="btn btn-info  fa fa-search pull-right" onClick="return tester2();"> FILTRER</button>



							<br>


							<!--FIN select pour taille de filtrage>-->
						</div>
					</form>
					<!--FIN FORM-->
				</br>
				<hr>

				<?php 

								//CREATION DE LA FOUNCTION FILTRE
				function filtre($taille,$user,$diplome,$specialite,$wilaya,$groupe,$recherche,$etab){


					$employers = Employe::trouve_tous_filtre_dsp($taille,$diplome,$specialite,$wilaya,$groupe,$etab);

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
						if($groupe[0]!="tous"){
							$specialite0=Specialite::trouve_par_groupe($groupe[0]);
							foreach($specialite0 as $specialite0){
								$s.=' '.htmlspecialchars(trim($specialite0->nom_specialite)).'"';
							}
							for($i=1;$i<sizeof($groupe);$i++){
								$specialite1=Specialite::trouve_par_groupe($groupe[$i]);	
								foreach($specialite1 as $specialite1){
									$s.=' et '.htmlspecialchars(trim($specialite1->nom_specialite)).'"';
								}
							}
						}
						else{
							$s.=" tous ";
						}

					}

					if(sizeof($specialite)>1){
						for($i=1;$i<sizeof($specialite);$i++){
							$specialit=Specialite::trouve_par_id($specialite[$i]);
							$s.=' et '.htmlspecialchars(trim($specialit->nom_specialite)).'"';
						}
					}

	//*********************************											

					$r="";
					if($recherche=="tous"){ $r="Recherche tous";} else { $r="Recherche structures";}



					?>
					<center><label class="alert alert-success" id="liste" style="font-size:12px;background:#0D9E1C"><span class='pull-left'>Resultat de filtrage  de </span><?php echo " <strong>diplome :</strong> <span style='color:#fff'>" .$d."</span>&nbsp;&nbsp;&nbsp;&nbsp; <strong>specialite : </strong><span style='color:#fff'>".$s."</span>&nbsp;&nbsp;&nbsp;&nbsp; ".$r; ?>
					<a  href='export_excel_filtre.php?var=<?php echo $diplome[0]; for($i=1;$i<sizeof($diplome);$i++){ echo ",".$diplome[$i];} echo "|";if($specialite[0]=="tous"){ if($groupe[0]!="tous"){
						$specialite0=Specialite::trouve_par_groupe($groupe[0]);
						for($i=0;$i<sizeof($specialite0)-1;$i++){
							echo htmlspecialchars(trim($specialite0[$i]->id_specialite)).',';
						}
						echo htmlspecialchars(trim($specialite0[sizeof($specialite0)-1]->id_specialite)).'|';
						for($i=1;$i<sizeof($groupe)-1;$i++){
							$specialite1=Specialite::trouve_par_groupe($groupe[$i]);	

							for($i=0;$i<sizeof($specialite1)-1;$i++){
								echo htmlspecialchars(trim($specialite1[$i]->id_specialite)).',';
							}
							echo htmlspecialchars(trim($specialite1[sizeof($specialite1)-1]->id_specialite)).'|';
						}
					}
					else{
						echo "tous|";
					} } else { echo $specialite[0]; for($i=1;$i<sizeof($specialite);$i++){ echo ",".$specialite[$i];} echo "|" ; } $wilaya=Wilayas::trouve_par_Nom(addslashes($user->wilaya));  echo $wilaya->id_w; echo "|".$recherche ; ?>' class='btn btn-danger pull-right' ><img width="20" src="img/icons/xls.png"> Export excel</a>
				</label></center>
				<div class="panel-body">

					<div class="scrollable1" id="scrol" >                                   
						<table id="table0" class="table table-responsive" style="Maw-width:none !important;direction:rtl;text-align:left;" >

							<thead>
								<tr>
									<th style="width:100px !important">Mouvement  </th>
									<th>Photo</th>
									<th>Type d'établissement</th>



									<th>Specialite</th>
									<th>Diplome</th>

									<th>Date de naissance</th>
									<th>Prenom d'employer </th>
									<th>Nom d'employer </th>
									<th>N°ord  </th>



								</tr>
							</thead>
							<tbody>
								<?php
								$i1=1;
								foreach($employers as $employer){
									
									if($employer->type_employe==-1){
										$erreur1=0;	$erreur2=0;$erreur3=0;$erreur4=0;$erreur=0;	

										$date=date('Y');	
										$date_n=substr($employer->date_nais_employe,0,4);	

										if(($date-$date_n)<18 or ($date-$date_n)>70){
											$erreur1=1;	
										}				
										if($employer->diplome==0 ){
											$erreur2=2;	
										}
										if($employer->specialite==0){
											$erreur3=3;	
										}
										if($employer->type_etablissement==0){
											$erreur4=4;	
										}	
										?>
										<strong><tr style="<?php  if($erreur==1 or $erreur==2 or $erreur==3 or $erreur==4){ ?> color:#000; background:#0f9a1a2e;  <?php }else {?>color:#000;background:#0f9a1a2e;<?php } ?>" id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>"> 
											<td style="background:#0D9E1C">
												<?php  if($user->type=="Admin_dsp"){?>
													<?php 
													global $bd;
													$query=$bd->requete('select * from employer where type_employe='. $employer->id_employe.'');
													?>
													<div class="btn-group" >
														<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
														<ul class="dropdown-menu" role="menu" style="z-index:1">

															<li><a style="font-size:12px" href="ajouter_autre_employe.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Ajouter autre employés a cette structure ">Ajouter  </a></li>
															<li> <a style="font-size:12px" href="edit_employer_pere.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé"> Modifier </a></li>
															<li><a style="font-size:12px"   href="affiliation.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Photo et affiliation">Photo et affiliation </a></li>
															<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
															<li><a style="font-size:12px"   href="transfere.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Transfère de locale">Transfère </a></li>
															<li><a style="font-size:12px" onClick="delete_row('<?php echo $employer->id_employe;?>');change_message_per();"  data-toggle="tooltip" title="Classé l'employé">Classé </a></span></li>
															<li><a style="font-size:12px"   href="fin_relation.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>
															
															<li><a style="font-size:12px;cursor: pointer;"   onclick="get_fils(<?php echo $employer->id_employe;?>)" target="_blank" data-toggle="tooltip" title="liste des employés dans la structure">Emplyés de la structure (<?php echo mysqli_num_rows($query); ?>)
															</button></li>


														</ul>
													</div>
												<?php  }?>

											</td>
											  <td>
													<?php 
													$src_photo="";
													if($affiliation=Affiliation::trouve_par_id($employer->id_employe))
													{
														$src_photo="doc_pdf/".$affiliation->photo;
													}
													?>
												<img class='img-responcive pull-right'    type='image' id='photo' src='<?php if($src_photo!=''){ echo $src_photo; }  else { ?> http://placehold.it/100 <?php } ?>'  width='40' height='40'  onClick='affiche(this)'/>
													
													</td> 


											<td <?php if($erreur4==4){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?>>												
												<?php
												if($etablissement=Etablissement::trouve_par_id($employer->type_etablissement))
													echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); else echo "VIDE"; ?></td>

												<td <?php if($erreur3==3){ ?> style="background:red;color:#fff;text-align:center " <?php } ?>  > <?php
												if($specialite=Specialite::trouve_par_id($employer->specialite))
													echo (htmlspecialchars_decode($specialite->nom_specialite)); else echo "VIDE"; ?></td>
												<td <?php if($erreur2==2){ ?> style="background:red;color:#fff;text-align:center "<?php } ?>><?php 
												if($diplome=Diplome::trouve_par_id($employer->diplome))
													echo (htmlspecialchars_decode($diplome->nom_diplome)); else echo "VIDE"; ?></td> 
												
												<td <?php if($erreur1==1 and $employer->nais_valide==0){ ?> style="color:#fff; background:red;"   <?php } ?>><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
												<td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
												<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>

												<td><?php echo $i1; ?></td>
											</tr></strong>
											<?php ++$i1;  }

											if($employer->type_employe==0){
												$erreur1=0;	$erreur2=0;$erreur3=0;$erreur4=0;$erreur=0;	

												$date=date('Y');	
												$date_n=substr($employer->date_nais_employe,0,4);	

												if(($date-$date_n)<18 or ($date-$date_n)>70){
													$erreur1=1;	
												}				
												if($employer->diplome==0 ){
													$erreur2=2;	
												}
												if($employer->specialite==0){
													$erreur3=3;	
												}
												if($employer->type_etablissement==0){
													$erreur4=4;	
												}	
												?>
												<b><tr style=" <?php  if($erreur==1 or $erreur==2 or $erreur==3 or $erreur==4){ ?> color:#000; background:#0f9a1a2e;  <?php }else {?>color:#000;background:#0f9a1a2e;<?php } ?>" id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>"> 
													<td style="background:#0D9E1C">

														<?php  if($user->type == 'Admin_dsp'){?>
															<span> 
																<div class="btn-group" >
																	<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
																	<ul class="dropdown-menu" role="menu" style="z-index:1">
																		<li><a style="font-size:12px" href="ajouter_autre_employe.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Ajouter autre employés a cette structure ">Ajouter</a></li>

																		<li><a style="font-size:12px"  href="edit_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé">Modifier </a></li>
																		<li><a style="font-size:12px"   href="affiliation.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Photo et affiliation">Photo et affiliation </a></li>

																		<li><a style="font-size:12px"   href="transfere.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Transfère de locale">Transfère </a></li>

																		<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank"  data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
																		<li><a style="font-size:12px" onClick="delete_row('<?php echo $employer->id_employe;?>');change_message();" target="_blank" data-toggle="tooltip" title="Classé l'employé">Classé</a></span></li>
																		<li><a style="font-size:12px"   href="fin_relation.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Fin de relation de travail">Fin de Contrat </a></li>
																	</ul>
																</div>
															<?php  }?>
														</td>	
														  <td>
													<?php 
													$src_photo="";
													if($affiliation=Affiliation::trouve_par_id($employer->id_employe))
													{
														$src_photo="doc_pdf/".$affiliation->photo;
													}
													?>
												<img class='img-responcive pull-right'    type='image' id='photo' src='<?php if($src_photo!=''){ echo $src_photo; }  else { ?> http://placehold.it/100 <?php } ?>'  width='40' height='40'  onClick='affiche(this)'/>
													
													</td> 
														<td <?php if($erreur4==4){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?>>												
															<?php
															if($etablissement=Etablissement::trouve_par_id($employer->type_etablissement))
																echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); else echo "VIDE"; ?></td>

															<td <?php if($erreur3==3){ ?> style="background:red;color:#fff;text-align:center " <?php } ?>  > <?php
															if($specialite=Specialite::trouve_par_id($employer->specialite))
																echo (htmlspecialchars_decode($specialite->nom_specialite)); else echo "VIDE"; ?></td>
															<td <?php if($erreur2==2){ ?> style="background:red;color:#fff;text-align:center "<?php } ?>><?php 
															if($diplome=Diplome::trouve_par_id($employer->diplome))
																echo (htmlspecialchars_decode($diplome->nom_diplome)); else echo "VIDE"; ?></td> 

															<td <?php if($erreur1==1 and $employer->nais_valide==0){ ?> style="color:#fff; background:red;"   <?php } ?>><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
															<td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
															<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>

															<td><?php echo $i1;?></td>

															<?php
															++$i1;
														}

														if($recherche=='tous'){
															if($employer->type_employe!=0 &&  $employer->type_employe!=-1){


																$erreur1=0;	$erreur2=0;$erreur3=0;$erreur4=0;$erreur=0;	
																
																$date=date('Y');	
																$date_n=substr($employer->date_nais_employe,0,4);	

																if(($date-$date_n)<18 or ($date-$date_n)>70){
																	$erreur1=1;	
																}				
																if($employer->diplome==0 ){
																	$erreur2=2;	
																}
																if($employer->specialite==0){
																	$erreur3=3;	
																}
																if($employer->type_etablissement==0){
																	$erreur4=4;	
																}										


																?>

																<tr  style="<?php  if($erreur1==1 or $erreur2==2 or $erreur3==3 or $erreur4==4){ ?> color:#000; background:#fff;  <?php }else {?> color:#000; background:#fff;<?php } ?>" id ="<?php echo htmlspecialchars_decode($employer->id_employe); ?>">
																	<td style="background:#0D9E1C">
																		<?php  if($user->type == 'Admin_dsp'){?>
																			<div class="btn-group" >
																				<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=" width:150px;color:green"><i class="fa fa-cog" ></i><b>  Gestion Dossier</b> </button>
																				<ul class="dropdown-menu" role="menu" style="z-index:1">

																					<li><a style="font-size:12px"  href="edit_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Modifier l'employé"> Modifier</a></li>
																					<li><a style="font-size:12px"   href="affiliation.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Photo et affiliation">Photo et affiliation </a></li>
																					<li><a style="font-size:12px"  href="detail_employer.php?id_employe=<?php echo $employer->id_employe;?>" target="_blank" data-toggle="tooltip" title="Detail l'employé">Detail </a></li>
																					<li><a style="font-size:12px"  onClick="delete_row('<?php echo $employer->id_employe;?>');change_message();" target="_blank" data-toggle="tooltip" title="Classé l'employé">Classé</a></li>
																					<li><a style="font-size:12px"   href="fin_relation_fis.php?id_employe=<?php echo $employer->id_employe;?>" data-toggle="tooltip" target="_blank" title="Fin de relation de travail">Fin de Contrat </a></li>


																				</ul>
																			</div>
																		<?php }?>
																	</td>
																	  <td>
													<?php 
													$src_photo="";
													if($affiliation=Affiliation::trouve_par_id($employer->id_employe))
													{
														$src_photo="doc_pdf/".$affiliation->photo;
													}
													?>
												<img class='img-responcive pull-right'    type='image' id='photo' src='<?php if($src_photo!=''){ echo $src_photo; }  else { ?> http://placehold.it/100 <?php } ?>'  width='40' height='40'  onClick='affiche(this)'/>
													
													</td> 
													<td <?php if($erreur4==4){ ?> style="background:red;color:#fff;text-align:center "  <?php } ?>>												
																		<?php
																		if($etablissement=Etablissement::trouve_par_id($employer->type_etablissement))
																			echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); else echo "VIDE"; ?></td>

																		<td <?php if($erreur3==3){ ?> style="background:red;color:#fff;text-align:center " <?php } ?>  > <?php
																		if($specialite=Specialite::trouve_par_id($employer->specialite))
																			echo (htmlspecialchars_decode($specialite->nom_specialite)); else echo "VIDE"; ?></td>
																		<td <?php if($erreur2==2){ ?> style="background:red;color:#fff;text-align:center "<?php } ?>><?php 
																		if($diplome=Diplome::trouve_par_id($employer->diplome))
																			echo (htmlspecialchars_decode($diplome->nom_diplome)); else echo "VIDE"; ?></td> 

																		<td <?php if($erreur1==1 and $employer->nais_valide==0){ ?> style="color:#fff; background:red;"   <?php } ?>><?php echo htmlspecialchars_decode($employer->date_nais_employe); ?></td>
																		<td><?php echo htmlspecialchars_decode($employer->prenom_employe); ?></td>   
																		<td><?php echo htmlspecialchars_decode($employer->nom_employe); ?></td>
																		<td><?php echo $i1; ?></td>
																	</tr>
																	<?php

																	++$i1;
																}
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
										if(empty($_POST['diplome'])){
											$diplome="tous";	
										}else{ $diplome= $_POST['diplome'] ;

									}

									$groupe="";
									if(empty($_POST['groupe_specialite'])){
										$groupe="tous";	
									}else{ $groupe=($_POST['groupe_specialite']) ;}

									$specialite="";
									if(empty($_POST['specialite'])){
										$specialite="tous";	
									}else{ $specialite=($_POST['specialite']) ;}

									$etablissement="";
									if(empty($_POST['etablissement'])){
										$etablissement="tous";	
									}else{ $etablissement=($_POST['etablissement']) ;}

									$wilay=$user->wilaya;	
									$wila=Wilayas::trouve_par_Nom(addslashes($wilay));
									$wilaya=$wila->id_w;

									if($diplome!="tous" | $specialite!="tous"  | $groupe!="tous" ){
										filtre(0,$user,$diplome,$specialite,$wilaya,$groupe,$_POST['recherche'],$etablissement);

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

<div class="message-box animated fadedIn" data-sound="alert" id="modal_apercu" >
	<br><br>
	<div class="row">
		<div class="mb-middle col-xs-8 col-xs-offset-2" style="border-radius: 5px; background:#fff; ">
			<br>
			<div class="mb-title"><span ></span>  <strong></strong> </div>
			<center>
				<button class="pull-right" style="color: red" onclick="$('#modal_apercu').hide();">X</button>
				<br>
				<table>
					<tr>
						<div class="mb-content" id="fils" style="overflow-y: scroll;height: 500px">



						</div>
						<script type="text/javascript">
							function get_fils(pere){
								$('#modal_apercu').show();
								$.ajax({
									method:"post",
									url:'ajax_fils.php',
									data:{pere:pere},
									success:function(resultData){
										$('#fils').empty();
										$("#fils").append(resultData);
									}

								})
							}
						</script>
					</tr>
				</table>
			</center>
			<div class="col-xs-6">
			</div>
			<div class="mb-footer">
				<div class="pull-right">
					<br>
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


    <div class="message-box animated fadedIn" data-sound="alert" id="modal_apercu2" >
    	<br><br><br><br>
    	<br><br>
    	
    	<div class="row">
    		<div class="mb-middle col-sm-6 col-sm-offset-3" style="border-radius: 5px; background:#fff; ">
    			<br>
    			<div class="mb-title"><span ></span>  <strong></strong> </div>

    			<center>

    				<button class="pull-right" style="color: red" onclick="$('#modal_apercu2').hide();">X</button>

    				<table>
    					<tr>
    					
    						<div class="mb-content">
    							<img height="500" class="col-sm-12" id="img01">

    						</div>
    				
    					</tr>

    				</table>


    				
    			</center>
    			
    			
    		
    		

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

<script type="text/javascript">


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

	     function affiche(img){
        
	 $("#modal_apercu2").show();
	//var modal = document.getElementById('modal_apercu');
	var modalImg = document.getElementById('img01')

	var captionText = document.getElementById("caption");
	
    modalImg.src = img.src;
	

    captionText.innerHTML = img.alt;
	//alert(captionText.innerHTML);
	// img.id.css('visibility','hidden');
	
}



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
img:hover 
	{
		opacity: 0.7;
		cursor: pointer;
	}
	
</style>


<!-- END TEMPLATE -->      
<!-- END SCRIPTS -->                   
</body>
</html>
