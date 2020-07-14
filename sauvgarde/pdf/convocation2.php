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

session_start();

include("connection.php");	
$connec=mysqli_connect($_SESSION['page'][0],$_SESSION['page'][1],$_SESSION['page'][2]) or die('Connexion impossible : ' . mysqli_error());
mysqli_query ($connec,'SET NAMES \'UTF8\'');

$db=mysqli_select_db($connec,$_SESSION['page'][3]) or die('Connexion impossible : ' . mysqli_error($connec));

//******************************4
if(isset($_POST["email"])){
	//**************************
$query="select * from compte where email='".$_POST["email"]."' and password='".$_POST["pasword"]."'";
$result=mysqli_query($connec,$query);
	  $code= mysqli_num_rows($result);
	  
	//*******************************
	$query1="select * from compte where email='".$_POST["email"]."' and password='".$_POST["pasword"]."' and active='oui'";
$result1=mysqli_query($connec,$query1);
	  $code1= mysqli_num_rows($result1); 
	   
	  //***********************
	  $query2="select * from compte where email='".$_POST["email"]."' and password='".$_POST["pasword"]."' and active='oui' and inscrit='oui'";
$result2=mysqli_query($connec,$query2);
	  $code2= mysqli_num_rows($result2);
	  
	  //************************


if($code==1 && $code1==1 && $code2==0){
 $_SESSION['login_er_conv']=" لم تسجل   ؟؟".$_POST['email']."     ";
 header("Location: convocation.php");

}
else{
	if($code==1 && $code1==1 && $code2==1){
		
//********************************		
	  $code2= $date_convocation; 
	  if($date_convocation=="0000-00-00"){
		$_SESSION['login_er_conv']="لم يتم تحديد تاريخ المسابقة ؟؟";
 header("Location: convocation.php");  
	  }	
	  else{
	 header("Location: sauvgarde/pdf/convocation.php");	  
	  }


//****************************************


	}
	else{
	
	if($code==1 && $code1==0 ){
	 $_SESSION['login_er_conv']="   لست مسجل مسبقا  ؟؟".$_POST['email']."    ";
 header("Location: convocation.php");	
	}
	else{
 $_SESSION['login_er_conv']="خطأ في إسم البريد الاليكتروني أو كلمة السر خاطئة ؟؟";
 header("Location: convocation.php");
		
}
}
}




//******************************4








$code= $_POST['email'];

$query1="select * from condidat where code='".$code."'";
$result1=mysqli_query($connec,$query1);
	  $code1= mysqli_num_rows($result1); 
	  
	  //------------------------
	  $query01="select * from condidat where code='".$_POST['email']."'";
	$grade='';
$result01=mysqli_query($connec,$query01);	
while ($row=mysqli_fetch_array($result01)){
	$grade=$row['grade']; 
}
	$query00="select * from poste where Nom_poste='".$grade."'";
	$date_convocation='';

$result00=mysqli_query($connec,$query00);	
while ($row=mysqli_fetch_array($result00)){
	$date_convocation=$row['date_convocation']; 
	




	
}  
	  
	  //--------------------------
	
	
}
else{

 header("Location: convocation.php");	


}

require_once('tcpdf_include.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('author');
$pdf->SetTitle('الإستدعاء ');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');




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
$pdf->AddPage();




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



$htmlpersian = '
<h2 style="text-align:center">الجمهوريــة الجزائريـــــة الديمقراطيـــــة الشعبيــــــة</h2><br /><p style="text-align:center;text-size:9px">وزارة الصحة و السكان و اصلاح المستشفيات</p><br />مديرية الصحة و السكان لولاية الشلف
<br />';
//requete ettablissemednt************************
$query2="select * from etablissement ";
$result2=mysqli_query($connec,$query2);
//requete compte*************************
$query3="select * from compte  where email='".$code."'";
$result3=mysqli_query($connec,$query3);


while ($row=mysqli_fetch_array($result2)){ 
$htmlpersian.=$row["Nom_etab_ar"].'<br>';
}
$htmlpersian.='<h2 style="text-align:center"><u>الإستدعاء</u></h2>';
$grade="";
$date_naissance="";
$mail="";
while ($row=mysqli_fetch_array($result1)){ 
$htmlpersian.="<br><b> اللقب و الاسم : </b>".$row["nom"]."    ".$row["prenom"].'';
$grade=$row['grade'];
$date_naissance=$row['date_naisance'];
$mail=$row['email'];
}

$htmlpersian.="<br><b>تاريخ الإزدياد :".$date_naissance."<br>"." البريد الاليكتروني :</b>".$mail."<br />";



$htmlpersian.="<br><b>مسابقة على أساس الشهادة للإلتحاق برتبة :</b>     ".$grade."<br><br><br><br><br><br>سيتم اشعارك ان كان ملفك مقبولا عن طريق  رسالة نصية في بريدك الاليكتروني لاحقا";

$pdf->WriteHTML($htmlpersian, true, 0, true, 0);

// set LTR direction for english translation


$pdf->SetFontSize(10);

// print newline
//$pdf->Ln();


// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('quitance.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>