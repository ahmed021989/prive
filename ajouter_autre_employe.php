<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' );
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 

$id=0;
$wilaya='';

if ((isset($_GET['id_employe'])) && (is_numeric($_GET['id_employe'])) ) {
$id = $_GET['id_employe'];
		$SQL = $bd->requete(" SELECT * FROM `employer` where id_employe=".$id."");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														$wilaya=$rows["wilaya"];
														}	
	 
//comparer id et wilaya
	$SQL1 = $bd->requete("SELECT * FROM `employer` where wilaya='".$wilaya."' and id_employe=".$id."");
	$result='';
while ($rows = $bd->fetch_array($SQL1))
{
$result=$rows["wilaya"];

}
if($result==null){
	
}
	
		 $employer =  Employe::trouve_par_id($id);
}
elseif ( (isset($_POST['id_employe'])) &&(is_numeric($_POST['id_employe'])) ) { 
		 $id = $_POST['id_employe'];
		 $edit =  Employe::trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
	
if(isset($_POST['btn_submit'])){

	$errors = array();
	
$sql_modif=$bd->requete("update employer set type_employe=-1 where id_employe=".$id."");
	// new object document
$employer = new Employe();
	

														
														
	
 	$employer->nom_employe = (htmlspecialchars(trim($_POST['nom_employe'])));
 	$employer->prenom_employe = (htmlspecialchars(trim($_POST['prenom_employe'])));
 	$employer->date_nais_employe = htmlspecialchars(trim($_POST['date_nais_employe']));

 $employer->commune_nais = (htmlspecialchars(trim($_POST['commune_nais'])));
	
	$employer->sexe_employe = (htmlspecialchars(trim($_POST['sexe'])));
	
$employer->diplome = (htmlspecialchars(trim(addslashes($_POST['diplome'])))); 
 $employer->fonction = (htmlspecialchars(trim(addslashes($_POST['fonction']))));
	$employer->specialite = (htmlspecialchars(trim(addslashes($_POST['specialite']))));
	$employer->date_instal = htmlspecialchars(trim($_POST['date_instal']));
	$employer->date_creation = htmlspecialchars(trim($_POST['date_creation']));
	$employer->wilaya = (htmlspecialchars($wilaya));
	$sql=$bd->requete('select * from communes where nom_com="'.$_POST['commune_installation'].'"');
	$code_commune=0;
	while($row=$bd->fetch_array($sql)){
		$code_commune=$row['code_postal'];
	}
	$employer->commune_installation = (htmlspecialchars(trim($code_commune)));
	$employer->epoux = htmlspecialchars(trim($_POST['epoux']));
	 $etablissement=Etablissement::trouve_par_type($_POST['type_etablissement']);
	$employer->type_etablissement = (htmlspecialchars(trim(addslashes($etablissement->Id_etab))));  
	$employer->identite_jurdique = (htmlspecialchars(trim(addslashes($_POST['identite_jurdique']))));
	$employer->adrs = htmlspecialchars(trim($_POST['adrs']));
	$employer->type_employe = htmlspecialchars($id);
	  $employer->numero_agriment = htmlspecialchars(trim($_POST['numero_agriment']));  
	$employer->date_agriment = htmlspecialchars(trim($_POST['date_agriment']));
if(isset($_POST['date_nais_employe_ok'])){
		$employer->nais_valide = 1;
	}
	else{
	$employer->nais_valide = 0;	
	}
	
	if (empty($errors)){
   	if ($employer->existe())
			 {
			$msg_error = '<p style= "font-size: 20px; ">   Employer  " '  . (htmlspecialchars_decode($employer->nom_compler())) . ' " existe Déja!!!
			';
		$emp=Employe::trouve_par_existe($employer->nom_employe,$employer->prenom_employe,$employer->date_nais_employe,$employer->commune_nais);

		if($employer->existe_classee())
		{
		$msg_error .= " mais il est classé  <a class='btn btn-info' href='voire_classee.php'>Consulter pour le récupirer</a></p><br>"	;
		}
		else
		{
			$wilaya=Wilayas::trouve_par_id($emp->wilaya );
			if($user->wilaya!=$wilaya->nom)
			{
				$msg_error .= " dans la wilaya de :'".$wilaya->nom."'<br> contactez vous l'administration  </p><br>"	;
			}
		}
			
		}else{
			$employer->save();
 		  $msg_positif = '<p style= "font-size: 20px; ">   Employer  "  ' .(htmlspecialchars_decode($employer->nom_employe)) . '  " est bien ajouter  </p><br />';
	
		
		}
 		 
 		}else{
		// errors occurred
		$msg_error = '<h1> !! err  </h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
//$_SERVER['PHP_SELF'].'?id_employe='.$id;
}




?>
<?php
$titre = "Ajouter Autre Employés";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
}
?>
       
         
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
					  <li><a href="index.php">Accueil</a></li>  
					  <li class="active"><a href="ajouter_employe.php"><?php echo 'Ajouter Employé' ?></a></li> 
                       <li class="active"><?php echo $titre ?></li> 
                </ul>
                <!-- END BREADCRUMB -->                
                
                
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap"  >
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                           <form class="form-horizontal" role="form"  name="ajouter_employer"   id = "ajouter_employer"  action="<?php echo $_SERVER['PHP_SELF'].'?id_employe='.$id;?>" method="post">
                      
                            <div class="panel panel-default">
                            <div class="panel-body">
                              <?php 
			    $id=$_GET['id_employe'] ;
							  $employe=Employe::trouve_par_id($id);
					 
							  
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
                                        
										  <div class='row' style="border:1px solid green">          
<br>	
<div class='row'>
<div class="col-md-12">
  <div class="form-group" style ="dir:ltr;">
                                                <label class="col-md-3 control-label " style ="dir:ltr;color:green">TYPE D'ETABLISSEMENT</label>
                                                <div class="col-md-9">                                                                                            
                                              
<input class="form-control " id="type_etablissement"  name="type_etablissement"  required style= "text-align:left;color :#666;font-size:16px" value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id."");while ($rows = $bd->fetch_array($SQL)){$etablissment=Etablissement::trouve_par_id($rows["type_etablissement"]);echo stripcslashes(htmlspecialchars_decode($etablissment->type_etab));}?>" readonly />														   
														   
														
                                                 
													
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
                                                <input type="text" name="identite_jurdique" class="form-control"  required style= "text-align:left;color : #666;font-size:16px" readonly  value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id."");
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
                                                <input class="form-control select" id="commune_installation"  name="commune_installation" required style= "text-align:left;color : #666;font-size:16px" value="<?php $commune=Communes::trouve_par_code_postal($employer->commune_installation); echo $commune->nom_com;?>"readonly  />
																									   
														
                                                 
													
                                                </div>
												
                                            </div> 
											</div>
											
											<div class="col-md-6">
												 <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-5 control-label pull-left" style="color:green">DATE CREATION </label>	    
                                        <div class="col-md-7 ">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                <input type="date" name="date_creation" class="form-control"  style= "text-align:left;color : #666;font-size:16px"  value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id."");while ($rows = $bd->fetch_array($SQL)){
														echo htmlspecialchars_decode($rows["date_creation"]);}?>"readonly />
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
                                                <input type="text" name="adrs" class="form-control" placeholder="" style= "text-align:left;color : #666;font-size:16px"  value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id."");while ($rows = $bd->fetch_array($SQL)){
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
                                                <input type="text" name="numero_agriment" class="form-control" readonly  value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id."");
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
                                               <input type="date" name="date_agriment" class="form-control" readonly  value="<?php $SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id."");
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
                                                <input type="text" name="nom_employe" class="form-control" placeholder="EN MAJUSCULE" required  />
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
                                                <input type="text" name="prenom_employe" class="form-control" placeholder="EN MAJUSCULE" required  />
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
                                                <input type="text" name="epoux" class="form-control" placeholder="EN MAJUSCULE"   />
                                            </div>                                            
                                        </div>
										
                                    </div>
									</div>   <!-- fin col 6-->
										<div class='col-md-6'>
										 <div class="form-group">
                                                <label class="col-md-5 control-label" style="color:blue">SEXE</label>
                                               <div class="col-md-7"> 
											   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="sexe" id="option3" style="width:20px;height:20px;background-color:#399"  value="homme" checked="checked"> HOMME
