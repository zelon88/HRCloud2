<?php
  // / The following code represents the "All Teams" sidebar section.
  echo (' <div id=\'teamsSidebarDiv\' style=\'display:none;\' class=\'sidebar-content\'>');
  $publicTeams = $teamsList;
  $publicTeamCounter = count($publicTeams);
  $publicTeamCounter1 = 0;
  $lastPublicTeam = 0;
  echo ('<a href=\'?showTeams=1\'><strong>All Teams</strong></a>');
  foreach ($teamsList as $publicTeam) { 
    if ($publicTeamCounter1 >= $publicTeamCounter or in_array($publicTeam, $defaultDirs)) continue;
    $publicTeamFile = $TeamsDir.'/'.$publicTeam.'/'.$publicTeam.'_DATA.php';
    if (!file_exists($publicTeamFile)) continue;    
    include ($TeamsDir.'/'.$publicTeam.'/'.$publicTeam.'_DATA.php');
    if ($TEAM_NAME == '') continue;
    echo ('<a href=\'?joinTeam='.$publicTeam.'\'>'.$TEAM_NAME.'</a>'); 
    $publicTeamCounter1++; 
    $lastPublicTeam = $publicTeam; } 
  if ($publicTeamCounter == 0 or $publicTeamCounter1 == 0) {
    echo ('<a href=\'?joinTeam=view\'>Nothing to show!</a>'); }

  // / The following code represents the "My Teams" sidebar section.
  $myTeams = getMyTeamsQuietly($myTeamsList);
  $myTeamCounter = count($myTeams);
  $myTeamCounter1 = 0;
  $lastMyTeam = 0;
  echo ('<a href=\'?showTeams=1\'><strong>My Teams</strong></a>');
  foreach ($myTeams as $myTeam) { 
    if ($myTeamCounter1 >= $myTeamCounter or $myTeamCounter == 0 or in_array($myTeam, $defaultDirs)) continue;
    $myTeamFile = $TeamsDir.'/'.$myTeam.'/'.$myTeam.'_DATA.php';
    if (!file_exists($myTeamFile)) continue;
    include ($myTeamFile);
    if ($TEAM_NAME == '') continue;
    echo ('<a href=\'?joinTeam='.$myTeam.'\'>'.$TEAM_NAME.'</a>'); 
    $myTeamCounter1++; 
    $lastMyTeam = $myTeam; }
  if ($myTeamCounter == 0 or $myTeamCounter1 == 0) {
    echo ('<a href=\'?joinTeam=view\'>Nothing to show!</a>'); } 
  echo('</div>'); 