<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
$inputMATCH = array('sync node', 'node sync', 'whats your serverid', 'what is your serverid', 
  'refresh node', 'update node', 'syncnode', 'sync your node', 'nodesync', 'reloadnode', 'reload node', 'reload your node',
  'refreshnode', 'refreshyournode', 'refresh your node', 'reload the node', 'refresh the node', 'get node');

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

include($nodeCache); 
$serverStat = getServStat();
$output = "Yes, Sir! \r"."Sucessfully Reloaded nodeCache! \r".'This serverID & status: '.$serverStat."\r";
echo nl2br($output);

// / Write the nodeCount to the sesLogfile.
$txt = ('CoreAI: RELOADED nodeCache, nodeCount is '.$nodeCount.' on '.$date.'. ');
$compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
// / Get the status of this server and write it to the sesLogfile.
$txt = ('CoreAI: Server status is '.$serverStat.' on '.$date.'. ');
$compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }
