<!DOCTYPE HTML>
<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Teams
App Version: v0.8.2.4 (5-13-2017 00:00)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for communicating with team-mates.
App Integration: 1 (True)
HRCLOUD2-PLUGIN-END
//*/

?>
<script src="_SCRIPTS/sorttable.js"></script>
<script src="_SCRIPTS/clearField1.js"></script>
<script src="_SCRIPTS/common.js"></script>
<link rel='stylesheet' type='text/css' href='_SCRIPTS/style.php' />
<?php

// / The follwoing code checks if the teamsCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/Applications/Teams/teamsCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2TeamsApp35, Cannot process the HRCloud2 Teams Core file (teamsCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/Applications/Teams/teamsCore.php'); }

if ($headerDivNeeded == 'true') {
include($headerFile); }

// / The following code represents the graphical user-interface (GUI).
if ($teamsHeaderDivNeeded == 'true') {
  echo ('<div id=\'TeamsHeaderDiv\' name=\'TeamsHeaderDiv\' align=\'center\'><h3>Teams</h3><hr /></div>'); }

if ($teamsGreetingDivNeeded == 'true') {
  $emptyTeamsECHO = '<p>It looks like you aren\'t a part of any Teams yet! Let\'s fix that...</p>'."\n\n".'<p>Check out some of the Teams below, or 
    <a id="showNewTeams1" name="showNewTeams1" style="border: 1px solid '.$color.'; border-radius: 6px;" onclick="toggle_visibility(\'xNewTeams1\'); toggle_visibility(\'newTeamsDiv\');">Create A New Team</a></p>'; 
  $myTeamsDivNeeded = 'false'; 
  echo ('<div id="TeamsGreetingDiv" name="TeamsGreetingDiv" align="center"><h2>'.$teamsGreetings[$greetingKey].'</h2>');
    if (count($myTeamsList) < 1) {
  echo ('<div align="center" style="width:90%; float:center; cursor:pointer;">'.$emptyTeamsECHO.'</div></div>'); } }

if ($newTeamDivNeeded == 'true') {
  echo ('<div align=\'center\'><div id="newTeamsDiv" name="newTeamsDiv" align="center" style="width:65%; display:none; border: 1px solid '.$color.'; border-radius: 6px;">
    <img title="Close \'New Teams\'" alt="Close \'New Teams\'" id="xNewTeams1" name="xNewTeams1" style="float:right; display:none;" onclick="toggle_visibility(\'newTeamsDiv\'); toggle_visibility(\'xNewTeams1\');" src="_RESOURCES/x.png">
    <form method="post" action="Teams.php" type="multipart/form-data"><h4>New Team</h4>');
  echo nl2br('<input type="text" id="newTeam" name="newTeam" value="'.$newTeamNameEcho.'" onclick="Clear1();">'."\n");
  echo nl2br('<textarea id="teamDescription" name="teamDescription" cols="40" rows="5" onclick="Clear2();">'.$newTeamDescriptionEcho.'</textarea>'."\n");
  echo nl2br('<select id="newTeamVisibility" name="newTeamVisibility">
    <option value="0">Public</option>
    <option value="1">Private</option>
    </select>'."\n");
  echo nl2br('<input type="submit" id="newTeamButton" name="newTeamButton" value="New Team"></form></div></div>'."\n"); }

if ($teamsDivNeeded == 'true') { 

}

if ($friendsDivNeeded == 'true') { 

}

if ($filesDivNeeded == 'true') { 

}

if (isset($friendToAdd) && $friendToAdd !== '') {
  addFriend($friendToAdd); }

if (isset($userToEdit) && $userToEdit !== '') {
  editUser($userToEdit); }

if (isset($newTeamName) && $newTeamName !== '') {
  createNewTeam($newTeamName); }

if (isset($teamToEdit) && $teamToEdit !== '') {
  editTeam($teamToEdit); }

if (isset($teamToDelete) && $teamToDelete !== '') {
  deleteTeam($teamToDelete); }

if (isset($adminAddUserToTeam) && isset($adminTeamToAdd)) {
  adminAddUserToTeam($adminAddUser, $adminTeamToAdd); }

if (isset($adminRemoveUser) && isset($adminTeamToRemove)) {
  adminRemoveUser($adminRemoveUser, $adminTeamToRemove); }

if (isset($teamToJoin) && $teamToJoin !== '') {
  joinTeam($teamToJoin); }

if (isset($newSubTeam) && $newSubTeam !== '' && isset($teamToJoin) && $teamToJoin !== '') {
  createNewSubTeam($newSubTeam, $subTeamUsers); }

if (isset($subTeamToJoin) && $subTeamToJoin !== '' && isset($teamToJoin) && $teamToJoin !== '') {
  joinSubTeam($teamToJoin, $subTeamToJoin); }



if ($myTeamsDivNeeded == 'true') {
  getMyTeams($myTeamsList); }

if ($teamsDivNeeded == 'true') {
  getPublicTeams($teamsList); } 

