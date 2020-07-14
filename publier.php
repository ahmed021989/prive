<?php
require_once("includes/initialiser.php");
$id_act=$_GET['id_act'];

$sql=$bd->requete("update actualite set  publier=1  where id_act='$id_act'");




readresser_a("ajouter_act.php");


?>