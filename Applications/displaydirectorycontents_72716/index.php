<!doctype html>
<html>
<head>
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
function goBack() {
  window.history.back(); }
</script>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>Cloud Contents</title>
<?php
// / Verify the config.php file.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/config.php')) {
  echo nl2br('</head>ERROR!!! HRC2Index19, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require('/var/www/html/HRProprietary/HRCloud2/config.php'); }
$WPFile = '/var/www/html/wp-load.php';
// / Verify that WordPress is installed.
if (!file_exists($WPFile)) {
  echo nl2br('</head>ERROR!!! HRC2Index27, WordPress was not detected on the server.'."\n"); }
  else {
    require_once($WPFile); } 
// / Set all primary array data.
$PLMediaArr =  array('mp2', 'mp3', 'wma', 'wav', 'aac', 'flac', 'ogg', 'avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');
$ArchiveArray = array('zip', 'rar', 'tar', 'bz', 'gz', 'bz2', '7z', 'iso', 'vhd');
$DearchiveArray = array('zip', 'rar', 'tar', 'bz', 'gz', 'bz2', '7z', 'iso', 'vhd');
$DocumentArray = array('txt', 'doc', 'docx', 'rtf', 'xls', 'xlsx', 'odf', 'ods');
$ImageArray = array('jpeg', 'jpg', 'png', 'bmp', 'gif', 'pdf');
$MediaArray = array('3gp', 'avi', 'mp3', 'mp4', 'mov', 'aac', 'oog');
// / Set all secondary array data.
$archArr = array('rar', 'tar', 'tar.bz', '7z', 'zip', 'tar.gz', 'tar.bz2', 'tgz');
$pdfWordArr = array('pdf', 'doc', 'docx', 'txt', 'rtf', 'odf', 'pages', 'jpg', 'jpeg', 'png', 'bmp', 'gif');
$convertArr = array('pdf', 'doc', 'docx', 'txt', 'rtf', 'odf', 'pages', 'jpg', 'jpeg', 'png', 'bmp', 'gif', 'mp2', 'mp3', 'wma', 'wav', 'aac', 'flac', 'ogg', 'avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');
$pdfWordArr = array('pdf', 'jpg', 'jpeg', 'png', 'bmp', 'gif');
$imgArr = array('jpg', 'jpeg', 'png', 'bmp', 'gif');
$fileArray1 = array();
// / Set all incremental data to 0.
$tableCount = 0;
$ArchInc = 0;
$ConvertInc = 0;
$RenameInc = 0;
$ConvertInc = 0;
$EditInc = 0;
// / Reset and re-detect the UserID, just-in-case.
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
// / Handle integrated App variables.
$UserContacts = $InstLoc.'/DATA/'.$UserID.'/.AppData/.contacts.php';
$UserSharedIndex = $URL.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/.AppData/Shared/.index.php';
$UserNotes = $InstLoc.'/DATA/'.$UserID.'/.AppData/.notes.php';
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppData/.config.php';
// / User config loader.
if (!file_exists($UserConfig)) {
  @chmod($UserConfig, 0755); }
if (!file_exists($UserConfig)) {
  echo nl2br('</head>ERROR!!! HRC2Index35, User Cache file was not detected on the server!'."\n"); 
  die (); }
else {
    require($UserConfig); } 
// / Color scheme handler.
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
// / User directory handler.
if (isset($_POST['UserDir']) or isset($_POST['UserDirPOST'])) {
  if ($_POST['UserDir'] == '/' or $_POST['UserDirPOST'] == '/') { 
    $_POST['UserDir'] = '/'; 
    $_POST['UserDirPOST'] = '/'; } 
  $Udir = $_POST['UserDirPOST'].'/'; }
if (!isset($_POST['UserDir']) or !isset($_POST['UserDirPOST'])) { 
  $Udir = '/'; }
if ($Udir == '//') {
  $Udir = '/'; }
if ($Udir == '//') {
  $Udir = '/'; }
if ($Udir == '//') {
  $Udir = '/'; }
// / User directory cleaner.
$Udir = str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', $Udir))); 
$Udir = ltrim(rtrim($Udir,'//'),'/').'/';
$Udir = str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', $Udir))); 
// / GUI specific resources.
  function pretty_filesize($file) {
    $size=filesize($file);
    if($size<1024){$size=$size." Bytes"; }
    elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB"; }
    elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB"; }
    else{$size=round($size/1073741824, 1)." GB"; }
    return $size; }
// Checks to see if veiwing hidden files is enabled
if ($_SERVER['QUERY_STRING']=="hidden") { 
  $hide="";
  $ahref="./";
  $atext="Hide"; }
else { 
  $hide=".";
  $ahref="./?hidden";
  $atext="Show"; }
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
</script>
</head>
<body>
<div id="container">
<div align='center'><h3><?php
echo rtrim(ltrim($Udir, '/'), '/'); 
?></h3></div><?php
while (file_exists($CloudUsrDir.'Archive'.'_'.$Date.'_'.$ArchInc)) {
  $ArchInc++; }
?>
<div align="center" style="margin-bottom:5px;">
<input type='submit' name="back" id="back" value='&#x2190' class="submitsmall" target="cloudContents" onclick="goBack(); toggle_visibility('loadingCommandDiv');"> | <input type='submit' value='+' onclick="toggle_visibility('newOptionsDiv');"></div>
<div align="center" style="margin-bottom:5px;"><img id='copyButton' name='copyButton' title="Copy" alt="Copy" onclick="toggle_visibility('copyOptionsDiv');" src='Resources/copy.png'/> | <img id='renameButton' name='renameButton' title="Rename" alt="Rename" onclick="toggle_visibility('renameOptionsDiv');" src='Resources/rename.png'/> | <img id='deleteButton' name='deleteButton' title="Delete" alt="Delete" onclick="toggle_visibility('deleteOptionsDiv');" src='Resources/deletesmall.png'/> | <img id='archive' name='archive' title="Archive" alt="Archive" onclick="toggle_visibility('archiveOptionsDiv');" src='Resources/archiveFile.png'/> | 
<img id='dearchiveButton' name='dearchiveutton' title="Dearchive" alt="Dearchive" onclick="toggle_visibility('loadingCommandDiv');" src='Resources/dearchive.png'/> | <img id="convertButton" name="convertButton" title="Convert" alt="Convert" onclick="toggle_visibility('convertOptionsDiv');" src='Resources/convert.png'/> | 
<img id="imgeditButton" name="imgeditButton" title="Image / Photo Editing Tools" alt="Image / Photo Editing Tools" onclick="toggle_visibility('photoOptionsDiv');" src='Resources/photoedit.png'/> | <img id="pdfworkButton" name="pdfworkButton" title="OCR (Optical Character Recognition) Tools" alt="OCR (Optical Character Recognition) Tools" onclick="toggle_visibility('PDFOptionsDiv');" src='Resources/makepdf.png'/> | <img id="streamButton" name="streamButton" title="Create Playlist" alt="Create Playlist" onclick="toggle_visibility('StreamOptionsDiv');" src='Resources/stream.png'/> | <img id='shareButton' name="shareButton" title="Share" alt="Share" onclick="toggle_visibility('ShareOptionsDiv');" src='Resources/share.png'/> | <img id='clipboardButton' name="clipboardButton" title="Clipboard" alt="Clipboard" onclick="toggle_visibility('ClipboardOptionsDiv');" src='Resources/clipboard.png'/> | <img id='SearchButton' name="SearchButton" title="Search" alt="Search" onclick="toggle_visibility('SearchOptionsDiv');" src='Resources/searchsmall.png'/>
</div>

<div align="center" id='newOptionsDiv' name='newOptionsDiv' style="display:none;">
  <p><input type='submit' name="newFolder" id="newFolder" value='New Folder' onclick="toggle_visibility('makedirDiv'); toggle_visibility('makedir'); toggle_visibility('dirToMake');">
  <input type='submit' name="newFile" id="newFile" value='New File' onclick="toggle_visibility('uploadDiv'); toggle_visibility('upload'); toggle_visibility('filesToUpload');"></p>
  </div>

<form action="cloudCore.php" method="post" enctype="multipart/form-data">
<div align="center" name="makedirDiv" id="makedirDiv" style="display:none;">
<input type="text" name="dirToMake" id="dirToMake" value="<?php echo $Udir; ?>" style="display:none;">
<input type='submit' name="makedir" id="makedir" value='Create New Folder' style="display:none;" onclick="toggle_visibility('loadingCommandDiv');"></div>
</form>
<form action="cloudCore.php" method="post" enctype="multipart/form-data">
<div align="center" name="uploadDiv" id="uploadDiv" style="display:none;">
<input type="file" name="filesToUpload[]" id="filesToUpload" class="uploadbox" multiple style="display:none;">
<input type='submit' name="upload" id="upload" value='&#x21E7' style="display:none;" onclick="toggle_visibility('loadingCommandDiv');"></div>
</form>
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
  <input type='submit' id='createplaylistbutton' name='createplaylistbutton' value='Create Playlist' onclick="toggle_visibility('loadingCommandDiv');"></p>
</div>
<div align="center" id='ShareOptionsDiv' name='ShareOptionsDiv' style="display:none;">
<p><form action="<?php echo $UserSharedIndex; ?>" enctype="multipart/form-data"><input type='submit' id='viewsharebutton' name='viewsharebutton' value='View Shared' onclick="toggle_visibility('loadingCommandDiv');"></form></p>
<p><input type='submit' id='sharebutton' name='sharebutton' value='Share Files' onclick="toggle_visibility('loadingCommandDiv');"></p>
</div>
<div align="center" id='SearchOptionsDiv' name='SearchOptionsDiv' style="display:none;">
<form action="cloudCore.php" method="post" enctype="multipart/form-data">
<p><input type="text" id='search' name='search' value='Search...' onclick="Clear();">
  <input type='submit' id='searchbutton' name='searchbutton' value='Search Cloud' onclick="toggle_visibility('loadingCommandDiv');"></p>
</form>
</div>
<div align="center" id='ClipboardOptionsDiv' name='ClipboardOptionsDiv' style="display:none;">
<p><input type='submit' id='clipboardCopy' name='clipboardCopy' value='Copy' onclick="toggle_visibility('loadingCommandDiv');">
  | <input type='submit' id='clipboardPaste' name='clipboardPaste' value='Paste' onclick="toggle_visibility('loadingCommandDiv');"></p>
</div>
<div align="center" id='loadingCommandDiv' name='loadingCommandDiv' style="display:none;"><img src='Resources/logoSmall.gif' style="max-width:64px; max-height:64px;"/></div>
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
    <tbody>
<?php
  $myDirectory = rtrim($CloudLoc.'/'.$UserID.$UserDirPOST, '/');
  $myDirectory=opendir($myDirectory);
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
      if ($name == 'index.html') continue;
      $namehref=$dirArray[$index];
      $fileArray = array_push($fileArray1, $namehref);
    if (substr_compare($namehref, '/', 1)) { 
      $namehref = substr_replace('/'.$namehref, $namehref, 0); }
    $modtime=date("M j Y g:i A", filemtime($CloudUsrDir.$dirArray[$index]));
    $timekey=date("YmdHis", filemtime($CloudUsrDir.$dirArray[$index]));
    if (is_dir($dirArray[$index])) {
      $extn="&lt;Directory&gt;";
      $size="&lt;Directory&gt;";
      $sizekey="0";
      $class="dir";
        if (file_exists("$namehref/favicon.ico")) {
          $slash = '/';
          $favicon=" style='background-image:url($slash$namehref/favicon.ico);'";
          $extn="&lt;Website&gt;"; }
        if ($name==".") { $name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($slash$namehref/favicon.ico);'";}
        if ($name=="..") { $name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;"; } }
  // File-only operations
    else {
      // Gets file extension
      $extn = pathinfo($dirArray[$index], PATHINFO_EXTENSION);
      // Prettifies file type
      switch ($extn) {
        case "png": $extn="PNG Image"; break;
        case "jpg": $extn="JPEG Image"; break;
        case "jpeg": $extn="JPEG Image"; break;
        case "svg": $extn="SVG Image"; break;
        case "gif": $extn="GIF Image"; break;
        case "ico": $extn = "Windows Icon"; break;
        case "txt": $extn = "Text File"; break;
        case "log": $extn = "Log File"; break;
        case "htm": $extn = "HTML File"; break;
        case "html": $extn = "HTML File"; break;
        case "xhtml": $extn = "HTML File"; break;
        case "shtml": $extn = "HTML File"; break;
        case "php": $extn = "PHP Script"; break;
        case "js": $extn = "Javascript File"; break;
        case "css": $extn = "Stylesheet"; break;
        case "pdf": $extn = "PDF Document"; break;
        case "xls": $extn = "Spreadsheet"; break;
        case "xlsx": $extn= "Spreadsheet"; break;
        case "doc": $extn = "Microsoft Word Document"; break;
        case "docx": $extn = "Microsoft Word Document"; break;
        case "zip": $extn = "ZIP Archive"; break;
        case "htaccess": $extn = "Apache Config File"; break;
        case "exe": $extn = "Windows Executable"; break;
        case '<Directory>': $extn = 'Folder'; break;
        case 'Directory': $extn = 'Folder'; break;
        case '<directory>': $extn = 'Folder'; break;
        case 'directory': $extn = 'Folder'; break;
        default: if ($extn != ""){ $extn = strtoupper($extn)." File"; } else {
          $extn = "Folder"; } 
          break; }
        if (strpos($extn, 'directory') == 'true' or strpos($extn, 'Directory') == 'true' or strpos($name, '.') == 'false') {
          $extn = "Folder"; }
        if (strpos($name, '.Playlist') == 'true' or strpos($extn, 'PLAYLIST') == 'true') {
          $extn = "Playlist"; } 
        $size = pretty_filesize($CloudUsrDir.$dirArray[$index]);
        $sizekey = filesize($CloudUsrDir.$dirArray[$index]); }
$CleanUdir = str_replace('//', '/', $Udir.$name);
$CleanUdir = str_replace('//', '/', $CleanUdir);
$CleanUdir = str_replace('//', '/', $CleanUdir);
$CleanDir = rtrim($CleanUdir, '/');
if ($extn == 'HTML File' or $extn == 'PHP File' or $extn == 'CSS File') continue;
$FileURL = 'DATA/'.$UserID.$UserDirPOST.$namehref;
$extnRAW = pathinfo($dirArray[$index], PATHINFO_EXTENSION);
if ($extnRAW == '' or $extnRAW == NULL) {
  $extn = "Folder"; 
  $size = "Unknown"; }
if (preg_match('~[0-9]~', $size) == 'false') {
  $size = "Unknown"; }
if (in_array($extnRAW, $DearchiveArray)) {
  $specialHTML = ('<img id=\'dearchivebutton$tableCount\' name=\'dearchiveButton$tableCount\' href=\'#\' src=\'Resources/dearchive.png\' alt=\'Unpack\'/>'); }
if (in_array($extnRAW, $DocumentArray)) {
  $specialHTML = '<img src="Resources/makepdf.png" alt=\'Create PDF\'/>'; }
if (in_array($extnRAW, $ImageArray)) {
  $specialHTML = '<img src="Resources/photoedit.png" alt=\'Edit Photo\'/>'; }
if (in_array($extnRAW, $MediaArray)) {
  $specialHTML = '<img src="Resources/stream.png" alt=\'Stream Media\'/>'; }
if ($extn == "Folder") {
  $specialHTML = '<img src="Resources/archive.png" alt=\'Compress\'/>'; }
// / Handle the AJAX post for if a user clicks on a folder in their drive.
if ($extn == 'Folder' or $extn == '<Directory>' or strpos($name, '.') == 'false' 
  or $extnRAW == '' or $extnRAW == NULL) { 
?>
<script type="text/javascript">
$(document).ready(function () {
$("#corePostDL<?php echo $tableCount; ?>").click(function(){
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { download : "1", dirToMake : "<?php echo $CleanUdir; ?>", filesToDownload : "<?php echo $name; ?>"},
    success: function(returnFile) {
      toggle_visibility('loadingCommandDiv');
        window.location.href = "<?php echo ('cloudCore.php?UserDirPOST='.$CleanUdir); ?>";
    }
} );
});
});
</script>
<?php }
// / Handle the AJAX post for if a use clicks on a .Playlist file in their drive.
if ($extn == 'Playlist' or $extn == 'PLAYLIST') { 
if (isset ($_POST['UserDirPOST']) && $_POST['UserDirPOST'] !== '' && $_POST['UserDirPOST'] !== '/') { 
  $PLSpecialEcho = '?UserDirPOST='.$UserDirPOST; 
} else {
  $PLSpecialEcho = ''; } ?>
<script type="text/javascript">
$(document).ready(function () {
$("#corePostDL<?php echo $tableCount; ?>").click(function(){
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { playlistSelected : "<?php echo $name; ?>"},
    success: function(returnFile) {
      toggle_visibility('loadingCommandDiv');
      window.location.href = "<?php echo ('cloudCore.php?playlistSelected='.$name); ?>";
    }
} );
});
});
</script>
<?php }
if ($extn !== "Folder" or $extn !== "Playlist") { ?>
<script type="text/javascript">
$(document).ready(function () {
$("#corePostDL<?php echo $tableCount; ?>").click(function(){
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { download : "1", filesToDownload : "<?php echo $name; ?>"},
    success: function(returnFile) {
      toggle_visibility('loadingCommandDiv');
      window.setTimeout(function(){
        window.location.href = "<?php echo 'DATA/'.$UserID.$UserDirPOST.$name; ?>";
      }, 2500);
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
  </tbody>
  </table>
<div align='center' id='loading' name='loading' style="display:none;"><img src='Resources/pacman.gif'/></div>
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
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
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
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
$(document).ready(function () {
$("#dearchiveButton").click(function(){
var dearchiveSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
dearchiveSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { filesToDearchive : dearchiveSelected, dearchiveButton : "1"},
    success: function(data) {
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
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
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
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
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
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
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
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
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
} );
});
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
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
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
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
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
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
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
        play : "1"},
    success: function(data) {
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
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
        clipboardSelected: clipboardCopySelected,
        clipboardCopyDir : "<?php echo $Udir; ?>"},
    success: function(data) {
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
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
        clipboardPasteDir : "<?php echo $UserDirPOST; ?>"},
    success: function(data) {
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
$(document).ready(function () {
$("#sharebutton").click(function(){
var shareSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
shareSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { shareConfirm : "1", filesToShare : shareSelected},
    success: function(data) {
        window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
    }
} );
});
});
</script>
</body>
</html>