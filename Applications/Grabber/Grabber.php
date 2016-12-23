<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Calculator
App Version: 1.3 (12-20-2016 11:45-)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for doing math.
App Integration: 0 (False)
HRCLOUD2-PLUGIN-END
//*/
if (isset($_POST['grabberURL'])) { 
  $grabberURLPOST = str_replace(str_split('[]{};$!#^&@>*<'), '', $_POST['grabberURL']); }

if (isset($_POST['grabberFilename'])) { 
  $GrabberFilenamePOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['grabberFilename']); }

$YouTubeArr = array('youtube', 'youtu.be', 'googlevideo', 'googleusercontent', 'gstatic');
$DangerArr = array('<script ', '<?', '?>');  
?>
<script src="sorttable.js"></script>
<script type="text/javascript">
// / Javascript to clear the newNote text input field onclick.
    function Clear() {    
      document.getElementById("grabberURL").value= ""; }
    function Clear() {    
      document.getElementById("grabberFilename").value= ""; }
</script>
<div id='GrabberAPP' name='GrabberAPP' align='center'><h3>File Grabber</h3><hr />
<form action="Grabber.php" method="post">
<?php 
if (!isset($grabberURLPOST)) { 
  echo ('<p align="left" style="padding-left:15px;"><strong>2. </strong>Enter a URL to download.</p>'); 
?>
<p align="left" style="padding-left:15px;"><input id="grabberURL" name="grabberURL" value="" type="text"></p>
<?php 
  echo ('<p align="left" style="padding-left:15px;"><strong>1. </strong>Enter a Cloud directory/filename for your downloaded file (w/ extension).</p>'); 
  echo('<p align="left" style="padding-left:15px;"><input  id="grabberFilename" name="grabberFilename" value="" type="text"></p>'); 
  echo ('<p align="left" style="padding-left:15px;"><input type="submit" id="grabberSubmit" name="grabberSubmit" title="Grab Files" alt="Grab Files" value="Grab Files"></p>'); } 
?>
</form>
<hr />
<?php
// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2GrabberApp46, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

$GrabberFile = $CloudUsrDir.$GrabberFilenamePOST;

// / The following function was found on 
 // / http://stackoverflow.com/questions/7684771/how-check-if-file-exists-from-the-url
// / It checks if a remote file exists and returns the status. 
function does_url_exist($url){
  $ch = curl_init($url);    
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_exec($ch);
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  if ($code == 200){
    $stat = 'true'; } 
  else {
    $stat = 'false'; }
  curl_close($ch);
  return $stat; }

function grab_simple_file($url, $filename) {
  set_time_limit(0);
  $fp = fopen (dirname(__FILE__) . $GrabberFile, 'w+');
  $ch = curl_init(str_replace(" ","%20",$url));
  curl_setopt($ch, CURLOPT_TIMEOUT, 50);
  curl_setopt($ch, CURLOPT_FILE, $fp); 
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_exec($ch); 
  curl_close($ch);
  fclose($fp); }

if (isset($_POST['grabberURL'])) {
  if (strpos($grabberURLPOST, 'http') == 'false') {
    $txt = ('ERROR!!! HRC2GrabberApp43, The supplied URL "'.$grabberURLPOST.'" is not valid on '.$Time.'!'); 
    echo ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if (strpos($grabberURLPOST, 'http') == 'true') {
    // / The following code is performed on videos or files obfuscated by HTML..
    foreach ($YouTubeArr as $YouTubeArr1) {
      if (strpos($grabberURLPOST, $YouTubeArr1) == 'true') {
        $txt = ('ERROR!!! HRC2GrabberApp96, Grabber currently does not support embedded files on '.$Time.'!');
        echo ($txt.'<hr />');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        die();
        $Continue = '1'; }

      if ($Contiue = '1') {
        if (does_url_exist($grabberURLPOST) == 'true') { } }

    // / The following code is performed on normal URL's and files.
    if (strpos($grabberURLPOST, $YouTubeArr1) == 'false') {
      $txt = ('OP-Act: Scanning URL with simple method for file on '.$Time.'.');
      echo ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      if (does_url_exist($grabberURLPOST) == 'true') {
        $GRABData = grab_simple_file($grabberURLPOST, $GrabberFilenamePOST); 
        if (!file_exists($GrabberFile)) {
          $txt = ('ERROR!!! HRC2GrabberApp115, There was a problem creating '.$GrabberFilenamePOST.' on '.$Time.'!'); 
          echo ($txt.'<hr />');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
        if (file_exists($GrabberFile)) {
          $txt = ('OP-Act: Created '.$GrabberFilenamePOST.' on '.$Time.'!'); 
          echo ($txt.'<hr />');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }

      }

      if (does_url_exist($grabberURLPOST) == 'false') {
        $txt = ('ERROR!!! HRC2GrabberApp70, The supplied URL contains reference to a file that does not exist on '.$Time.'!');
        echo ($txt.'<hr />');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }


?>
</div>
