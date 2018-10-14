<!DOCTYPE HTML>
<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: RSS
App Version: v1.0 (10-13-2018 00:00)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for creating, viewing, and managing RSS feeds!
App Integration: 0 (True)
HRCLOUD2-PLUGIN-END
//*/

if (isset($_POST['showFeed'])) $_GET['showFeed'] = $_POST['showFeed'];
if (isset($_GET['showFeed'])) $noStyles = 1;
if (!isset($_GET['showFeed'])) { 
  $maxStyles = 1; ?>
  <script src="sorttable.js"></script>
  <script type="text/javascript">
  // / Javascript to clear the newFeed text input field onclick.
  function Clear() {    
    document.getElementById("newFeed").value= ""; }
  </script>
  <div id='RSSAPP' name='RSSAPP' align='center'><h3>RSS</h3><hr /><?php }

// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('../../sanitizeCore.php')) die ('</head><body>ERROR!!! HRC2RSSAPP10, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'.PHP_EOL.'</body></html>'); 
else require_once ('../../sanitizeCore.php'); 

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('../../commonCore.php')) die ('</head><body>ERROR!!! HRC2RSSAPP18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'.PHP_EOL.'</body></html>'); 
else require_once ('../../commonCore.php'); 

// / The following code ensures the RSS directory exists and creates it if it does not.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$RSSDir = $InstLoc.'/DATA/'.$UserID.'/.AppData/RSS/';
$RSSDir2 = $CloudUsrDir.'/.AppData/RSS/';
$feedData = '';
$feedTitle = 'New Feed...';
$feedButtonEcho = 'Create Feed';
if (!file_exists($RSSDir)) { 
  $txt = ('OP-Act: Creating user feed directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  mkdir($RSSDir); 
  if (!file_exists($RSSDir)) { 
    $txt = ('ERROR!!! HRC2N19, There was a problem creating the user feed directory on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ($txt); } }
copy($InstLoc.'/index.html', $RSSDir.'index.html'); 
$feedList = scandir($RSSDir, SCANDIR_SORT_DESCENDING);
$newest_feed = $feedList[0];

if (isset($_GET['showFeed'])) {
  require($InstLoc.'/Applications/RSS/RSSLib.php');
  $feedName = str_replace(str_split('\'"[]{};$!#^&%@>*<'), '', $_GET['showFeed']);
  $feedFile = $RSSDir.$feedName.'.txt'; 
  $feedData = trim(file_get_contents($feedFile));
  $feeds = explode(PHP_EOL, $feedData);
  echo('<div align="center"><p><strong>'.$feedName.'</strong></p><hr /></div>');
  showFeeds($feeds);
  die(); } 

if (!isset($_GET['showFeed'])) { 
  // / The following code is performed whenever a user selects to edit a Feed.
  if (isset($_GET['editFeed'])) {
    $feedToEdit = str_replace(str_split('./\'[]{};:$!#^&%@>*<'), '', $_GET['editFeed']);
    $feedName = str_replace(str_split('./\'[]{};:$!#^&%@>*<'), '', $_GET['editFeed']);
    if ($feedToEdit == '') $feedToEdit = 'New Feed-'.$Date;
    if ($feedName == '') $feedName = 'New Feed-'.$Date;
    $feedToEdit = $feedToEdit.'.txt';
    $feedData = @file_get_contents($RSSDir.$feedToEdit);
    $feedData = str_replace('<br />', '', $feedData);
    $feedTitle = $_GET['editFeed'];
    $feedButtonEcho = 'Edit Feed';
    $txt = ('OP-Act: Opening Feed '.$feedToEdit.' for editing on '.$Time.'!'); 
    echo 'Editing <i>'.$feedName.'</i>'; 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

  // / The following code is performed whenever a user selects to delete a Feed.
  if (isset($_GET['deleteFeed'])) {
    $feedToDelete = str_replace(str_split('./\'[]{};:$!#^&%@>*<'), '', $_GET['deleteFeed']);
    $feedToDelete = $feedToDelete;
    $counter = 0;
    while (file_exists($RSSDir.$feedToDelete.'.txt')) {
      if ($counter >= 10) continue;
      @unlink($RSSDir.$feedToDelete.'.txt'); 
      $counter++; }
    while (file_exists($RSSDir2.$feedToDelete.'.txt')) {
      if ($counter >= 10) continue;
      @unlink($RSSDir2.$feedToDelete.'.txt'); 
      $counter++; }
    if (file_exists($RSSDir.$feedToDelete.'.txt') or file_exists($RSSDir2.$feedToDelete.'.txt')){
      $txt = ('ERROR!!! HRC2N86, There was a problem deleting the selected user feed on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    $txt = ('OP-Act: Deleting Feed '.$feedToDelete.' on '.$Time.'!');
    echo 'Deleted <i>'.$feedToDelete.'</i>'; 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

  // / If the RSS directory exists we check that the API POST variables were set.  
  if (is_dir($RSSDir)) {
    // / If the input POSTS are set, we turn them into a feed.
    if (isset($_POST['newFeed'])) {
      $feedName = str_replace(str_split('./\'/[]{};:$!#^&%@>*<'), '', $_POST['newFeed']);
      if (!isset($_POST['feed'])) {
        $txt = ('ERROR!!! HRC2N26, There was no Feed content detected on '.$Time.'!'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        die ($txt); }
      if ($feedName == '' or $_POST['newFeed'] == '') $feedName = 'New Feed-'.$Date; 
      $feed = str_replace(PHP_EOL.PHP_EOL, PHP_EOL, str_replace(PHP_EOL.PHP_EOL.PHP_EOL, PHP_EOL, str_replace(' ', PHP_EOL, str_replace(',', PHP_EOL, str_replace(', ', PHP_EOL, str_replace(str_split('\'"[]{};$!#^&%@>*<'), '', $_POST['feed'])))))); 
      $FeedFile = $RSSDir.$feedName.'.txt'; 
      $MAKEFeedFile = file_put_contents($FeedFile, $feed.PHP_EOL); 
      $txt = ('OP-Act: Feed '.$feedName.' created sucessfully on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      echo nl2br('Created <i>'.$feedName.'</i>'); } 
    // / If the input POSTS are NOT set, we present the user with a New Feed form.
      echo nl2br('<form method="post" action="RSS.php" type="multipart/form-data">'."\n");
      echo nl2br('<input type="text" id="newFeed" name="newFeed" value="'.$feedTitle.'" onclick="Clear();">'."\n");
      echo ('<textarea id="feed" name="feed" cols="40" rows="5">'.$feedData.'</textarea>');
      echo nl2br("\n".'<input type="submit" value="'.$feedButtonEcho.'"></form>'); } ?>
  <br>
  </div><div id="feedList" name="feedList" align="center"><strong>My RSS</strong><hr /></div>
  <div align="center">
    <table class="sortable">
    <thead><tr>
    <th>Feed</th>
    <th>Edit</th>
    <th>Delete</th>
    <th>Last Modified</th>
    </tr></thead><tbody>
    <?php  
    $feedList2 = scandir($RSSDir); 
    $feedCounter = 0;
    foreach ($feedList2 as $feed) { 
      if ($feed == '.' or $feed == '..' or strpos($feed, '.txt') == 'false' or $feed == 'index.html'
       or strpos($feed, '.html') == 'true' or $feed == '' or $feed == '.txt') continue; 
      $feedCounter++;
      $feedFile = $RSSDir.$feed; 
      $feedEcho = str_replace('.txt', '', $feed);
      $feedTime = date("F d Y H:i:s.",filemtime($feedFile));
      echo nl2br ('<tr><td><a href="RSS.php?showFeed='.$feedEcho.'"><strong>'.$feedCounter.'. </strong>  '.$feedEcho.'</a></td>');
      echo nl2br('<td><a href="RSS.php?editFeed='.$feedEcho.'"><img id="edit'.$feedCounter.'" name="'.$feed.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/edit.png"></a></td>');
      echo nl2br('<td><a href="RSS.php?deleteFeed='.$feedEcho.'"><img id="delete'.$feedCounter.'" name="'.$feed.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/deletesmall.png"></a></td>');
      echo nl2br('<td><a><i>'.$feedTime.'</i></a></td></tr>'); } ?>
    <tbody>
    </table>
  </div>
<?php } ?>


