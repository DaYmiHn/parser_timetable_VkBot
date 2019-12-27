<?php
require_once "simple_html_dom.php";
$html1 =  file_get_html("https://stats.pkgh.ru/?group=ИП-16-3&lastname=Осейкин&period=week");



foreach($html1->find('.simple-little-table')[0]->find('tr') as $div) { 
	if(strpos($div, date("d.m.y")) !== false) { 
 		$prihod = $div->find('td')[1]->innertext; 
    }
}
if ($prihod !== '---'){
	$url = "https://api.vk.com/method/messages.send?message=Уса%20подъехала%20в%20".$prihod."&user_id=159523765&access_token=f7f6da8696c1ab55e0c42128f7fc8a347d589e10fcdd0c113f4a1eaddc91cddc1f0425fa97155de81c8b8&v=5.0";
	file_get_contents($url);
}
$connection = new PDO('mysql:host=localhost;dbname=id9518464_botrasp', 'id9518464_den', 'savin228' );
$connection->query("TRUNCATE TABLE rasp;"); 

$html =  file_get_html("https://pkgh.edu.ru/obuchenie/shedule-of-classes.html");

foreach($html->find('.showhide') as $div) { 
	if(strpos($div->innertext, 'ИП-16-3') !== false) { 
 		$rasp = $div->find('table')[1]; 
    }
}
$k= 0;
foreach($rasp->find('tr.pair') as $div) {
		$k++;
		$para = $div->find('p.pname')[7]->innertext;
		if(strpos($para, 'МДК') !== false) {
 			$para = substr($para, 16); 
    	} 
		$chars = ['&nbsp;','(', ')'];
		$cab = str_replace($chars, '', $div->find('span.pcab')[0]->innertext);
	    $connection->query("INSERT INTO rasp VALUES (".$k.", '".$para."', '".$cab."');");

	    // echo date("D",time());
	}
	$connection->query("INSERT INTO rasp VALUES ('6', 'Не учебное время', '');");

 ?>
