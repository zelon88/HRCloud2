<?php
// / The following code handles the pellOpen GET request.
if (isset($_GET['pellOpen'])) {
  $_POST['pellOpen'] = $_GET['pellOpen']; 
  $pellOpen = 1; }

// / The following code sanitizes all POST inputs used by Pell for HRCloud2.
$_POST['filename'] = str_replace(str_split('~#[](){};:$!#^&%@>*<"\\\''), '', $_POST['filename']);
$_POST['filename'] = str_replace(' ', '_', $_POST['filename']);
$_POST['pellOpen'] = str_replace(str_split('~#[](){};:$!#^&%@>*<"\\\''), '', $_POST['pellOpen']);
$_POST['pellOpen'] = str_replace(' ', '_', $_POST['pellOpen']);
$_POST['extension'] = str_replace(str_split('~#[](){};:$!#^&%@>*<"\\\''), '', $_POST['extension']);
$_POST['rawOutput'] = str_replace(str_split('.~#[](){};:$!#^&%@>*<"\\\''), '', $_POST['rawOutput']);

// / The following code sets global variables for the session.
  // / Arrays...
$pellDocArray = array('txt', 'docx', 'rtf', 'pdf', 'doc');
$pellDocs1 = 'txt';
$pellDocs2 = 'doc';
$pellDocs3 = 'docx';
$pellDocs4 = 'rtf';
$pellDocs5 = 'pdf';
$pellDocs6 = array('docx', 'pdf', 'doc');
$pellDocs7 = array('docx', 'rtf', 'pdf', 'doc');
$pellDangerArr = array('index.php', 'index.html');
  // / Post inputs...
$htmlOutput = str_replace('&lt;', '<', str_replace('&gt;', '>', $_POST['htmlOutput'])); 
$filename = $_POST['filename'];
$pellOpen = $_POST['pellOpen'];
$rawOutput = $_POST['rawOutput'];
$extension = $_POST['extension'];
  // / Directory structure...
$pellFiles = scandir($CloudUsrDir);
$pellTempDir0 = $InstLoc.'/Applications/Pell/TEMP/';
$pellTempDir = $InstLoc.'/Applications/Pell/TEMP/'.$UserID;
$pellTempFile = str_replace('//', '/', $pellTempDir.'/'.$filename.'.html');
$newPathname = str_replace('//', '/', $CloudUsrDir.'/'.$filename.'.'.$extension);
$pellOpenFile = str_replace('//', '/', $CloudUsrDir.'/'.$pellOpen);

// / The following code sets the selected file for the save input textbox.
if (isset($_POST['pellOpen']) && $pellOpen !== '') {
  $fileEcho = $pellOpen;
  $fileEcho1 = $pellOpen; }
if (isset($_POST['filename']) && $filename !== '') {
  $fileEcho = $filename;
  $fileEcho1 = $filename; }
foreach ($pellDocArray as $extCleaner) {
  $extCleaner = '.'.$extCleaner;
  if ($extCleaner == '.doc') { 
    if (substr($fileEcho, 0, -1) == 'x') { 
      str_replace('.docx', '', $fileEcho); } }
  $fileEcho = str_replace($extCleaner, '', $fileEcho); }

// / The following code gathers the document data to be saved and creates a temporary HTML file with it.
if (!is_dir($pellTempDir0)) {
  mkdir($pellTempDir0); }
if (!file_exists($pellTempDir0.'/index.html')) {
  copy($InstLoc.'/index.html', $pellTempDir0.'/index.html'); }
if (!is_dir($pellTempDir)) {
  mkdir($pellTempDir); }
if (!file_exists($pellTempDir.'/index.html')) {
  copy($InstLoc.'/index.html', $pellTempDir.'/index.html'); }
