<?php 

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