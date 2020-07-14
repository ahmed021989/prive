 <?php
require_once("includes/initialiser.php");
$user = Personne::trouve_par_id($session->id_utilisateur);
?>

                                     	<table id="table3"  class="table  table-striped" style="Maw-width:none !important;direction:rtl;text-align:left" >
					   <thead>
                                            <tr>
                                          <th >Action</th>
												 <th>Identite juridique</th>
												  <th>Type d'établissement</th>
												    <th>Commune d'installation</th>
													<th>Prenom d'employer </th>
													<th>Nom d'employer </th>
													<th>Numéro  </th>

												
                                                
                                            </tr>
                                        </thead>
										<tbody >
										
										
<?php
						$wilaya=Wilayas::trouve_par_Nom($user->wilaya);
						if($user->type=="Admin_dsp"){
						//$employer_peres=Employe::trouve_tous_pere($wilaya->id_w);
						$req=$bd->requete("select * from employer where (type_employe=-1 or type_employe=0) and wilaya=".$wilaya->id_w."");
						}
						else{
						//$employer_peres=Employe::trouve_tous_pere2();
							$req=$bd->requete("select * from employer where (type_employe=-1 or type_employe=0)");

						}
						$i1=1;
						//foreach($employer_peres as $employer){
							while($row=mysqli_fetch_array($req)){
							?>
						<tr  id ="<?php echo htmlspecialchars_decode($row['id_employe']); ?>"> 
											<td style="background:#fff">
					 <button style="color:#green;font-size:20px" id="<?php echo $row['id_employe'];?>"  class=" btn btn-success fa fa-building-o
" data-toggle="tooltip"  onClick="ici(<?php echo $row['id_employe']; ?>);">Choisi</button> &nbsp &nbsp
	
											
												</td>	
												 <td><?php echo stripcslashes(htmlspecialchars_decode($row['identite_jurdique'])); ?></td> 
											<td><?php
												if($etablissement=Etablissement::trouve_par_id($row['type_etablissement']))
												echo stripcslashes(htmlspecialchars_decode($etablissement->type_etab)); ?></td>
											<td><?php
												if($commune2=Communes::trouve_par_code_postal($row['commune_installation']))
												echo htmlspecialchars_decode($commune2->nom_com); ?></td>
											
											
                                            <td><?php echo htmlspecialchars_decode($row['prenom_employe']); ?></td>   
											<td><?php echo htmlspecialchars_decode($row['nom_employe']); ?></td>

											<td><?php echo $i1;?></td>	
											</tr>
							
						<?php
						++$i1;}
						
						?>
						</tbody>
						</table>
					<?php echo "<script>$('#charge').hide();</script>";  ?>	
		<script>			              
      $('#table3').dataTable( 
{

 "searching": true,
	"paging":true,
		 "ordering": false,
 
} ); 
</script>
      