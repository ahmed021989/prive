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
$edit1 =  Employe::trouve_par_id($id_employe);
} elseif ( (isset($_POST['id_employe'])) &&(is_numeric($_POST['id_employe'])) ) { 
	$id_employe = $_POST['id_employe'];
	$edit1=  Employe::trouve_par_id($id_employe);
} else { 
	$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
} 

$msg_positif= '';
if(isset($_POST['submit'])){


	$errors = array();
	if(Affiliation::trouve_par_id($id_employe))
	{
		
    $edit=Affiliation::trouve_par_id($id_employe);
    $edit->id_employe = htmlspecialchars(trim($_GET['id_employe']));
	$edit->nom_pere = htmlspecialchars(trim($_POST['nom_pere']));
	$edit->nom_mere = (htmlspecialchars(trim($_POST['nom_mere'])));
	
	
		 if(!empty($_FILES)){

	
	
//var_dump($_FILES['lien_pdf']);
$fichier=$_FILES['photo']['name'];
$fichier_tmp=$_FILES['photo']['tmp_name'];
//$fich_exten=strchr($fichier,'.');
$extensions = array('jpg' , 'jpeg' , 'gif' , 'png');
$extension = strrchr($fichier, '.'); 
//Début des vérifications de sécurité...
//if(in_array($extension,$extensions)){ //Si l'extension n'est pas dans le tableau

   
$dest='doc_pdf/'.$id_employe.$extension;

     if( move_uploaded_file($fichier_tmp,$dest)){
	 $edit-> photo = $id_employe.$extension;
     
		
	 }
	
	
	
	
	$msg_system= '';

	


		if ($edit->modifier()){
		

			$msg_positif .= '<p style= "font-size: 20px; ">  Il a été mis à jour '.$edit1->nom_compler().'    </p><br />';

		//readresser_a("liste_employe.php");												

		}else{
			$msg_error = "<h1>Une erreur dans le programme ! </h1>
			<h1>Aucune mise à jour ..??? ! </h1>
			<p class=\"error\" style= \"font-size: 20px; \" >  S'il vous plaît re- mise à jour à nouveau !!</p>";
		//readresser_a("liste_employe.php");	
		
		}

	
}
	}
	else
	{

	$ajout= new Affiliation();
	$ajout->id_employe = htmlspecialchars(trim($_GET['id_employe']));
	$ajout->nom_pere = htmlspecialchars(trim($_POST['nom_pere']));
	$ajout->nom_mere = (htmlspecialchars(trim($_POST['nom_mere'])));
	
	
		 if(!empty($_FILES)){

	
	
//var_dump($_FILES['lien_pdf']);
$fichier=$_FILES['photo']['name'];
$fichier_tmp=$_FILES['photo']['tmp_name'];
//$fich_exten=strchr($fichier,'.');
$extensions = array('jpg' , 'jpeg' , 'gif' , 'png');
$extension = strrchr($fichier, '.'); 
//Début des vérifications de sécurité...
//if(in_array($extension,$extensions)){ //Si l'extension n'est pas dans le tableau

   
$dest='doc_pdf/'.$id_employe.$extension;

     if( move_uploaded_file($fichier_tmp,$dest)){
	 $ajout-> photo = $id_employe.$extension;
     
		
	 }
	
	
	
	
	$msg_system= '';

	


		if ($ajout->ajouter()){
		

			$msg_positif .= '<p style= "font-size: 20px; ">  Il a été ajouter  '.$edit1->nom_compler().'  </p><br />';

		//readresser_a("liste_employe.php");												

		}else{
			$msg_error = "<h1>Une erreur dans le programme ! </h1>
			<h1>Aucune mise à jour ..??? ! </h1>
			<p class=\"error\" style= \"font-size: 20px; \" >  S'il vous plaît re- mise à jour à nouveau !!</p>";
		//readresser_a("liste_employe.php");	
			echo "<script>$('#mb-ouverture').hide();</script>";
		}


	
}
   }
	
}

