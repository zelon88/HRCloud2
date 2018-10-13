<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
$inputMATCH = array('scan a file', 'scan file', 'virus check', 'malware check', 'av scan', 'antivirus scan', 'scan for', 'file scan');
$CMDcounter++;

if (isset($input)) {
  foreach ($inputMATCH as $inputM1) {
    if (preg_match('/'.$inputM1.'/', $input)) {
      $CMDinit[$CMDcounter] = 1;
      $input = preg_replace('/'.$inputM1.'/',' ',$input); } } }
      
if (!isset($input)) {
  $input = ''; }

$input = str_replace('   ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
$input = ltrim($input);
if ($CMDinit[$CMDcounter] == 1) {

// / --------------------------------------
$HRScan2File = '/var/www/html/HRProprietary/HRScan2/scanGui1.php';
if (file_exists($HRScan2File)) { 
  ?>
  <iframe width="500" src="/HRProprietary/HRScan2/scanCore.php?noGui=TRUE"></iframe>
  <?php } 
if (!file_exists($HRScan2File)) { ?>
  <p>HRScan2 was not detected on this server! To scan files with HRAI you must install <a href="https://github.com/zelon88/HRScan2" target="_blank">HRScan2</a>.</p>
<?php } }