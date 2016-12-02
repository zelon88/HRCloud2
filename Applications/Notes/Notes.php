<!DOCTYPE HTML>
<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Notes
App Version: 1.3 (11-26-2016 00:16)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for creating, viewing, and managing notes and to-do lists!
App Integration: 1 (True)
HRCLOUD2-PLUGIN-END
//*/

?>
<script src="sorttable.js"></script>
<script type="text/javascript">
// / Javascript to clear the newNote text input field onclick.
    function Clear() {    
      document.getElementById("newNote").value= ""; }
</script>
<div id='NotesAPP' name='NotesAPP' align='center'><h3>Notes</h3><hr /><?php
 
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

// / The following code ensures the Notes directory exists and creates it if it does not.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$NotesDir = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/Notes/';
$notesList = scandir($NotesDir, SCANDIR_SORT_DESCENDING);
$newest_note = $notesList[0];
$noteData = '';
$noteTitle = 'New Note...';
$noteButtonEcho = 'Create Note';
if (!file_exists($NotesDir)) { 
  $txt = ('OP-Act: Creating user notes directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  mkdir($NotesDir); }
if (!file_exists($NotesDir)) { 
  $txt = ('ERROR!!! HRC2N19, There was a problem creating the user notes directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ($txt); } 

// / The following code is performed whenever a user selects to edit a Note.
if (isset($_GET['editNote'])) {
  $noteToEdit = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editNote']);
  $noteName = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editNote']);
  $noteToEdit = $noteToEdit.'.txt';
  $noteData = @file_get_contents($NotesDir.$noteToEdit);
  $noteData = str_replace('<br />', '', $noteData);
  $noteTitle = $_GET['editNote'];
  $noteButtonEcho = 'Edit Note';
  $txt = ('OP-Act: Opening Note '.$noteToDelete.' for editing on '.$Time.'!'); 
  echo 'Editing <i>'.$noteName.'</i>'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

// / The following code is performed whenever a user selects to delete a Note.
if (isset($_GET['deleteNote'])) {
  $noteToDelete = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['deleteNote']);
  $noteToDelete = $noteToDelete;
  unlink($NotesDir.$noteToDelete.'.txt'); 
  $txt = ('OP-Act: Deleting Note '.$noteToDelete.' on '.$Time.'!');
  echo 'Deleted <i>'.$noteToDelete.'</i>'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

// / If the Notes directory exists we check that the API POST variables were set.  
if (is_dir($NotesDir)) {
  // / If the input POSTS are set, we turn them into a note.
  if (isset($_POST['newNote'])) {
  	$noteName = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['newNote']);
    if (!isset($_POST['note'])) {
      $txt = ('ERROR!!! HRC2N26, There was no Note content detected on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      die ($txt); } 
  	$note = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['note']); 
    $NoteFile = $NotesDir.$noteName.'.txt'; 
    $MAKENoteFile = file_put_contents($NoteFile, $note.PHP_EOL); 
    $txt = ('OP-Act: Note '.$noteName.' created sucessfully on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br('Created <i>'.$noteName.'</i>'); } 
  // / If the input POSTS are NOT set, we present the user with a New Note form.
  	echo nl2br('<form method="post" action="Notes.php" type="multipart/form-data">'."\n");
  	echo nl2br('<input type="text" id="newNote" name="newNote" value="'.$noteTitle.'" onclick="Clear();">'."\n");
  	echo ('<textarea id="note" name="note" cols="40" rows="5">'.$noteData.'</textarea>');
    echo nl2br("\n".'<input type="submit" value="'.$noteButtonEcho.'"></form>'); 
     }
?>
<br>
</div><div id="notesList" name="notesList" align="center"><strong>My Notes</strong><hr /></div>
<div align="center">
<table class="sortable">
<thead><tr>
<th>Note</th>
<th>Edit</th>
<th>Delete</th>
<th>Last Modified</th>
</tr></thead><tbody>
 <?php 
$notesList2 = scandir($NotesDir); 
$noteCounter = 0;
foreach ($notesList2 as $note) {
  if ($note == '.' or $note == '..' or strpos($note, '.txt') == 'false' 
    or $note == '' or $note == '.txt') continue; 
  $noteCounter++;
  $noteFile = $NotesDir.$note; 
  $noteEcho = str_replace('.txt', '', $note);
  $noteTime = date("F d Y H:i:s.",filemtime($noteFile));
  echo nl2br ('<tr><td><strong>'.$noteCounter.'. </strong><a href="Notes.php?editNote='.$noteEcho.'">'.$noteEcho.'</a></td>');
  echo nl2br('<td><a href="Notes.php?editNote='.$noteEcho.'"><img id="edit'.$noteCounter.'" name="'.$note.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/edit.png"></a></td>');
  echo nl2br('<td><a href="Notes.php?deleteNote='.$noteEcho.'"><img id="delete'.$noteCounter.'" name="'.$note.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/deletesmall.png"></a></td>');
  echo nl2br('<td><a><i>'.$noteTime.'</i></a></td></tr>'); } ?>
<tbody>
</table>
</div><?php
