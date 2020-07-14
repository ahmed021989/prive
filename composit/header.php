<!DOCTYPE html>
<html lang="en">
<head>        
	<!-- META SECTION -->
	<title><?php echo $titre; ?></title>            
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" href="img/Image11.png" type="image/png" />
	<!-- END META SECTION -->

	<!-- CSS INCLUDE -->        
	<link rel="stylesheet" type="text/css" id="theme" href="css/theme-blue.css"/>
	<!-- EOF CSS INCLUDE -->   
	<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
	<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
	<script>
		webshims.setOptions('waitReady', false);
		webshims.setOptions('forms-ext', {types: 'date'});
		webshims.polyfill('forms forms-ext');
	</script>

	<script language="javascript" type="text/javascript">
		function getXMLHTTP() { //fuction to return the xml http object
			var xmlhttp=false;	
			try{
				xmlhttp=new XMLHttpRequest();
			}
			catch(e)	{		
				try{			
					xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(e){
					try{
						xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
					}
					catch(e1){
						xmlhttp=false;
					}
				}
			}

			return xmlhttp;
		}
	</script>
	
	
	
	<?php if (in_array('prix_vente',$header)){?>	
		<script language="javascript" type="text/javascript">
			function getdiag(organe_id,divdiag) {		
				
				var strURL="ajax/trouvevent.php?organe="+organe_id+"&diag="+divdiag;
				var req = getXMLHTTP();
				
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
								document.getElementById(divdiag).innerHTML=req.responseText;

							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}		
			}
			
		</script>
	<?php }?>	

	
	<?php if (in_array('voiture',$header)){?>	
		<script language="javascript" type="text/javascript">
			function getdiag(organe_id,divdiag) {		
				
				var strURL="ajax/trouvevoiture.php?organe="+organe_id+"&diag="+divdiag;
				var req = getXMLHTTP();
				
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
								document.getElementById(divdiag).innerHTML=req.responseText;

							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}		
			}
			
		</script>
	<?php }?>	



	<?php if (in_array('fact',$header)){?>	
		<script language="javascript" type="text/javascript">
			function getdiag(organe_id,divdiag) {		
				
				var strURL="ajax/trouvefact.php?organe="+organe_id+"&diag="+divdiag;
				var req = getXMLHTTP();
				
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
								document.getElementById(divdiag).innerHTML=req.responseText;

							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}		
			}
			
		</script>
	<?php }?>	
	
	<?php if (in_array('service',$header)){?>	
		<script language="javascript" type="text/javascript">
			function sup(organe_id,divdiag) {		
				
				var strURL="ajax/listeservice.php?organe="+organe_id+"&diag="+divdiag;
				var req = getXMLHTTP();
				
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
								document.getElementById(divdiag).innerHTML=req.responseText;

							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}		
			}
			
		</script>
	<?php }?>	
	
	<?php if (in_array('fact_fr',$header)){?>	
		<script language="javascript" type="text/javascript">
			function getdiag(organe_id,divdiag) {		
				
				var strURL="ajax/trouvefact_fr.php?organe="+organe_id+"&diag="+divdiag;
				var req = getXMLHTTP();
				
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
								document.getElementById(divdiag).innerHTML=req.responseText;

							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}		
			}
			
		</script>
	<?php }?>	

	<?php if (in_array('somme',$header)){?>	
		<script language="javascript" type="text/javascript">
			function getdiag(organe_id,divdiag) {		
				
				var strURL="ajax/trouvefact.php?organe="+organe_id+"&diag="+divdiag;
				var req = getXMLHTTP();
				
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
								document.getElementById(divdiag).innerHTML=req.responseText;

							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}		
			}
			
		</script>
	<?php }?>	
	<?php if (in_array('personne',$header)){?>	
		<script language="javascript" type="text/javascript">
			function sup(id,divlist) {		
				
				var strURL="ajax/listeutil.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;

						} else {
							alert("Problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}

	</script>
<?php }?>	

<?php if (in_array('grade',$header)){?>	
	<script language="javascript" type="text/javascript">
		function sup(id,divlist) {		

			var strURL="ajax/listegrade.php?id="+id+"&list="+divlist;
			var req = getXMLHTTP();
			if (req) {

				req.onreadystatechange = function() {
					if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;

						} else {
							alert("Problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}

	</script>
<?php }?>

<?php if (in_array('versement',$header)){?>	
	<script language="javascript" type="text/javascript">
		function suppsante(id,divlist) {		

			var strURL="ajax/listeversement.php?id="+id+"&list="+divlist;
			var req = getXMLHTTP();
			if (req) {

				req.onreadystatechange = function() {
					if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;

						} else {
							alert("Problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}

	</script>
<?php }?>
<?php if (in_array('direction',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supprhsp(id,divlist) {		

			var strURL="ajax/listedirection.php?id="+id+"&list="+divlist;
			var req = getXMLHTTP();
			if (req) {

				req.onreadystatechange = function() {
					if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;

						} else {
							alert("Problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}

	</script>
<?php }?>
<?php if (in_array('etablissement',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supprhsp(id,divlist) {		

			var strURL="ajax/listetypetab.php?id="+id+"&list="+divlist;
			var req = getXMLHTTP();
			if (req) {

				req.onreadystatechange = function() {
					if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;

						} else {
							alert("Problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}

	</script>
<?php }?>	

<?php if (in_array('actualite',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supprhsp(id,divlist) {		

			var strURL="ajax/listeactualite.php?id="+id+"&list="+divlist;
			var req = getXMLHTTP();
			if (req) {

				req.onreadystatechange = function() {
					if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;

						} else {
							alert("Problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}

	</script>
<?php }?>


<?php if (in_array('personne',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supprhsp(id,divlist) {		

			var strURL="ajax/listeadmin.php?id="+id+"&list="+divlist;
			var req = getXMLHTTP();
			if (req) {

				req.onreadystatechange = function() {
					if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;

						} else {
							alert("Problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}

	</script>
<?php }?>
<?php if (in_array('employer',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supprhsp(id,divlist) {		

			var strURL="ajax/listeemployer.php?id="+id+"&list="+divlist;
			var req = getXMLHTTP();
			if (req) {

				req.onreadystatechange = function() {
					if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;

						} else {
							alert("Problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}

	</script>
<?php }?>

</head>
<body  >
	<?php 
/*$sql = $bd->requete('select * from cpt_connectes where ip="'.$_SERVER['REMOTE_ADDR'].'"');
if(mysqli_num_rows($sql)>0)
{
    $bd->requete('update cpt_connectes set timestamp="'.time().'" where ip="'.$_SERVER['REMOTE_ADDR'].'"');
}
else
{
    $bd->requete('insert into cpt_connectes (ip, timestamp) values ("'.$_SERVER['REMOTE_ADDR'].'", "'.time().'")');
}
$times_m_5mins = time()-(60*1);
$bd->requete("delete from cpt_connectes where timestamp < ".$times_m_5mins."");*/
?>
<!-- START PAGE CONTAINER -->
<div class="page-container page-navigation-toggled page-container-wide ">

	<!-- START PAGE SIDEBAR -->
	<div id="div_sidebare" class="page-sidebar mCustomScrollbar _mCS_1 mCS-autoHide mCS_no_scrollbar page-sidebar-fixed scroll mCS_disabled" >
		<!-- START X-NAVIGATION -->
		<ul class="x-navigation x-navigation-minimized">
			<li class="xn-logo">
				<a href="index.php">  <strong>SIRH-SP</strong></a>
				<a href="#" class="x-navigation-control"></a>
			</li>
			<li class="xn-profile">
				<a href="#" class="profile-mini">
					<img src="assets/images/users/Image11.png" />
				</a>
				<div class="profile">
					<div class="profile-image" id="img_pro">
						<a href="index.php" ><img src="assets/images/users/Image11.png" /></a>
					</div>
					<div class="profile-data">
						<div class="profile-data-name"><?php echo $user->nom_compler(); ?></div>
						

					</div>
					<div class="profile-controls">
						<a href="edit_pass.php" class="profile-control-left"><span class="fa fa-unlock-alt"></span></a>
						<a href="edit_util.php?id=<?php echo $user->id ;?>" target="_blank" class="profile-control-right"><span class="fa fa-pencil"></span></a>
					</div>
				</div>                                                                        
			</li>



			<li>
				<a href="index.php"><span class="fa fa-desktop"></span> <span class="xn-text" <?php echo $user->type; ?>   >Tableau de Bord</span></a>                        
			</li> 
			<?php  if( $user->type == 'DGSS-RH' )  {  ?>

				<li class="xn-openable">
					<a href="liste_employe.php"><span class="fa fa-group" style="font-size:20px"></span> <span class="xn-text"> Liste des employés </span></a>

				</li>	
				<li >
					<a href="etat_numerique.php"><span class="fa fa-list-ol" style="font-size:20px"></span>  Etat Sexe / Age</a>

				</li>
			<?php  } ?>

			<?php  if( $user->type == 'administrateur' )  {  ?>     






				<li class="xn-openable" >
					<a href="ajouter_act.php"><span class="fa fa-bell-o" style="font-size:22px"> </span> <span class= "xn-text">Actualité</span></a>
				</li>

				<li class="xn-openable">
					<a href="#"><span class="fa fa-hospital-o" style="font-size:22px"></span> <span class= "xn-text"> Type d'établissement </span></a>
					<ul>
						<li><a href="ajouter_etab.php"><span class="fa fa-hospital-o" style="font-size:15px"> </span>  Type d'établissement </a></li>



					</ul>
				</li>


				<li class="xn-openable" >
					<a href="#"><span class="fa fa-group" style="font-size:20px"></span> <span class="xn-text"> Utilisateurs </span></a>
					<ul>
						<li><a href="ajouter_util.php"><span class="fa fa-user"></span>  Ajouter Utilisateur</a></li>
						<li><a href="liste_util.php"><span class="fa fa-list"></span>  Liste des utilisateurs</a></li>
						
						
					</ul>
				</li>	


				<li class="xn-openable">
					<a href="#"><span class="fa fa-group" style="font-size:20px"></span> <span class="xn-text"> Employés </span></a>
					<ul>
						<li> <a href="ajouter_employe.php"><span class="fa fa-user" style="font-size:20px"></span>  Ajouter employé</a>  </li>
						<li><a href="liste_employe.php"><span class="fa fa-list"></span>  Liste des employés</a></li>
						<li><a href="liste_archive.php"><span class="fa fa-archive"></span>  Employés classés </a></li>
						<li><a href="liste_fin_relation.php"><span class="fa fa-list-alt"></span>liste  fin de contrat </a></li>
					</ul>
				</li>
				<li><a href="liste_controle.php"><span class="fa fa-warning" style="font-size:20px"></span> <span class="xn-text"> Controle d'erreurs</span></a>
				</li>

				<li class="xn-openable">

					<a href="#"><span class="fa fa-file" style="font-size:20px"></span> <span class="xn-text"> Etat Repport </span></a>
					<ul>
						
						<li >
							<a href="etat_numerique.php"><span class="fa fa-list-ol" style="font-size:20px"></span> Etat Sexe /Age</a>

						</li>
						
						<li >
							<a href="etat_densite.php"><span class="fa fa-list-ol" style="font-size:20px"></span>  Etat Densité</a>

						</li>
					</ul>
				</li>
				<li >
				

				</li>

				<li >
					<a href="backup.php"><span class="fa fa-database" style="font-size:20px"></span> <span class="xn-text"> Sauvegarde Backup </span></a>

				</li>







				<!-- ////////////////////////////////////////-->

			<?php } else if ($user->type == 'Admin_dsp') { ?>

				




				<li> <a href="ajouter_employe.php"><span class="fa fa-user" style="font-size:20px"></span> <span class="xn-text"> Ajouter employé</span></a>  </li>
				<li><a href="liste_employe.php"><span class="fa fa-list"></span> <span class="xn-text"> Liste des employés</span></a></li>
				<li > <a href="etat_numerique.php"><span class="fa fa-list-ol" style="font-size:20px"></span> <span class="xn-text"> Etat Sexe / Age</span></a>  </li>
				<li><a href="liste_archive.php"><span class="fa fa-archive"></span><span class="xn-text">  Employés classés  </span></a></li>
				<li><a href="liste_fin_relation.php"><span class="fa fa-list-alt"></span><span class="xn-text">  fin de contrat </span></a></li>
				<li><a href="liste_controle.php"><span class="fa fa-warning" style="font-size:20px"></span> <span class="xn-text"> Controle d'erreurs</span></a>
				</li>




				<!-- ////////////////////////////////////////-->




			<?php        } ?>

			<!-- ////////////////////////////////////////-->


		</ul> 

		<!-- END X-NAVIGATION -->
	</div>
	<!-- END PAGE SIDEBAR -->

	<!-- PAGE CONTENT -->
	<div class="page-content ">

		<!-- START X-NAVIGATION VERTICAL -->
		<ul id="ul_min" class="x-navigation x-navigation-horizontal x-navigation-panel">

			<!-- TOGGLE NAVIGATION -->
			<li class="xn-icon-button">
				<a href="#" class="x-navigation-minimize" ><span  class="fa fa-dedent"></span></a>

				<!-- END TOGGLE NAVIGATION -->
				<!-- SEARCH -->

				<!-- END SEARCH -->
				<!-- SIGN OUT -->
				<li class="xn-icon-button pull-right">

					<a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out" style="font-size:22px;color:red"> </span></a>                        
				</li> 
				<li class="xn-icon-button pull"> 



				</li> 

				
				<li class="xn-icon-button pull-right" >

					<a href="message.php"><span class="fa fa-envelope-o"></span></a>
					<div class="informer informer-info" id="count_messages" ></div>
					<script>
						setInterval('load_message()',500);
						function load_message(){
							$("#count_messages").load('ajax_message.php');	
						}
					</script> 

				</li>
				<li class="xn-search pull-right">
					<form role="form" method="post" action="recherche.php">
						<input type="text" name="recherche" style="background:#fff;width:250px;font-size:11px" placeholder="nom ou prenom ou identitie juridique" />
						<button type="submit" class="btn btn-default  btn-sm" style="visibility:visible;background:#f4d03f">Valider</button>

					</form>
				</li> 


				<h3  style = "color:#FFFFFF;  padding-top :10px;"  >Ressources Humaines Secteur Privé :   &nbsp; <?php echo $user->wilaya ?></span>

				</h3> 
				
				<!-- END SIGN OUT -->
                    <!-- MESSAGES 
              
                  END MESSAGES -->
                    <!-- TASKS -->
                    
                    <!-- END TASKS -->
                </ul>
         <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
    	<script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
                <script>
                	$('#de').click(function(){

                		$(".page-container").addClass("page-navigation-toggled");
                	});

$("#div_sidebare").on('mouseout',function(){
	
$(".page-sidebar").addClass("mCS_disabled");
$(".x-navigation").addClass("x-navigation-minimized");
$('.page-container').addClass('page-navigation-toggled');
$('.page-container').addClass('page-container-wide');
$("#ul_min").removeClass('x-navigation-minimized');
 

	});
$("#div_sidebare").on('mousemove',function(){
	
$(".page-sidebar").removeClass("mCS_disabled");
$(".x-navigation").removeClass("x-navigation-minimized");
$('.page-container').removeClass('page-navigation-toggled');
$('.page-container').removeClass('page-container-wide');
$("#ul_min").removeClass('x-navigation-minimized');

	});



                	setInterval('load_connect1()',3000);
				//setTimeout('load_connect()',500);
				function load_connect1(){
					$("#load").load('ajax_connect2.php');
					
					
				}
				


			</script>

			<div id="load"></div>
			<!-- END X-NAVIGATION VERTICAL -->                     

