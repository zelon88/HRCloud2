<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Grabber
App Version: 1.2 (2-5-2017 12:30)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for grabbing files from URL's.
App Integration: 0 (False)
HRCLOUD2-PLUGIN-END
//*/

// / The following code sanitizes the user input URL. 
if (isset($_POST['grabberURL'])) { 
  $grabberURLPOST = str_replace(str_split('[]{};$!#^&@>*<'), '', $_POST['grabberURL']); }

// / The following code sanitizes the user input filename. 
if (isset($_POST['grabberFilename'])) { 
  $_POST['grabberFilename'] = str_replace('./', '', $_POST['grabberFilename']); 
  $_POST['grabberFilename'] = str_replace('../', '', $_POST['grabberFilename']);
  $_POST['grabberFilename'] = str_replace('..', '', $_POST['grabberFilename']); 
  $GrabberFilenamePOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['grabberFilename']);
  $GrabberFilenamePOST = str_replace('./', '', $GrabberFilenamePOST); 
  $GrabberFilenamePOST = str_replace('../', '', $GrabberFilenamePOST);
  $GrabberFilenamePOST = str_replace('..', '', $GrabberFilenamePOST); }

?>
<script type="text/javascript">
// / Javascript to clear the text input fields onclick.
    function Clear() {    
      document.getElementById("grabberURL").value= ""; }
    function Clear() {    
      document.getElementById("grabberFilename").value= ""; }
    function goBack() {
      window.history.back(); }
</script>
<div id='GrabberAPP' name='GrabberAPP' align='center'><h3>File Grabber</h3><hr />
<form action="Grabber.php" method="post" enctype="multipart/form-data">
<?php 
if (!isset($grabberURLPOST)) { 
  echo ('<p align="left" style="padding-left:15px;"><strong>2. </strong>Enter a URL to download.</p>'); 
?>
<p align="left" style="padding-left:15px;"><input id="grabberURL" name="grabberURL" value="" type="text"></p>
<?php 
  echo ('<p align="left" style="padding-left:15px;"><strong>1. </strong>Enter a Cloud directory/filename for your downloaded file (w/ extension).</p>'); 
  echo('<p align="left" style="padding-left:15px;"><input  id="grabberFilename" name="grabberFilename" value="" type="text"></p>'); 
  echo ('<p align="left" style="padding-left:15px;"><input type="submit" id="grabberSubmit" name="grabberSubmit" title="Grab Files" alt="Grab Files" value="Grab Files"></p><hr />'); } 
?>
</form>
<?php
// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2GrabberApp46, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

if ($UserIDRAW == 0) {
  $txt = ('ERROR!!! HRC2GrabberApp56, A non-logged in user attempted to execute the Grabber App on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die($txt); }

$ERROR = 0;
$YouTubeArr = array('youtube', 'youtu.be', 'googlevideo', 'googleusercontent', 'gstatic');
$DangerArr = array('<script ', '<?', '?>');
$DangerExtArr = array('..', './', '.php', '.html', '.js', '.a');  
$txt = ('OP-Act: Initiating Grabber App on '.$Time.'.');
$MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  
// / The following function was found on 
 // / http://stackoverflow.com/questions/7684771/how-check-if-file-exists-from-the-url
// / It checks if a remote file exists and returns the status. 
function does_url_exist($url) {
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
  $fp = fopen ($filename, 'w+');
  $ch = curl_init(str_replace(" ","%20",$url));
  curl_setopt($ch, CURLOPT_TIMEOUT, 50);
  curl_setopt($ch, CURLOPT_FILE, $fp); 
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_exec($ch); 
  curl_close($ch);
  fclose($fp); }

if (isset($grabberURLPOST)) {
  $GrabberFile = $CloudUsrDir.$GrabberFilenamePOST;  
  $GrabberTmpFile = $CloudTmpDir.$GrabberFilenamePOST;  
  if (strpos('http', $grabberURLPOST) == 'false') {
    $txt = ('ERROR!!! HRC2GrabberApp43, The supplied URL "'.$grabberURLPOST.'" is not valid on '.$Time.'!'); 
    $ERROR = 1;
    echo ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    $txt = ('OP-Act: Scanning URL for file on '.$Time.'.');
    echo ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  if (strpos($grabberURLPOST, 'http') == 'true') {
    foreach($DangerExtArr as $DangerExtArr1) {
      $Ext1Count = count($DangerExtArr1);
      $ExtString = substr($grabberURLPOST, -$Ext1Count);
      if (strpos($ExtString, $DangerExtArr1) == 'true') {
        $txt = ('ERROR!!! HRC2GrabberApp99, The file at the specified URL is an unsupported filetype on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        die($txt); } }
    if (does_url_exist($grabberURLPOST) == 'true') {     // / The following code is performed on normal URL's and files.
      $txt = ('OP-Act: Scan complete! A File exists at '.$grabberURLPOST.' on '.$Time.'.');
      echo ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      if (does_url_exist($grabberURLPOST) == 'true') {
        $GRABData1 = grab_simple_file($grabberURLPOST, $GrabberFile); 
        $GRABData2 = grab_simple_file($grabberURLPOST, $GrabberTmpFile); 
      // / Check the Cloud Location with ClamAV before archiving, just in case.
      if ($VirusScan == '1') {
        shell_exec('clamscan -r '.$GrabberFile.' | grep FOUND >> '.$ClamLogDir); 
        shell_exec('clamscan -r '.$CloudTempDir.' | grep FOUND >> '.$ClamLogDir); 
        if (filesize($ClamLogDir > 10)) {
          echo nl2br('WARNING!!! HRC2GrabberApp124, There were potentially infected files detected. The file
            transfer could not be completed at this time. Please check your file for viruses or
            try again later.'."\n");
            die(); } }
        if (!file_exists($GrabberFile)) {
          $txt = ('ERROR!!! HRC2GrabberApp115, There was a problem creating '.$GrabberFilenamePOST.' on '.$Time.'!'); 
          $ERROR = 1;
          echo ($txt.'<hr />');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
        if (file_exists($GrabberFile)) {
          $txt = ('OP-Act: Created '.$GrabberFilenamePOST.' on '.$Time.'!'); 
          echo ($txt.'<hr />');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }

      if (does_url_exist($grabberURLPOST) == 'false') {
        $txt = ('ERROR!!! HRC2GrabberApp70, The supplied URL contains reference to a file that does not exist on '.$Time.'!');
        $ERROR = 1;
        echo ($txt.'<hr />');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } 
  
  $txt1 = ('<p><form action="'.$URL.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/'.$GrabberFilenamePOST.'"><input type="submit" id="downloadGrabbed" name="downloadGrabbed" value="Download Grabbed File"></form></p>');
  if (!file_exists($GrabberFile) or $ERROR == 1) {
    $txt1 = ''; }
  $txt2 = ('<p><button id="goBack" name="goBack" onclick="goBack();">Go Back</button></p>');
  echo nl2br($txt1.$txt2.'<hr />'); }

?>
</div>