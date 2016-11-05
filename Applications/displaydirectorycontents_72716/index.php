<!doctype html>
<html>
<head>
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
function goBack() {
  window.history.back(); }
setTimeout(function(){
</script>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>Cloud Contents</title>
<?php
  $PLMediaArr =  array('mp2', 'mp3', 'wma', 'wav', 'aac', 'flac', 'ogg', 'avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');
  $archArr = array('rar', 'tar', 'tar.bz', '7z', 'zip', 'tar.gz', 'tar.bz2', 'tgz');
  $pdfWordArr = array('pdf', 'doc', 'docx', 'txt', 'rtf', 'odf', 'pages', 'jpg', 'jpeg', 'png', 'bmp', 'gif');
  $convertArr = array('pdf', 'doc', 'docx', 'txt', 'rtf', 'odf', 'pages', 'jpg', 'jpeg', 'png', 'bmp', 'gif', 'mp2', 'mp3', 'wma', 'wav', 'aac', 'flac', 'ogg', 'avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');
  $pdfWordArr = array('pdf', 'jpg', 'jpeg', 'png', 'bmp', 'gif');
  $imgArr = array('jpg', 'jpeg', 'png', 'bmp', 'gif');
if (!file_exists('config.php')) {
  echo nl2br('</head>ERROR!!! HRC2Index19, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require('config.php'); }
$WPFile = '/var/www/html/wp-load.php';
// / Verify that WordPress is installed.
if (!file_exists($WPFile)) {
  echo nl2br('</head>ERROR!!! HRC2Index27, WordPress was not detected on the server.'."\n"); }
  else {
    require($WPFile); } 
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$UserContacts = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.contacts.php';
$UserNotes = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.notes.php';
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.config.php';
if (!file_exists($UserConfig)) {
  echo nl2br('</head>ERROR!!! HRC2Index35, User Cache file was not detected on the server!'."\n"); 
  die (); }
else {
    require($UserConfig); } 
if ($ColorScheme == '0' or $ColorScheme == '' or !isset($ColorScheme)) {
  $ColorScheme = '1'; }
if ($ColorScheme == '1') {
  echo ('<link rel="stylesheet" type="text/css" href="Applications/displaydirectorycontents_72716/style.css">'); }
if ($ColorScheme == '2') {
  echo ('<link rel="stylesheet" type="text/css" href="Applications/displaydirectorycontents_72716/styleRED.css">'); }
if ($ColorScheme == '3') {
  echo ('<link rel="stylesheet" type="text/css" href="Applications/displaydirectorycontents_72716/styleGREEN.css">'); }
if ($ColorScheme == '4') {
  echo ('<link rel="stylesheet" type="text/css" href="Applications/displaydirectorycontents_72716/styleGREY.css">'); }
if ($ColorScheme == '5') {
  echo ('<link rel="stylesheet" type="text/css" href="Applications/displaydirectorycontents_72716/styleBLACK.css">'); } 
?>
    <script type="text/javascript" src="<?php echo $URL; ?>/HRProprietary/HRCloud2/Applications/jquery-3.1.0.min.js"></script>
    <script src="Applications/displaydirectorycontents_72716/sorttable.js"></script>
    <script type="text/javascript">
    function Clear() {    
      document.getElementById("search").value= ""; }
    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if(e.style.display == 'block')
         e.style.display = 'none';
      else
         e.style.display = 'block'; }
    function goBack() {
      window.history.back(); }
$(document).ready(function () {
$("#makedir").click(function(){
var Selected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
Selected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { UserDir : $("#dirToMake").val()},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
</head>
<body>
<div id="container">
  <table class="sortable">
      <thead>
    <tr>
      <th>Filename</th>
      <th>Select</th>
      <th>Type</th>
      <th>Size</th>
      <th>Date Modified</th>
    </tr>
      </thead>
      <tbody><?php
$tableCount = 0;
if (isset($_POST['UserDir'])) {
  ?><div align='center'><h3><?php
  echo$_POST['UserDir']; 
  ?></h3></div><?php
  $Udir = $_POST['UserDir'].'/'; }
if (!isset($_POST['UserDir'])) {
  $Udir = ''; }
  // Adds pretty filesizes
  function pretty_filesize($file) {
    $size=filesize($file);
    if($size<1024){$size=$size." Bytes";}
    elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
    elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
    else{$size=round($size/1073741824, 1)." GB";}
    return $size;
  }
  // Checks to see if veiwing hidden files is enabled
  if($_SERVER['QUERY_STRING']=="hidden")
  {$hide="";
   $ahref="./";
   $atext="Hide";}
  else
  {$hide=".";
   $ahref="./?hidden";
   $atext="Show";}
$fileArray1 = array();
$ArchInc = 0;
while (file_exists($CloudUsrDir.$UserDirPOST.'Archive'.'_'.$Date.'_'.$ArchInc)) {
  $ArchInc++; }
?>
<div align="center">
<form><div style="margin-bottom:10px;"><input type='submit' name="back" id="back" value='&#x2190;' href="#" class="submitsmall" target="cloudContents" onclick="goBack(); toggle_visibility('loadingCommandDiv');"> | 
<input type='submit' name="refresh" id="refresh" value='&#x21BA' href="#" class="submitsmall" onclick="toggle_visibility('loadingCommandDiv');"></form> | 
<a><input type='submit' name="new" id="new" value='+' class="submitsmall" onclick="toggle_visibility('newOptionsDiv');" onclick="toggle_visibility('newFolder'); toggle_visibility('newFile');"></div>
<img id='copyButton' name='copyButton' title="Copy" alt="Copy" onclick="toggle_visibility('copyOptionsDiv');" src='Resources/copy.png'/> | <img id='renameButton' name='renameButton' title="Rename" alt="Rename" onclick="toggle_visibility('renameOptionsDiv');" src='Resources/rename.png'/> | <img id='deleteButton' name='deleteButton' title="Delete" alt="Delete" onclick="toggle_visibility('deleteOptionsDiv');" src='Resources/deletesmall.png'/> | <img id='archive' name='archive' title="Archive" alt="Archive" onclick="toggle_visibility('archiveOptionsDiv');" src='Resources/archiveFile.png'/> | 
<img id='dearchive' name='dearchive' title="Dearchive" alt="Dearchive" onclick="toggle_visibility('loadingCommandDiv');" src='Resources/dearchive.png'/> | <img id="convertButton" name="convertButton" title="Convert" alt="Convert" onclick="toggle_visibility('convertOptionsDiv');" src='Resources/convert.png'/> | 
<img id="imgeditButton" name="imgeditButtin" title="Image / Photo Editing Tools" alt="Image / Photo Editing Tools" onclick="toggle_visibility('photoOptionsDiv');" src='Resources/photoedit.png'/> | <img id="pdfworkButton" name="pdfworkButton" title="OCR (Optical Character Recognition) Tools" alt="OCR (Optical Character Recognition) Tools" onclick="toggle_visibility('PDFOptionsDiv');" src='Resources/makepdf.png'/> | <img id="streamButton" name="streamButton" title="Create Playlist" alt="Create Playlist" onclick="toggle_visibility('StreamOptionsDiv');" src='Resources/stream.png'/> | 
<img id='searchButton' name="searchButton" title="Search "alt="Search" onclick="toggle_visibility('SearchOptionsDiv');" src='Resources/searchsmall.png'/></a>
<div align="center" id='newOptionsDiv' name='newOptionsDiv' style="display:none;">
<a><input type='submit' name="newFolder" id="newFolder" value='New Folder' style="dispaly:none;" onclick="toggle_visibility('makedir'); toggle_visibility('dirToMake');">
  <input type='submit' name="newFile" id="newFile" value='New File' style="dispaly:none;" onclick="toggle_visibility('upload'); toggle_visibility('filesToUpload');"></form></a></div>
<form action="cloudCore.php" method="post" enctype="multipart/form-data">
<div align="center">
<input type="text" name="dirToMake" id="dirToMake" style="display:none;">
<input type='submit' name="makedir" id="makedir" value='Create New Folder' style="display:none;" onclick="toggle_visibility('loadingCommandDiv');">
<input type="file" name="filesToUpload[]" id="filesToUpload" class="uploadbox" multiple style="display:none;">
<input type='submit' name="upload" id="upload" value='&#x21E7' style="display:none;" onclick="toggle_visibility('loadingCommandDiv');"></p></form>
</div>
</div>
</div>
<div align="center" id='scandocshowDiv' name='scandocshowDiv' style="display:none;">
<input type="text" id="scandocuserfilename" name="scandocuserfilename" value='<?php echo $Udir.'Scanned-Document_'.$Date; ?>'> 
<select id='outputtopdf' name='outputtopdf'> 
  <option value="0">Preserve Extensions</option>
  <option value="1">Create PDF's</option>
</select>
<input type="submit" id="scandocSubmit" name="scandocSubmit" value='Scan Document' onclick="toggle_visibility('loadingCommandDiv');">
</div>
<div align="center" id='deleteOptionsDiv' name='deleteOptionsDiv' style="display:none;">
Are you sure?
<input type="submit" id="deleteFileSubmit" name="deleteFileSubmit" value='Confirm Delete' onclick="toggle_visibility('loadingCommandDiv');">
</div>
<div align="center" id='copyOptionsDiv' name='copyOptionsDiv' style="display:none;">
<input type="text" id='newcopyfilename' name='newcopyfilename' value='<?php echo $Udir.'Copied_'.$Date; ?>'> 
<input type="submit" id="copyFileSubmit" name="copyFileSubmit" value='Copy Files' onclick="toggle_visibility('loadingCommandDiv');">
</div>
<div align="center" id='renameOptionsDiv' name='renameOptionsDiv' style="display:none;">
<input type="text" id='renamefilename' name='renamefilename' value='<?php echo $Udir.'Renamed_'.$Date; ?>'> 
<input type="submit" id="renameFileSubmit" name="renameFileSubmit" value='Rename Files' onclick="toggle_visibility('loadingCommandDiv');">
</div>
<div align="center" id='archiveOptionsDiv' name='archiveOptionsDiv' style="display:none;">
<input type="text" id='userfilename' name='userfilename' value='<?php echo $Udir.'Archive'.'_'.$Date.'_'.$ArchInc; ?>'> 
<select id='archextension' name='archextension'> 
  <option value="zip">Zip</option>
  <option value="rar">Rar</option>
  <option value="tar">Tar</option>
  <option value="7z">7z</option>
  <option value="tar.bz2">Tar.bz2</option> 
</select>
<input type="submit" id="archiveFileSubmit" name="archiveFileSubmit" value='Archive Files' onclick="toggle_visibility('loadingCommandDiv');">
</div>
<div align="center" id='convertOptionsDiv' name='convertOptionsDiv' style="display:none;">
<input type="text" id="userconvertfilename" name="userconvertfilename" value="<?php echo $Udir.'Convert'.'_'.$Date; ?>"> 
<select id='extension' name='extension'> 
  <option value="">Select Format</option>
    <option value="mp3">--Audio Formats--</option>
  <option value="mp3">Mp3</option>
  <option value="avi">Avi</option>
  <option value="wav">Wav</option>
  <option value="ogg">Ogg</option>
    <option value="txt">--Document Formats--</option>
  <option value="doc">Doc</option>
  <option value="docx">Docx</option>
  <option value="rtf">Rtf</option>
  <option value="txt">Txt</option>
  <option value="odf">Odf</option>
  <option value="pdf">Pdf</option>
    <option value="ods">--Spreadsheet Formats--</option>
  <option value="xls">Xls</option>
  <option value="xlsx">Xlsx</option>
  <option value="ods">Ods</option>
  <option value="pdf">Pdf</option>
    <option value="zip">--Archive Formats--</option>
  <option value="zip">Zip</option>
  <option value="rar">Rar</option>
  <option value="tar">Tar</option>
  <option value="tar.bz2">Tar.bz2</option>
  <option value="7z">7z</option>
</select>
<input type="submit" id="convertSubmit" name="convertSubmit" value='Convert Files' onclick="toggle_visibility('loadingCommandDiv');">
</div>
<div align="center" id='photoOptionsDiv' name='photoOptionsDiv' style="display:none;">
<p>Filename: <input type="text" id='userphotofilename' name='userphotofilename' value='<?php echo $Udir.'Edited'.'_'.$Date; ?>'>
  <select id='photoextension' name='photoextension'>
  <option value="jpg">Jpg</option>
  <option value="bmp">Bmp</option>
  <option value="png">Png</option>
</select></p>
<p>Width and height: </p>
<p><input type="number" size="4" value="0" id='width' name='width' min="0" max="3000"> X <input type="number" size="4" value="0" id="height" name="height" min="0"  max="3000"></p> 
<p>Rotate: <input type="number" size="3" id='rotate' name='rotate' value="0" min="0" max="359"></p>
<input type="submit" id='convertPhotoSubmit' name='convertPhotoSubmit' value='Convert Files' onclick="toggle_visibility('loadingCommandDiv');">
</div>
<div align="center"><img src='Resources/logosmall.gif' id='loadingCommandDiv' name='loadingCommandDiv' style="display:none; max-width:64px; max-height:64px;"/></div>
</div>
<div align="center" id='PDFOptionsDiv' name='PDFOptionsDiv' style="display:none;">
<p><a id='makePDFbutton' name='makePDF' value='makePDF' ></a></p> 
<p><select id='method1' name='method1'>   
  <option value="0">Select Method</option>  
  <option value="0">Automatic</option>  
  <option value="1">Method 1 (Simple)</option>
  <option value="2">Method 2 (Advanced)</option>
</select></p>
<p><a id='userpdfconvertfilename1'><input type="text" id='userpdfconvertfilename' name='userpdfconvertfilename' value='<?php echo $Udir.'Converted'.'_'.$Date; ?>'></a>
  <select id='pdfextension' name='pdfextension'>   
  <option value="">Select Format</option> 
  <option value="pdf">Pdf</option>   
  <option value="doc">Doc</option>
  <option value="docx">Docx</option>
  <option value="rtf">Rtf</option>
  <option value="txt">Txt</option>
  <option value="odf">Odf</option>
</select></p>
<p><input type="submit" id='pdfwork' name='pdfwork' value='Perform PDFWork' onclick="toggle_visibility('loadingCommandDiv');"></p>
</div>
<div align="center" id='StreamOptionsDiv' name='StreamOptionsDiv' style="display:none;">
<p><input type="text" id='playlistname' name='playlistname' value='<?php echo $Udir.'Playlist'.'_'.$Date; ?>'>
  <input type='submit' id='createplaylistbutton' name='createplaylistbutton' value='Create Playlist' onclick="toggle_visibility('loadingCommandDiv');"></p></input>
</div>
<div align="center" id='SearchOptionsDiv' name='SearchOptionsDiv' style="display:none;">
<form action="cloudCore.php" method="post" enctypt="multipart/form-data">
<p><input type="text" id='search' name='search' value='Search...' onclick="Clear();">
  <input type='submit' id='searchbutton' name='searchbutton' value='Search Cloud' onclick="toggle_visibility('loadingCommandDiv');"></input></p>
</form>
</div>
<div align="center" id='ClipboardOptionsDiv' name='SearchOptionsDiv' style="display:none;">
<p><input type='submit' id='clipboardCopy' name='clipboardCopy' value='Copy' onclick="toggle_visibility('loadingCommandDiv');"></input>
  | <input type='submit' id='clipboardPaste' name='clipboardPaste' value='Paste' onclick="toggle_visibility('loadingCommandDiv');"></input></p>
</div>
<div align="center"><img src='Resources/logosmall.gif' id='loadingCommandDiv' name='loadingCommandDiv' style="display:none; max-width:64px; max-height:64px;"/></div>
</div>
<?php
   // Opens directory
   $myDirectory=opendir($CloudLoc.'/'.$UserID.$UserDirPOST);
  // Gets each entry
  while($entryName=readdir($myDirectory)) {
     $dirArray[]=$entryName;
  }
  // Closes directory
  closedir($myDirectory);
  // Counts elements in array
  $indexCount=count($dirArray);
  // Sorts files
  sort($dirArray);
  // Loops through the array of files
  for($index=0; $index < $indexCount; $index++) {
  // Decides if hidden files should be displayed, based on query above.
      if(substr("$dirArray[$index]", 0, 1)!=$hide) {
  // Resets Variables
    $favicon="";
    $class="file";
  // Gets File Names
    $name=$dirArray[$index];
    $namehref=$dirArray[$index];
        $fileArray = array_push($fileArray1, $namehref);
    if (substr_compare($namehref, '/', 1)) { 
      $namehref = substr_replace('/'.$namehref, $namehref, 0); }
  // Gets Date Modified
    $modtime=date("M j Y g:i A", filemtime($CloudUsrDir.$dirArray[$index]));
    $timekey=date("YmdHis", filemtime($CloudUsrDir.$dirArray[$index]));
  // Separates directories, and performs operations on those directories
    if(is_dir($dirArray[$index]))
    {
        $extn="&lt;Directory&gt;";
        $size="&lt;Directory&gt;";
        $sizekey="0";
        $class="dir";
      // Gets favicon.ico, and displays it, only if it exists.
        if(file_exists("$namehref/favicon.ico"))
          {
                        $slash = '/';
            $favicon=" style='background-image:url($slash$namehref/favicon.ico);'";
            $extn="&lt;Website&gt;";
          }
      // Cleans up . and .. directories
        if($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($slash$namehref/favicon.ico);'";}
        if($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;"; }
    }
  // File-only operations
    else{
      // Gets file extension
      $extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);
      // Prettifies file type
      switch ($extn){
        case "png": $extn="PNG Image"; break;
        case "jpg": $extn="JPEG Image"; break;
        case "jpeg": $extn="JPEG Image"; break;
        case "svg": $extn="SVG Image"; break;
        case "gif": $extn="GIF Image"; break;
        case "ico": $extn="Windows Icon"; break;
        case "txt": $extn="Text File"; break;
        case "log": $extn="Log File"; break;
        case "htm": $extn="HTML File"; break;
        case "html": $extn="HTML File"; break;
        case "xhtml": $extn="HTML File"; break;
        case "shtml": $extn="HTML File"; break;
        case "php": $extn="PHP Script"; break;
        case "js": $extn="Javascript File"; break;
        case "css": $extn="Stylesheet"; break;
        case "pdf": $extn="PDF Document"; break;
        case "xls": $extn="Spreadsheet"; break;
        case "xlsx": $extn="Spreadsheet"; break;
        case "doc": $extn="Microsoft Word Document"; break;
        case "docx": $extn="Microsoft Word Document"; break;
        case "zip": $extn="ZIP Archive"; break;
        case "htaccess": $extn="Apache Config File"; break;
        case "exe": $extn="Windows Executable"; break;
        default: if($extn!=""){$extn=strtoupper($extn)." File";} else{$extn="Folder";} break;
      }
        if (strpos($name, '.Playlist') or strpos($extn, 'PLAYLIST')) {
          $extn = "Playlist"; }
      // Gets and cleans up file size
        $size=pretty_filesize($CloudUsrDir.$dirArray[$index]);
        $sizekey=filesize($CloudUsrDir.$dirArray[$index]);
    }
$FileURL = 'DATA/'.$UserID.$UserDirPOST.$namehref;
$ArchiveArray = array('zip', 'rar', 'tar', 'bz', 'gz', 'bz2', '7z', 'iso', 'vhd');
$DearchiveArray = array('zip', 'rar', 'tar', 'bz', 'gz', 'bz2', '7z', 'iso', 'vhd');
$DocumentArray = array('txt', 'doc', 'docx', 'rtf', 'xls', 'xlsx', 'odf', 'ods');
$ImageArray = array('jpeg', 'jpg', 'png', 'bmp', 'gif', 'pdf');
$MediaArray = array('3gp', 'avi', 'mp3', 'mp4', 'mov', 'aac', 'oog');
$extnRAW = pathinfo($dirArray[$index], PATHINFO_EXTENSION);
if (in_array($extnRAW, $DearchiveArray)) {
  $specialHTML = ('<img id=\'dearchivebutton$tableCount\' name=\'dearchiveButton$tableCount\' href=\'#\' src=\'Resources/dearchive.png\' alt=\'Unpack\'/>'); }
if (in_array($extnRAW, $DocumentArray)) {
  $specialHTML = '<img src="Resources/makepdf.png" alt=\'Create PDF\'/>'; }
if (in_array($extnRAW, $ImageArray)) {
  $specialHTML = '<img src="Resources/photoedit.png" alt=\'Edit Photo\'/>'; }
if (in_array($extnRAW, $MediaArray)) {
  $specialHTML = '<img src="Resources/stream.png" alt=\'Stream Media\'/>'; }
// / Handle the AJAX post for if a user clicks on a folder in their drive.
if ($extn == "Folder") {
  $specialHTML = '<img src="Resources/archive.png" alt=\'Compress\'/>'; ?>
<script type="text/javascript">
$(document).ready(function () {
$("#corePostDL<?php echo $tableCount; ?>").click(function(){
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { download : "1", filesToDownload : "<?php echo $name; ?>"},
    success: function(returnFile) {
      toggle_visibility('loadingCommandDiv');
        window.location.href = "<?php echo 'cloudCore.php?UserDirPOST='.$name; ?>";
    }
} );
});
});
</script>
<?php }
// / Handle the AJAX post for if a use clicks on a .Playlist file in their drive.
if ($extn == "Playlist") { ?>
<script type="text/javascript">
$(document).ready(function () {
$("#corePostDL<?php echo $tableCount; ?>").click(function(){
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { playlistSelected : "<?php echo $name; ?>"},
    success: function(returnFile) {
      toggle_visibility('loadingCommandDiv');
        window.location.href = "<?php echo 'cloudCore.php?playlistSelected='.$name; ?>";
    }
} );
});
});
</script>
<?php }
if (($extn !== "Folder") or ($extn !== "Playlist")) { ?>
<script type="text/javascript">
$(document).ready(function () {
$("#corePostDL<?php echo $tableCount; ?>").click(function(){
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { download : "1", filesToDownload : "<?php echo $name; ?>"},
    success: function(returnFile) {
      toggle_visibility('loadingCommandDiv');
        window.location.href = "<?php echo 'DATA/'.$UserID.$UserDirPOST.$name; ?>";
    }
} );
});
});
</script>
<?php }
   echo("
    <tr class='$class'>
      <td><a id='corePostDL$tableCount' $favicon class='name' onclick=".'"toggle_visibility(\'loadingCommandDiv\');"'.">$name</a></td>
      <td><div><input type='checkbox' name='corePostSelect[]' id='$Udir$namehref' value='$Udir$namehref'></div></td>
            <td><a id='corePostDL$tableCount' name='corePostDL$tableCount'>$extn</a></td>
      <td sorttable_customkey='$sizekey'><a id='corePostDL$tableCount' name='corePostDL$tableCount'>$size</a></td>
      <td sorttable_customkey='$timekey'><a id='corePostDL$tableCount' name='corePostDL$tableCount'>$modtime</a></td>
    
    </tr>");
    $tableCount++; } } ?>
  </table>
<div align='center' id='loading' name='loading' style="display:none;"><img src='Resources/pacman.gif'/></div>
</div>
<script type="text/javascript">
$(document).ready(function () {
$("#copyFileSubmit").click(function(){
var copySelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
copySelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { copy : "1", filesToCopy : copySelected, 
    newcopyfilename : $("#newcopyfilename").val()},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<script type="text/javascript">
$(document).ready(function () {
$("#renameFileSubmit").click(function(){
var renameSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
renameSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { rename : "1", filesToRename : renameSelected, 
    renamefilename : $("#renamefilename").val()},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<?php if (in_array($extension, $archArr)) { ?>
<script type="text/javascript">
$(document).ready(function () {
$("#dearchive").click(function(){
var dearchiveSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
dearchiveSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { dearchive : "1", filesToDearchive : dearchiveSelected},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function () {
$("#archiveFileSubmit").click(function(){
var archiveSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
archiveSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { archive : "1", filesToArchive : archiveSelected, 
    userfilename : $("#userfilename").val(), archextension : $("#archextension").val()},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<script type="text/javascript">
$(document).ready(function () {
$("#deleteFileSubmit").click(function(){
var deleteSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
deleteSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { deleteconfirm : "1", filesToDelete : deleteSelected},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<?php if (in_array($extension, $pdfWordArr)) { ?>
<script type="text/javascript">
$(document).ready(function () {
$("#scandocSubmit").click(function(){
var scandocSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
scandocSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { scanDocSelected : scandocSelected, scandocuserfilename : $("#scandocuserfilename").val(), 
    outputScanDocToPDF : $("#outputtopdf").val()},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<?php } 
if (in_array($extension, $convertArr)) { ?>
<script type="text/javascript">
$(document).ready(function () {
$("#convertSubmit").click(function(){
var convertSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
convertSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { convertSelected : convertSelected,
      userconvertfilename : $("#userconvertfilename").val(),
      extension : $("#extension").val()},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
} );
});
</script>
<?php } 
if (in_array($extension, $imgArr)) { ?>
<script type="text/javascript">
$(document).ready(function () {
$("#convertPhotoSubmit").click(function(){
var convertphotoSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
convertphotoSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { convertSelected : convertphotoSelected,
        userconvertfilename : $("#userphotofilename").val(),
        height : $("#height").val(), 
        width : $("#width").val(), 
        rotate : $("#rotate").val(), 
        extension : $("#photoextension").val()},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<?php } 
if (in_array($extension, $pdfWordArr)) { ?>
<script type="text/javascript">
$(document).ready(function () {
$("#pdfwork").click(function(){
var pdfworkSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
pdfworkSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { pdfworkSelected : pdfworkSelected,
        userpdfconvertfilename : $("#userpdfconvertfilename").val(),
        pdfextension : $("#pdfextension").val(),
        method1 : $("#method1").val()},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<?php } 
if (in_array($extension, $PLMediaArr)) { ?>
<script type="text/javascript">
$(document).ready(function () {
$("#createplaylistbutton").click(function(){
var streamSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
streamSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { streamSelected : streamSelected,
        playlistname : $("#playlistname").val()},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<?php } 
if (in_array($extension, $PLMediaArr)) { ?>
<script type="text/javascript">
$(document).ready(function () {
$("#streambutton").click(function(){
var streamSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
streamSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { streamSelected : streamSelected,
        play : "1")},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function () {
$("#clipboardCopy").click(function(){
var clipboardCopySelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
clipboardCopySelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: {
        clipboard : "1",
        clipboardCopy: "1",
        clipboardSelected : clipboardCopySelected,
        clipboardCopyDir : "<?php echo $Udir; ?>"},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
<script type="text/javascript">
$(document).ready(function () {
$("#clipboardPaste").click(function(){
var clipboardPasteSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
clipboardPasteSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: {
        clipboard : "1",
        clipboardPaste: "1",
        clipboardSelected : clipboardPasteSelected,
        clipboardPasteDir : "<?php echo $Udir; ?>"},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
});
</script>
</body>
</html>