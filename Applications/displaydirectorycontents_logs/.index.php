<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="./.favicon.ico">
   <title>HRCLoud2 | Log Viewer</title>

   <link rel="stylesheet" href="./.style.css">
   <script src="./.sorttable.js"></script>
</head>
<body>
<div id="container">
<div align="center"><h3>HRCloud2 Logs</h3></div>
<?php
// / Tje following code verifies that the HRCloud2 configuration file exists.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/config.php')) {
  echo nl2br('</head>ERROR!!! HRC2SharedIndex19, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require('/var/www/html/HRProprietary/HRCloud2/config.php'); }
$WPFile = '/var/www/html/wp-load.php';
// / Verify that WordPress is installed.
if (!file_exists($WPFile)) {
  echo nl2br('</head>ERROR!!! HRC2SharedIndex27, WordPress was not detected on the server.'."\n"); }
  else {
    require_once($WPFile); } 
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$UserContacts = $InstLoc.'/DATA/'.$UserID.'/.AppData/.contacts.php';
$UserSharedIndex = $URL.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/.AppData/Shared/.index.php';
$UserNotes = $InstLoc.'/DATA/'.$UserID.'/.AppData/.notes.php';
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppData/.config.php';
if (!file_exists($UserConfig)) {
  @chmod($UserConfig, 0755); }
if (!file_exists($UserConfig)) {
  echo nl2br('</head>ERROR!!! HRC2SharedIndex35, User Cache file was not detected on the server!'."\n"); 
  die (); }
else {
    require($UserConfig); } 

if ($ColorScheme == '0' or $ColorScheme == '' or !isset($ColorScheme)) {
  $ColorScheme = '1'; }
if ($ColorScheme == '1') {
  echo ('<link rel="stylesheet" type="text/css" href="/HRProprietary/HRCloud2/Applications/displaydirectorycontents_72716/style.css">'); }
if ($ColorScheme == '2') {
  echo ('<link rel="stylesheet" type="text/css" href="/HRProprietary/HRCloud2/Applications/displaydirectorycontents_72716/styleRED.css">'); }
if ($ColorScheme == '3') {
  echo ('<link rel="stylesheet" type="text/css" href="/HRProprietary/HRCloud2/Applications/displaydirectorycontents_72716/styleGREEN.css">'); }
if ($ColorScheme == '4') {
  echo ('<link rel="stylesheet" type="text/css" href="/HRProprietary/HRCloud2/Applications/displaydirectorycontents_72716/styleGREY.css">'); }
if ($ColorScheme == '5') {
  echo ('<link rel="stylesheet" type="text/css" href="/HRProprietary/HRCloud2/Applications/displaydirectorycontents_72716/styleBLACK.css">'); } 
?>
<table class="sortable">
  <thead>
	<tr>
	  <th>Filename</th>
	  <th>Type</th>
	  <th>Size</th>
	  <th>Date Modified</th>
	</tr>
	  </thead>
	  <tbody>
<?php
	// Adds pretty filesizes
	function pretty_filesize($file) {
	  $size=filesize($file);
	  if($size<1024){$size=$size." Bytes";}
	  elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
	  elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
	  else{$size=round($size/1073741824, 1)." GB";}
	  return $size; }

 	// Checks to see if veiwing hidden files is enabled
	if($_SERVER['QUERY_STRING']=="hidden") { $hide="";
	 $ahref="./";
	 $atext="Hide";}
	else { $hide=".";
	 $ahref="./?hidden";
	 $atext="Show"; }
	 $myDirectory=opendir(".");
	while ($entryName=readdir($myDirectory)) {
	  $dirArray[]=$entryName; }
	closedir($myDirectory);
	$indexCount=count($dirArray);
	sort($dirArray);
	for ($index=0; $index < $indexCount; $index++) {
	  if (substr("$dirArray[$index]", 0, 1)!=$hide) {
		$favicon="";
		$class="file";
		$name=$dirArray[$index];
		$modtime=date("M j Y g:i A", filemtime($dirArray[$index]));
		$namehref=$dirArray[$index];
		$timekey=date("YmdHis", filemtime($dirArray[$index]));
		if(is_dir($dirArray[$index])) {
		  $extn="&lt;Directory&gt;";
		  $size="&lt;Directory&gt;";
		  $sizekey="0";
		  $class="dir";
		  if(file_exists($namehref."/favicon.ico")) {
		    $favicon=" style='background-image:url($namehref/favicon.ico);'";
		    $extn="&lt;Website&gt;"; }
			// Cleans up . and .. directories
				if ($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($namehref/.favicon.ico);'";}
				if ($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;"; } }

	// File-only operations
		  else {
		  // Gets file extension
		  $extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);

			// Prettifies file type
		  switch ($extn) {
		    case "txt": $extn="Text File"; 
		    break;
		    default: 
		  if ($extn!=""){$extn=strtoupper($extn)." File"; } 
		  else {$extn="Unknown"; } break; }

			// Gets and cleans up file size
				$size=pretty_filesize($dirArray[$index]);
				$sizekey=filesize($dirArray[$index]); }

		if ($namehref == 'index.html' or $namehref == 'style.css' or $namehref == 'Notes' or $namehref == 'Contacts' 
			or strpos($namehref, '.css') == 'true' or strpos($namehref, '.html') == 'true' or strpos($namehref, '.css') == 'true' 
			or strpos($namehref, 'Shared') == 'true') continue;
	// Output
	 echo("<tr class='$class'>
			<td><a href='./$namehref/.index.php'$favicon class='name'>$name</a></td>
			<td><a href='./$namehref/.index.php'>$extn</a></td>
			<td sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
			<td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td>
		</tr>"); } }
	?>
	    </tbody>
	</table>

</div>
</body>
</html>
