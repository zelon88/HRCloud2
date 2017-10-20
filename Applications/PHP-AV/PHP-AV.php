<?php
// / -----------------------------------------------------------------------------------
/*//
HRCLOUD2-PLUGIN-START
App Name: PHP-AV
App Version: 2.9 (10-20-2017 22:30)
App License: GPLv3
App Author: FujitsuBoy (aka Keyboard Artist) & zelon88
App Description: A simple HRCloud2 App for scanning files for viruses.
App Integration: 0 (False)
App Permission: 0 (Admin)
HRCLOUD2-PLUGIN-END

Written by FujitsuBoy (aka Keyboard Artist)
Modified by zelon88
//*/
$versions = 'PHP-AV App v2.8 | Virus Definition v4.2, 10/17/2017';
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code represents the Javascript required for PHP-AV to function.
?>
<script type="text/javascript">
    function Clear() {    
      document.getElementById("AVScanTarget").value= ""; }
    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if(e.style.display == 'block')
         e.style.display = 'none';
      else
         e.style.display = 'block'; }
    function goBack() {
      window.history.back(); }
    </script>
<div align="center"><h3>PHP-AV</h3><hr /></div>
<?php
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
// / The following code is performed when a user selects to scan their server with PHP-AV.
if (!isset($_POST['AVScan'])) { ?>
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
if (isset($_POST['AVScan'])) {
  $CONFIG = Array();
  $CONFIG['debug'] = 0;
  $CONFIG['scanpath'] = $_SERVER['DOCUMENT_ROOT'];
  $CONFIG['extensions'] = Array();
  $debug = null;
  include('config.php');
  if (isset($_POST['AVScanTarget'])) {
    $CONFIG['scanpath'] = str_replace(' ', '\ ', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AVScanTarget'])); }
  if (!isset($_POST['AVScanTarget']) or $_POST['AVScanTarget'] == '') {
    $CONFIG['scanpath'] = $_SERVER['DOCUMENT_ROOT']; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Functions
function file_scan($folder, $defs, $debug) {
  // Hunts files/folders recursively for scannable items.
  $defData = hash_file('sha256', 'virus.def');
  global $dircount, $report, $memoryLimit;
  $dircount++;
  if ($debug)
    $report .= '<p class="d">Scanning folder $folder ...</p>';
    if ($d = @dir($folder)) {
      while (false !== ($entry = $d->read())) {
        $isdir = @is_dir($folder.'/'.$entry);
        if (!$isdir and $entry!='.' and $entry!='..') {
          virus_check($folder.'/'.$entry, $defs, $debug, $defData); } 
        elseif ($isdir  and $entry !='.' and $entry!='..') {
          file_scan($folder.'/'.$entry, $defs, $debug, $defData); } }
      $d->close(); } }

function load_defs($file, $debug) {
  // Reads tab-delimited defs file.
  $defs = file($file);
  $counter = 0;
  $counttop = sizeof($defs);
  while ($counter < $counttop) {
	$defs[$counter] = explode('	', $defs[$counter]);
	$counter++; }
if ($debug)
  echo '<p>Loaded ' . sizeof($defs) . ' virus definitions</p>';
  return $defs; }

function check_defs($file) {
  // Check for >755 perms on virus defs.
  clearstatcache();
  $perms = substr(decoct(fileperms($file)),-2);
  if ($perms > 55)
	return false;
  else
	return true; }

function virus_check($file, $defs, $debug, $defData) {
  // Hashes and checks files/folders for viruses against static virus defs.
  global $memoryLimit, $chunkSize, $filecount, $infected, $report, $CONFIG;
	$filecount++;
	if ($file !== $InstLoc.'/Applications/PHP-AV/virus.def') {
	  if (file_exists($file)) { 
	  	$filesize = filesize($file);
      // / Scan files larger than the memory limit by breaking them into chunks.
      if ($filesize >= $memoryLimit && file_exists($file)) {
        $handle = @fopen($file, "r");
          if ($handle) {
            while (($buffer = fgets($handle, $chunkSize)) !== false) {
              $data = $buffer;
              foreach ($defs as $virus) {
                if ($virus[1] !== '') {
                  if (strpos($data, $virus[1]) or strpos($file, $virus[1])) {
                   // File matches virus defs.
                   $report .= '<p class="r">Infected: ' . $file . ' (' . $virus[0] . ')</p>';
                   $infected++;
                   $clean = 0; } } } }
            if (!feof($handle)) {
              echo 'ERROR!!! PHPAV160, Unable to open '.$file.' on '.$Time.'.'.\n; }
          fclose($handle); } 
          if ($virus[2] !== '') {
            if (strpos($data1, $virus[2])) {
                // File matches virus defs.
              $report .= '<p class="r">Infected: ' . $file . ' (' . $virus[0] . ')</p>';
              $infected++;
              $clean = 0; } }
           if ($virus[3] !== '') {
            if (strpos($data2, $virus[3])) {
                // File matches virus defs.
              $report .= '<p class="r">Infected: ' . $file . ' (' . $virus[0] . ')</p>';
              $infected++;
               $clean = 0; } } } } }
      // / Scan files smaller than the memory limit by fitting the entire file into memory.
      if ($filesize < $memoryLimit && file_exists($file)) {
        $data = file($file);
	      $data = implode('\r\n', $data); }
	    if (file_exists($file)) {
        $data1 = md5_file($file);
	      $data2 = hash_file('sha256', $file); }
      if (!file_exists($file)) {
        $data1 = '';
        $data2 = ''; }
      if ($defData !== $data2) {
	       $clean = 1;
	      foreach ($defs as $virus) {
	        $filesize = @filesize($file);
		      if ($virus[1] !== '') {
		        if (strpos($data, $virus[1])) {
			       // File matches virus defs.
			       $report .= '<p class="r">Infected: ' . $file . ' (' . $virus[0] . ')</p>';
			       $infected++;
			       $clean = 0; } }
		      if ($virus[2] !== '') {
            if (strpos($data1, $virus[2])) {
			          // File matches virus defs.
			        $report .= '<p class="r">Infected: ' . $file . ' (' . $virus[0] . ')</p>';
			        $infected++;
			        $clean = 0; } }
		       if ($virus[3] !== '') {
            if (strpos($data2, $virus[3])) {
			          // File matches virus defs.
			        $report .= '<p class="r">Infected: ' . $file . ' (' . $virus[0] . ')</p>';
			        $infected++;
			         $clean = 0; } } }
	       if (($debug)&&($clean)) {
		      $report .= '<p class="g">Clean: ' . $file . '</p>'; } } } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The fopllowing code displays the PHP-AV results page after a scan has completed.
function renderhead() {
?>
<html>
<head>
<title>Virus scan</title>
<style type="text/css">
h1 {
	font-family: arial; }
p {
	font-family: arial;
	padding: 0;
	margin: 0;
	font-size: 10px; }
.g {
	color: #009900; }
.r {
	color: #990000;
	font-weight: bold; }
.d {
	color: #ccc; }
#summary {
	border: #333 solid 1px;
	background: #f0efca;
	padding: 10px;
	margin: 10px; }
#summary p {
	font-size: 12px; }
</style>
</head>
<body>
<?php }
// Declare variables.
$report = '';
// Output html headers.
renderhead();
// Set counters.
$dircount = 0;
$filecount = 0;
$infected = 0;
// Load virus defs from flat file.
$defs = load_defs('virus.def', $debug);
// Scan specified root for specified defs.
file_scan($CONFIG['scanpath'], $defs, $CONFIG['debug']);
// Output summary
echo '<h2>Scan Completed</h2>';
echo '<div id=summary>';
echo '<p><strong>Scanned folders:</strong> ' . $dircount . '</p>';
echo '<p><strong>Scanned files:</strong> ' . $filecount . '</p>';
echo '<p class=r><strong>Infected files:</strong> ' . $infected . '</p>';
echo '</div>';
// Output full report.
echo $report; } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code represents the PHP-AV Footer, which displays version information.
?>
<hr />
<p style="text-align:center;">Loaded virus definition: <i><u><a style="color:blue; cursor:pointer;" onclick="window.open('virus.def','resizable,height=400,width=650'); return false;"><?php echo $versions; ?></u></i></p>
</body>
</html>