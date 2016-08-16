<?php 

// / HRAI is a very flexible, yet remarkably portable program that could be adjusted to run on many servers and platforms.
// / The network consists of individual servers. Each server should contain an independant set of core files, as well as
// / an independant set of learning configuration files that gives each server a unique identity. Each server should also
// / contain a database of data learned by the network. This should be an official database from an official HRAI repository.
// / This "global database" will be updated during idle server time using data collected from each server. Even without
// / access to the global database HRAI will still function using it's own independant learning configuration files. Whenever
// / a network can be established a new HRAI collective database will be created between the networked HRAI, combining the
// / individual databases from each server into a common one. Whenever a link to an official HRAI repository is established
// / any individual or common learned databases will be uploaded and integrated. The integration will be incorporated into
// / the next official global database and distributed as such. 

// / In addition to being able to operate independantly, HRAI servers can help other servers in their vicinity if a common 
// / database between the servers exists. When operating in this way, each HRAI server becomes known as a "node". Each node
// / is capable of receiving $_POST data as variables from another servers thought process and complete it using the common 
// / databases. 

// / In this script we declare that the server is part of the HRAI network, and try to detect other HRAI servers on the same
// / network. This script also detects the prescence of any local learning files, common databases, and global databases. 
// / The script also attempts to identify the capability for an HRAI network on it's locak network. 

// / Eventually if one can be created it will be. If a network already exists we will join it. We will also attempt to 
// / establish a connection to the official HRAI repository, and determine if it's time to update our global database and 
// / source code.

  
function remoteFileExists($path) {
   // / Use this to determine if a remote URL contains a file.
   return (@fopen($path,"r")==true); }

function getServMemUse() {
      // / Returns human readable memory usage in Kb, Mb, or Gb respective
      // / to the amount of RAM being used.
        $mem_usage = memory_get_usage(true); 
        
        if ($mem_usage < 1024) {
            $mem = $mem_usage." bytes"; }
        elseif ($mem_usage < 1048576) {
            $mem =  round($mem_usage/1024,2)." kilobytes"; }
        else {
            $mem = round($mem_usage/1048576,2)." megabytes"; }
        return ($mem."\r"); }

function getServPageUse() {
    // / Returns human readable memory usage in Kb, Mb, or Gb respective
    // / to the amount of RAM being used.
        $mem_usage = (memory_get_usage(true) - memory_get_usage(true)); 
        if ($mem_usage < 1024) {
            $mem = $mem_usage." bytes"; }
        elseif ($mem_usage < 1048576) {
            $mem =  round($mem_usage/1024,2)." kilobytes"; }
        else {
            $mem = round($mem_usage/1048576,2)." megabytes"; }
        return ($mem."\r"); }

function getServCPUUseNow() {
	// / Returns current CPU Usage.
    $load = sys_getloadavg();
    return $load[1]; }

function getServCPUUseAvg1() {
	// / Returns average CPU Usage from last 60 seconds.
    $load = sys_getloadavg();
    return $load[60]; }

function getServCPUUseAvg5() {
	// / Returns average CPU usage from the last 5 minutes.
    $load = sys_getloadavg();
    return $load[300]; }

function getServCPUUseAvg10() {
	// / Returns average CPU usage from the last 10 minutes.
    $load = sys_getloadavg();
    return $load[600]; }


function getServUptime() {
	// / Returns custom CPU usage from post data.
	exec("uptime", $system); // get the uptime stats 
	$string = $system[0]; // this might not be necessary 
	$uptime = explode(" ", $string); // break up the stats into an array 
	$up_days = $uptime[4]; // grab the days from the array 
	$hours = explode(":", $uptime[7]); // split up the hour:min in the stats 
	$up_hours = $hours[0]; // grab the hours 
	$mins = $hours[1]; // get the mins 
	$up_mins = str_replace(",", "", $mins); // strip the comma from the mins 
    return ("echo $up_days;".', '."echo $up_hours;".', '."echo $up_mins;"); }

function getServBusy() {
  // / Determine if the server is busy by looking at average CPU usage.
  $cpuUse = getServCPUUseNow();
  if ($cpuUse > ('1.2')) {
  $busy = '1'; }  
  else {
  $busy = '0'; }
return $busy; }

function getServIdent(){
    // / SECRET: This is where we define the $serverID for this node.
    // / Get serverID and $onlineStatus. 
    require('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CallForHelp.php');
    return $serverID; }

function getServStat() {
	// / Output is the a complex identifier for the server ID, online status, and resource usage. 
	// / We can call this from other servers to determine if a particular server is worthy of use	// /within a cluster as a node.
	$serverID = getServIdent();
    $onlineStatus = '1';
    $busy = getServBusy(); 
    // /Output looks like 1 1 0 for an online machine with server ID 1 connected to a network and idle.
    // /Output looks like 232 1 1 for an online machine with server ID 232 connected to a network and busy.
    // /Output looks like 5599 0 1 for an offline machine with server ID 5599 not connected to a network and busy.
    return ($serverID.', '.$onlineStatus.', '.$busy); }

