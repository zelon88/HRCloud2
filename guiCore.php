<?php
// / -----------------------------------------------------------------------------------
// / The following code detects if the commonCore is in memory and loads it if neccesary. 
if (!file_exists(realpath(dirname(__FILE__)).'/commonCore.php')) die ('ERROR!!! HRC2GuiCore17, Cannot process the HRCloud2 Common Core file (commonCore.php).'.PHP_EOL); 
else require_once(realpath(dirname(__FILE__)).'/commonCore.php'); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the variables for the session.
$PLMediaArr =  array('mp2', 'mp3', 'wma', 'wav', 'aac', 'flac', 'ogg', 'avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');
$ArchiveArray = array('zip', 'rar', 'tar', 'bz', 'gz', 'bz2', '7z', 'iso', 'vhd', 'vdi');
$DearchiveArray = array('zip', 'rar', 'tar', 'bz', 'gz', 'bz2', '7z', 'iso', 'vhd');
$DocumentArray = array('txt', 'doc', 'docx', 'rtf', 'xls', 'xlsx', 'odf', 'ods', 'pptx', 'ppt', 'xps', 'potx', 'potm', 'pot', 'ppa', 'odp');
$ImageArray = array('jpeg', 'jpg', 'png', 'bmp', 'gif', 'pdf');
$MediaArray = array('mp3', 'mp4', 'mov', 'aac', 'oog', 'wma', 'mp2', 'flac');
$VideoArray = array('3gp', 'mkv', 'avi', 'mp4', 'flv', 'mpeg', 'wmv');
$DrawingArray = array('svg', 'dxf', 'vdx', 'fig');
$archArr = array('rar', 'tar', 'tar.bz', '7z', 'zip', 'tar.gz', 'tar.bz2', 'tgz');
$convertArr = array('pdf', 'doc', 'docx', 'txt', 'rtf', 'odf', 'pages', 'jpg', 'jpeg', 'png', 'bmp', 'gif', 'mp2', 'mp3', 'wma', 'wav', 'aac', 'flac', 
  'ogg', 'avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4', 'pptx', 'ppt', 'xps');
$pdfWorkArr = array('pdf', 'jpg', 'jpeg', 'png', 'bmp', 'gif');
$imgArr = array('jpg', 'jpeg', 'png', 'bmp', 'gif');
$modelarray = array('3ds', 'obj', 'collada', 'off', 'ply', 'stl', 'ptx', 'dxf', 'u3d', 'vrml');
$fileArray1 = array();
$tableCount = $ArchInc = $ConvertInc = $RenameInc = $EditInc = 0;
$FavoritedIcon = '/HRProprietary/HRCloud2/Resources/favorites.png';
$SharedIcon = '/HRProprietary/HRCloud2/Resources/triangle.png';
$FolderIcon = '/HRProprietary/HRCloud2/Resources/folder.png';
$SharedFiles = scandir($UserSharedDir);
if (!isset($Udir)) $Udir = '';
$Udir = str_replace('//', '/', str_replace('//', '/', $Udir));
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets GUI specific resources.
function getCurrentURL() {
  if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') $httpPrefix = 'https://'; 
  if (!empty($_SERVER['HTTPS']) or $_SERVER['HTTPS'] = 'on') $httpPrefix = 'http://'; 
  $Current_URL = $httpPrefix.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
  return ($CurrentURL); }
function getFiles($pathToFiles) {
  $dirtyFileArr = scandir($Files);
  foreach ($dirtyFileArr as $dirtyFile) {
    $dirtyExt = pathinfo($pathToFiles.'/'.$dirtyFile, PATHINFO_EXTENSION);
    if (in_array($dirtyExt, $DangerousFiles) or $dirtyFile == 'index.html') continue;
    array_push($Files, $dirtyFile); }
  return ($Files); }
function getExtension($pathToFile) {
  return pathinfo($pathToFile, PATHINFO_EXTENSION); } 
function getFilesize($File) {
  $Size = @filesize($File);
  if (!is_numeric($Size)) $Size = 0;
  if ($Size < 1024) $Size=$Size." Bytes"; 
  elseif (($Size < 1048576) && ($Size > 1023)) $Size = round($Size / 1024, 1)." KB";
  elseif (($Size < 1073741824) && ($Size > 1048575)) $Size = round($Size / 1048576, 1)." MB";
  else ($Size = round($Size/1073741824, 1)." GB");
  return ($Size); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the $CD variable used to craft responsive absolute paths.
$CurrentDir = $_SERVER['REQUEST_URI'];
$CD = '';
if (strpos($CurrentDir, 'Applications') ==  TRUE) $CD = '../../';
if (strpos($_SERVER["SCRIPT_FILENAME"], 'HRAIMiniGui') !== FALSE) $CD = '../';
if (strpos($CurrentDir, '.AppData/') !== FALSE) $CD = '../../../../';
if (strpos($CurrentDir, '.AppData/.index.php') !== FALSE) $CD = '../../../';
if (strpos($CurrentDir, 'Shared') !== FALSE) $CD = '../../../../';
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// Checks to see if veiwing hidden files is enabled
if ($_SERVER['QUERY_STRING'] == "hidden") { 
  $hide = "";
  $ahref = "./";
  $atext = "Hide"; }
else { 
  $hide = ".";
  $ahref = "./?hidden";
  $atext = "Show"; }
// / -----------------------------------------------------------------------------------
?>