<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="./.favicon.ico">
   <title>HRCLoud2 | Log Viewer</title>
   <link rel="stylesheet" href="./.style.css">
   <script src="./.sorttable.js"></script>
</head>
<?php
// / -----------------------------------------------------------------------------------
// / The follwoing code checks for required core files and terminates if they are missing.
if (!file_exists('../../../../commonCore.php')) {
  echo nl2br('ERROR!!! HRC235, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once ('../../../../commonCore.php'); }
// / -----------------------------------------------------------------------------------
  
// / -----------------------------------------------------------------------------------
// / The following code sets the variables for the session.
$Current_URL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$UserContacts = $InstLoc.'/DATA/'.$UserID.'/.AppData/.contacts.php';
$UserSharedIndex = $URL.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/.AppData/Shared/.index.php';
$UserNotes = $InstLoc.'/DATA/'.$UserID.'/.AppData/.notes.php';
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppData/.config.php';
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code loads the users config.php file.
if (!file_exists($UserConfig)) {
  @chmod($UserConfig, 0755); }
if (!file_exists($UserConfig)) {
  echo nl2br('</head>ERROR!!! HRC2LogsIndex49, User Cache file was not detected on the server!'."\n"); 
  die (); }
else {
    require($UserConfig); } 
// / -----------------------------------------------------------------------------------

// / Color scheme handler.
if ($ColorScheme == '0' or $ColorScheme == '' or !isset($ColorScheme)) {
  $ColorScheme = '1'; }
if ($ColorScheme == '1') {
  echo ('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Applications/displaydirectorycontents_72716/style.css">'); }
if ($ColorScheme == '2') {
  echo ('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Applications/displaydirectorycontents_72716/styleRED.css">'); }
if ($ColorScheme == '3') {
  echo ('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Applications/displaydirectorycontents_72716/styleGREEN.css">'); }
if ($ColorScheme == '4') {
  echo ('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Applications/displaydirectorycontents_72716/styleGREY.css">'); }
if ($ColorScheme == '5') {
  echo ('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Applications/displaydirectorycontents_72716/styleBLACK.css">'); } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will verify the user ID and the directory being accessed before continuing.
if (strpos($Current_URL, $UserID) == 'false') {
  $txt = ('ERROR!!! HRC2LogsIndex74, Could not verify the user '.$UserID.' on '.$Time.'!');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die($txt); }
// / ------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code generates most of the HTML boody for the session.
?>

<body style="font-family:<?php echo $Font; ?>;">
<div align="center" id="container">
<div align="center"><h3>Shared Files</h3></div>
<div align="center" style="margin-bottom:10px;">
<input type='submit' name="back" id="back" value='&#x2190' target="cloudContents" class="submitsmall" onclick="goBack(); toggle_visibility('loadingCommandDiv');"> | 
<input type='submit' name="refresh" id="refresh" value='&#x21BA' class="submitsmall" onclick="toggle_visibility('loadingCommandDiv'); refresh();"></div>
<div align="center" name="unshareButton" id="unshareButton" style="margin-bottom:10px;"><img src="/HRProprietary/HRCloud2/Resources/deletesmall.png" title="Remove Shared File" alt="Remove Shared File" onclick="toggle_visibility('loadingCommandDiv');"></div>
<div align="center" id='loadingCommandDiv' name='loadingCommandDiv' style="float:center; display:none; margin-bottom:10px; max-width:64px; max-height:64px;"><img src='/HRProprietary/HRCloud2/Resources/logosmall.gif'></div>
</div>
<table class="sortable">
  <thead>
	<tr>
	  <th>Filename</th>
	  <th>Type</th>
	  <th>Select</th>
	  <th>Size</th>
	  <th>Date Modified</th>
	</tr>
	  </thead>
	  <tbody>
<?php
	function pretty_filesize($file) {
	  $size=filesize($file);
	  if($size<1024){$size=$size." Bytes";}
	  elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
	  elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
	  else{$size=round($size/1073741824, 1)." GB";}
	  return $size; }

	if($_SERVER['QUERY_STRING']=="hidden") { $hide="";
	 $ahref="./";
	 $atext="Hide";}
	else { $hide=".";
	 $ahref="./?hidden";
	 $atext="Show"; }
	 $myDirectory=opendir($UserSharedDir);
	while ($entryName=readdir($myDirectory)) {
	  $dirArray[]=$entryName; }
	closedir($myDirectory);
	$indexCount=count($dirArray);
	sort($dirArray);
	for ($index = 0; $index < $indexCount; $index++) {
	  if (substr("$dirArray[$index]", 0, 1)!=$hide) {
		$favicon="";
		$class="file";
		$name=$dirArray[$index];
		$path=$UserSharedDir.'/'.$name;
		$modtime=date("M j Y g:i A", filemtime($path));
		$namehref=$UserShared.'/'.$name;
		$timekey=date("YmdHis", filemtime($path));
		if(is_dir($path)) {
		  $extn="&lt;Directory&gt;";
		  $size="&lt;Directory&gt;";
		  $sizekey="0";
		  $class="dir";
		  if(file_exists($namehref."/favicon.ico")) {
		    $favicon=" style='background-image:url($namehref/favicon.ico);'";
		    $extn="&lt;Website&gt;"; }
				if ($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($namehref/.favicon.ico);'";}
				if ($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;"; } }

		  else {
		  $extn=pathinfo($path, PATHINFO_EXTENSION);
		  switch ($extn) {
		    case "txt": $extn="Text File"; 
		    break;
		    default: 
		    if ($extn!="") {
		      $extn=strtoupper($extn)." File"; } 
		    else {$extn="Unknown"; } break; }
		  $size=pretty_filesize($path);
          $sizekey=filesize($path); }

    if (in_array($name, $defaultApps)) continue;

	 echo("<tr class='$class'>
			<td><a href='$namehref'$favicon class='name'>$name</a></td>
			<td><a href='$namehref'>$extn</a></td>
      <td><div><input type='checkbox' name='corePostSelect[]' id='$namehref' value='$name'></div></td>
            <td sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
			<td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td></tr>"); ?>
<?php 
$fileCounter++;
} } ?>
</tbody>
</table>
<script type="text/javascript">
$(document).ready(function () {
$("#unshareButton").click(function(){
var unshareSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
unshareSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: '<?php echo $URL; ?>/HRProprietary/HRCloud2/cloudCore.php',
    data: { unshareConfirm : "1", filesToUnShare : unshareSelected},
    success: function(data) {
        window.location.href = "<?php echo $UserSharedIndex; ?>";
    }
} );
});
});
</script>
</body>
</html>
