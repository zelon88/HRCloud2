<?php
// / --------------------------------------------------
// / Declare variables.
if (!isset($_GET['city'])) $city = "" ; 
else $city = str_replace('..', '', str_replace(str_split('\\~#[]{};:$!#^&%@>*<"\''), '', $_GET['city'])); 

// / Set the time.
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$Now = time();

// / Your OpenWeatherMap.org API key.
// / Requires account with OpenWeatherMap.
$key = '<INSERT_OPENWEATHERMAP_API_KEY_HERE';

// / Specify URLs used to obtain weather information.
$urlWithCity = 'https://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$key;
$imageUrl = 'https://openweathermap.org/img/w/';
$icon = 'Weather.png';

// / Specify string variables for UI elements.
$needKeyTextA = 'It looks like your server administrator has not yet setup their API key!';
$needKeyTextB = 'Tell them to head to https://openweathermap.org/ and sign up for a free account so you can check the weather using this app.';
$needKeyText = $needKeyTextA.PHP_EOL.$needKeyTextB;
$welcomeTextA = 'What\'s the weather?';
$welcomeTextB = 'Enter the name of a city to check its weather.';
$jumbotronTopText = $welcomeTextA;
$jumbotronBottomText = $welcomeTextB;

// / Initialize default variables.
$weather = '';
$weatherArray = array();
$tempKelvin = $tempKelvinMin = $tempKelvinMax = $feelsLike = $pressure = $humidity = $cloudCover = $windSpeed = $visibility = $direction = $sunrise = $sunset = 0;
// / --------------------------------------------------

// / --------------------------------------------------
// / Declare functions.

// / A function to send a curl request to the weather provider.
function curl($url) { 
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data; }

// / Convert temperature kelvin to fahrenheit.
function kelvin_to_fahrenheit($kelvin) { 
  return (9 / 5 * ($kelvin - 273.15) + 32); }

// / Convert temperature kelvin to celsius.
function kelvin_to_celsius($kelvin) { 
  return ($kelvin - 273.15); }

// / Convert speed in meters per second to kilometers per hour.
function mps_to_kph($mps) { 
  return (3.6 * $mps); }

// / Convert speed in meters per second to miles per hour.
function mps_to_mph($mps) {
  return (2.23694 * $mps); }

// / A function to parse the JSON response from the weather provider.
function getContents($input, $url, $theUrl) { 
if (!empty($input) && !empty($url) && !empty($theUrl)) { 
  $urlContents = curl($url);
  $weatherArray = json_decode($urlContents, true);
  $weather = $input." currently has ".$weatherArray['weather'][0]['description'].".";
  $tempKelvin = $weatherArray['main']['temp'];
  $tempKelvinMin = $weatherArray['main']['temp_min'];
  $tempKelvinMax = $weatherArray['main']['temp_max'];
  $feelsLike = $weatherArray['main']['feels_like'];
  $pressure = $weatherArray['main']['pressure'];
  $humidity = $weatherArray['main']['humidity'];
  $visibility = $weatherArray['visibility'];
  $cloudCover = $weatherArray['clouds']['all'];
  $windSpeed = $weatherArray['wind']['speed'];
  $direction = $weatherArray['wind']['deg'];
  $sunrise = $weatherArray['sys']['sunrise'];
  $sunset = $weatherArray['sys']['sunset'];
  $icon = $weatherArray['weather'][0]['icon']; // Access the icon in the json file.
  $icon = $theUrl.$icon.'.png'; // Concatenate and inject to the img's src attribute.
  return (array($weather, $weatherArray, $icon, $tempKelvin, $tempKelvinMin, $tempKelvinMax, $feelsLike, $pressure, $humidity, $cloudCover, $visibility, $windSpeed, $direction, $sunrise, $sunset)); } }
// / --------------------------------------------------