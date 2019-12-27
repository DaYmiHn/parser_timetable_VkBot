<?php
require_once "simple_html_dom.php";

if (!isset($_REQUEST)) {
    return;
}
function getToken(){
	$html = file_get_html('https://myshop-uu56.myinsales.ru/admin/login');
	$i = 1;
	foreach($html->find('input') as $a) {
	 if ($i ==2)$token = $a->value;
	 $i++;
	}
	return $token;
}

function getCount(){
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
    curl_setopt($curl, CURLOPT_COOKIEFILE, "cookiefile"); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.0; ru; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'); 
    curl_setopt($curl, CURLOPT_URL, 'https://myshop-uu56.myinsales.ru/admin/login'); 
    $html = curl_exec($curl);

    $post = "utf8=✓&authenticity_token=".getToken()."&continue=https://myshop-uu56.myinsales.ru/admin2/dashboard?&enter_host=&auth_domain=myshop-uu56&email=spb.koroleva48@smart.space&password=4a7e4e86734c9b23c&commit=Войти";

    curl_setopt($curl, CURLOPT_URL, 'https://auth.insales.ru/login');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    $html = curl_exec($curl);


   	$url = 'https://myshop-uu56.myinsales.ru/admin2/orders?c_from='.date("d.m.Y").'&c_to='.date("d.m.Y").'&page=1&per_page=200&s%5B%5D=delivered&utf8=%E2%9C%93';
    curl_setopt($curl, CURLOPT_URL, $url);
    $fp = fopen("temp_file.html", "w");
    curl_setopt($curl, CURLOPT_FILE, $fp);
    $html = curl_exec($curl);
    $page = file_get_html("temp_file.html");

    $i = 0;
	foreach($page->find('input') as $a) {
		$i++;
	}
	return $i-10;
}



$connection = new PDO('mysql:host=localhost;dbname=id9518464_botrasp', 'id9518464_den', 'savin228' );
$confirmationToken = '3b410de1';

$token = 'f7f6da8696c1ab55e0c42128f7fc8a347d589e10fcdd0c113f4a1eaddc91cddc1f0425fa97155de81c8b8';

$secretKey = 'dfsdfsdfw3rwesdf';

$data = json_decode(file_get_contents('php://input')); 

switch ($data->type) { 

case 'confirmation': 
echo $confirmation_token; 
break; 


case 'message_new': 



$user_id = $data->object->user_id; 
$user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&access_token={$token}&v=5.0")); 

// if ($data->object->body == 'Сколько заказов?' || $data->object->body == 'сколько'){
    $para = 'Сегодня было доставленно '.getCount().' заказов';
// } else {
    // $para = $data->object->body;
// }


$user_name = $user_info->response[0]->first_name; 

$request_params = array( 
'message' => $para, 
//'message' => $para."<br>"., 
'user_id' => $user_id, 
'access_token' => $token, 
'v' => '5.0' 
); 

$get_params = http_build_query($request_params); 

file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 


echo('ok'); 

break; 

} 
?> 