if (isset($htmlOutput) && isset($filename) && $filename !== '' && isset($extension)) {
  file_put_contents($pellTempFile, $htmlOutput);
  $txt = ('OP-Act: Created a temporary HTML file on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }

// / The following code initializes the document conversion engine.
if ((isset($_POST['pellOpen']) && $pellOpen !== '') or (isset($_POST['filename']) && $filename !=='')) {
  if (file_exists('/usr/bin/unoconv')) {
    $txt = ('OP-Act: Verified the document conversion engine on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    exec("pgrep soffice.bin", $DocEnginePID, $DocEngineStatus);
    if (count($DocEnginePID) < 1) {
      exec('/usr/bin/unoconv -l &', $DocEnginePID1); 
      $txt = ('OP-Act: Starting the document conversion engine (PID '.$DocEnginePID[1].') on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      exec("pgrep soffice.bin", $DocEnginePID, $DocEngineStatus); } }
  if (!file_exists('/usr/bin/unoconv')) {
    $txt = ('ERROR!!! HRC2PellApp30, Could not verify the document conversion engine on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (count($DocEnginePID) >= 1) {
    $txt = ('OP-Act, The document conversion engine PID is '.$DocEnginePID[1]);
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }

// / The following code opens files from a users Cloud drive and presents them in to Pell for editing.
if (isset($_POST['pellOpen']) && $pellOpen == 1) {
  if (strpos($pellOpen, '.'.$pellDocs1) == 'true') {
    $pellOpenFileData = file_get_contents($pellOpenFile);
    $pellOpenFileDataArr = file($pellOpenFile);
    $pellOpenFileTime = date("F d Y H:i:s.",filemtime($pellOpenFile)); 
    $txt = ('OP-Act: Copied contents of '.$pellOpen.' to memory on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }

  if (in_array($pellOpen, $pellDocs7) == 'true') {

  }

// / The following code is performed when the "Raw HTML" is checked.
if ($rawOutput == 'checked' && isset($filename) && $filename !=='' && isset($extension) && $extesion !== '') {
  // / The following code starts the document conversion engine if an instance is not already running.
  if (file_exists($pellTempFile) && isset($filename) && isset($extension)) {
    if (in_array($extension, $pellDocArray)) {
          $txt = ("OP-Act, Executing \"unoconv -o $newPathname -f $extension $pellTempFile\" on ".$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);      
          exec("unoconv -o $newPathname -f $extension $pellTempFile", $returnDATA); 
        // / For some reason files take a moment to appear after being created with Unoconv.
          $stopper = 0;
          while(!file_exists($newPathname)) {
            exec("unoconv -o $newPathname -f $extension $pellTempFile");
            $stopper++;
            if ($stopper == 10) {
              $txt = 'ERROR!!! HRC2PellApp53, The converter timed out while copying your file. ';
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
              unlink($pellTempFile);
              die($txt); } } } } }

// / The following code is performed when the "Raw HTML" option is not checked.
if ($rawOutput !== 'checked' && isset($filename) && $filename !=='' && isset($extension) && $extesion !== '') {
  if (file_exists($pellTempFile) && isset($filename) && isset($extension)) {
    $txt = ("OP-Act, Executing \"pandoc -o $newPathname $pellTempFile\" on ".$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);      
    exec("pandoc -o $newPathname $pellTempFile", $returnDATA); } }

// / The following code captures any errors generated during execution and logs them/returns them to the user.
if (!is_array($returnDATA)) {
  $txt = ('OP-Act, The conversion engine returned '.$returnDATA.' on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
if (is_array($returnDATA)) {
  $txt = ('OP-Act, The conversion engine returned the following on '.$Time.':');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);                
  foreach($returnDATA as $returnDATALINE) {
    $txt = ($returnDATALINE);
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }

// / The following code cleans up any lingering temp files.if (file_exists($pellTempFile)) {
if (file_exists($pellTempFile)) {
  $txt = ('ERROR!!! HRC2PellApp87, There was a problem cleaning temporary Pell data on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
if (!file_exists($pellTempFile)) {
  $txt = ('OP-Act, Deleted temporary Pell data on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