&nbsp;&nbsp;
    <input type="radio" name="sexe" id="option4" style="width:20px;height:20px;background-color:#399"  value="femme" > FEMME

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
                                                <input type="date" name="date_nais_employe" id="date_nais_employe"  class="form-control" required value="0000-00-00" />
                                            </div> 
												<div class="col-md-12 col-xs-0" id="juste" style="visibility:hidden">
													<span style="color:red">Cette date est correcte </span><input style="width:15px;height:15px;" type="checkbox" name="date_nais_employe_ok" id="date_nais_employe_ok"   value="date juste"  />
											    </div>											
                                        </div>
										
                                    </div>                 
                                </div> <!--fin col6-->

									<div class="col-md-6 ">	
                                    
                                   <div class="form-group">
                                                <label class="col-md-5 control-label " style="color:blue">COMMUNE DE NAISSANCE</label>
                                                <div class="col-md-7">                                                                                            
                                              
												<select class="form-control select" id="commune_nais"  name="commune_nais" data-live-search="true"  required />
															 <option value = "-3" >Selectionner Commune</option>
														<?php $SQL = $bd->requete("SELECT * FROM `communes` order by nom_com ");
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
									<div class="form-group" style ="dir:rtl;">
                                      <label class="col-md-6 control-label" style="color:blue">FONCTION</label>	    
                                        <div class="col-md-6 ">  
                                            									
                                          
                                                
                                                <select class="form-control select" name="fonction" id="fonction" class="form-control" data-live-search="true"    />
												 <option value = "">Selectionner fonction</option>
												
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
                                                <input type="date" name="date_instal" class="form-control"  required />
                                            </div>  
											</div>											
                                       
										</div>
										
                                    </div>
								                                  
																	</div> <br>
																	
								
									<!-- fin col6-->
								
									<!--  row diplom-->
									 <div class="row">
									<div class="col-md-12 ">	
									<div class="form-group">
                                      <label class="col-md-3 control-label" style="color:blue">DIPLOME</label>	    
                                        <div class="col-md-9 ">  
                                            									
                                          
                                                
                                                <select class="form-control select" name="diplome" id="diplome" class="form-control" data-live-search="true"  required  onchange="change_specialite();" />
												 <option value = "-4">Selectionner le diplome</option>
												
												 <?php $SQL = $bd->requete("SELECT * FROM `diplome` order by nom_diplome");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value ='.$rows["id_diplome"].'>'.$rows["nom_diplome"].'</option>';
														}
														
														?>	
												</select>
                                       
										
                                    </div>  
									</div>
									</div>
