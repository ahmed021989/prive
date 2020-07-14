<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'DGSS-RH');
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
	if($user->type!='administrateur' and $user->type!='DGSS-RH' ){
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
?>


<?php
$titre = "detail de l'employé ";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp'  ){
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

			<form class="form-horizontal" name="ajouter_direction"  id = "ajouter_direction" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
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

						<div class='row' style="color:black">
							<div class="col-md-4">
								<b>NOM:</b> <?php echo $employer->nom_employe?></div>
								<div class="col-md-4">
									<b>PRENOM: </b><?php echo $employer->prenom_employe; ?>
								</div>
								<div class="col-md-4">
									<b>EPOUX: </b><?php echo $employer->epoux; ?>
								</div>
							</div><!--fin row 1-->
							<br>
							<div class='row' style="color:black">
								<div class="col-md-4">
									<b>SEXE:</b> <?php echo $employer->sexe_employe;?></div>
									<div class="col-md-4">
										<b>DATE NAISSANCE: </b><?php echo $employer->date_nais_employe; ?>
									</div>
									<div class="col-md-4">
										<b>COMMUNE NAISSANCE: </b><?php if($commune0=Communes::trouve_par_code_postal($employer->commune_nais)) echo $commune0->nom_com; ?>
									</div>
								</div><!--fin row 2-->
								<br>
								<div class='row' style="color:black">
									<div class="col-md-4">
										<b>FONCTION:</b> <?php
										if($fonction=Fonction::trouve_par_id($employer->diplome)) echo $fonction->nom_fonc;?></div>
										<div class="col-md-8">
											<b>DATE INSTALLATION: </b><?php echo $employer->date_instal; ?>
										</div>
									</div><!--fin row 3-->
									<br>
									<div class='row' style="color:black">

										<div class="col-md-4">
											<b>DIPLOME: </b><?php if($diplome=Diplome::trouve_par_id($employer->diplome)) echo $diplome->nom_diplome; ?>
										</div>
										<div class="col-md-8">
											<b>SPECIALITE: </b><?php if($specialite=Specialite::trouve_par_id($employer->specialite)) echo $specialite->nom_specialite; ?>
										</div>
										<br>
										<hr style="border-color:green">



										<div class='row' style="color:black">
											<div class="col-md-6">
												<b>TYPE D'ETABLISSEMENT:</b> <?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id_employe."");while ($rows = $bd->fetch_array($SQL)){  if($etablissment=Etablissement::trouve_par_id($rows["type_etablissement"])) echo htmlspecialchars_decode(stripcslashes($etablissment->type_etab));}?>
											</div>
											<div class="col-md-6">
												<b>IDENTITE JURIDIQUE COMMERCIELLE: </b><?php echo $employer->identite_jurdique; ?>
											</div>
										</div><!--fin row 1-->
										<br>
										<div class='row' style="color:black">
											<div class="col-md-6">
												<b>COMMUNE D'INSTALLATION: </b><?php if($commune=Communes::trouve_par_code_postal($employer->commune_installation))  echo $commune->nom_com; ?>
											</div>
											<div class="col-md-6">
												<b>DATE DE CREATION:</b> <?php echo $employer->date_creation ;?>
											</div>
										</div><!--fin row 2-->
										<br>
										<div class='row' style="color:black">
											<div class="col-md-12">
												<b>ADRESSE: </b><?php echo $employer->adrs; ?>
											</div>
										</div><!--fin row 3-->
										<br>
										<div class='row' style="color:black">
											<div class="col-md-4">
												<b>Wilaya: </b><?php if( $wilaya=Wilayas::trouve_par_id($employer->wilaya))  echo $wilaya->nom; ?>
											</div>
											<div class="col-md-4">
												<b>NUMERO AGREMENT: </b><?php echo $employer->numero_agriment; ?>
											</div>
											<div class="col-md-4">
												<b>DATE AGREMENT : </b><?php echo $employer->date_agriment; ?>
											</div>
										</div><!--fin row4 -->
										<br>

									</div>
								</div>                    



								<!-- END PAGE CONTENT WRAPPER -->                                
							</div> 
						</form>	

						<h4></h4>
						<div class="page-content-wrap" > 

							<div class="col-md-12" style="border:1px solid red">
								<div class="panel panel-default"  >
									<div class="panel-heading" >                                
										<h3 class="panel-title"> HISTORIQUE D'EMPLOI </h3>

									</div>



									<!--fin relation -->
									<!--********************-->
									<?php 
									if($fin_relation=Fin_relation::trouve_par_id2($employer->id_employe)){ 
										$i1=1;

										?>
										<h3 class="panel-title"> Contrats </h3>
										<div class="panel-body" >

											<div class="scrollable1" id="scrol"  style="background:#F5F5F5" >                                   
												<table id="table_muta" class="table  table-striped"  style="background:#F5F5F5">

													<thead>
														<tr>

															<th>Numéro  </th>	
															<th>Date installation</th>
															<th>Date fin contrat</th>
															<th>Spécialité</th>
															<th>Type d'établissement</th>
															<th>Identite_jurdique</th>
															<th>Commune installation </th>
														</tr>
													</thead>
													<?php foreach($fin_relation as $fin_relation){  ?>
														<tbody>
															<tr>
																<td><?php echo  $i1;  ?></td> 
																<td><?php echo  $fin_relation->date_instal;  ?></td> 
																<td><?php echo  $fin_relation->date_fine;  ?></td> 
																<td><?php  $specialite=Specialite::trouve_par_id($fin_relation->specialite); echo $specialite->nom_specialite;  ?></td>
																<td><?php  $etab=Etablissement::trouve_par_id($fin_relation->type_etablissement); echo $etab->type_etab;  ?></td> 
																<td><?php echo $fin_relation->identite_jurdique; ?></td> 
																<td><?php   $commune=Communes::trouve_par_code_postal($fin_relation->commune_installation); echo $commune->nom_com;  ?></td> 




															</tr>
															<?php  $i1++; } ?>
														</tbody>
													</table>

												</div>
											</div>
										<?php } ?>



										<!--transfer -->
										<!--********************-->
										<?php 
										if($transfere=Transfere::trouve_par_id2($employer->id_employe)){ 
											$i1=1;

											?>
											<h3 class="panel-title"> Transfert </h3>
											<div class="panel-body" >

												<div class="scrollable1" id="scrol"  style="background:#F5F5F5" >                                   
													<table id="table_muta" class="table  table-striped"  style="background:#F5F5F5">

														<thead>
															<tr>

																<th>Numéro  </th>	
																<th>Date Transfert</th>
																<th>Adresse</th>
																<th>identite_jurdique</th>
																<th>Type d'établissement</th>
																<th>commune installation </th>
																<th>Date création </th>   






															</tr>
														</thead>
														<?php foreach($transfere as $transfere){  ?>
															<tbody>
																<tr>
																	<td><?php echo  $i1;  ?></td> 
																	<td><?php echo  $transfere->date_trans;  ?></td> 
																	<td><?php echo  $transfere->adrs;  ?></td> 
																	<td><?php echo $transfere->identite_jurdique; ?></td> 
																	<td><?php  $etab=Etablissement::trouve_par_id($transfere->type_etablissement); echo $etab->type_etab;  ?></td> 
																	<td><?php   $commune=Communes::trouve_par_code_postal($transfere->commune_installation); echo $commune->nom_com;  ?></td> 
																	<td><?php echo  $transfere->date_creation;  ?></td> 



																</tr>
																<?php  $i1++; } ?>
															</tbody>
														</table>

													</div>
												</div>
											<?php } ?>

										</div>
									</div>


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


									<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>

									<!-- END THIS PAGE PLUGINS -->       
									<!-- START TEMPLATE -->
									<script type="text/javascript" src="js/plugins.js"></script>        
									<script type="text/javascript" src="js/actions.js"></script>        
									<!-- END TEMPLATE -->
									<script>
										function verif_date(){

											var date_n = document.getElementById('date_nais_employe').value;

											var anne=date_n.substring(0,4);
											var d= new Date();
											d2=d.getFullYear();
											if(d2-anne<18 | d2-anne>70){
												document.getElementById('date_nais_employe').style.background='red';
												document.getElementById('date_nais_employe').style.color='white';		
//alert("verifier date naissance");
return false;
}
else{

	return true;
}
}

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






