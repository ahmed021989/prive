<?php
require_once("includes/initialiser.php");
if($session->is_logged_in()) {
$user = Personne::trouve_par_id($session->id_utilisateur);
readresser_a("index.php");
 }
  


// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['b_login'])) { // Form has been submitted.

  $login = $bd->escape_value($_POST['login']);
  $passe =$bd->escape_value($_POST['passe']);
  // Check database to see if login/passe exist.
	$utilisateur_trouver = Personne::valider($login, $passe);
	
  if ($utilisateur_trouver) {
    
	$session->login($utilisateur_trouver);
    readresser_a("index.php");
  } else {
    // login/passe combo was not found in the database
    $message = '<h3><style= " style="color: #FE6E16;"><strong>login Ou Mot de passe  incorrect !!!! </strong></h3>';
	$_SESSION['login_er']= $message;
	
  }
  
} else { // Form has not been submitted.
  $login = "";
  $passe = "";
}
?>
<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>RH Secteur Privé</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="img/Image11.PNG" type="image/PNG" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                     
    </head>
    <body>
        
        <div class="login-container lightmode">  
		  <h3> <div class="login-title" style="text-align: center;"> </div>	</h3>
         <h3> <div class="login-title" style="text-align: center;color:#FAF8F6;"><strong > REPUBLIQUE ALGERIENNE DEMOCRATIQUE ET POPULAIRE </strong> </div>	</h3>
        <h4> <div class="login-title" style="text-align: center;color: #FAF8F6;"><strong>  MINISTERE DE LA SANTE, DE LA POPULATION ET DE LA REFORME HOSPITALIERE </strong></div>	</h4> 
 <h4> <div class="login-title" style="text-align: center;color: #FAF8F6;"><strong> DIRECTION DES RESSOURCES HUMAINES </strong></div>	</h4> 		
            <div class="login-box animated fadeInDown">
          <div style = "text-align:center;" >   <img width="200" height="150" class="img-rounded" src="img/Image11.png" /> </div>
		  <br/>
                <div class="login-body">
					<?php 
					if (isset( $_SESSION['login_er'])){?>
		             <div class="alert alert-error">
                                
                               <h4> <strong><?php  echo $_SESSION['login_er'];?></strong> </h4>
                            </div>
           
					<?php
		 
						unset($_SESSION['login_er']);
					}
		
						?>
          <div class="login-title" style="text-align: left;color: #b11d3c;"><strong style="color: #170C50;"><center>Se connecter</strong> à votre Compte</center></div>

                  
                    <form action="login.php" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input style="font-size:16px" type="text" class="form-control" placeholder="Login" name ="login" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input style="font-size:16px" type="password" class="form-control" placeholder="Mot de Passe" name= "passe" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                        </div>
                        <div class="col-md-12">
                            <button class=" btn btn-info btn-block " name ="b_login" type="submit">Se Connecter</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div class="">
                 <center>&copy; <?php echo date("Y")?> MSPRH DRH SIRH </center>
                    </div>
                   
                </div>
            </div>
            
        </div>
        
    </body>
</html>






