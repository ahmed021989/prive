

<?php
require_once("includes/initialiser.php");
ini_set('max_execution_time', 0); 
/*if(!$session->is_logged_in()) {

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
}*/
?>
<?php
/*$titre = "Listes des employés";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp'){
	//require_once("composit/header.php");
	
}
*/
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
               
                <!-- END BREADCRUMB -->                       
             <?php //if  ($user->type == 'administrateur' or $user->type=="DGSS-RH")   {  ?>   
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
                                    
									 <h3 class="panel-title"><strong>Géolocalisation des structures </strong></h3>
								                               
                                </div>
  <div id="mapDiv" style="width: 100%; height: 500px">
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  
   <?php // } ?>
  <script>
    // position we will use later
    var lat = 35.0518439;
    var lon = 3.2891143;
    // initialize map
    map = L.map('mapDiv').setView([lat, lon], 7);
    // set map tiles source
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
      maxZoom: 8,
    }).addTo(map);
	
	var villes = {
"01":{"lat" :  27.9660477,"lon": -0.47043    ,'nam':"Adrar"},
"02":{"lat" :  36.20342  ,"lon" : 1.26807    ,'nam':"chlef"},
"03":{"lat" :  33.58333  ,"lon" : 2.66667    ,'nam':"Laghouat"},
"04":{"lat" :  35.83333  ,"lon" : 7.08333    ,'nam':"Oum el Bouaghi"},
"05":{"lat" :  35.5      ,"lon":5.91667		 ,'nam':"Batna"},
"06":{"lat" :  36.66667  ,"lon": 4.91667 	 ,'nam':"Béjaïa"},
"07":{"lat" :  34.66667  ,"lon": 5.41667 	 ,'nam':"Biskra"},
"08":{"lat" :  30.25     ,"lon": -3.08333	 ,'nam':" Béchar"},
"09":{"lat" :  36.481377 ,"lon": 2.7301504	 ,'nam':"Blida"},
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

		$.ajax({
	method:"post",
	url:"ajax_geolocalisation.php",
	data: {vill:vill},
	success:function(resultData){
		contentStrings= '<div id="content" ><div > <span style="font-size:24px">Wilaya de : '+nam+'</span>';
	    contentStrings+='<table class="table table-bordered" style="width:300px;color:#000" class="table-bordered" ><tr style="background:#0D9E1C"><th>Structures</th><th >Nombre</th>';

		contentStrings+=resultData;
		contentStrings+='</table></div>';
		markers[vill].bindPopup(contentStrings).openPopup();
	}
		})

	});	
}
/*function bind(vill,nam,lat,lon){
	$.ajax({
	method:"post",
	url:"ajax_geolocalisation.php",
	data: {vill:vill},
	success:function(resultData){
	
    	contentStrings= '<div id="content" ><div > <span style="font-size:24px">Wilaya de : '+nam+'</span>';
	    contentStrings+='<table class="table table-bordered" style="width:300px;color:#000" class="table-bordered" ><tr style="background:#0D9E1C"><th>Structures</th><th >Nombre</th>';

		contentStrings+=resultData;
		contentStrings+='</table></div>';
	    marker = L.marker([lat, lon]);
	    marker .addTo(map);
	    marker.bindPopup(contentStrings).openPopup();
	}
	});
	
}
	for(vill in villes){
		
bind(vill,villes[vill].nam,villes[vill].lat,villes[vill].lon);;
	}
	*/

 </script>
 <?php 