?>
<?php
$titre = "Affiliation de l'employé ";
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
<div class="panel panel-default">
	<div class="row">
		<div class="col-sm-12" >
			<?php  
			$employe=Employe::trouve_par_id($id_employe);
if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										}
			?>
<br>
			<div class="col-xs-6 col-sm-4"><h3><?php echo $employe->nom_employe; ?></h3></div>
			<div class="col-xs-6 col-sm-4"><h3><?php echo $employe->prenom_employe; ?></h3></div>
			<div class="col-xs-6 col-sm-4"><h3><?php echo $employe->date_nais_employe; ?></h3></div>
		</div>
		</div>
		<hr>
		<div class="container" > 
		<div class="row"> 
		<div class="col-sm-12"> 
			<form class="form-horizontal" name="form1"  id = "form1" action="<?php echo $_SERVER['PHP_SELF'].'?id_employe='.$id_employe;?>" method="post" enctype="multipart/form-data">
		<?php  
		$nom_pere="";
		$nom_mere="";
		$src_photo="";
		if($Affiliation=Affiliation::trouve_par_id($id_employe)){
$nom_pere=$Affiliation->nom_pere;
$nom_mere=$Affiliation->nom_mere;
$src_photo="doc_pdf/".$Affiliation->photo;

}
		?>
				
				<div class="form-group col-sm-6">
				<div class="col-sm-10">
					<label for="nom_pere" ><h4>Prénom du père </h4></label>
					<input type="text" style="font-size: 14px" class="form-control" id="nom_pere" name="nom_pere" value="<?php echo $nom_pere; ?>" />
				</div>
			</div>
		
			
					<div class="form-group col-sm-6">
					<div class="col-sm-10">		
					<label for="nom_mere"><h4>Nom et prénom de la mère </h4></label>
					<input type="text" style="font-size: 14px" class="form-control" id="nom_mere" name="nom_mere" value="<?php echo $nom_mere; ?>" />
				</div>
			</div>	
				

</div>

<div class="container">
<label for="photo"><h4>Photo de lemployé</h4></label>
			<div class="row" >

				<div class="col-sm-6" style="border: 1px solid black;border-radius: 4px">
					<div id='divphoto' class="form-group col-xl-6 ">
					<img class='img-responcive pull-right'    type='image' id='photo' src='<?php if($src_photo!=''){ echo $src_photo; }  else { ?> http://placehold.it/100 <?php } ?>'  width='100' height='100'  onClick='affiche(this)'> </span><label for="photo"></label> 
				</div>
					<div class="form-group col-xl-6">
					
					<input type="file" class="form-control" id="phpto" name="photo" accept='image/gif, image/jpg, image/jpeg, image/png' onchange='readURL(this,"photo");' data-preview-file-type="any"  data-filesize="20"  />
				</div>
					
			</div>
