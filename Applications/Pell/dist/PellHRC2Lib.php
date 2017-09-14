<?php
// / -----------------------------------------------------------------------------------
// / The following code handles GET requests and sets POST inputs with them.
  // / Pell For HRC2 accepts API inputs from the following POST and/or GET inputs.
if (isset($_GET['deleteFile'])) {
  $_POST['deleteFile'] = $_GET['deleteFile']; }
if (isset($_GET['saved'])) {
  $_POST['saved'] = $_GET['saved']; }
if (isset($_GET['extension'])) {
  $_POST['extension'] = $_GET['extension']; }
if (isset($_GET['pellOpen'])) {
  $_POST['pellOpen'] = $_GET['pellOpen']; }
if (isset($_GET['filename'])) {
  $_POST['filename'] = $_GET['filename']; }
if (isset($_GET['rawOutput'])) {
  $_POST['rawOutput'] = $_GET['rawOutput']; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sanitizes all POST (and get) inputs used by Pell for HRCloud2.
$_POST['deleteFile'] = str_replace(str_split('~#[](){};:$!#^&%@>*<"\\\''), '', $_POST['deleteFile']);
$_POST['deleteFile'] = str_replace(' ', '_', $_POST['deleteFile']);
$_POST['filename'] = str_replace(str_split('~#[](){};:$!#^&%@>*<"\\\''), '', $_POST['filename']);
$_POST['filename'] = str_replace(' ', '_', $_POST['filename']);
$_POST['pellOpen'] = str_replace(str_split('~#[](){};:$!#^&%@>*<"\\\''), '', $_POST['pellOpen']);
$_POST['pellOpen'] = str_replace(' ', '_', $_POST['pellOpen']);
$_POST['extension'] = str_replace(str_split('~#[](){};:$!#^&%@>*<"\\\''), '', $_POST['extension']);
$_POST['htmlOutput'] = str_replace(str_split('"\\\''), '', $_POST['htmlOutput']);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets global variables for the session.
  // / Arrays...
$pellDocArray = array('txt', 'docx', 'rtf', 'pdf', 'odt', 'doc');
$pellDocs1 = array('txt');
$pellDocs2 = array('doc');
$pellDocs3 = array('docx');
$pellDocs4 = array('rtf');
$pellDocs5 = array('pdf');
$pellDocs6 = array('docx', 'doc');
$pellDocs7 = array('pdf');
$pellDocs8 = array('docx', 'doc', 'odt', 'rtf');
$pellDocs9 = array('pdf', 'png', 'bmp', 'jpg', 'jpeg');
$pellDangerArr = array('index.php', 'index.html');
  // / Post inputs...
$deletefile = $_POST['deleteFile'];
$htmlOutput = htmlspecialchars_decode(trim($_POST['htmlOutput']));
$filename = $_POST['filename'];
$deleteFile = $_POST['deleteFile'];
$pellOpen = $_POST['pellOpen'];
$extension = $_POST['extension'];
  // / Directory structure...
$pellFiles = scandir($CloudUsrDir);
$pellTempDir0 = $InstLoc.'/Applications/Pell/TEMP/';
$pellTempDir = $InstLoc.'/Applications/Pell/TEMP/'.$UserID;
$pellTempFile = str_replace('//', '/', $pellTempDir.'/'.$filename.'.html');
$newPathname = str_replace('//', '/', $CloudUsrDir.'/'.$filename.'.'.$extension);
$pellOpenFile = str_replace('//', '/', $CloudUsrDir.'/'.$pellOpen);
$pellOpenFileExtension = pathinfo($pellOpenFile, PATHINFO_EXTENSION);
$newTempHtmlPathname = str_replace('//', '/', $pellTempDir.'/'.$pellOpen.'.html');
$newTempTxtPathname = str_replace('//', '/', $pellTempDir.'/'.$pellOpen.'.txt');
$newHtmlPathname = str_replace($pellOpenFileExtension, 'html', $pellOpenFile);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Function by Justin Cook...
  // / http://www.justin-cook.com/2006/03/31/php-parse-a-string-between-two-strings/
function get_string_between($string, $start, $end){
  $string = ' ' . $string;
  $ini = strpos($string, $start);
  if ($ini == 0) return '';
  $ini += strlen($start);
  $len = strpos($string, $end, $ini) - $ini;
  return substr($string, $ini, $len); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to delete a document using the Pell editor.
if (isset($_POST['deleteFile']) && $deleteFile !== '') {
  $deleteFilePath = $CloudUsrDir.'/'.$deleteFile;
  if (file_exists($deleteFilePath)) {
    $txt = ('OP-Act: Deleting '.$deleteFile.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    @unlink($deleteFilePath); }
  if (!file_exists($deleteFilePath)) {
    $txt = ('OP-Act: Deleted '.$deleteFile.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($txt."\n"); }
  if (file_exists($deleteFilePath)) {
    $txt = ('ERROR!!! HRC2PellApp73 Could not delete '.$deleteFile.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    echo nl2br($txt."\n"); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the selected file for the save input textbox.
if (isset($_POST['pellOpen']) && $pellOpen !== '') {
  $fileEcho = $pellOpen;
  $fileEcho1 = $pellOpen; }
if (isset($_POST['filename']) && $filename !== '') {
  $fileEcho = $filename;
  $fileEcho1 = $filename; }
// / -----------------------------------------------------------------------------------

// / ----------------------------------------------------------------------------------- 
// / The following code cleans the extensions (ex: .doc before .docx to avoid false positive w/ leftover "x")
foreach ($pellDocArray as $extCleaner) {
  $extCleaner = '.'.$extCleaner;
  if ($extCleaner == '.doc') { 
    if (substr($fileEcho, 0, -1) == 'x') { 
      str_replace('.docx', '', $fileEcho); } }
  $fileEcho = str_replace($extCleaner, '', $fileEcho); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
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
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code initializes the document conversion engine.
if ((isset($_POST['pellOpen']) && $pellOpen == '') or (isset($_POST['filename']) && $filename !=='')) {
  if (file_exists('/usr/bin/unoconv')) {
    $txt = ('OP-Act: Verified the document conversion engine on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    exec("pgrep soffice.bin", $DocEnginePID, $DocEngineStatus);
    if (count($DocEnginePID) < 1) {
      exec('/usr/bin/unoconv -l &', $DocEnginePID1); 
      $txt = ('OP-Act: Starting the document conversion engine (PID '.$DocEnginePID1[1].') on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      exec("pgrep soffice.bin", $DocEnginePID, $DocEngineStatus); } }
  if (!file_exists('/usr/bin/unoconv')) {
    $txt = ('ERROR!!! HRC2PellApp30, Could not verify the document conversion engine on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($txt."\n"); }
  if (count($DocEnginePID) >= 1) {
    $txt = ('OP-Act, The document conversion engine PID is '.$DocEnginePID[1]);
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code opens files from a users Cloud drive and presents them to Pell for editing.
if (isset($_POST['pellOpen']) && $pellOpen !== '') {
  if (!file_exists($pellOpenFile)) {
    $txt = ('ERROR!!! HRC2PellApp89, Could not load '.$pellOpen.' into memory on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($txt."\n"); }
  if (file_exists($pellOpenFile)) {
    $pellOpenFileTime = date("F d Y H:i:s.",filemtime($pellOpenFile)); 
    // / Code to handle opening .txt files.
    if (in_array($pellOpenFileExtension, $pellDocs1)) {
      $pellOpenFileData = str_replace('<?', '', file_get_contents($pellOpenFile));
      $pellOpenFileDataArr = file($pellOpenFile);
      $pellOpenFileTime = date("F d Y H:i:s",filemtime($pellOpenFile)); 
      $txt = ('OP-Act: Copied contents of '.$pellOpen.' into memory on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
    // / Code for opening .rtf files.
    if (in_array($pellOpenFileExtension, $pellDocs4)) {
      if (!file_exists('/var/www/html/HRProprietary/HRCloud2/Applications/Pell/dist/rtf-html-php.php')) {
        echo nl2br('ERROR!!! HRC2PellApp114, Cannot process the rtf conversion engine file (rtf-html-php.php).'."\n"); 
        die (); }
      else {
        require ('/var/www/html/HRProprietary/HRCloud2/Applications/Pell/dist/rtf-html-php.php'); }
      $reader = new RtfReader();
      $rtfDATA = str_replace('<?', '', file_get_contents($pellOpenFile)); 
      $result = $reader->Parse($rtfDATA);
      if ($result == TRUE) {
        $txt = ('OP-Act: Copied contents of '.$pellOpen.' into memory on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
        $formatter = new RtfHtml();
        $pellOpenFileData = $formatter->Format($reader->root); }
      if ($result !== TRUE) {
        $txt = ('ERROR!!! HRC2PellApp128 Could not copy the contents of '.$pellOpen.' into memory on '.$Time.'!');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo nl2br($txt."\n"); } }
    // / Code for opening .odt, .doc and .docx files.
    if (in_array($pellOpenFileExtension, $pellDocs8)) {
      $txt = ('OP-Act: Executing "unoconv -o '.$newTempHtmlPathname.' -f '.$pellOpenFile.'" on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      exec("unoconv -o $newTempHtmlPathname -f $pellOpenFile");
      if (!file_exists($newTempHtmlPathname)) {
        $txt = ('ERROR HRC2PellApp195, could not convert the selected file on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        die($txt); }
      $pellOpenFileData = file_get_contents($newTempHtmlPathname);
      $junk = get_string_between($pellOpenFileData, '<!DOCTYPE HTML', '"ltr">');
      $pellOpenFileData = str_replace('<!DOCTYPE HTML'.$junk.'"ltr">', '', $pellOpenFileData);
      $junk = null;
      unset($junk);
      $pellOpenFileData = str_replace('</body>', '', $pellOpenFileData);
      $pellOpenFileData = str_replace('</html>', '', $pellOpenFileData);
      $pellOpenFileData = str_replace('<?', '', $pellOpenFileData);
      $pellOpenFileDataArr = file($newTempHtmlPathname);
      $pellOpenFileTime = date("F d Y H:i:s",filemtime($newTempHtmlPathname)); 
      $txt = ('OP-Act: Copied contents of '.$pellOpen.' into memory on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a file is saved.
if (isset($_POST['filename']) && $filename !== '' && isset($_POST['extension']) && $extesion !== '') {
  // / The following code starts the document conversion engine if an instance is not already running.
  if (file_exists($pellTempFile) && isset($filename) && isset($extension)) {
    if (in_array($extension, $pellDocs1)) {
      copy($pellTempFile, $newPathname); }
    if (in_array($extension, $pellDocs8)) {
      $txt = ("OP-Act, Executing \"unoconv -o $newPathname -f $extension $pellTempFile\" on ".$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);      
      // / For some reason files take a moment to appear after being created with Unoconv.
      $stopper = 0;
      exec("unoconv -o $newPathname -f $extension $pellTempFile");
      $stopper++;
      if ($stopper == 10) {
        $txt = 'ERROR!!! HRC2PellApp53, The converter timed out while copying your file. ';
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
        echo nl2br($txt."\n");
        unlink($pellTempFile);
        die($txt); } } }
  if (file_exists($newPathname)) {
    $txt = ('OP-Act, Created '.$newPathname.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($txt."\n"); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code captures any errors generated during execution and logs them/returns them to the user.
if (is_array($returnDATA)) {
  $txt = ('OP-Act, The conversion engine returned the following on '.$Time.':');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);                
  foreach($returnDATA as $returnDATALINE) {
    $txt = ($returnDATALINE);
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code cleans up any lingering temp files. 
if (file_exists($pellTempFile)) {
  @unlink($pellTempFile);
  if (file_exists($pellTempFile)) {
    $txt = ('ERROR!!! HRC2PellApp87, There was a problem cleaning temporary Pell data on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    echo nl2br($txt."\n"); }
  if (!file_exists($pellTempFile)) {
    $txt = ('OP-Act, Deleted temporary Pell data on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code reloads the page as-needed so that recently saved files appear in the load files menu.
if (isset($filename) && $filename !== '' && isset($extension) && $extesion !== '') {
  echo('<script>window.location.href = "'.$URL.'/HRProprietary/HRCloud2/Applications/Pell/Pell.php'.'";</script>'); }
// / -----------------------------------------------------------------------------------