</div>									<!-- fin row diplome-->
										 <!-- fin row 4-->
										
										
										
										
									 <!-- Specialite -->
									 <br>
									 <div class='row'>
									     <div class="col-md-12">
                                    <div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label" style="color:blue">SPECIALITE</label>	    
                                        <div class="col-md-9 ">  
                                            									
                                         
                                                <select class="form-control select" name="specialite" id="specialite" data-live-search="true"  class="form-control"  required  >
												
													
												</select>
                                                                                     
                                         </div>
												
                                            </div> 
											</div>
											</div>
											<br>
											</div>
											
										
										
										<!--*************************************-->
										
									
									
									  <!--<div class="form-group" style ="dir:rtl;" >
									
                                      <label class="col-md-3 control-label">ACTIVITE</label>	    
                                        <div class="col-md-6 col-xs-12">  
                                            									
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>  
                                                <input type="text" name="activite" class="form-control" value="/*$SQL = $bd->requete("SELECT * FROM `employer` where id_employe=".$id_employe."");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo $rows["activite"];
														}*/
														
														?>"  />
                                            </div>                                            
                                        </div>
										
                                    </div>-->
                                    
                                     <!-- prenom-->
                            
									
									
									
									
									
                                        
                                  
                                   <!-- END TEMPLATE -->
       

 <!-- The Modal document scanner -->
                              <div class="panel-footer">
								
								    <button   class="btn btn-info pull-right" style="background:#20820d;" type = "submit" name = "btn_submit" onclick='return verif_date();' >Ajouter</button>  
                                    <a href="index.php" style="background:red" class="btn btn-danger ">Retour</a> 
                                    
                                    
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                  
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                          
            <!-- END PAGE CONTENT -->

        <!-- END PAGE CONTAINER -->


       <!-- MESSAGE BOX-->
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
        <!-- END TEMPLATE -->    

        <!-- START TEMPLATE -->
        <script>
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
		
		function choix(){
			var modal = document.getElementById('myModal');
   modal.style.display = "block";
			//('#myModal').show;
			//var idselect=document.getElementById("type_etablissment").value;
			//alert(idselect);
			
		}
		function ferme(){
			var modal = document.getElementById('myModal');
   modal.style.display = "none";
			//('#myModal').show;
			//var idselect=document.getElementById("type_etablissment").value;
			//alert(idselect);
			
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
		
		</script>
     
    <!-- END SCRIPTS -->           
    </body>
</html>




