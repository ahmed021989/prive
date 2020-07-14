 <?php
 require_once("includes/initialiser.php");
 global $bd;


 // cabinet géneraliste

 $SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas where  wilayas.id_w=employer.wilaya and employer.type_etablissement=6  and employer.specialite=119  and(employer.type_employe=-1 or employer.type_employe=0) and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL2)){
 	$nbr_structure_m = $row['som2'];
 }

 $SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas where  wilayas.id_w=employer.wilaya and employer.type_etablissement=6 and employer.specialite=119 and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL1)){
 	$nbr_employe_m = $row['som'];
 }





										 /// officine pharmaceutique

 $SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas where  wilayas.id_w=employer.wilaya and employer.type_etablissement=38 and employer.specialite=125 and(employer.type_employe=-1 or employer.type_employe=0) and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL2)){
 	$nbr_structure_ph = $row['som2'];
 }

 $SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas where  wilayas.id_w=employer.wilaya and employer.type_etablissement=38  and employer.specialite=125 and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL1)){
 	$nbr_employe_ph = $row['som'];
 }



										   /// Cabinet de specialistes

 $SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12) and employer.diplome=13 and employer.specialite=specialite.id_specialite  and  specialite.id_groupe_specialite in(1,2,3)	and(employer.type_employe=-1 or employer.type_employe=0) and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL2)){
 	$nbr_structure_sp = $row['som2'];
 }

 $SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12)  and employer.diplome=13 and employer.specialite=specialite.id_specialite and  specialite.id_groupe_specialite in(1,2,3) and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL1)){
 	$nbr_employe_sp = $row['som'];
 }

 $SQL3 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12)  and employer.specialite=119  and employer.specialite=specialite.id_specialite  and  specialite.id_groupe_specialite in(7) and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL3)){
 	$nbr_employe_gen = $row['som'];
 }

 $SQL0 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement in (9,12) and (employer.diplome=13 or employer.specialite=119) and employer.specialite=specialite.id_specialite  and  specialite.id_groupe_specialite in(1,2,3,7) and employer.wilaya={$_POST['vill']}  and archive=0") ;
 while($row=mysqli_fetch_array($SQL0)){
 	$nbr_employe_total_spe = $row['som'];
 }



										  /// Cabinet de groupe



 $SQL5 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.diplome=13 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(1,2,3) and(employer.type_employe=-1 or employer.type_employe=0) and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL5)){
 	$nbr_structure_groupe_sp = $row['som2'];
 }

 $SQL2 = $bd->requete("SELECT count(employer.id_employe) as som2 FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=119 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(7) and(employer.type_employe=-1 or employer.type_employe=0) and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL2)){
 	$nbr_structure_groupe_gp = $row['som2'];
 }


 $SQL1 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(7) and employer.specialite=119 and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL1)){
 	$nbr_employe_generaliste = $row['som'];
 }

 $SQL3 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(1,2,3) and employer.diplome=13 and employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL3)){
 	$nbr_employe_specialiste= $row['som'];
 }

 $SQL0 = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer`,wilayas,specialite where  wilayas.id_w=employer.wilaya and employer.type_etablissement=7 and employer.specialite=specialite.id_specialite and specialite.id_groupe_specialite and  specialite.id_groupe_specialite in(1,2,3,7) and (employer.diplome=13 or employer.specialite=119) and employer.wilaya={$_POST['vill']}  and archive=0") ;
 while($row=mysqli_fetch_array($SQL0)){
 	$nbr_employe_total_groupe = $row['som'];
 }



 echo "<tr><td> Cabinet de généraliste</td><td style='text-align:right'>".number_format($nbr_structure_m, 0, ',', ' ')."</td></tr>";
 echo "<tr><td> Officine pharmaceutique</td><td style='text-align:right'>".number_format($nbr_structure_ph, 0, ',', ' ')."</td></tr>";
 echo "<tr><td> Cabinet de spécialiste</td><td style='text-align:right'>".number_format($nbr_structure_sp, 0, ',', ' ')."</td></tr>";
 echo "<tr><td> Cabinet de groupe</td><td style='text-align:right'>".number_format($nbr_structure_groupe_sp, 0, ',', ' ')."</td></tr>";

 echo "|";

//envoi de total

 $SQL_t_structure = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer` where employer.wilaya={$_POST['vill']} and employer.type_employe in(-1,0) and archive=0") ;
 while($row=mysqli_fetch_array($SQL_t_structure)){
 	$nbr_total_structure = $row['som'];
 }
 echo $nbr_total_structure;
  echo "|";
  $SQL_t_employe = $bd->requete("SELECT count(employer.id_employe) as som FROM  `employer` where employer.wilaya={$_POST['vill']} and archive=0") ;
 while($row=mysqli_fetch_array($SQL_t_employe)){
 	$nbr_total_employe = $row['som'];
 }
echo $nbr_total_employe;


 ?>
