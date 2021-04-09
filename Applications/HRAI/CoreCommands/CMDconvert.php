<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
$inputMATCH = array('convert', 'change file');
$CMDcounter++;
$CMDinit[$CMDcounter] = 0;

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
$HRConvert2File = '/var/www/html/HRProprietary/HRConvert2/convertGui1.php';
if (file_exists($HRConvert2File)) { 
  ?>
  <iframe width="500" src="/HRProprietary/HRConvert2/convertCore.php?noGui=TRUE"></iframe>
  <?php } 
if (!file_exists($HRConvert2File)) { ?>
  <p>HRConvert2 was not detected on this server! To convert files with HRAI you must install <a href="https://github.com/zelon88/HRConvert2" target="_blank">HRConvert2</a>.</p>
<?php } }