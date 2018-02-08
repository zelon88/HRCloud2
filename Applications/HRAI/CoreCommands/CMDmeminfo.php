<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
$inputMATCH = array('how much ram', 'how much memory', 'ram usage', 'ram use', 
  'memory use', 'mem use', 'mem info', 'memory info');
$CMDcounter++;

foreach ($inputMATCH as $inputM1) {
  if (preg_match('/'.$inputM1.'/', $input)) {
    $CMDinit[$CMDcounter] = 1;
    $input = preg_replace('/'.$inputM1.'/',' ',$input); } }

$input = str_replace('   ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
$input = ltrim($input);
if ($CMDinit[$CMDcounter] == 1) {

// / --------------------------------------

function getMemInfo() {
  $infoCachefile = '/var/www/html/infoCache.php';
  $memFree = shell_exec("more /proc/meminfo | grep MemFree"); 
  $memTotal = shell_exec("more /proc/meminfo | grep MemTotal"); 
    $infoCachefileO = fopen("$infoCachefile", "a+");
    $txt = ("$memTotal"."\r"."$memFree");
    $compCachefile = file_put_contents($infoCachefile, $txt.PHP_EOL , FILE_APPEND);
    return $txt; }
$GetMemInfo = getMemInfo();
$output = $output.'Memory Information:'."\r".$GetMemInfo."\r";
echo nl2br($output); }