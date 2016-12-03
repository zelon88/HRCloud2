
 | <img id='clipboardButton' name='clipboardButton' title="Clipboard" alt="Clipboard" onclick="toggle_visibility('ClipboardOptionsDiv');" src='Resources/clipboard.png'/>

<?php 

// / The following code controls the creation and management of a users clipboard cache file.
if (isset($_POST['clipboard'])) {
  if (!is_array($_POST['clipboardSelected'])) {
    $_POST['clipboardSelected'] = array($_POST['clipboardSelected']); } 
  $clipboard = str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboard']));
  $txt = ('OP-Act: Initiated Clipboard on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $UserClipboard = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.clipboard.php';
  $opCounter = 0;
  include($UserClipboard);
  $opCounter = $clipboardArray['opCounter'];
  $opCounter++;
  $txt = '';
  $MAKEClipboardFile = file_put_contents($UserClipboard, $txt.PHP_EOL , FILE_APPEND); 
  $copyCounter = 0;
  if (isset($_POST['clipboardCopy'])) {
    $_POST['clipboardCopy'] = str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardCopy']));
    if (!isset($_POST['clipboardSelected'])) {
      $txt = ('ERROR!!! HRC21018, No file selected on '.$Time.'!');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      die($txt); }
    foreach ($_POST['clipboardSelected'] as $clipboardSelected) {
      $clipboardSelected = str_replace(str_split('\\/[]{};:>$#!&* <'), '', $clipboardSelected);
      $CopyDir = str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardCopyDir'])); 
      $txt = ('OP-Act: User selected to Copy an item to Clipboard on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      if ($copyCounter == 0) {
        $clipboardArray = '<?php $clipboardArray = array(\'type\'=>\'filecopy\', \'opCounter\'=>\''.$opCounter.'\', \'selected\'=>\''.$CopyDir.$clipboardSelected.'\'';
        $MAKEClipboardFile = file_put_contents($UserClipboard, $clipboardArray.PHP_EOL , FILE_APPEND); } 
      if ($copyCounter > 0) { 
        $clipboardArray = ', \''.$CopyDir.$clipboardSelected.'\'';
        $MAKEClipboardFile = file_put_contents($UserClipboard, $clipboardArray.PHP_EOL , FILE_APPEND); }
      $copyCounter++; } 
    $clipboardArray = '); ?>';
    $MAKEClipboardFile = file_put_contents($UserClipboard, $clipboardArray.PHP_EOL , FILE_APPEND); } 

  if (isset($_POST['clipboardPaste'])) {
    $_POST['clipboardPaste'] = str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardPaste']));
    if (!isset($_POST['clipboardPasteDir'])) {
      $txt = ('ERROR!!! HRC21018, No file selected on '.$Time.'!');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      die($txt); } 
    $PasteDir = (str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardPasteDir'])).'/');   
    $txt = ('OP-Act: User selected to Paste files from Clipboard to '.$PasteDir.' on '.$Time.'.');
    echo nl2br($txt);
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    require ($UserClipboard);
$txt = $clipboardArray['selected'];
     $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
 } }
