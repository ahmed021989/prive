<?php
require_once("includes/initialiser.php");
$id_mess=$_GET['id_mess'];
$dat=date('Y-m-d H:i');
$sql=$bd->requete("update message set date_supp_des='$dat', id_des_supp=-1 ,lire_mess=-2 where id_mess='$id_mess'");




readresser_a("message.php");


?>