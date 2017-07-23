<!DOCTYPE HTML>
<?php
/*//
HRCLOUD2-PLUGIN-START
App Name: Bookmarks	
App Version: 1.5 (7-23-2017 14:00)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for saving your favorite URL's.
App Integration: 1 (True)
HRCLOUD2-PLUGIN-END
//*/

?>
<script src="sorttable.js"></script>
<script type="text/javascript">
// / Javascript to clear the newBookmark text input field onclick.
    function Clear() {    
      document.getElementById("newBookmark").value= ""; }
</script>
<div id='BookmarksAPP' name='BookmarksAPP' align='center'><h3>Bookmarks</h3><hr /><?php
 
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AL10, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AL18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The following code ensures the Bookmarks directory exists and creates it if it does not.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$BookmarksDir = $InstLoc.'/DATA/'.$UserID.'/.AppData/Bookmarks/';
$BookmarksDir2 = $CloudUsrDir.'/.AppData/Bookmarks/';
$bookmarkData = '';
$bookmarkTitle = 'New Bookmark...';
$bookmarkButtonEcho = 'Create Bookmark';
if (!file_exists($BookmarksDir)) { 
  $txt = ('OP-Act: Creating user bookmarks directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  mkdir($BookmarksDir); }
if (!file_exists($BookmarksDir)) { 
  $txt = ('ERROR!!! HRC2N19, There was a problem creating the user bookmarks directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ($txt); }
copy($InstLoc.'/index.html', $BookmarksDir.'index.html'); 
$bookmarksList = scandir($BookmarksDir, SCANDIR_SORT_DESCENDING);
$newest_bookmark = $bookmarksList[0];

// / The following code is performed whenever a user selects to edit a Bookmark.
if (isset($_GET['editBookmark'])) {
  $bookmarkToEdit = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_GET['editBookmark']);
  $bookmarkName = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_GET['editBookmark']);
  if ($bookmarkToEdit == '') $bookmarkToEdit = 'New Bookmark-'.$Date;
  if ($bookmarkName == '') $bookmarkName = 'New Bookmark-'.$Date;
  $bookmarkToEdit = $bookmarkToEdit.'.txt';
  $bookmarkData = @file_get_contents($BookmarksDir.$bookmarkToEdit);
  $bookmarkTitle = $_GET['editBookmark'];
  $bookmarkButtonEcho = 'Edit Bookmark';
  $txt = ('OP-Act: Opening Bookmark '.$bookmarkToEdit.' for editing on '.$Time.'!'); 
  echo 'Editing <i>'.$bookmarkName.'</i>'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

// / The following code is performed whenever a user selects to delete a Bookmark.
if (isset($_GET['deleteBookmark'])) {
  $bookmarkToDelete = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_GET['deleteBookmark']);
  $bookmarkToDelete = $bookmarkToDelete;
  $counter = 0;
  while (file_exists($BookmarksDir.$bookmarkToDelete.'.txt')) {
    if ($counter >= 10) continue;
    @unlink($BookmarksDir.$bookmarkToDelete.'.txt'); 
    $counter++; }
  while (file_exists($BookmarksDir2.$bookmarkToDelete.'.txt')) {
    if ($counter >= 10) continue;
    @unlink($BookmarksDir2.$bookmarkToDelete.'.txt'); 
    $counter++; }
  if (file_exists($BookmarksDir.$bookmarkToDelete.'.txt') or file_exists($BookmarksDir2.$bookmarkToDelete.'.txt')){
    $txt = ('ERROR!!! HRC2B86, There was a problem deleting the selected user bookmark on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  $txt = ('OP-Act: Deleting Bookmark '.$bookmarkToDelete.' on '.$Time.'!');
  echo 'Deleted <i>'.$bookmarkToDelete.'</i>'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

// / If the Bookmarks directory exists we check that the API POST variables were set.  
if (is_dir($BookmarksDir)) {
  // / If the input POSTS are set, we turn them into a bookmark.
  if (isset($_POST['newBookmark'])) {
  	$bookmarkName = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_POST['newBookmark']);
    if (!isset($_POST['bookmark'])) {
      $txt = ('ERROR!!! HRC2N26, There was no Bookmark content detected on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      die ($txt); } 
    if ($bookmarkName == '' or $_POST['newBookmark'] == '') { 
      $bookmarkName = 'New Bookmark-'.$Date; }
  	$bookmark = str_replace(str_split('[]{};$!#^&%@>*<'), '', $_POST['bookmark']); 
    $BookmarkFile = $BookmarksDir.$bookmarkName.'.txt'; 
    $MAKEBookmarkFile = file_put_contents($BookmarkFile, $bookmark); 
    $txt = ('OP-Act: Bookmark '.$bookmarkName.' created sucessfully on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br('Created <i>'.$bookmarkName.'</i>'); } 
  // / If the input POSTS are NOT set, we present the user with a New Bookmark form.
  	echo nl2br('<form method="post" action="Bookmarks.php" type="multipart/form-data">'."\n");
  	echo nl2br('<input type="text" id="newBookmark" name="newBookmark" value="'.$bookmarkTitle.'" onclick="Clear();">'."\n");
  	echo nl2br('<input type="text" id="bookmark" name="bookmark" value="'.$bookmarkData.'">'."\n");
    echo nl2br("\n".'<input type="submit" value="'.$bookmarkButtonEcho.'"></form>'); }
?>
<br>
</div><div id="bookmarksList" name="bookmarksList" align="center"><strong>My Bookmarks</strong><hr /></div>
<div align="center">
<table class="sortable">
<thead><tr>
<th>Bookmark</th>
<th>Edit</th>
<th>Delete</th>
<th>Last Modified</th>
</tr></thead><tbody>
 <?php 
$bookmarksList2 = scandir($BookmarksDir); 
$bookmarkCounter = 0;
foreach ($bookmarksList2 as $bookmark) {
  if ($bookmark == '.' or $bookmark == '..' or strpos($bookmark, '.txt') == 'false' or $bookmark == 'index.html' 
    or strpos($bookmark, '.html') == 'true' or $bookmark == '' or $bookmark == '.txt') continue; 
  $bookmarkCounter++;
  $bookmarkFile = $BookmarksDir.$bookmark;
  $bookmarkDATA = file_get_contents($bookmarkFile); 
  $bookmarkEcho = str_replace('.txt', '', $bookmark);
  $bookmarkTime = date("F d Y H:i:s.",filemtime($bookmarkFile));
  echo nl2br ('<tr><td><strong>'.$bookmarkCounter.'. </strong><a target="_blank" href="'.$bookmarkDATA.'">'.$bookmarkEcho.'</a></td>');
  echo nl2br('<td><a href="Bookmarks.php?editBookmark='.$bookmarkEcho.'"><img id="edit'.$bookmarkCounter.'" name="'.$bookmark.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/edit.png"></a></td>');
  echo nl2br('<td><a href="Bookmarks.php?deleteBookmark='.$bookmarkEcho.'"><img id="delete'.$bookmarkCounter.'" name="'.$bookmark.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/deletesmall.png"></a></td>');
  echo nl2br('<td><a><i>'.$bookmarkTime.'</i></a></td></tr>'); } ?>
<tbody>
</table>
</div><?php
