<!DOCTYPE HTML>
<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Teams
App Version: 0.6 (3-24-2017 12:30)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for communicating with team-mates.
App Integration: 1 (True)
HRCLOUD2-PLUGIN-END
//*/

?>
<script src="_SCRIPTS/sorttable.js"></script>
<script type="text/javascript">
// / Javascript to clear the messenger text input field onclick.
    function Clear() {    
      document.getElementById("messengerInput").value= ""; }
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
if ($teamsHeaderDivNeeded == 'true') {
  echo nl2br('<div id=\'TeamsHeaderDiv\' name=\'TeamsHeaderDiv\' align=\'center\'><h3>Teams</h3><hr /></div>'); }

if ($teamsGreetingDivNeeded == 'true') {
  echo nl2br('<div id="TeamsGreetingDiv" name="TeamsGreetingDiv"><h2>'.$teamsGreetings[$greetingKey].'</h2>');
  echo nl2br('<p>'.$emptyTeamsECHO.'</p></div>'); }

if ($newTeamDivNeeded == 'true') {
  echo nl2br('<div id="newTeamsDiv" name="newTeamsDiv"><form method="post" action="Teams.php" type="multipart/form-data">'."\n");
  echo nl2br('<input type="text" id="newTeam" name="newTeam" value="'.$teamName.'" onclick="Clear();">'."\n");
  echo ('<textarea id="teamDescription" name="teamDescription" cols="40" rows="5">'.$noteData.'</textarea>'."\n");
  echo nl2br('<select id="newTeamVisibility" name="newTeamVisibility">
    <option value="0">Public</option>
    <option value="1">Private</option>
    </select>'."\n");
  echo nl2br("\n".'<input type="submit" id="newTeamButton" name="newTeamButton" value="New Team"></form></div>'); }

if ($myTeamsDivNeeded == 'true') {
  echo nl2br('<div id="newTeamsDiv" name="newTeamsDiv"><form method="post" action="Teams.php" type="multipart/form-data">'."\n");
  echo nl2br("\n".'<div id="myTeamsList" name="myTeamsList" align="center"><strong>My Teams</strong><hr /></div>');
  echo nl2br('<div align="center">
    <table class="sortable">
    <thead><tr>
    <th>Team</th>
    <th>Delete</th>
    </tr></thead><tbody>'); 
  $myTeamCounter = 0;
  foreach ($teamList as $myTeam) {
    if ($myTeam == '.' or $myTeam == '..' or strpos($myTeam, '.php') == 'false' 
      or $myTeam == '' or $myTeam == '.php') continue; 
    $teamCounter++;
    $myTeamFile = $TeamsDir.$myTeam; 
    $myTeamEcho = str_replace('php', '', $myTeam);
    $myTeamTime = date("F d Y H:i:s.",filemtime($myTeamFile));
    echo nl2br ('<tr><td><strong>'.$myTeamCounter.'. </strong><a href="Teams.php?viewTeam='.$myTeamEcho.'">'.$myTeamEcho.'</a></td>');
    echo nl2br('<td><a href="Notes.php?deleteNote='.$myTeamEcho.'"><img id="delete'.$myTeamCounter.'" name="'.$myTeam.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/deletesmall.png"></a></td>'); 
    echo nl2br('</tr><tbody></table></table>'); } } ?>

<?php
/*
</div><div id="TeamsList" name="TeamsList" align="center"><strong>Teams</strong><hr /></div>
<div align="center">
<table class="sortable">
<thead><tr>
<th>Team</th>
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
</div>
*/

