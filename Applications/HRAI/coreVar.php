<?php
// / This file contains the variables required to run core.php. These may be useful if they are required 
// / elsewhere, or if there is a problem and we would have undefined variables. Anything that would otherwise
// / be calculated by core.php or another required or included script will have an optimized default set here.
// / In the event of a missing var elsewhere in HRAI, these defaults should do the trick. For example, in a 
// / default situation where the core.php could not access it's own vars, the $CallForHelp variable here is
// / automatically set to 0, which will find us another available node to offload this servers workload. 
// /
// / We will include all our vars, but barely any includes or requires. There are no functions and barely
// / any logic in this script. 
// /
// / In order to correctly create and log sessions, and to provide learning based on userID we need to validate
// / WordPress. This simple logic will determine if the server runs WordPress, and will get some special vars if
// / it does. If it does not, we will define these vars with constants, just-in-case.

$langParserfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/langPar.php';
$onlineFile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/online.php';
$coreVarfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreVar.php';
$coreFuncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreFunc.php';
$coreArrfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreArr.php';
$nodeCache = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/Cache/nodeCache.php';
$wpfile = '/var/www/html/wp-load.php';
$date = date("F j, Y, g:i a");
$day = date("d");
include_once $onlineFile;
$nodeCount = getNetStat();
// / $CallForHelp   0 = Automatically call for help.  1 = Don't automatically call for help.
$CallForHelp = 0;
// / $getServBusy automatically assumes that the server is idle. This avoids a potential loop in core.php
// / where the server could potentially keep calling for help. For good measure, always match this var with
// / $CallForHelp, just-in-case. 
$getServBusy = 0;









// / Everything and anything below this line is machine created code.