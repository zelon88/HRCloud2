<?php
// / -----------------------------------------------------------------------------------
/*//
HRCLOUD2-PLUGIN-START
App Name: PHP-AV
App Version: 3.0 (10-24-2017 00:00)
App License: GPLv3
App Author: FujitsuBoy (aka Keyboard Artist) & zelon88
App Description: A simple HRCloud2 App for scanning files for viruses.
App Integration: 0 (False)
App Permission: 0 (Admin)
HRCLOUD2-PLUGIN-END

Written by FujitsuBoy (aka Keyboard Artist)
Modified by zelon88
//*/
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the memory limit for PHP to unlimited. Memory is controlled later.
ini_set('memory_limit', '-1');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code loads needed HRCloud2 features and functions.
require('/var/www/html/HRProprietary/HRCloud2/config.php');
require('/var/www/html/HRProprietary/HRCloud2/commonCore.php');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if App permission is set to '1' and if the user is an administrator or not.
if ($UserIDRAW !== 1) {
  $txt = ('ERROR!!! HRC2PHPAVApp28, A non-administrator attempted to execute the PHP-AV App on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);  
  die($txt); } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code represents the HTML header.
?>
<html>
<head>
<title>PHP-AV</title>
<link rel="stylesheet" href="style.css">
<div align="center"><h3>PHP-AV</h3><hr /></div>
</head>
<body>
<?php
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the variables for the session.
$versions = 'PHP-AV App v3.0 | Virus Definition v4.5, 10/24/2017';
$memoryLimitPOST = str_replace(str_split('~#[](){};:$!#^&%@>*<"\''), '', $_POST['memoryLimit']);
$chunkSizePOST = str_replace(str_split('~#[](){};:$!#^&%@>*<"\''), '', $_POST['chunkSize']);
$report = '';
$dircount = 0;
$filecount = 0;
$infected = 0;
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user opens the PHP-AV app.
if (!isset($_POST['AVScan'])) { ?>
<script type="text/javascript" src="Resources/common.js"></script>
<div align="center">
<br>
<p style="text-align:left; margin:15px;">PHP-AV is an open-source server-side anti-virus and vulnerability detection tool 
  written in PHP developed by FujitsuBoy (aka Keyboard Artist) and heavily modified by zelon88.</p>
<p style="text-align:left; margin:15px;">This tool will scan for dangerous files, malicious file-contents,  
  active vulnerabilities and potentially dangerous scripts and exploits.</p>
<br>
<button onclick="toggle_visibility('Options');">Options</button>
<form type="multipart/form-data" action="PHP-AV.php" method="POST">
<div name="Options" id="Options" style="display:none;">
<a style="max-width:75%;"><hr /></a>
<p>Specify a server directory/filename: </p><input type="text" name="AVScanTarget" id="AVScanTarget" value="">
<a style="max-width:75%;"><hr /></a>
</div>
<br>
<input type="submit" name="AVScan" id="AVScan" value="Scan Server" onclick="toggle_visibility('loading');"></form>
<div align="center"><img src='Resources/logosmall.gif' id='loading' name='loading' style="display:none; max-width:64px; max-height:64px;"/></div>
</div>
<?php }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects to scan their server with PHP-AV.
if (isset($_POST['AVScan'])) {
  $CONFIG = Array();
  $CONFIG['debug'] = 0;
  $CONFIG['scanpath'] = $_SERVER['DOCUMENT_ROOT'];
  $CONFIG['extensions'] = Array();
  $debug = null;
  include_once('config.php');
  include_once('PHP-AV-Lib.php');
  $defs = load_defs('virus.def', $debug);
  file_scan($CONFIG['scanpath'], $defs, $CONFIG['debug']);
  // / The following code sets user supplied memory variables if they are greater than the ones contained in config.php.
  if ($memoryLimitPOST >= $memoryLimit) {
    $memoryLimit = $memoryLimitPOST; }
  if ($chunkSizePOST >= $chunkSize) {
    $chunkSize = $chunkSizePOST; }
  if (isset($_POST['AVScanTarget'])) {
    $CONFIG['scanpath'] = str_replace(' ', '\ ', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AVScanTarget'])); }
  if (!isset($_POST['AVScanTarget']) or $_POST['AVScanTarget'] == '') {
    $CONFIG['scanpath'] = $_SERVER['DOCUMENT_ROOT']; }
  echo '<h2>Scan Completed</h2>
   <div id=summary>
   <p><strong>Scanned folders:</strong> '.$dircount.'</p>
   <p><strong>Scanned files:</strong> '.$filecount.'</p>
   <p class=r><strong>Infected files:</strong> '.$infected.'</p>
   </div>'.$report; } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code represents the PHP-AV Footer, which displays version information.
?>
<hr />
<p style="text-align:center;">Loaded virus definition: <i><u><a style="color:blue; cursor:pointer;" onclick="window.open('virus.def','resizable,height=400,width=650'); return false;"><?php echo $versions; ?></u></i></p>
</body>
</html>
