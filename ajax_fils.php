<?php
require_once("includes/initialiser.php");
global $bd;
if(isset($bd)){
	
	$pere=Employe::trouve_par_id($_POST['pere']);
	$etabl=Etablissement::trouve_par_id($pere->type_etablissement);
	echo '<p><h3>liste des employé dans  :<strong>'.$etabl->type_etab.' / '.$pere->identite_jurdique.'</strong></h3></p>';
	$sql=$bd->requete('select * from employer where type_employe='.$_POST['pere'].'');
	echo '<table id="table_fils" class="table datatable table-bordered table-stripped">
	<thead>
	<tr>
	<th>N° ordre</th>
	<th>Nom</th>
	<th>Prenom</th>
	<th>Date de naissance</th>
	<th>Diplome</th>
	<th>Spécialité</th>
	</tr>
	</thead>
	<tbody>';
	$i=1;
	while($row=mysqli_fetch_array($sql)){
		$nom_diplome="";$nom_specialite="";
if($diplome=Diplome::trouve_par_id($row['diplome'])){
$nom_diplome=$diplome->nom_diplome;
}
if($specialite=Specialite::trouve_par_id($row['specialite'])){
$nom_specialite=$specialite->nom_specialite;
}
		echo '<tr>
		<td>'.$i.'</td>
		<td>'.$row['nom_employe'].'</td>
		<td>'.$row['prenom_employe'].'</td>
		<td>'.$row['date_nais_employe'].'</td>
		<td>'.$nom_diplome.'</td>
		<td>'.$nom_specialite.'</td>
		</tr>';
		$i++;
	}
	echo '</tbody></table>';
}
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#table_fils').DataTable();
} );
</script>
<!-- END PRELOADS -->                
<!-- START SCRIPTS -->
<!-- START PLUGINS -->





