<?php
@session_start();
/*if(isset($_SESSION['count2'])){
$_SESSION['count2']=$_SESSION['count2']+1;

unset($_SESSION['count2']);
 header("Location: ../../entre.php");
}
else{
$_SESSION['count2']=1;	
}*/
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
@session_start();

require_once("connection.php");	
$connec=mysqli_connect($_SESSION['page'][0],$_SESSION['page'][1],$_SESSION['page'][2]) or die('Connexion impossible : ' . mysqli_error());
mysqli_query ($connec,'SET NAMES \'UTF8\'');

$db=mysqli_select_db($connec,$_SESSION['page'][3]) or die('Connexion impossible : ' . mysqli_error($connec));
$tab=explode( ':', $_GET["id"] );
$code= $tab[0];
$query1="select * from condidat where code='".$code."'";
$result1=mysqli_query($connec,$query1);
	  $code1= mysqli_num_rows($result1); 
	  $query2="select * from compte where id_user='".$_GET['id']."'";
	  $result2=mysqli_query($connec,$query2);
	  $code2= mysqli_num_rows($result2); 
	  
	  $query_doc="select * from document_demmande ";
$result_doc=mysqli_query($connec,$query_doc);

	  $query_conc="select * from poste ";
$result_conc=mysqli_query($connec,$query_conc);
$date_concours='';
while ($row=mysqli_fetch_array($result_conc)){ 
$date_concours=$row['date_convocation'];
}

require_once('tcpdf_include.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('author');
$pdf->SetTitle('قائمة المرشحين المسجلين ');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');




// set header and footer fonts

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont('');
$pdf->SetPrintHeader(false);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, '', PDF_MARGIN_RIGHT);

//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor



// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

// set some language-dependent strings (optional)
$pdf->setLanguageArray($lg);
$pdf->SetFont('aealarabiya', '', 18);

// ---------------------------------------------------------

// set font


// add a page
$pdf->AddPage('L');




// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content


/*$htmlpersian = '
<h2 style="text-align:center">الجمهوريــة الجزائريــة الديمقراطيـة الشعبيـة<span dir="ltr"><br />
  </span>نموذج رقم<span dir="ltr"> </span><span dir="ltr"><span dir="ltr"> </span> </span><strong><span dir="ltr">(2)</span></strong><span dir="ltr"> </span><span dir="ltr"><br />
  </span>استمارة معلومات للمشاركة في المسابقة على أساس الشهادة <span dir="ltr"><br />
</span>للإلتحاق برتبة:
';
while ($row=mysqli_fetch_array($result1)){ 
$htmlpersian.=$row["grade"].'</h2>';
}*/
//if($code2!=0){
if(isset($_POST['select_tous'])){

$htmlpersian = '
<h2 style="text-align:center">الجمهوريــة الجزائريـــــة الديمقراطيـــــة الشعبيــــــة</h2><p style="text-align:center;text-size:9px">وزارة الصحة و السكان و اصلاح المستشفيات</p><br />مديرية الصحة و السكان لولاية الشلف
<br />';
//requete ettablissemednt************************
$query2="select * from etablissement ";
$result2=mysqli_query($connec,$query2);
//requete dossier accept*************************
$query3="select * from compte,condidat  where compte.email=condidat.code  and condidat.grade='".$_POST['select_tous']."' order by condidat.id";
$result3=mysqli_query($connec,$query3);


while ($row=mysqli_fetch_array($result2)){ 
$htmlpersian.=$row["Nom_etab_ar"].'<br>';
}

$htmlpersian.='<p>تسجيل ملفات الترشح في المسابقة على أساس الشهادة للالتحاق برتبة :'.$_POST['select_tous'].'.</p><br>';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);

$pdf->SetFont('dejavusans', '', 10);
$htmlpersian='<table border="1" cellspacing="0" cellpadding="2"> <tr><th>الرقم  </th><th>تاريخ التسجيل الالكتروني</th><th>تاريخ ايداع الملف </th><th>لقب و اسم المترشح</th><th> الملاحظات(الوثائق الناقصة) </th></tr>';
$htmlpersian.='<tbody>';
$i=1;
while ($row=mysqli_fetch_array($result3)){ 
//requette compte******************************
$query12="select * from compte ";
$result12=mysqli_query($connec,$query12);

$date_inscr="";

while ($row1=mysqli_fetch_array($result12)){ 
$date_inscr=$row['date_inscr'];

}
//fin compte requete*****************************


$query11="select * from condidat where code='".$row['code']."' and grade='".$_POST['select_tous']."'";
$result11=mysqli_query($connec,$query11);
$cod="";
$nom="";
while ($row=mysqli_fetch_array($result11)){ 
//$htmlpersian.="<br><b> اللقب و الاسم : </b>".$row["nom"]."    ".$row["prenom"].'';
$cod=$row['code'];
$nom=$row['nom'].' '.$row['prenom'];

}


$htmlpersian.='<tr><td>'.$i.'</td><td>'.$date_inscr.'</td><td></td><td>'.$nom.'</td><td></td>';


	$htmlpersian.='</tr>';
++$i;
}
$htmlpersian.="</tbody></table>";
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);
//$pdf->setRTL(false);
$pdf->SetFont('dejavusans', '', 12);
$htmlpersian='أنا الممضي أسفله السيد: سليماني محمد مدير المؤسسة العمومية الاستشفائية الشلف الاخوات باج أشهد .............. لرتبة  '.$_POST['select_tous'].' قد أغلق عند الرقم  '.$i.'  يوم .....على الساعة ...... ';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);
/*$htmlpersian='<table border="1"><tr><td style="width:40px">الرقم</td><td style="width:400px">إسم الوثيقة</td><td style="width:40px">العدد</td></tr>';

while ($row=mysqli_fetch_array($result_doc)){ 
$htmlpersian.='<tr style="font-size:14px"><td>'.$row['code'].'</td><td>'.$row['nom_doc_demmande'].'</td><td>'.$row['nbr'].'</td></tr>';
}
$htmlpersian.='</table>';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);
$htmlpersian='تجرى المقابلة بتاريخ :'.$date_concours;
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);
$pdf->setRTL(false);
// set LTR direction for english translation
$html='<img src="images/logo.JPG" style="left:10px; width:150px;height:150px;float:left" />';
$pdf->WriteHTML($html, true, 0, true, 0);

$pdf->SetFontSize(10);*/

// print newline
//$pdf->Ln();
//}
}
else{
 header("Location: ../../administration/list_cond_titre.php");		
}
// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('liste_tous_condidats.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>