/*for($i=1;$i<49;$i++){
	
	
	
										  $SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas where  wilayas.id_w=employer.wilaya and employer.type_etablissement=6  and employer.specialite=119  and(employer.type_employe=-1 or employer.type_employe=0) and employer.wilaya={$i} and archive=0") ;
					                    while($row=mysqli_fetch_array($SQL2)){
										 $nbr_structure_m = $row['som2'];
										 }
										 
                                     $SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas where  wilayas.id_w=employer.wilaya and employer.type_etablissement=6 and employer.specialite=119 and employer.wilaya={$i} and archive=0") ;
					                     while($row=mysqli_fetch_array($SQL1)){
										 $nbr_employe_m = $row['som'];
										 }
										  
										 
										 
										 
										
										 /// officine pharmaceutique
										 
										 $SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas where  wilayas.id_w=employer.wilaya and employer.type_etablissement=38 and employer.specialite=125 and(employer.type_employe=-1 or employer.type_employe=0) and employer.wilaya={$i} and archive=0") ;
					                    while($row=mysqli_fetch_array($SQL2)){
										 $nbr_structure_ph = $row['som2'];
										 }
										 
										  $SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas where  wilayas.id_w=employer.wilaya and employer.type_etablissement=38  and employer.specialite=125 and employer.wilaya={$i} and archive=0") ;
					                     while($row=mysqli_fetch_array($SQL1)){
										 $nbr_employe_ph = $row['som'];
										 }
										 
										 
										 
										   /// Cabinet de specialistes
										 
										 $SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12) and employer.diplome=13 and employer.specialite=specialite.id_specialite  and  specialite.id_groupe_specialite in(1,2,3)	and(employer.type_employe=-1 or employer.type_employe=0) and employer.wilaya={$i} and archive=0") ;
					                    while($row=mysqli_fetch_array($SQL2)){
										 $nbr_structure_sp = $row['som2'];
										 }
										 
										  $SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12)  and employer.diplome=13 and employer.specialite=specialite.id_specialite and  specialite.id_groupe_specialite in(1,2,3) and employer.wilaya={$i} and archive=0") ;
					                     while($row=mysqli_fetch_array($SQL1)){
										 $nbr_employe_sp = $row['som'];
										 }
										 
										  $SQL3 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12)  and employer.specialite=119  and employer.specialite=specialite.id_specialite  and  specialite.id_groupe_specialite in(7) and employer.wilaya={$i} and archive=0") ;
					                     while($row=mysqli_fetch_array($SQL3)){
										 $nbr_employe_gen = $row['som'];
										 }
										 
										  $SQL0 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12) and (employer.diplome=13 or employer.specialite=119) and employer.specialite=specialite.id_specialite  and  specialite.id_groupe_specialite in(1,2,3,7) and employer.wilaya={$i}  and archive=0") ;
					                     while($row=mysqli_fetch_array($SQL0)){
										 $nbr_employe_total_spe = $row['som'];
										 }
										 
										 
										 
										  /// Cabinet de groupe
										  
										 
										  
										   $SQL5 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.diplome=13 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(1,2,3) and(employer.type_employe=-1 or employer.type_employe=0) and employer.wilaya={$i} and archive=0") ;
					                    while($row=mysqli_fetch_array($SQL5)){
										 $nbr_structure_groupe_sp = $row['som2'];
										 }
										 
										 $SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=119 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(7) and(employer.type_employe=-1 or employer.type_employe=0) and employer.wilaya={$i} and archive=0") ;
					                    while($row=mysqli_fetch_array($SQL2)){
										 $nbr_structure_groupe_gp = $row['som2'];
										 }
										 
										 
										  $SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(7) and employer.specialite=119 and employer.wilaya={$i} and archive=0") ;
					                     while($row=mysqli_fetch_array($SQL1)){
										$nbr_employe_generaliste = $row['som'];
										 }
										 
										  $SQL3 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(1,2,3) and employer.diplome=13 and employer.wilaya={$i} and archive=0") ;
					                     while($row=mysqli_fetch_array($SQL3)){
										  $nbr_employe_specialiste= $row['som'];
										 }
										 
										  $SQL0 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(1,2,3,7) and (employer.diplome=13 or employer.specialite=119) and employer.wilaya={$i}  and archive=0") ;
					                     while($row=mysqli_fetch_array($SQL0)){
										 $nbr_employe_total_groupe = $row['som'];
										 }


$k="dsdsd";
$contenent= " <table><tr><td> Cabinet de généraliste</td><td style='text-align:right'>".number_format($nbr_structure_m, 0, ',', ' ')."</td></tr></table>";
/*$contenent.= "<tr><td> Officine pharmaceutique</td><td style='text-align:right'>".number_format($nbr_structure_ph, 0, ',', ' ')."</td></tr>";
$contenent.="<tr><td> Cabinet de spécialiste</td><td style='text-align:right'>".number_format($nbr_structure_sp, 0, ',', ' ')."</td></tr>";
$contenent.= "<tr><td> Cabinet de groupe</td><td style='text-align:right'>".number_format($nbr_structure_groupe_sp, 0, ',', ' ')."</td></tr></table>";*/
/*echo "<script>   markers[".$i."].bindPopup('{$contenent}').openPopup();</script>";	
	
	
}*/

?>
  <style>
  .my-label {
   background:red;
   color:#fff;
   font-size:9px;
}
  </style>
 
			
</body>
</html>