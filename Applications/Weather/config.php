<?php
//    =========================================================
// 						Variables
//    =========================================================


if (!isset($_GET['city']))
{
	//If not isset -> set as empty
$city="" ;

} else {
	$city = str_replace('..', '', str_replace(str_split('\\~#[]{};:$!#^&%@>*<"\''), '', $_GET['city']));
}

$png ="";
$key ='';
    
/* === Get url ==== */
$urlWithCity = 'https://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$key;

$imageUrl = 'https://openweathermap.org/img/w/'.$png;
    

//    =========================================================
// 						Functions
//    =========================================================

function curl($url) {
	#  HTTP request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

  function getContents($input, $url, $icon, $theUrl) {
    /* ===  Once city is typed in get the
            contents and show it back to the user       ==== */
        if (!empty($input)) {
            $urlContents = curl($url);
            $weatherArray = json_decode($urlContents, true);
            $weather = $input." currently has ".$weatherArray['weather'][0]['description'].".";
			$icon = $weatherArray['weather'][0]['icon']; // Access the icon in the json file
			$newIconUrl = $theUrl.$icon.'.png'; // concatenate and inject to the img's src attribute
            print_r($weatherArray);
			

        }          
   }

 ?>
