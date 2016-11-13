<?php 

if (!file_exists('config.php')) {
  echo nl2br('ERROR!!! HRC2SC35, Cannot process the HRCloud2 Config file (config.php).'."\n"); 
  die (); }
else {
  require_once ('config.php'); }

chmod($InstLoc, 0755);
chmod($InstLoc.'/Applications', 0755);
chmod($InstLoc.'/Resources', 0755);
chmod($InstLoc.'/DATA', 0755);
chmod($InstLoc.'/Screenshots', 0755);

// / Secutity related processing.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$YUMMYSaltHash = $_POST['YUMMYSaltHash'];
if (!isset($YUMMYSaltHash)) {
  echo nl2br('!!! WARNING !!! HRC2SAVEAppSettings43, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); }
if ($YUMMYSaltHash !== $SaltHash) {
  echo nl2br('!!! WARNING !!! HRC2SAVEAppSettings46, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); }
  ?>