function getNetStat() {
	// / See which local servers are online and worthy of being used as nodes.
if (file_exists('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/core.php')) {
  include ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/adminINFO.php');
    $node0URL = $nodeURL;
    $node0Stat = getServStat();
    $node0ServerID = getServIdent();
    $node0OnlineStatus = 1;
    $node0Busy = getServBusy(); 
    $nodeCache = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/Cache/nodeCache.php';
    require ($nodeCache);
    if (getServStat() == $node0ServerID.'1'.'0') {
      $node0 = '1'; } 
    elseif (getServStat() !== $node0ServerID.'1'.'1') {
      $node0 = '0'; } 

    $nodeCache0 = fopen("$nodeCache", "a+");    
    $txt = ('$node0ServerID = \''.$node0ServerID.'\'; $node0OnlineStatus = '.$node0OnlineStatus.'; $node0Busy = '.$node0Busy.'; $node0URL = \''.$node0URL.'\'; ');
    $compLogfile = file_put_contents($nodeCache, $txt.PHP_EOL , FILE_APPEND); } 
    // / Count the number of active nodes and total it up. Use this to determine if the server is alone on a network. 
	$nodeCount = $node0OnlineStatus+$node1OnlineStatus+$node2OnlineStatus+$node3OnlineStatus+$node4OnlineStatus+$node5OnlineStatus+
                 $node6OnlineStatus+$node7OnlineStatus+$node8OnlineStatus+$node9OnlineStatus;
  $nodeCache0 = fopen("$nodeCache", "a+");
  $txt = ('$nodeCount = '.$nodeCount.'; ');
  $compLogfile = file_put_contents($nodeCache, $txt.PHP_EOL , FILE_APPEND); 
	if ($nodeCount <= 1){
	  $alone = 1;
	  return $nodeCount; }
	elseif ($nodeCount > 1){
      $alone = 0;
  	  return $nodeCount;} } 

function tailFile($filepath, $lines = 2) {
  // / Use this when reading files to only read the last several lines.
  $txt = trim(implode("", array_slice(file($filepath), -$lines))); 
   return $txt; }

function getRemoteData($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data; }

function getNode($nodeToTestURL) {
  include '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CallForHelp.php';
  // / Determines if a given URL contains an instance of HRAI. If it does we read and copy it's nodeCache,
  // / and return which nodeNumber we can call it. Also writes new nodeID, status, and identity to our nodeCache.
  $mynodeCache = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/Cache/nodeCache.php';
  $nodeURL1 = $nodeToTestURL;
  $nodeURLCachefile = $nodeURL1.'/HRProprietary/HRCloud2/Applications/HRAI/Cache/nodeCache.txt';
  $mytmpnodeCache = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/Cache/nodeCacheTMP.txt';
  $mytmpnodeCachephp = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/Cache/nodeCacheTMP.php';
  // / Include our nodeCache to get our nodeCount, and increment it for use as our next node. 
  // / If we accidentally return the current node we will de-crement this back to 0 before the
  // / return. That means BOTH returns at the bottom of this function could return 0.
  include_once ($mynodeCache);
  $nodeNum = $nodeCount+1;
  // / If the target URL contains a nodeCache, we open it's contents and save them in our own temp location. 
    $TMPnodeCache0 = fopen("$mytmpnodeCache", "w"); 
    $Data = getRemoteData($nodeURLCachefile); // / Here we get the contents from the target.
    $Data = preg_replace('/\<\?php/', ' ', $Data);
    $tmpnodeCachedat2 = file_put_contents("$mytmpnodeCachephp", $Data.PHP_EOL , FILE_APPEND); // / Here we put the files in a temp cache.
    // / We need to get the variables from our nodeCache, so we're going to include it now.
    include_once '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/Cache/nodeCacheTMP.php'; // / First we include the temp nodeCache...
    // / Now we're going to use our incremented node identifier from earlier to save the stats and identity of our
    // / detected node in our local nodeCache. 
      include_once '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/adminINFO.php';
      $newNodeServerID = "$node0ServerID";
      if ("$newNodeServerID" !== $serverID) { // / If the server we snooped is this server, we drop the nodeCount back to 0.
        if (!empty($node0ServerID)) {
    $nodeCache0 = fopen("$mynodeCache", "a+");    
    $txt = ('$node'.$nodeNum.'ServerID = \''.$node0ServerID.'\'; $node'.$nodeNum.'OnlineStatus = '.$node0OnlineStatus.'; $node'.$nodeNum.'Busy = '.$node0Busy.'; $node'.$nodeNum.'URL = \''.$node0URL.'\'; ');
    $compLogfile = file_put_contents("$mynodeCache", $txt.PHP_EOL , FILE_APPEND);  
      // / If the supplied URL is part of the HRAI network, we return the nodeNumber. If it is not, we return 0.
      return ('1'."$newNodeServerID"); } }  // / If the target node IS an HRAI server, we detect if it is the current server and return the
                              // / nodeCount instead.
    else {
      return 0; } } // / If the target URL is NOT an HRAI server, return 0.




