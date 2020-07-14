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
	<li class="active">Tableau de bord > structures</li>
</ul>
<!-- END BREADCRUMB -->                       

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">


	<?php if  ($user->type == 'administrateur' || $user->type == 'DGSS-RH')   {  ?>   
		<!-- PAGE CONTENT WRAPPER -->
		<div class="page-content-wrap">
			<!-- START WIDGETS -->                    
		



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


									<ul class="panel-controls">

										<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
										<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>

										
									</ul>                                
								</div>
								<div class="panel-body">
									<table id="table0" style="color:#000;background:#0f9a1a2e"  class="table datatable scrollable table-striped">
										<thead>
											<tr>

												<th>N° Ord  </th>
												<th>Nom Wilaya</th>
												<th>Population</th>
												<th>Nbr cabinet généraliste</th>
												<th>Nbr Employés</th>
												<th>Nbr officine pharmaceutique</th>
												<th>Nbr Employés</th>

												<th>Nbr cabinet de specialistes</th>
												<th>Nbr Employés specialistes</th>
												<th>Nbr Employés géneralistes</th>
												<th>Total cabinet specialistes</th>


												
												<th>Nbr cabinet de groupe specialistes</th>
												<th>Nbr cabinet de groupe generalistes</th>
												<th>Nbr Employés specialistes</th>
												<th>Nbr Employés géneralistes</th>
												<th>Total groupe</th>




											</tr>
										</thead>
										<tbody>
											<?php 

											for($i=1;$i<49;$i++){
												?>
												<tr >
													<?php
													$SQL0 = $bd->requete("SELECT * FROM  wilayas where id_w=".$i."") ;
													$nom_wil="";$pop_wil="";
													while($row=mysqli_fetch_array($SQL0)){
														$nom_wil=$row['nom'];	
														$pop_wil=$row['pop_wil'];
													}

										 // cabinet géneraliste

													$SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement=6  and employer.specialite=119  and(employer.type_employe=-1 or employer.type_employe=0) and archive=0") ;
													while($row=mysqli_fetch_array($SQL2)){
														$nbr_structure_m = $row['som2'];
													}

													$SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement=6 and employer.specialite=119 and archive=0") ;
													while($row=mysqli_fetch_array($SQL1)){
														$nbr_employe_m = $row['som'];
													}





										 /// officine pharmaceutique

													$SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement=38 and employer.specialite=125 and(employer.type_employe=-1 or employer.type_employe=0) and archive=0") ;
													while($row=mysqli_fetch_array($SQL2)){
														$nbr_structure_ph = $row['som2'];
													}

													$SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement=38  and employer.specialite=125 and archive=0") ;
													while($row=mysqli_fetch_array($SQL1)){
														$nbr_employe_ph = $row['som'];
													}



										   /// Cabinet de specialistes

													$SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas,specialite where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12) and employer.diplome=13 and employer.specialite=specialite.id_specialite  and  specialite.id_groupe_specialite in(1,2,3)										 and(employer.type_employe=-1 or employer.type_employe=0) and archive=0") ;
													while($row=mysqli_fetch_array($SQL2)){
														$nbr_structure_sp = $row['som2'];
													}

													$SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12)  and employer.diplome=13 and employer.specialite=specialite.id_specialite and  specialite.id_groupe_specialite in(1,2,3) and archive=0") ;
													while($row=mysqli_fetch_array($SQL1)){
														$nbr_employe_sp = $row['som'];
													}

													$SQL3 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12)  and employer.specialite=119  and employer.specialite=specialite.id_specialite  and  specialite.id_groupe_specialite in(7) and archive=0") ;
													while($row=mysqli_fetch_array($SQL3)){
														$nbr_employe_gen = $row['som'];
													}

													$SQL0 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12) and (employer.diplome=13 or employer.specialite=119) and employer.specialite=specialite.id_specialite  and  specialite.id_groupe_specialite in(1,2,3,7)  and archive=0") ;
													while($row=mysqli_fetch_array($SQL0)){
														$nbr_employe_total_spe = $row['som'];
													}



										  /// Cabinet de groupe



													$SQL5 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas,specialite where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.diplome=13 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(1,2,3) and(employer.type_employe=-1 or employer.type_employe=0) and archive=0") ;
													while($row=mysqli_fetch_array($SQL5)){
														$nbr_structure_groupe_sp = $row['som2'];
													}

													$SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas,specialite where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=119 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(7) and(employer.type_employe=-1 or employer.type_employe=0) and archive=0") ;
													while($row=mysqli_fetch_array($SQL2)){
														$nbr_structure_groupe_gp = $row['som2'];
													}


													$SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(7) and employer.specialite=119 and archive=0") ;
													while($row=mysqli_fetch_array($SQL1)){
														$nbr_employe_generaliste = $row['som'];
													}

													$SQL3 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(1,2,3) and employer.diplome=13 and archive=0") ;
													while($row=mysqli_fetch_array($SQL3)){
														$nbr_employe_specialiste= $row['som'];
													}

													$SQL0 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where wilayas.id_w=".$i." and wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(1,2,3,7) and (employer.diplome=13 or employer.specialite=119)  and archive=0") ;
													while($row=mysqli_fetch_array($SQL0)){
														$nbr_employe_total_groupe = $row['som'];
													}


													echo "<td>".$i."</td> <td>".$nom_wil."</td>"."<td style='text-align:right'>".number_format($pop_wil, 0, ',', ' ')."</td><td style='text-align:right'>".number_format($nbr_structure_m, 0, ',', ' ')."</td>"."<td style='text-align:right'>".number_format($nbr_employe_m, 0, ',', ' ')."</td><td style='text-align:right'>".number_format($nbr_structure_ph, 0, ',', ' ')."</td>"."<td style='text-align:right'>".number_format($nbr_employe_ph, 0, ',', ' ')."</td>
													<td style='text-align:right'>".number_format($nbr_structure_sp, 0, ',', ' ')."</td>"."<td style='text-align:right'>".number_format($nbr_employe_sp, 0, ',', ' ')."</td><td style='text-align:right'>".number_format($nbr_employe_gen, 0, ',', ' ')."</td>"."<td style='text-align:right'>".number_format($nbr_employe_total_spe, 0, ',', ' ')."</td>
													<td style='text-align:right'>".number_format($nbr_structure_groupe_sp, 0, ',', ' ')."</td>"."<td style='text-align:right'>".number_format($nbr_structure_groupe_gp, 0, ',', ' ')."</td>"."<td style='text-align:right'>".number_format($nbr_employe_specialiste, 0, ',', ' ')."</td><td style='text-align:right'>".number_format($nbr_employe_generaliste, 0, ',', ' ')."</td>"."<td style='text-align:right'>".number_format($nbr_employe_total_groupe, 0, ',', ' ')."</td>";

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
										<div class="widget-int num-count"><strong><?php $wilaya=Wilayas::trouve_par_Nom(addslashes($user->wilaya));  $SQL = $bd->requete("SELECT * FROM  `employer` where wilaya='".$wilaya->id_w."' and archive=0") ;
										$nbr1 = mysqli_num_rows($SQL);
										echo $nbr1;
										?></strong></div>
										<div class="widget-title">Employés</div>

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
										<div class="widget-int num-count"><strong><?php $wilaya=Wilayas::trouve_par_Nom(addslashes($user->wilaya));  $SQL = $bd->requete("SELECT * FROM  `employer` where (`type_employe` = '-1' or `type_employe` = '0') and wilaya='".$wilaya->id_w."' and archive=0 ") ;
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
						



						<!-- etat numerique par commune-->
						<div class="panel panel-default">

							<div class="panel-body">
								<table id="table0" class="table datatable scrollable table-striped" style="background:#0f9a1a2e;color:#000">
									<thead style="background:#0f9a1a2e">
										<tr>

											<th>N° Ord  </th>
											<th>Nom Commune</th>
											<th>Population</th>
											<th>Nbre Structures</th>
											<th>Nbre Employés</th>
											

											

										</tr>
									</thead>
									<tbody>
										<?php 
										$wilaya=Wilayas::trouve_par_Nom(addslashes($user->wilaya));
										$communes=Communes::trouve_tous_wilaya($wilaya->id_w);
										$i=1;
										foreach($communes as $commune){

											?>
											<tr>
												<?php


												$SQL1 = $bd->requete("SELECT count(*) as som FROM  `employer`,communes where communes.code_postal=employer.commune_installation and communes.code_postal=".$commune->code_postal." and archive=0 ") ;
												while($row=mysqli_fetch_array($SQL1)){
													$nbr_employe = $row['som'];  
												}


												$SQL2 = $bd->requete("SELECT count(*) as som2 FROM  `employer`,communes where communes.code_postal=employer.commune_installation and communes.code_postal=".$commune->code_postal." and(employer.type_employe=-1 or employer.type_employe=0) and archive=0") ;
												while($row=mysqli_fetch_array($SQL2)){
													$nbr_structure = $row['som2'];  
												}




												echo "<td>".$i."</td> <td>".$commune->nom_com."</td>"."<td style='text-align:right'>".number_format($commune->pop_com, 0, ',', ' ')."</td><td style='text-align:right'>".number_format($nbr_structure, 0, ',', ' ')."</td>"."<td style='text-align:right'>".number_format($nbr_employe, 0, ',', ' ')."</td>";

										// echo $nbr_employe ." et ".$nbr_structure." i ".$i."<br>";
												?>
											</tr>
											<?php
											++$i;}
											?>




										</tbody>
									</table>
								</div>

							</div>

						</div>


					<?php } ?>
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