</div>
</div>
</div>
<div class="container">
<div class="form-group col-sm-3 pull-right">
				<button type="submit" name="submit" class="btn btn-success">Valider</button>
			</div>
		</div>
		<br>
			</div> <!-- fin crow 1 -->

			
		</form>

	</div>                    



        <!-- END PAGE CONTENT WRAPPER -->                                
    </div>       
    <!-- END PAGE CONTENT -->


    <div class="message-box sm animated fadeIn " data-sound="alert" id="mb-liste_etab" >
    	<div class="row ">

    		<div class="col-sm-8 col-sm-offset-2" style="background:#fff">
    			<div class="pull-right">
    				<div>
    					<br><br>
    					<button class="btn btn-danger fa fa-times btn-lg mb-control-close"></button> 
    				</div>
    			</div>
    			<center><span id="charge" style="font-size:14px">CHARGEMENT ...<img src="img/fileinput/loading.gif" width="20" height="20"/> </span></center>
    			<br><br><br><br>

    			<?php    

    			?>
    			<h3><div id="supr"></div> </h3>                   
    			<center><h3><p> </p></h3></center>
    			<div id="peres">

    			</div>


    			<div class="mb-footer">
    				<div class="pull-right">

    				</div>
    			</div>
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




    <div class="message-box animated fadedIn" data-sound="alert" id="modal_apercu" >
    	<br><br><br><br>
    	<br><br>
    	
    	<div class="row">
    		<div class="mb-middle col-sm-6 col-sm-offset-3" style="border-radius: 5px; background:#fff; ">
    			<br>
    			<div class="mb-title"><span ></span>  <strong></strong> </div>

    			<center>

    				<button class="pull-right" style="color: red" onclick="$('#modal_apercu').hide();">X</button>

    				<table>
    					<tr>
    						<div class="mb-content">
    							<img height="500" class="col-sm-12" id="img01">

    						</div>
    					</tr>

    				</table>


    				
    			</center>
    			
    				<div class="row" >				
    			</h3>

    		</div>
    		<div class="col-md-6">
    		</div>
    		<div class="mb-footer">
    			<div class="pull-right">
    				<br>
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
    		<div class="message-box animated fadeIn"  id="rr">
    		<div class="mb-container">
    			<div class="mb-middle">
    				<div class="mb-title"><span class="fa fa-trash-o"></span> Supprimer <strong> les données </strong> ??!!</div>
    				<div class="mb-content">
    				  <img class="mb-content" id="img01">
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
        <script type="text/javascript" src="js/plugins/fileinput/fileinput.min.js"></script>        


    	<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>

    	<!-- END THIS PAGE PLUGINS -->       
    	<!-- START TEMPLATE -->
    	<script type="text/javascript" src="js/plugins.js"></script>        
    	<script type="text/javascript" src="js/actions.js"></script>
    	<script>
    		function load_peres(){
    			if($("#peres").load('ajax_peres.php')){

    			}
    		}
    	</script>
    	<script>
    		//window.onload=ouverture();
    		function ouverture(){
    			<?php   if($msg_positif==''){ ?>
    				$('#mb-ouverture').show();
    				verif_date();
    				<?php 

    			} ?>
    		}
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

$('.mb-control-close0').on('click',function(){
	load_peres();
	$('#mb-liste_etab').hide(); 
	$('#mb-ouverture').hide();				
})
$('.mb-control-close').on('click',function(){

	$('#mb-liste_etab').hide(); 
            // $('#mb-ouverture').hide();				
        })
//photo functions
	function readURL(input,imag) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
					var img='#'+imag;
                    $(img)
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        function affiche(img){
        
	 $("#modal_apercu").show();
	//var modal = document.getElementById('modal_apercu');
	var modalImg = document.getElementById('img01')

	var captionText = document.getElementById("caption");
	
    modalImg.src = img.src;
	

    captionText.innerHTML = img.alt;
	//alert(captionText.innerHTML);
	// img.id.css('visibility','hidden');
	
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

function ici(id){

	//alert(diplome);

	tabl = new Array();

	$.ajax({
		method:"post",
		url:"ajax_edit_etab.php",
		data: {id:id},
		success:function(resultData){
		//alert(resultData);
		tabl=resultData.split('|');
	// alert(resultData);



	
	$("#commune_installation").val(tabl[0]); 
	$('#adrs').val(tabl[1]);
	$("#numero_agriment").val(tabl[2]); 
	$("#date_agriment").val(tabl[3]); 
	$("#type_etablissement").val(tabl[4]); 
	$("#identite_jurdique").val(tabl[5]); 
	$("#date_creation").val(tabl[6]); 
	$('#mb-liste_etab').hide();

	




}

})
	
}


</script>

<style>
	#divphoto :hover{
		background: red;
	}
	#mb-liste_etab {

		position: absolute;
		z-index: 101;
		padding: 30px 40px 34px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		-moz-box-shadow: 0 0 10px rgba(0,0,0,.4);
		-webkit-box-shadow: 0 0 10px rgba(0,0,0,.4);
		-box-shadow: 0 0 10px rgba(0,0,0,.4);
	}
	.scrollable {
		float: left !important;
		overflow-x: scroll !important ;

		white-space: nowrap;


	}
	img:hover 
	{
		opacity: 0.5;
		cursor: pointer;
	}
</style>
<!-- END SCRIPTS -->     
<!-- END SCRIPTS -->                   
</body>
</html>






