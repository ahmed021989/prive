
<?php
require_once("connection.php");	
$connec=mysqli_connect($_SESSION['page'][0],$_SESSION['page'][1],$_SESSION['page'][2]) or die('Connexion impossible : ' . mysqli_error());
mysqli_query ($connec,'SET NAMES \'UTF8\'');

$db=mysqli_select_db($connec,$_SESSION['page'][3]) or die('Connexion impossible : ' . mysqli_error());
$quer_grad="select * from wilayas";


$result_grad=mysqli_query($connec,$quer_grad);
while ($row=mysqli_fetch_array($result_grad)){ 
if($row["nom"]!=null){
echo $row["nom"].'|';
}
}


?>