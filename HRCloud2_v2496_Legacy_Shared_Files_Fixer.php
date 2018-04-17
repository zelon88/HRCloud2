<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 Legacy Shared Files Updater</title>
<?php
// / HRCloud2 v2.4.9.6 Legacy Shared Files updater.
// / This script replaces any legacy shared files on the server with symlinks.
// / Written on 4/15/2018 
// / Justin Grimes, zelon88 
// / https://github.com/zelon88, https://github.com/zelon88/HRCloud2

// / Load the HRCloud2 Common Core file.
if (!file_exists(realpath(dirname(__FILE__)).'/commonCore.php')) {
  echo nl2br('ERROR!!! HRC235, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once (realpath(dirname(__FILE__)).'/commonCore.php'); }
?>

</head>
<body>
<h2>HRCloud2 Legacy Shared Files Updater</h2>

<?php
// / Authenticate the user as an administrator.
if ($UserIDRAW !== 1) die ('Permission Denied.');
// / Set variables for the session.
$InstLoc_DATA_Directory = rtrim($CloudTemp, '/'); 
$CloudLoc_DATA_Directory = rtrim($CloudLoc, '/');
$IgnoreArr = array('.html', '.php', '.js', '.css', '.htaccess');
// / Display header text if files aren't being replaced.
if (!isset($_POST['FIX']) && $UserIDRAW == 1) {
  echo nl2br ('This script will update HRCloud2 v2.4.9.6 Shared User directories with symlinks to valid Cloud files.'."\r\r"); 
  echo nl2br ('The following files will be replaced:'."\r\r"); }
// / Scan the $InstLoc_DATA_Directory for files that could be update-able.
foreach ($iterator = new \RecursiveIteratorIterator (
  new \RecursiveDirectoryIterator ($InstLoc_DATA_Directory, \RecursiveDirectoryIterator::SKIP_DOTS),
  \RecursiveIteratorIterator::SELF_FIRST) as $item) {
  	// / Set variables for the selection.
  	$name = basename($item);
    $target = str_replace('/.AppData/Shared/', '/', str_replace($InstLoc_DATA_Directory, $CloudLoc_DATA_Directory, $item));
    // / Apply filters to the detected files to remove config files and files likely to fail.
    foreach ($IgnoreArr as $ignore) {
     if (strpos($item, $ignore) == TRUE) continue(2); }
    if (strpos($item, '/Shared/') == FALSE) continue;
    if (is_link($item)) continue;
    if (!file_exists($target)) continue;
    // / Echo the output after all filters were applied.
    if ($UserIDRAW == 1) echo nl2br ($item."\r"); 
    // / Actually replace the selected files with symlinks if the Update button is submitted.
    if (isset($_POST['FIX']) && $UserIDRAW == 1) {
      unlink ($item);
      symlink($target, $item);
      if (file_exists($item)) echo nl2br('Sucess!'."\r");
      if (!file_exists($item)) echo nl2br('FAILED!!!'."\r"); } }

if (!isset($_POST['FIX'])) echo nl2br ('<form action="HRCloud2_v2496_Legacy_Shared_Files_Fixer.php" method="post"><input type="submit" name="FIX" id="FIX" value="Update"></form>'); 
?>
</bpdy>
</html>