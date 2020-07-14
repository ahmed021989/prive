<?php
require_once("../../includes/initialiser.php");
if(!$session->is_logged_in()) {

	//readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_perso' or 'Agent_perso' or 'Admin_bg' or 'Agent_bg' or 'User' or 'surveillance');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page  ccsdcsdc";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 

}
?>
<?php 

ob_start(); 


//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).




require_once('tcpdf_include.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('author');
$pdf->SetTitle('Compte');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, compte');





// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor



// set some language dependent data:


// ---------------------------------------------------------

// set font


// add a page
$pdf->AddPage();

$htmlpersian='<h4 style="text-align:center">REPUBLIQUE ALGERIENNE DEMOCRATIQUE ET POPULAIRE<br>';
$htmlpersian.='MINISTERE DE LA SANTE, DE LA POPULATION ET DE LA REFORME HOSPITALIERE
<br>';
$htmlpersian.='DIRECTION DES RESSOURCES HUMAINES
<br></h4>';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);
$htmlpersian='<br><h2 style="text-align:center">Informations d’accès au SIRHSP</h2><br><hr><br><br>';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);

$id = $_GET['id'];
$htmlpersian="";
$SQL = $bd->requete("SELECT * FROM `personne` where id=".$id." ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
													$htmlpersian.='<br><h1 style="color:rgb(255,255,255);background-color:rgb(135,206,250);text-align:center">DSP  : '.$rows["wilaya"].' </h1><br><br>';
														}
														


$pdf->WriteHTML($htmlpersian, true, 0, true, 0);










$id = $_GET['id'];
$htmlpersian="";
$htmlpersian.='<br><br><h2 style=";float:right">Adresse URL: '.$_SERVER['HTTP_HOST']." </h2> ";
$SQL = $bd->requete("SELECT * FROM `personne` where id=".$id." ");
															while ($rows = $bd->fetch_array($SQL))
														{
													
													$htmlpersian.="<h2>Nom : ".$rows["nom"]." <br><br>Prenom: ".$rows["prenom"]."<br><br>Numéro Mobile: ".$rows["telephone"]."<br><br>";
													$htmlpersian.="Utilisateur: ".$rows["login"]."<br><br>";
													$htmlpersian.="Mot de passe : ".$rows["cpt"]." <br></h2>";
														}
														


$pdf->WriteHTML($htmlpersian, true, 0, true, 0);



// print newline
//$pdf->Ln();



 

// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('compte.pdf', 'I');



//============================================================+
// END OF FILE
//============================================================+
?>