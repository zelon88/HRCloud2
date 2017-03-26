<!DOCTYPE HTML>
<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Teams
App Version: 0.5 (3-24-2017 12:30)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for communicating with team-mates.
App Integration: 1 (True)
HRCLOUD2-PLUGIN-END
//*/

?>
<script src="Scripts/sorttable.js"></script>
<script type="text/javascript">
// / Javascript to clear the newNote text input field onclick.
    function Clear() {    
      document.getElementById("messangeInput").value= ""; }
</script>
<?php
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2TeamsApp27, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2TeamsApp35, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The follwoing code checks if the teamsCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/Applications/Teams/teamsCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2TeamsApp35, Cannot process the HRCloud2 Teams Core file (teamsCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/Applications/Teams/teamsCore.php'); }

// / The following code sets variables for the GUI now that the core and cache files have loaded.
if ($currentUserTeams == '') {
  $teamsGreetings = array('Hi There!', 'Hello!');
  $teamsGreetingsInternational = array('Hi There!', 'Hello!', 'Bonjour!', 'Hola!', 'Namaste!', 'Salutations!', 'Konnichiwa!', 'Bienvenidos!', 'Guten Tag!');
  if ($settingsInternationalGreetings = '1' or $settingsInternationalGreetings == 1) $teamsGreetings = $teamsGreetingsInternational;
  $greetingKey = array_rand($teamsGreetings);
  $emptyTeamsECHO = 'It looks like you aren\'t a part of any Teams yet! Let\'s fix that...'."\n\n".'Check out some of the Teams below,
    or <a href=\'/?newTeamGUI=1\'>Create A New Team.</a>'; }

// / The following code represents the graphical user-interface (GUI).
?>
<div id='TeamsAPP' name='TeamsAPP' align='center'><h3>Teams</h3><hr />
<?php
if (!isset($newTeamGUI)) {
 }
?>
<h2><?php echo $teamsGreetings[$greetingKey]; ?></h2>
<br />
<p><?php echo nl2br($emptyTeamsECHO); ?><p>




<?php

// / The following code is performed whenever a user selects to delete a Note.
if (isset($_GET['deleteNote'])) {
  $noteToDelete = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_GET['deleteNote']);
  $noteToDelete = $noteToDelete;
  unlink($NotesDir.$noteToDelete.'.txt'); 
  $txt = ('OP-Act: Deleting Note '.$noteToDelete.' on '.$Time.'!');
  echo 'Deleted <i>'.$noteToDelete.'</i>'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

// / If the Notes directory exists we check that the API POST variables were set.  
if (is_dir($NotesDir)) {
  // / If the input POSTS are set, we turn them into a note.
  if (isset($_POST['newNote'])) {
    $noteName = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_POST['newNote']);
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

