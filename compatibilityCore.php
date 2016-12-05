<?php

// / The follwoing code checks if the CommonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('ERROR!!! HRC2CompatCore14, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('ERROR!!! HRC2CompatCore22, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

if ($ClearCachePOST == '1' or $ClearCachePOST == 'true') {
  unlink($UserConfig); 
  if (!file_exists($UserConfig)) { 
    copy($LogInstallDir.'.config.php', $UserConfig); }
  if (!file_exists($UserConfig)) { 
    $txt = ('ERROR!!! HRC2CompatCore151, There was a problem creating the user config file on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ('ERROR!!! HRC2CompatCore151, There was a problem creating the user config file on '.$Time.'!'); }
  if (file_exists($UserConfig)) {
    require ($UserConfig); } }

// / The following code is performed whenever a user requests that HRCloud2 Auto-Update to the latest version.
// / Will establish a CuRL connection to Github and download the latest Master commit in .zip form and unpack it
  // / to the $InstLoc. Temporary files will then be deleted.
if ($AutoUpdatePOST == '1' or $AutoUpdatePOST == 'true') {
  set_time_limit(0);

  $ResourceDir = $InstLoc.'/Resources';
  $UpdatedZIPURL = 'https://github.com/zelon88/HRCloud2/archive/master.zip';

  $ch2=curl_init();
  $MAKEUpdatedZIP = fopen($ResourceDir.'/item.zip','w+');
  curl_setopt($ch2, CURLOPT_URL, $UpdatedZIPURL->URL);
  curl_setopt($ch2, CURLOPT_FILE, $MAKEUpdatedZIP );
  curl_setopt($ch2, CURLOPT_TIMEOUT, 5040);
  curl_setopt($ch2, CURLOPT_POST, 1);
  curl_setopt($ch2, CURLOPT_POSTFIELDS,$UpdatedZIPURL->XMLRequest);
  curl_setopt($ch2, CURLOPT_SSLVERSION, 3); 
  curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
  curl_exec($ch2);
  curl_close($ch2);
  fclose($MAKEUpdatedZIP); }