<?php
@session_start();
/*if(isset($_SESSION['count1'])){
$_SESSION['count1']=$_SESSION['count1']+1;
	
unset($_SESSION['count1']);
 header("Location: ../../entre.php");
}
else{
$_SESSION['count1']=1;	
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

require_once("connection.php");	
$connec=mysqli_connect($_SESSION['page'][0],$_SESSION['page'][1],$_SESSION['page'][2]) or die('Connexion impossible : ' . mysqli_error());
mysqli_query ($connec,'SET NAMES \'UTF8\'');

$db=mysqli_select_db($connec,$_SESSION['page'][3]) or die('Connexion impossible : ' . mysqli_error($connec));
$query1="select * from condidat where code='".$_GET['code']."'";
$result1=mysqli_query($connec,$query1);
	  $code1= mysqli_num_rows($result1); 

//requete diplome**********************
$query2="select * from diplome where code='".$_GET['code']."'";
$result2=mysqli_query($connec,$query2);

//requete parcours1

$query3="select * from parcours1 where code='".$_GET['code']."'";
$result3=mysqli_query($connec,$query3);
//requete formation
$query4="select * from formation where user='".$_GET['code']."'";
$result4=mysqli_query($connec,$query4);
	  $code4= mysqli_num_rows($result4); 
	  
	  //requete travaux*****************
$query5="select * from travaux where user='".$_GET['code']."'";
$result5=mysqli_query($connec,$query5);
	  $code5= mysqli_num_rows($result5); 
	  
	  	  //requete experiance*****************
$query6="select * from experiance where user='".$_GET['code']."'";
$result6=mysqli_query($connec,$query6);
	  $code6= mysqli_num_rows($result6); 
	  $query7="select * from employer where code='".$_GET['code']."'";
$result7=mysqli_query($connec,$query7);
	  $code7= mysqli_num_rows($result7); 

require_once('tcpdf_include.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('author');
$pdf->SetTitle('إستمارة المعلومات');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');




// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->SetPrintHeader(false);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont('');

// set margins
$pdf->SetMargins(10, '-10', 10);

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
$pdf->SetFont('aealarabiya', '', 14);

// ---------------------------------------------------------

// set font


// add a page
$pdf->AddPage('P', 'A4');
$pdf->Cell(0, 0, 'A4 PORTRAIT', 1, 1, 'C');




// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content


$htmlpersian = '<h2 ><p align="center" dir="rtl" style="" ><em>الجمهوريــة الجزائريــة الديمقراطيـة الشعبيـة</em><span dir="ltr"><br />
  </span><em>نموذج رقم</em><span dir="ltr"> </span><em><span dir="ltr"><span dir="ltr"> </span> </span></em><strong><span dir="ltr">(2)</span></strong><em><span dir="ltr"></span></em><span dir="ltr"><br />
  </span><em>استمارة معلومات للمشاركة في المسابقة على أساس الشهادة </em><span dir="ltr"><br />
</span><em>للإلتحاق برتبة : 
';
$nom="";
$prenom="";
$fils_de="";
$et_fils_de="";
$sexe="";
$date_naisance="";
$lieu_naisance="";
$nationalite="";
$marie="";
$nbr_enfants="";
$fils_chahid="";
$andicape="";
$nature_endicape="";
$commune="";
$wilaya="";
$adresse="";
$n_telephone="";
$email="";
$service_national="";
$n_piece_sv="";
$date_deliv_piece_sv="";
$id="";
while ($row=mysqli_fetch_array($result1)){ 
$id=$row["id"];
$nom=$row["nom"];
$prenom=$row["prenom"];
$sexe=$row['sexe'];
$fils_de=$row["fils_de"];
$et_fils_de=$row["et_fils_de"];
$date_naisance=$row["date_naisance"];
$lieu_naisance=$row["lieu_naisance"];
$nationalite=$row["nationalite"];
$marie=$row["marie"];
$nbr_enfants=$row["nbr_enfants"];
$fils_chahid=$row["fils_chahid"];
$andicape=$row["andicape"];
$nature_endicape=$row["nature_endicape"];
$commune=$row["commune"];
$wilaya=$row["wilaya"];
$adresse=$row["adresse"];
$n_telephone=$row["n_telephone"];
$email=$row["email"];
$service_national=$row["service_national"];
$n_piece_sv=$row["n_piece_sv"];
$date_deliv_piece_sv=$row["date_deliv_piece_sv"];

$htmlpersian.=$row["grade"].'</em>
</p>';
}
$quer="select * from etablissement";
$resul=mysqli_query($connec,$quer);	
$nom_etab="";
while ($row=mysqli_fetch_array($resul)){
	$nom_etab=$row['Nom_etab_ar'];

}
$htmlpersian.='
<p align="center" dir="rtl" style="border:1px solid black; "><em>إطار خاص بالإدارة المنظمة للمسابقة</em><span dir="ltr"><br />
  </span>'.$nom_etab.'<span dir="ltr"> </span><span dir="ltr"><span dir="ltr"> </span><br />
</span><em>رقم التسجيل :'.$id.'  تاريخ التسجيل  (إيداع الملف):..........</em></p>
';

$htmlpersian.='<p></p><center><table border="1"   style="border:1px solid black;text-align:center"><tr><td><strong>1 : المعلومات الشخصية</strong></td></tr></table></center>';

$htmlpersian.='<p align="right" style="font-size:16px" dir="rtl">- اللقب :<i>'.$nom.' </i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  الإسم : <i>'.$prenom.'</i><br />
  <span dir="rtl">- إبن (ة) : <i>'.$fils_de.'</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  و   <i>'. $et_fils_de.'</i></span><br />
  <span dir="rtl">- تاريخ الإزدياد :  <i dir="rtl">'. $date_naisance .'</i></span><br />
  <span dir="rtl">- مكان الإزدياد :   <i>'. $lieu_naisance .'</i></span><br />
<span dir="rtl">الجنسية :  <i>'. $nationalite  .'</i></span><br />

<span dir="rtl">- الوظعية العائلية : متزوج (ة) <i>';


if($marie=="لا"){
	$htmlpersian.='&nbsp; نعم &nbsp;<table height="10px" > <tr><td   class="ici" style="; border:1px black solid;width:20px" > &nbsp;&nbsp;&nbsp; </td><td style="width:20px"> لا  </td><td style="border:1px black solid;width:20px">&nbsp;x </td>';}
	if($marie=="نعم"){
	$htmlpersian.='&nbsp; نعم &nbsp;<table > <tr><td   class="ici" style="; border:1px black solid;width:20px" > x  </td><td style="width:20px"> لا  </td><td style="border:1px black solid;width:20px"></td>';
}
$htmlpersian.='<td> عدد الأولاد '. $nbr_enfants  .'</td></tr></table><br />

<span dir="rtl">- هل لك صفة دوي حقوق الشهيد : )<i>';


 if($fils_chahid=="لا"){
	$htmlpersian.='&nbsp; نعم &nbsp;<table > <tr><td   class="ici" style="; border:1px black solid;width:20px" >   </td><td style="width:20px"> لا  </td><td style="border:1px black solid;width:20px">x</td></tr></table>';}
	if($fils_chahid=="نعم"){
$htmlpersian.='&nbsp; نعم &nbsp;<table > <tr><td   class="ici" style="; border:1px black solid;width:20px" > x  </td><td style="width:20px"> لا  </td><td style="border:1px black solid;width:20px"></td></tr></table>';
}$htmlpersian.='<br />
<span dir="rtl">- هل أنت من دوي الإحتياجات الخاصة :&nbsp;'; if($andicape=="لا"){
	$htmlpersian.='&nbsp; نعم &nbsp;<table  width="100%"> <tr><td   class="ici" style="; border:1px black solid;width:20px" >   </td><td style="width:20px"> لا  </td><td style="border:1px black solid;width:20px">x</td>';}


	if($andicape=="نعم"){
	$htmlpersian.='&nbsp; نعم &nbsp;<table > <tr><td   class="ici" style="; border:1px black solid;width:20px" > x  </td><td style="width:20px"> لا  </td><td style="border:1px black solid;width:20px"></td>
	';
}






$htmlpersian.='<td width="50%"> أذكر طبيعة الإعاقة :'. $nature_endicape .'</td></tr></table> <br /><span dir="rtl"> مكان الإقامة  البلدية :'.$commune .' الولاية   '. $wilaya .'</span><br />';



$htmlpersian.='<span dir="rtl">- العنوان :   '.$adresse.'</span><br /><span dir="rtl">- رقم الهاتف :   '. $n_telephone .'</span><br />';


if($sexe=="أنثى"){
	
}else{
$htmlpersian.='<span dir="ltr">: عنوان البريد الإلكتروني -  </span><span dir="rtl"> '. $email .'</span><br /><span dir="rtl">- الوضعية اتجاه الخدمة الوطنية :'; 


if($service_national=="مؤدى"){
	$htmlpersian.='<table > <tr><td style="width:30px">مؤدى</td><td   class="ici" style="; border:1px black solid;width:20px" >x</td><td>    معفى   </td><td> مؤجل </td><td> مسجل  </td> </tr></table>  ';}
	if($service_national=="معفى"){
	$htmlpersian.='<table > <tr><td>مؤدى</td><td style="width:30px"> معفى  </td><td   class="ici" style="; border:1px black solid;width:20px">x</td><td >   مؤجل    </td><td> مسجل</td> </tr></table> ';
}
	if($service_national=="مؤجل"){
	$htmlpersian.='<table > <tr><td>مؤدى</td><td> معفى  </td><td style="width:30px">مؤجل </td><td   class="ici" style="; border:1px black solid;width:20px" > x  </td><td>    مسجل    </td> </tr></table> ';
}
	if($service_national=="مسجل"){
	$htmlpersian.='<table > <tr><td>مؤدى</td><td> معفى  </td><td> مؤجل  </td><td style="width:40px"> مسجل </td><td   class="ici" style="; border:1px black solid;width:20px" > x  </td>  </tr></table> ';
}
;
$htmlpersian.='<br /><span dir="rtl">- مرجع الوثيقة : الرقم : '. $n_piece_sv .' تاريخ الإصدار :  '.$date_deliv_piece_sv.'</span>';
}

$pdf->WriteHTML($htmlpersian, true, 0, true, 0);


// diplome

$nom_diplom="";
$nom_filiere="";
$nom_specialite="";
$date_diplome="";
$numero_diplome="";
$dure_diplomeA="";
$dure_diplomeM="";
$dure_diplome_de="";
$dure_diplome_jusqua="";
$etablis_diplome="";
while ($row1=mysqli_fetch_array($result2)){ 
$nom_diplom=$row1["nom_diplom"];
$nom_filiere=$row1["nom_filiere"];
$nom_specialite=$row1["nom_specialite"];
$date_diplome=$row1["date_diplome"];
$numero_diplome=$row1["numero_diplome"];
$dure_diplomeA=$row1["dure_diplomeA"];
$dure_diplomeM=$row1["dure_diplomeM"];
$dure_diplome_de=$row1["dure_diplome_de"];
$dure_diplome_jusqua=$row1["dure_diplome_jusqua"];
$etablis_diplome=$row1["etablis_diplome"];
}

$html='<p align="center" style="border:1px solid black">2- معلومات حول الشهادة (أو المؤهل) المتحصل   عليه</p>
<p align="right" style="font-size:16px"><span dir="rtl" >*تسمية الشهادة : <i>'.$nom_diplom.'</i></span><br /><span dir="rtl">الشعبة : <i>'. $nom_filiere.'</i> التخصص :  <i>'. $nom_specialite.'</i></span><br /> <span dir="rtl">- تاريخ الحصول على الشهادة ( أو المؤهل) : <i> '.$date_diplome.'  </i>رقم : <i> '.$numero_diplome.'  </i></span><br /><span dir="rtl">مدة التكوين للحصول على الشهادة :&nbsp;  <i> '.$dure_diplomeA.'"سنة و"'.$dure_diplomeM.'"شهر"</i>من<i> '.$dure_diplome_de.'</i>إلى<i>'.$dure_diplome_jusqua.'</i></span><br /><span dir="rtl">-المؤسسة المسلمة للشهادة : <i>'.$etablis_diplome.' </i></span></p></font></h2></div>';

$pdf->WriteHTML($html, true, 0, true, 0);
$pdf->AddPage('P', 'A4');
$pdf->Cell(0, 0, 'A4 PORTRAIT', 1, 1, 'C');
// set LTR direction for english translation
//PAGE 02***************************************
$html='<p></p><center><table border="1"   style="border:1px solid black;text-align:center"><tr><td><strong> 3- معلومات حول المسار الدراسي</strong></td></tr></table></center>';
$pdf->WriteHTML($html, true, 0, true, 0);

$mention_diplome="";
	$anne_major;
	$n_piece_major;
	
	$date_piece_major;
	$de;
	$pr_an1sm;$pr_an2sm;$pr_anmy;
	$dz_an1sm;$dz_an2sm;$dz_anmy;
	$tr_an1sm;$tr_an2sm;$tr_anmy;
	$qt_an1sm;$qt_an2sm;$qt_anmy;
	$cq_an1sm;$cq_an2sm;$cq_anmy;
	$six_an1sm;$six_an2sm;$six_anmy;
	$sept_an1sm;$sept_an2sm;$sept_anmy;
	$huit_an1sm;$huit_an2sm;$huit_anmy;
	$moyen_general;
	$note_memoire;
	while($row2=mysqli_fetch_array($result3)){
		$mention_diplome=$row2["mention_diplome"];
	$anne_major=$row2["anne_major"];
	$n_piece_major=$row2["n_piece_major"];
	
	$date_piece_major=$row2["date_piece_major"];
	$de=$row2["de"];
	$pr_an1sm=$row2["pr_an1sm"];$pr_an2sm=$row2["pr_an2sm"];$pr_anmy=$row2["pr_anmy"];
	$dz_an1sm=$row2["dz_an1sm"];$dz_an2sm=$row2["dz_an2sm"];$dz_anmy=$row2["dz_anmy"];
	$tr_an1sm=$row2["tr_an1sm"];$tr_an2sm=$row2["tr_an2sm"];$tr_anmy=$row2["tr_anmy"];
	$qt_an1sm=$row2["qt_an1sm"];$qt_an2sm=$row2["qt_an2sm"];$qt_anmy=$row2["qt_anmy"];
	$cq_an1sm=$row2["cq_an1sm"];$cq_an2sm=$row2["cq_an2sm"];$cq_anmy=$row2["cq_anmy"];
	$six_an1sm=$row2["six_an1sm"];$six_an2sm=$row2["six_an2sm"];$six_anmy=$row2["six_anmy"];
	$sept_an1sm=$row2["sept_an1sm"];$sept_an2sm=$row2["sept_an2sm"];$sept_anmy=$row2["sept_anmy"];
	$huit_an1sm=$row2["huit_an1sm"];$huit_an2sm=$row2["huit_an2sm"];$huit_anmy=$row2["huit_anmy"];
	$moyen_general=$row2["moyen_general"];
	$note_memoire=$row2["note_memoire"];
	}
$html='<p align="right" style="font-size:16px"><span dir="rtl">*تقدير الشهادة : '.$mention_diplome.' </span><br />
  <span dir="rtl">* الطالب الأول (Major) في الدفعة : السنة الدراسية :  '.$anne_major.'رقم الوثيقة : '.$n_piece_major.'</span><br />
  <span dir="rtl">تاريخ الإصدار : '.$date_piece_major.' من قبل : '.$de.' </span><br />
  <span dir="rtl">*معدل المسار الدراسي (كما هو مبين في كشوف النقاط السنوية أو السداسية ) : </span></p>
 ';
$pdf->WriteHTML($html, true, 0, true, 0);
$pdf->setRTL(false);
$html=' <style>
    table{
      direction:rtl;
    }
  </style><center><table  class="table-hover table-bordered pull-right" id="table1" border="1" >
   <tr>
    <th  rowspan="2" valign="top">المعدل العام
مجموع معدل السنوات</th>
    <th  rowspan="2" valign="top">المعدل السنوي</th>
    <th  colspan="2" valign="top">معدل السداسي</th>
    <th  rowspan="2" valign="top">السنة</th>
  </tr>
  <tr>
    <th  valign="top">السداسي الثاني</th>
    <th  valign="top">السداسي الأول</th>
  </tr>
  <tr>
    <td  rowspan="8" valign="top"><i align="right">'.$moyen_general.'  </i></td>
    <td  valign="top"><i align="right">'.$pr_anmy.'  </i></td>
    <td valign="top"><i align="right">'.$pr_an2sm.'  </i></td>
    <td  valign="top"><i align="right">'.$pr_an1sm.'  </i></td>
    <td  valign="top">1</td>
  </tr>
  <tr>
    <td  valign="top"><i align="right">'.$dz_anmy.'  </i></td>
    <td  valign="top"><i align="right">'.$dz_an2sm.'  </i></td>
    <td  valign="top"><i align="right">'.$dz_an1sm.'  </i></td>
    <td  valign="top">2</td>
  </tr>
  <tr>
    <td valign="top"><i align="right">'.$tr_anmy.'  </i></td>
    <td  valign="top"><i align="right">'.$tr_an2sm.'  </i></td>
    <td  valign="top"><i align="right">'.$tr_an1sm.'  </i></td>
    <td  valign="top">3</td>
  </tr>
  <tr>
    <td  valign="top"><i align="right">'.$qt_anmy.'  </i></td>
    <td  valign="top"><i align="right">'.$qt_an2sm.'  </i></td>
    <td  valign="top"><i align="right">'.$qt_an1sm.'  </i></td>
    <td  valign="top">4</td>
  </tr>
  <tr>
    <td  valign="top"><i align="right">'.$cq_anmy.'  </i></td>
    <td  valign="top"><i align="right">'.$cq_an2sm.'  </i></td>
    <td  valign="top"><i align="right">'.$cq_an1sm.'  </i></td>
    <td  valign="top">5</td>
  </tr>
  <tr>
    <td  valign="top"><i align="right">'.$six_anmy.'  </i></td>
    <td  valign="top"><i align="right">'.$six_an2sm.'  </i></td>
    <td  valign="top"><i align="right">'.$six_an1sm.'  </i></td>
    <td  valign="top">6</td>
  </tr>
  <tr>
    <td  valign="top"><i align="right">'.$sept_anmy.'  </i></td>
    <td  valign="top"><i align="right">'.$sept_an2sm.'  </i></td>
    <td  valign="top"><i align="right">'.$sept_an1sm.'  </i></td>
    <td  valign="top">7</td>
  </tr>
  <tr>
    <td  valign="top"><i align="right">'.$huit_anmy.'  </i></td>
    <td valign="top"><i align="right">'.$huit_an2sm.'  </i></td>
    <td  valign="top"><i align="right">'.$huit_an1sm.'  </i></td>
    <td  valign="top">8</td>
  </tr>
</table></center>';
$pdf->WriteHTML($html, true, 0, true, 0);
$pdf->setRTL(true);
$html='<p align="right" style="font-size:16px"><span dir="rtl">علامة مدكرة نهاية الدراسة إن لم تكن محسوبة في معدل السداسي الأخير أو المعدل العام:'.$note_memoire.'</span><br />';
$pdf->WriteHTML($html, true, 0, true, 0);

$html='<center><table border="1"   style="border:1px solid black;text-align:center"><tr><td><strong>4-معلومات حول التكوين المكمل للشهادة في نفس التخصص (ان وجدت)
</strong></td></tr></table></center>';
$pdf->WriteHTML($html, true, 0, true, 0);




// formation **********************


$html='<table border="1" ><tr><td  rowspan="2" valign="top">طبيعة الشهاد</td>
<td  rowspan="2" valign="top">الشعبة </td>
   <td  rowspan="2" valign="top">التخصص</td>
   <td  rowspan="2" valign="top">المؤسسة المسلمة للشهادة</td><td  rowspan="2" valign="top">رقم الشهادة</td>
      <td rowspan="2" valign="top" >تاريخ إصدار الشهادة</td>
       <td  colspan="2" valign="top">مدة التكوين</td>        
      <td rowspan="2"  valign="top"  >تاريخ الحصول على الشهادة أو <br>تاريخ التسجيل في الدكتوراه</td>   
    </tr>
    <tr>
      <td  valign="top">من</td>
     <td  valign="top">إلى</td>   
    </tr>';
				



 if($code4==0){
$html.='<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';	
 }
else{
	$i=0;
while ($row4=mysqli_fetch_array($result4)){
	$nature_diplome_f="";
	$filiere_f="";
	$specialite_f="";
	$etablissement_f="";
	$numero_diplome_f="";
	$date_diplome_f="";
		$date_f_de="";
			$date_f_jusqua="";
				$date_doctor="";
	if($i==0){
	$nature_diplome_f="nature_diplome_f";
	$filiere_f="filiere_f";
	$specialite_f="specialite_f";
	$etablissement_f="etablissement_f";
	$numero_diplome_f="numero_diplome_f";
	$date_diplome_f="date_diplome_f";
		$date_f_de="date_f_de";
			$date_f_jusqua="date_f_jusqua";
				$date_doctor="date_doctor";
	}
	else{
	$nature_diplome_f="nature_diplome_f".$i;	
	$filiere_f="filiere_f".$i;
	$specialite_f="specialite_f".$i;
		$etablissement_f="etablissement_f".$i;
			$specialite_f="specialite_f".$i;
				$numero_diplome_f="numero_diplome_f".$i;
	$date_diplome_f="date_diplome_f".$i;
	$date_f_de="date_f_de".$i;
	$date_f_jusqua="date_f_jusqua".$i;
	$date_doctor="date_doctor".$i;
	}
	
$html.='<tr style="font-size:11px"><td>'.$row4[$nature_diplome_f].'</td>
 <td>'.$row4[$filiere_f].'</td>
 <td>'.$row4[$specialite_f].'</td>
 <td>'.$row4[$etablissement_f].'</td>
 <td>'.$row4[$numero_diplome_f].'</td>
 <td>'.$row4[$date_diplome_f].'</td>
 <td>'.$row4[$date_f_de].'</td>
 <td>'.$row4[$date_f_jusqua].'</td>
 <td>'.$row4[$date_doctor].'</td></tr>';

}
 
}
 

$html.='</table></center><br>';
$pdf->WriteHTML($html, true, 0, true, 0);


$pdf->AddPage('P', 'A4');
$pdf->Cell(0, 0, 'A4 PORTRAIT', 5, 5, 'C');

//***travaux*******************
$html='<p></p><center><table border="1"   style="border:1px solid black;text-align:center"><tr><td><strong> 5- معلومات حول الأشغال والدراسات المنجزة (إن وجدت)
</strong></td></tr></table></center>';
$pdf->WriteHTML($html, true, 0, true, 0);

$html='<center><table border="1">
				 <tr>
   <td  rowspan="2" valign="top"><p >طبيعة العمل أو الدراسة</p></td>
<td  rowspan="2" valign="top"><p >تاريخ النشر </p></td>
 

       <td  colspan="3" valign="top"><p >المجلة أو الدورية المنشور بها</p></td>        
     
    </tr>
    <tr>
      <td  valign="top"><p >التسمية</p></td>
     <td  valign="top">العدد</td>
     <td  valign="top"><p >التاريخ</p></td>

    </tr>';
	
	 if($code5==0){
$html.='<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';	
 }
 else{
	$i=0;
while ($row5=mysqli_fetch_array($result5)){
	$nature_travail='';
	$date_publication='';
	$nom_journal_publication='';
	$numero_journal_publication='';
	$date_journal_publication='';
	
	if($i==0){
	$nature_travail="nature_travail";
	$date_publication="date_publication";
	$nom_journal_publication="nom_journal_publication";
	$numero_journal_publication="numero_journal_publication";
	$date_journal_publication="date_journal_publication";
	
	}
	else{
	$nature_travail="nature_travail".$i;	
	$date_publication="date_publication".$i;
	$nom_journal_publication="nom_journal_publication".$i;
		$numero_journal_publication="numero_journal_publication".$i;
			$date_journal_publication="date_journal_publication".$i;
			
	}
	$html.='<tr style="font-size:11px"><td>'.$row5[$nature_travail].'</td>
<td>'.$row5[$date_publication].'</td>
<td>'.$row5[$nom_journal_publication].'</td>
<td>'.$row5[$numero_journal_publication].'</td>
<td>'.$row5[$date_journal_publication].'</td></tr>';
}
 }
$html.='</table>';	
	
 $pdf->WriteHTML($html, true, 0, true, 0);
 
 //experiance*********************
 $html='<p></p><center><table border="1"   style="border:1px solid black;text-align:center"><tr><td><strong> 6- معلومات حول الخبرة المهنية (إن وجدت) 
</strong></td></tr></table></center>';
$pdf->WriteHTML($html, true, 0, true, 0);

$html='<table  border="1" > <tr>
   <td  rowspan="2" valign="top">تسمية الإدارة أو المؤسسة  
(الهيئة المستخدمة)</td>
<td rowspan="2" valign="top">الوظيفة أو المنصبالمشغول</td>
 

       <td  colspan="2" valign="top">االفترة</td>   
         <td  colspan="2" valign="top">شهادة العمل أو عقد العمل</td>  
           <td  rowspan="2" valign="top">سبب إنهاء علاقة العمل</td>     
     
    </tr>
    <tr>
 
     <td  valign="top">من</td>
     <td  valign="top">الى</td>
       <td  valign="top">الرقم</td>
     <td  valign="top">التاريخ</td>
   
      
      
     
    </tr>';
		 if($code6==0){
$html.='<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';	
 }
  else{
	$i=0;
while ($row6=mysqli_fetch_array($result6)){
	$etablis_experiance='';
	$grade_experiance='';
	$date_experiance_de='';
	$date_experiance_jusqua='';
	$numero_attestation='';
		$date_attestation='';
			$cause_fin_relation='';
	
	if($i==0){
	$etablis_experiance="etablis_experiance";
	$grade_experiance="grade_experiance";
	$date_experiance_de="date_experiance_de";
	$date_experiance_jusqua="date_experiance_jusqua";
	$numero_attestation="numero_attestation";
	$date_attestation="date_attestation";
	$cause_fin_relation="cause_fin_relation";
	
	}
	else{
	$etablis_experiance="etablis_experiance".$i;	
	$grade_experiance="grade_experiance".$i;
	$date_experiance_de="date_experiance_de".$i;
		$date_experiance_jusqua="date_experiance_jusqua".$i;
			$numero_attestation="numero_attestation".$i;
			$date_attestation="date_attestation".$i;
			$cause_fin_relation="cause_fin_relation".$i;
			
	}
	$html.='<tr style="font-size:11px"><td>'.$row6[$etablis_experiance].'</td>
<td>'.$row6[$grade_experiance].'</td>
<td>'.$row6[$date_experiance_de].'</td>
<td>'.$row6[$date_experiance_jusqua].'</td>
<td>'.$row6[$numero_attestation].'</td>
<td>'.$row6[$date_attestation].'</td>
<td>'.$row6[$cause_fin_relation].'</td></tr>';
}
  }
$html.='</table>';	
	
 $pdf->WriteHTML($html, true, 0, true, 0);
 
 
 
 
 //dernier etape******************##############
  $html='<center><table border="1"   style="border:1px solid black;text-align:center"><tr><td><strong> 7- معلومات حول الوضعية المهنية الحالية (بالنسبة للمترشحين العاملين)

</strong></td></tr></table></center>';
$pdf->WriteHTML($html, true, 0, true, 0);
 
 $nom_emploie="";
$date_emploie_initial="";
$date_emploie_actuel="";
$categorie="";
$degre="";
$numero_document="";
$date_document="";
$nature_signateur="";
$adresse_administration="";
$telephone_administration="";
$fax_administration="";
$email_administration="";

while ($row7=mysqli_fetch_array($result7)){ 
$nom_emploie=$row7["nom_emploie"];
$date_emploie_initial=$row7["date_emploie_initial"];
$date_emploie_actuel=$row7["date_emploie_actuel"];
$categorie=$row7["categorie"];
$degre=$row7["degre"];
$numero_document=$row7["numero_document"];
$date_document=$row7["date_document"];
$nature_signateur=$row7["nature_signateur"];
$adresse_administration=$row7["adresse_administration"];
$telephone_administration=$row7["telephone_administration"];
$fax_administration=$row7["fax_administration"];
$email_administration=$row7["email_administration"];

}
 
 
$html=' <p align="right" style="font-size:16px"><span dir="rtl">* تسوية الوظيفة أو الرتب المشغولة عند تاريخ الترشح للمسابقة :  '.$nom_emploie.'</span><br />
  <span dir="rtl">- تاريخ أول تعيين :  '.$date_emploie_initial.'</span><br />
  <span dir="rtl">- تاريخ التعيين في الرتبة أو المنصب المشغول حاليا :   '.$date_emploie_actuel.'</span><br />
  <span dir="rtl">- الصنف : '.$categorie.'</span><br />
  <span dir="rtl">- الدرجة : '.$degre.'</span><br />
  <span dir="rtl">- مرجع موافقة الإدارة المستخدمة للمشاركة في المسابقة : الرقم :  '.$numero_document.' التاريخ : '.$date_document.'</span><br />
  <span dir="rtl">* صفة السلطة صاحبة الإمضاء :  '.$nature_signateur.'</span><br />
  <span dir="rtl">- عنوان الإدارة : '.$adresse_administration.'</span><br />
  <span dir="rtl">- الهاتف :'.$telephone_administration.' فاكس : '.$fax_administration.' البريد الإلكتروني :'.$email_administration.'</span><br />';
$pdf->WriteHTML($html, true, 0, true, 0);

$html='<br><p style="font-size:20px">             أنا الممضي أدناه أصرح بشرفي  بصحة المعلومات المبينة في  هذه الوثيقة وأتحمل كل تبعات 
عدم صحة أو دقة المعلومات بما في  ذلك إلغاء نجاحي في  المسابقة. 
 </p><p style="text-align:left">إمضاء المعني</p>'; 
$pdf->WriteHTML($html, true, 0, true, 0);
// print newline
//$pdf->Ln();

// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('imprime.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>