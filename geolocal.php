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
$titre = "Géolocalisation des structures";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
	
}

?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
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
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="index.php">Accueil</a></li>                    
	<li class="active">Tableau de bord > Géolocalisation des structures par wilaya</li>
</ul>
<!-- END BREADCRUMB -->                       
<?php if  ($user->type == 'administrateur' or $user->type=="DGSS-RH")   {  ?>   
	<!-- PAGE CONTENT WRAPPER -->

	<!-- START WIDGETS -->                    




	<!-- END WIDGETS -->                    


	<br>
	<div class="row">
		<div class="col-md-12">

			<!-- START DEFAULT DATATABLE -->
			<div class="panel panel-default">
				<div class="panel-heading">                                

						<!-- 	<h3 class="panel-title"><strong>Géolocalisation des structures par wilaya</strong></h3>
						-->
					</div>
					<div class="row" >
			<div id="mapDiv0" class="col-md-2 pull-left	" style="border-radius: 4px; height: 600px;border:1px solid #777;overflow-y: scroll;">

				<?php 
				$sql=$bd->requete('select * from wilayas');
				while ($row=mysqli_fetch_array($sql)) 
				{
					if($row['id_w']!=49)
					{
						?>
						<span class='btn btn-block wila' id="<?php echo $row['id_w']; ?>" onclick="show(<?php echo $row['id_w'].",'".$row['nom']."'"; ?>)"> <?php echo $row['nom'] ;?></span>
						<?php
					}
				}
				?>

						</div> <!-- fin col-2 -->

						<div id="mapDiv" class="col-md-7 " style="border-radius: 4px; height: 600px;border:1px solid #777;">
							<!-- 	la carte s'affiche ici -->
						</div> <!-- fin col-7 -->
						<div id="mapDiv1" class="col-md-3" style="border-radius: 4px; height: 600px;border:1px solid #777;">
							<div class="row text-center" >
								<div class="col-md-12"> 
									<label id="label_wilaya" class="affiche">Wilaya</label>
								</div> <!-- fin col-md-12 -->

							</div> <!-- fin row -->

							<div class="row text-center" > <!-- debut row -->
								<div class="col-md-6"> 
									<b style="font-size: 20px;color: #000" >Employés</b> <br>
									<label id="label_total_structure" class="affiche">0</label>
							</div> <!-- fin col-md-6 -->
								<div class="col-md-6"> 
									<b style="font-size: 20px;color: #000">	Structures</b><br>
									<label id="label_total_employe" class="affiche">0</label>
								</div> <!-- fin col-md-6 -->


							</div> <!-- fin row -->

						</div> <!-- fin col-3 -->

			


					
					</div> <!-- fin row  -->
					<div class="row"> <!-- debut row -->
						<div class="col-md-12" style="border-radius: 4px; border:1px solid #777"> 

						</div>
					</div> <!-- fin de row -->

				</div>
			<!-- 	box de déconnexion --> 
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
		</div>



	<?php  } ?>
	<script>
		// position we will use later
		var lat = 36.0518439;
		var lon = 3.2891143;
		// initialize map
		map = L.map('mapDiv').setView([lat, lon], 7);
		// set map tiles source
		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
			maxZoom: 8,
		}).addTo(map);
		
		var villes = {
			"1":{"lat" :  27.9660477,"lon": -0.47043    ,'nam':"Adrar"},
			"2":{"lat" :  36.20342  ,"lon" : 1.26807    ,'nam':"chlef"},
			"3":{"lat" :  33.58333  ,"lon" : 2.66667    ,'nam':"Laghouat"},
			"4":{"lat" :  35.83333  ,"lon" : 7.08333    ,'nam':"Oum el Bouaghi"},
			"5":{"lat" :  35.5      ,"lon":5.91667		 ,'nam':"Batna"},
			"6":{"lat" :  36.66667  ,"lon": 4.91667 	 ,'nam':"Béjaïa"},
			"7":{"lat" :  34.66667  ,"lon": 5.41667 	 ,'nam':"Biskra"},
			"8":{"lat" :  30.25     ,"lon": -3.08333	 ,'nam':" Béchar"},
			"9":{"lat" :  36.481377 ,"lon": 2.7301504	 ,'nam':"Blida"},
			"10":{"lat" :  36.25     ,"lon": 3.91667	 ,'nam':"Bouira"},
			"11":{"lat" :  23.75     ,"lon":4.66667  	 ,'nam':"Tamanrasset"},
			"12":{"lat" :  35        ,"lon":7.83333 	 ,'nam':"Tebessa"},
			"13":{"lat" :  34.66667  ,"lon": -1.41667 	 ,'nam':"Tlemcen"},
			"14":{"lat" :  34.91667  ,"lon": 1.58333 	 ,'nam':"Tiaret"},
			"15":{"lat" :  36.75     ,"lon": 4.25  	 	 ,'nam':"Tizi Ouzou"},
			"16":{"lat" :  36.7538345,"lon": 3.0534636 	 ,'nam':"Alger"},
			"17":{"lat" :  34.342841 ,"lon": 3.217253	 ,'nam':"Djelfa"},
			"18":{"lat" :  36.75     ,"lon": 6 			 ,'nam':"Jijel"},
			"19":{"lat" :  36.189275 ,"lon" : 5.403493 	 ,'nam':"Sétif"},
			"20":{"lat" :  34.743349 ,"lon" : 0.244076	 ,'nam':"Saida"},
			"21":{"lat" :  36.75     ,"lon": 6.83333	 ,'nam':"Skikda"},
			"22":{"lat" :  34.83333  ,"lon": -0.5  		 ,'nam':"Sidi Belabbes"},
			"23":{"lat" :  36.83333  ,"lon": 7.58333 	 ,'nam':"Annaba"},
			"24":{"lat" :  36.41667  ,"lon": 7.41667 	 ,'nam':"Guelma"},
			"25":{"lat" :  36.33333  ,"lon": 6.66667	 ,'nam':"Constantine"},
			"26":{"lat" :  36.08333  ,"lon": 3 			 ,'nam':"Medea"},
			"27":{"lat" :  36        ,"lon": 0.33333	 ,'nam':"Mostaganem"},
			"28":{"lat" :  35.33333  ,"lon": 4.33333	 ,'nam':"M’sila"},
			"29":{"lat" :  35.41667  ,"lon": 0.16667 	 ,'nam':"Mascara"},
			"30":{"lat" :  30.5      ,"lon": 6.16667 	 ,'nam':"Ouargla"},
			"31":{"lat" :  35.7112355,"lon": -0.7082324	 ,'nam':"Oran"},
			"32":{"lat" :  32.5      ,"lon": 1.16667	 ,'nam':"El Bayadh"},
			"33":{"lat" :  26.83333  ,"lon": 8.16667 	 ,'nam':"Illizi"},
			"34":{"lat" :  36.08333  ,"lon": 4.75 		 ,'nam':"Bordj Bou Arréridj"},
			"35":{"lat" :  36.75     ,"lon": 3.66667	 ,'nam':"Boumerdes"},
			"36":{"lat" :  36.75     ,"lon": 8.16667 	 ,'nam':" El Tarf"},
			"37":{"lat" :  27.41667  ,"lon": -5.83333	 ,'nam':"Tindouf"},
			"38":{"lat" :  35.75     ,"lon": 1.75 		 ,'nam':"Tissemsilt"},
			"39":{"lat" :  33.16667  ,"lon": 7.25 		 ,'nam':"El Oued"},
			"40":{"lat" :  35        ,"lon": 7 			 ,'nam':"Khenchela"},
			"41":{"lat" :  36.16667  ,"lon": 7.91667	 ,'nam':"Souk Ahras"},
			"42":{"lat" :  36.58333  ,"lon": 2.41667	 ,'nam':"Tipaza"},
			"43":{"lat" :  36.41667  ,"lon": 6.16667	 ,'nam':"Mila"},
			"44":{"lat" :  36.16667  ,"lon": 2.16667	 ,'nam':"Ain Defla"},
			"45":{"lat" :  33.5      ,"lon": -0.83333 	 ,'nam':"Naama"},
			"46":{"lat" :  35.33333  ,"lon": -1.08333	 ,'nam':"Ain Temouchent"},
			"47":{"lat" :  31.08333  ,"lon": 3.16667	 ,'nam':"Ghardaia"},
			"48":{"lat":   35.684    ,"lon": 0.582		 ,'nam':"Relizane"}
			
		};
		var markers=[];
		for(vill in villes){
			markers[vill]=L.marker([villes[vill].lat, villes[vill].lon]);
			markers[vill].addTo(map);
		}



		for(ville in villes){
			bind_event(markers[ville],ville,villes[ville].nam);

		}

		function bind_event(marker,vill,nam){

			marker.addEventListener("click", function(){
				show(vill,nam);
			});	
		}

		function show(vill,nam){

			$.ajax({
				method:"post",
	url:"ajax_geolocalisation.php",//page ajax pour recuperer les donnés
	data: {vill:vill},
	success:function(resultData){   //les données sont 'resultData'
	var resutlat=resultData.split('|');
	contentStrings= '<div id="content" ><div style="text-align:center"> <u><span style="font-size:24px;">'+nam+'</span></u>';
	contentStrings+='<table class="table table-striped table-bordered" style="width:300px;color:#000;" class="table-bordered" ><tr style="background:#0D9E1C"><th>Structures</th><th >Nombre</th>';

	contentStrings+=resutlat[0];
	contentStrings+='</table></div>';
		markers[vill].bindPopup(contentStrings).openPopup(); //affichage de données

		//$('#label_total').Text('fdf');
		$('#label_total_employe').text(resutlat[1]);
		$('#label_total_structure').text(resutlat[2]);
		$('#label_wilaya').text(nam);
	}

});
		}
</script>
	<style>
		.my-label {
			background:red;
			color:#fff;
			font-size:9px;
		}
		.affiche{
			font-size:24px;
			color:#4caf50;

		}
		.wila{
			background:#428bca;
			color: #fff;
			font-weight: bold;
		}
	</style>


</body>
</html>