
<?php
require_once("connection.php");	
$connec=mysqli_connect($_SESSION['page'][0],$_SESSION['page'][1],$_SESSION['page'][2]) or die('Connexion impossible : ' . mysqli_error());
mysqli_query ($connec,'SET NAMES \'UTF8\'');

$db=mysqli_select_db($connec,$_SESSION['page'][3]) or die('Connexion impossible : ' . mysqli_error());
$quer_grad="select * from diplome_demmande where poste='".$_POST["poste"]."'";


$result_grad=mysqli_query($connec,$quer_grad);
while ($row=mysqli_fetch_array($result_grad)){ 
if($row["diplome"]!=null){
echo $row["diplome"].'|';
}
}
//hna dur la requette ta3ak 
/*if($_POST['poste']=='مساعد مهندس'){
echo "لسيانس|";
echo "شهادة معادلة|";


}
else{
echo "هادي|";
echo "احمد|";
echo "ميلود|";	
echo "بيس";
}*/


?>