<?php


function getNode($nodeToTestURL) {
  include '/var/www/html/HRProprietary/HRAI/CallForHelp.php';
  // / Determines if a given URL contains an instance of HRAI. If it does we read and copy it's nodeCache,
  // / and return which nodeNumber we can call it. Also writes new nodeID, status, and identity to our nodeCache.
  $mynodeCache = '/var/www/html/HRProprietary/HRAI/Cache/nodeCache.php';
  $nodeURL1 = $nodeToTestURL;
  $nodeURLCachefile = $nodeURL1.'/HRProprietary/HRAI/Cache/nodeCache.txt';
  $mytmpnodeCache = '/HRProprietary/HRAI/Cache/nodeCacheTMP.php';
  // / Include our nodeCache to get our nodeCount, and increment it for use as our next node. 
  // / If we accidentally return the current node we will de-crement this back to 0 before the
  // / return. That means BOTH returns at the bottom of this function could return 0.
  include_once $mynodeCache;
  $nodeNum = $nodeCount+1;
  // / If the target URL contains a nodeCache, we open it's contents and save them in our own temp location. 
 // / If the target URL contains a temp nodeCache, we copy it.
      $Data = getRemoteData($nodeToTestURL); // / Here we get the contents from the target.
    $tmpnodeCachedat2 = file_put_contents($mytmpnodeCache, $Data); // / Here we put the files in a temp cache.
    // / We need to get the variables from our nodeCache, so we're going to include it now.
    include_once $mytmpnodeCache; // / First we include the temp nodeCache...
        if ($node0ServerID !== $serverID) {  // / If the node we just snooped on is the current node we're going to ignore it.
    // / Now we're going to use our incremented node identifier from earlier to save the stats and identity of our
    // / detected node in our local nodeCache. 
    $nodeCache0 = fopen("$mynodeCache", "a+");    
    $txt = ('$node'.$nodeNum.'ServerID = \''.$node0ServerID.'\'; $node'.$nodeNum.'OnlineStatus = '.$node0OnlineStatus.'; $node'.$nodeNum.'Busy = '.$node0Busy.'; $node'.$nodeNum.'URL = \''.$node0URL.'\'; ');
    $compLogfile = file_put_contents($mynodeCache, $txt.PHP_EOL , FILE_APPEND); }
        if ($node0ServerID == $serverID) { // / If the server we snooped is this server, we drop the nodeCount back to 0.
  $nodeNum = $nodeCount-1;  
      // / If the supplied URL is part of the HRAI network, we return the nodeNumber. If it is not, we return 0.
      return  $nodeNum; }  // / If the target node IS an HRAI server, we detect if it is the current server and return the
                              // / nodeCount instead.
    else {
      return 0; } } // / If the target URL is NOT an HRAI server, return 0.


echo getNode('192.168.1.10');