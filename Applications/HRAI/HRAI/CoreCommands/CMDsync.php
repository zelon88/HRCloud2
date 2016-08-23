<?php

  include($nodeCache); 
  $serverStat = getServStat();
  echo nl2br("Yes, Sir! \r");
  echo nl2br("-Sucessfully Reloaded nodeCache! \r");
  echo nl2br('-This serverID & status: '.$serverStat."\r");
  echo nl2br("--------------------------------\r");
  // / Write the nodeCount to the sesLogfile.
  $sesLogfileO = fopen("$sesLogfile", "a+");
  $txt = ('CoreAI: RELOADED nodeCache, nodeCount is '.$nodeCount.' on '.$date.'. ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
  // / Get the status of this server and write it to the sesLogfile.
  $sesLogfileO = fopen("$sesLogfile", "a+");
  $txt = ('CoreAI: Server status is '.$serverStat.' on '.$date.'. ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND);
