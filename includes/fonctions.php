<?php
	
function transformer($code) {
	$code = preg_replace("#é#", '&eacute;', $code);
	$code = preg_replace("#è#", '&egrave;', $code);
	$code = preg_replace("#ê#", '&ecirc;', $code);
	$code = preg_replace("#à#", '&agrave;', $code);
	$code = preg_replace("#ç#", '&ccedil;', $code);
	$code = preg_replace("#ù#", '&ugrave;', $code);
	$code = preg_replace("#û#", '&ucirc;', $code);
	$code = preg_replace("#©#", '&copy;', $code);
	

	return $code;
}

function find_all_files($dir) 
{ 
    $root = scandir($dir,0); 
    foreach($root as $value) 
    { 
        if($value === '.' || $value === '..' || $value === 'index.html') {continue;} 
        if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;} 
        foreach(find_all_files("$dir/$value") as $value) 
        { 
            $result[]=$value; 
        } 
    } 
    return $result; 
}

function eleminer_zeros_de_date( $date="" ) {
  // first remove the marked zeros
  $sans_zeros = str_replace('*0', '', $date);
  // then remove any remaining marks
  $nettoye = str_replace('*', '', $sans_zeros);
  return $nettoye;
}

function readresser_a( $emplacement = NULL ) {
  if ($emplacement != NULL) {
    header("Location: {$emplacement}");
    exit;
  }
}

function afficher_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}



function contenir_composition_template($template="") {
    global $user,$main_menu_sel,$sub_menu_sel;
	include(SITE_ROOT.DS.'composit'.DS.$template);
}
 //*******************************************************************************

//*********************************************************

function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "pas de permition d'ecriture sur le ficher login ";
  }
}

function datetime_to_text($datetime=""){
  $unixdatetime = strtotime($datetime);
  return strftime("%d/%m/%Y a %I:%M %p",$unixdatetime);
}

function datetime_to_year($datetime=""){
  $unixdatetime = strtotime($datetime);
  return strftime("%Y ",$unixdatetime);
}

function mysql_datetime($datetime=''){
 if(empty($datetime)){
 return strftime("%Y-%m-%d %H:%M:%S",time());
 }else{
  return strftime("%Y-%m-%d %H:%M:%S",$datetime);
 }
 }
 
function mysql_date($date=''){
 if(empty($date)){
 return strftime("%Y-%m-%d",time());
 }else{
  return strftime("%Y-%m-%d",$date);
 }
 } 
 
function mysql_time($time=''){
 if(empty($time)){
 return strftime("%H:%M",time());
 }else{
  return strftime("%H:%M",$time);
 }
 }
 
 function fr_datetime($datetime=''){
 if(empty($datetime)){
 return strftime("%H:%M:%S | %d/%m/%Y ",time());
 }else{
  return strftime("%H:%M:%S | %d/%m/%Y ",$datetime);
 }
 }
 function fr_date($datetime){
 if(empty($datetime)){
 return strftime("%d/%m/%Y",time());
 }else{
  return strftime("%d/%m/%Y",$datetime);
 }
 }
 
  function fr_date2($datetime){
  $unixdatetime = strtotime($datetime);
  return strftime("%d-%m-%Y",$unixdatetime);
 }
 
 
function frdate_mysqldate($frdate){
    $jj = substr($frdate,0,2);
	$mm = substr($frdate,3,2);
	$yy = substr($frdate,6,4);
	
	return  strftime("%Y-%m-%d %H:%M:%S",strtotime($yy."-".$mm."-".$jj));
}

function get_date($datemysql){
    $date[] = substr($datemysql,0,4);
	$date[] = substr($datemysql,5,2);
	$date[] = substr($datemysql,8,2);
	
	return  $date;
 }
 
 function ar_date($datetime=''){
 if(empty($datetime)){
 return strftime("%Y/%m/%d ",time());
 }else{
  return strftime("%Y/%m/%d ",$datetime);
 }
 }
 function fr_datetime2($datetime=''){
 if(empty($datetime)){
 return strftime(" %d.%m.%y | %Hh%M ",time());
 }else{
  return strftime(" %d.%m.%y | %Hh%M ",$datetime);
 }

}

								
						
								
function error_message($msg){

return '<div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <br/>
			  '.$msg.' 
            </div>';
}

function system_message($msg){

return '<div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <br/>
			  '.$msg.'
            </div>';
}

function positif_message($msg){
return '<div class="alert alert-success ">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <br/>
			  '.$msg.'
            </div>';


}

function session_message($msg){
return '<div class="alert alert-info">'.$msg.'</div>';
return '<div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <br/>
			  '.$msg.'
            </div>';
}

function warning_message($msg){

return '<div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <br/>
			  '.$msg.'
            </div>';
}

?>