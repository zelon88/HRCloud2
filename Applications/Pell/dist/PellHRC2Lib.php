<?php

// / The following code sanitizes all POST inputs used by Pell for HRCloud2.
$_POST['filename'] = str_replace(str_split('.~#[](){};:$!#^&%@>*<"\''), '', $_POST['filename']);
$_POST['filename'] = str_replace(' ', '_', $_POST['filename']);
$_POST['extension'] = str_replace(str_split('.~#[](){};:$!#^&%@>*<"\''), '', $_POST['extension']);

// / The following code sets global variables for the session.
$pellFiles = scandir($CloudUsrDir);
$pellDocArray = array('txt', 'doc', 'docx', 'rtf', 'pdf');
$pellDangerArr = array('index.php', 'index.html');
$pellTempDir = $InstLoc.'/Applications/Pell/TEMP';
$htmlOutput = $_POST['htmlOutput'];
$filename = $_POST['filename'];
$newPathname = $CloudUsrDir.'/'.$filename.'.html';
$extension = $_POST['extension'];

// / The following code gathers the document data to be saved and creates a temporary HTML file with it.
if (!is_dir($pellTempDir)) {
  mkdir($pellTempDir); }
if (!file_exists($pellTempDir.'/index.html')) {
	copy($InstLoc.'/index.html', $pellTempDir.'/index.html'); }
if (isset($_POST['htmlOutput']) && isset($_POST['filename']) && $_POST['filename'] !== '' && isset($_POST['extension'])) {
  $pellTempFile = $pellTempDir.'/'.$filename.'.html';
  file_put_contents($pellTempFile, $htmlOutput); 
  $txt = ('OP-Act: Created a temporary HTML file on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }

// / The following code starts the document conversion engine if an instance is not already running.
if (file_exists($pellTempFile) && isset($_POST['filename']) && isset($_POST['extension'])) {
  if (in_array($extension, $pellDocArray)) {
    // / The following code performs several compatibility checks before copying or converting anything.
    if (file_exists('/usr/bin/unoconv')) {
      $txt = ('OP-Act: Verified the document conversion engine on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    // / The following code checks to see if Unoconv is in memory.
      exec("pgrep soffice.bin", $DocEnginePID, $DocEngineStatus);
      if (count($DocEnginePID) < 1) {
        exec('/usr/bin/unoconv -l &', $DocEnginePID1); 
        $txt = ('OP-Act: Starting the document conversion engine (PID '.$DocEnginePID[1].') on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        exec("pgrep soffice.bin", $DocEnginePID, $DocEngineStatus); } }
      if (file_exists('/usr/bin/unoconv')) {
        $txt = ('ERROR!!! HRC2PellApp30, Could not verify the document conversion engine on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      if (count($DocEnginePID) >= 1) {
        $txt = ('OP-Act, The document conversion engine PID is '.$DocEnginePID[1]);
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
        $txt = ("OP-Act, Executing \"unoconv -o $newPathname -f $extension $pathname\" on ".$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);      
        exec("unoconv -o $newPathname -f $extension $pathname", $returnDATA); 
      if (!is_array($returnDATA)) {
        $txt = ('OP-Act, Unoconv returned '.$returnDATA.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
      if (is_array($returnDATA)) {
        $txt = ('OP-Act, Unoconv returned the following on '.$Time.':');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }                
        foreach($returnDATA as $returnDATALINE) {
          $txt = ($returnDATALINE);
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
      // / For some reason files take a moment to appear after being created with Unoconv.
        $stopper = 0;
        while(!file_exists($newPathname)) {
          exec("unoconv -o $newPathname -f $extension $pellTempFile");
          $stopper++;
          if ($stopper == 10) {
            $txt = 'ERROR!!! HRC2PellApp53, The converter timed out while copying your file. ';
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
            die($txt); } } } } }
