<?php
require_once("includes/initialiser.php");
global $bd;
if(isset($bd)){
echo ' '.mysqli_num_rows($bd->requete('select distinct user from cpt_connectes')).'';
}
?>