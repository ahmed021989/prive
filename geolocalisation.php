

		<script src="https://maps.google.com/maps/api/js?key=AIzaSyBHJbCnTp2wK-mnqE6wYcdZ5SPyc2LYAEY&v=1" type="text/javascript"></script>
		  <!-- START PRELOADS -->
     
		<script async type="text/javascript">
		
      
			// On initialise la latitude et la longitude de Paris (centre de la carte)
			var lat = 35.0518439;
			var lon = 1.1891143;
			var map = null;
			// Fonction d'initialisation de la carte
			function initMap() {
				// Créer l'objet "map" et l'insèrer dans l'élément HTML qui a l'ID "map"
				map = new google.maps.Map(document.getElementById("map"), {
					// Nous plaçons le centre de la carte avec les coordonnées ci-dessus
					center: new google.maps.LatLng(lat, lon), 
					// Nous définissons le zoom par défaut
					zoom: 7, 
					// Nous définissons le type de carte (ici carte routière)
					mapTypeId: google.maps.MapTypeId.ROADMAP, 
					// Nous activons les options de contrôle de la carte (plan, satellite...)
					mapTypeControl: true,
					// Nous désactivons la roulette de souris
					scrollwheel: false, 
					mapTypeControlOptions: {
						// Cette option sert à définir comment les options se placent
						style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR 
					},
					// Activation des options de navigation dans la carte (zoom...)
					navigationControl: true, 
					navigationControlOptions: {
						// Comment ces options doivent-elles s'afficher
						style: google.maps.NavigationControlStyle.ZOOM_PAN 
					}
				});
			}
			window.onload = function(){
				// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
				initMap(); 
			};
			
			// Nous initialisons une liste de marqueurs
var villes = {
"02":{"lat" : 36.20342 ,"lon" : 1.26807,'nam':"chlef"},

"20":{"lat": 34.743349 , "lon" : 0.244076,'nam':"Saida"},

"17":{"lat" : 34.342841 , "lon": 3.217253,'nam':"Djelfa"},
"19":{"lat" : 36.189275 , "lon" : 5.403493,'nam':"Sétif"},

	"16":{"lat": 36.7538345,"lon": 3.0534636,'nam':"Alger"},
	"09":{"lat": 36.481377,"lon": 2.7301504,'nam':"Blida"},
	"01":{"lat": 27.9660477,"lon": -0.47043,'nam':"Adrar"},
	"31":{"lat": 35.7112355,"lon": -0.7082324,'nam':"Oran"}
};
function initMap() {
	map = new google.maps.Map(document.getElementById("map"), {
		center: new google.maps.LatLng(lat, lon),
		zoom: 5,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: true,
		scrollwheel: false,
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
		},
		navigationControl: true,
		navigationControlOptions: {
			style: google.maps.NavigationControlStyle.ZOOM_PAN
		}
	});
	// Nous parcourons la liste des villes
	var markers=[];
	for(vill in villes){
		 markers[vill] = new google.maps.Marker({
			// A chaque boucle, la latitude et la longitude sont lues dans le tableau
			position: {lat: villes[vill].lat, lng: villes[vill].lon},
			// On en profite pour ajouter une info-bulle contenant le nom de la ville
			title: villes[vill].nam,
			 label: {
        fontSize: "8pt",
        text: vill
    },
	
			map: map
		});
	

	}
	for(marker in markers){
	
	var activeInfoWindow; 
bind_event(marker);
	
}	

function bind_event(marker) {

var contentString = '<div id="content" style="width:400px"><div> <span style="font-size:24px">Wilaya de :'+markers[marker].title+'</span>';
contentString+='<table ><tr><th style="border:1px solid black">Structures</th><th style="border:1px solid black">Nombre</th>';
contentString+='<tr><td style="border:1px solid black">Cabinets generalistes</td><td style="border:1px solid black">273</td>';
contentString+='<tr><td style="border:1px solid black">Officines pharmaceutiques</td><td style="border:1px solid black">84</td></tr></table></div>';
        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
		markers[marker].addListener('click', function() {
		  if (activeInfoWindow) { activeInfoWindow.close();}
		//
        infowindow.open(map, markers[marker]);
       activeInfoWindow = infowindow;
	
		});	
}
}
		</script>
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
		<style type="text/css">
			#map{ /* la carte DOIT avoir une hauteur sinon elle n'apparaît pas */
				height:400px;
			}
		</style>
		<title>Carte</title>
	</head>
	<body>
		<div id="map">
			<!-- Ici s'affichera la carte -->
		</div>
		
	</body>
</html>
    