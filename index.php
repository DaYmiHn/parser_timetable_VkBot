<?php 
require_once "simple_html_dom.php";
$connection = new PDO('mysql:host=localhost;dbname=id9518464_botrasp', 'id9518464_den', '1234578' );

function sravTime($n, $e, $t){
	if (strtotime($t)>strtotime($n) && strtotime($t)<strtotime($e)) {
 		return true;
 	} else {
 		return false;
 	}
}

$onlineTime = '12:30';
$z = array('1_n' => '08:00', '1_e' => '10:40',  //звонки
		'2_n' => '10:40', '2_e' => '12:25',
		'3_n' => '12:25', '3_e' => '14:35',
		'4_n' => '14:35', '4_e' => '16:20',
		'5_n' => '16:20', '5_e' => '18:00',
		'neactiv_n' => '18:00', 'neactiv_e' => '08:00');

if (sravTime($z['1_n'], $z['1_e'], $onlineTime)) {
	$para =  '1';
} elseif (sravTime($z['2_n'], $z['2_e'], $onlineTime)){
	$para =  '2';
} elseif (sravTime($z['3_n'], $z['3_e'], $onlineTime)){
	$para =  '3';
} elseif (sravTime($z['4_n'], $z['4_e'], $onlineTime)){
	$para =  '4';
} elseif (sravTime($z['5_n'], $z['5_e'], $onlineTime)){
	$para =  '5';
} else {
	$para =  '6';
// 	break;
}

$sql = "SELECT * FROM `rasp` WHERE `num` =  '".$para."'";
$result = $connection->query($sql);
$assocArray = $result->fetch();
$para =  $assocArray['para']."   ".$assocArray['cab']; 


