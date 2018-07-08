<?php
$HRAI_VERSION = 'v5.8';
$InstLoc = '/var/www/html/HRProprietary/HRCloud2';
$HRAIMiniGUIFile = $InstLoc.'/Applications/HRAIMiniGui.php';
$HRC2SecurityCoreFile = $InstLoc.'/securityCore.php';
$HRC2CommonCoreFile = $InstLoc.'/commonCore.php';
$coreVarfile = $InstLoc.'/Applications/HRAI/coreVar.php';
$coreFuncfile = $InstLoc.'/Applications/HRAI/coreFunc.php';
$adminInfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/adminINFO.php';
$CMDFilesDir1 = scandir($InstLoc.'/Applications/HRAI/CoreCommands');
$CMDcounter = 0;
$newlineArr = array("\n", "\r\n", "\r");
$date = date("F j, Y, g:i a");
$day = date("d");
$hour = date("g:i a");
$output = '';
$HRAIAmplitude = '100';
$HRAIWordgap = '50';  
$HRAISpeed = '175';
$HRAIPitch = '0';
$HRAIVoiceType = '';
// / $CallForHelp   0 = Automatically call for help.  1 = Don't automatically call for help.
$CallForHelp = 0;
// / $getServBusy automatically assumes that the server is idle. This avoids a potential loop in core.php
// / where the server could potentially keep calling for help. For good measure, always match this var with
// / $CallForHelp, just-in-case. 
$getServBusy = 0;




// / Everything and anything below this line is machine created code.