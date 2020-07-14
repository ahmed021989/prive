<?php
require_once("includes/initialiser.php");
$id_mess=$_GET['id_mess'];
$dat=date('Y-m-d H:i');
$sql=$bd->requete("update message set date_supp_exp='$dat', id_exp_supp=-1 where id_mess='$id_mess'");




readresser_a("mess_env.php");


?>