<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Calendar
App Version: 0.5 (1-18-2018 23:00)
App License: GPLv3
App Author: bastianallgeier & zelon88
App Description: A simple Calendar app for HRCloud2!
App Integration: 0 (False)
HRCLOUD2-PLUGIN-END
//*/

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2CalendarApp25, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The follwoing code checks if the calendarLibrary file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/Applications/Calendar/calendarLibrary.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2CalendarApp17, Cannot process the Calendar Library file (calendarLibrary.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/Applications/Calendar/calendarLibrary.php'); }

// / The following code sets the desured GUI for the session.
$guiPOST = htmlentities(str_replace(str_split('~#[](){};:$!#^&%@>*<"\''), '', $_GET['gui']), ENT_QUOTES, 'UTF-8'); 
$GUI = 'month';
if ($guiPOST === 'year') $GUI = 'year';
if ($guiPOST === 'month') $GUI = 'month';
if ($guiPOST === 'week') $GUI = 'week';

// / The following code checks for the existence of a Calendar directory in the users AppData directory.
if (!is_dir($CalendarLogsDir)) {
  $txt = 'OP-Act: Creating a Calendar AppData directory on '.$Time.'.';
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);  
  @mkdir($CalendarLogsDir);
  if (!is_dir($CalendarLogsDir)) {
    $txt = 'ERROR!!! HRC2CalendarApp21, Could not create a Calendar AppData directory on '.$Time.'.';
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  copy ($InstLoc.'/index.html', $CalendarLogsDir.'/index.html');
  if (!file_exists($CalendarCacheFile)) {
    $data = '';
    $MAKECacheFile = file_put_contents($LogFile, $data.PHP_EOL, FILE_APPEND); 
  }
}

include('GUI/'.$GUI.'.php');