<?php
  // / The following code represents the "All Teams" sidebar section.
  echo (' <div id=\'teamsSidebarDiv\' style=\'display:none;\' class=\'sidebar-content\'>');
  $publicTeams = $teamsList;
  $publicTeamCounter = count($publicTeams);
  $publicTeamCounter1 = 0;
  echo ('<a href=\'?showTeams=1\'><strong>All Teams</strong></a>');
  foreach ($teamsList as $publicTeam) { 
    if ($publicTeamCounter1 >= $publicTeamCounter or in_array($publicTeam, $defaultDirs)) continue;
    include ($TeamsDir.'/'.$publicTeam.'/'.$publicTeam.'_DATA.php');
    echo ('<a href=\'?joinTeam='.$publicTeam.'\'><'.$TEAM_NAME.'</a>'); 
    echo ('<a href=\'?joinTeam='.$publicTeam.'\'><i>'.$TEAM_DESCRIPTION.'</i></a>'); 
    $publicTeamCounter1++; } 
  if ($publicTeamCounter == 0 or $publicTeamCounter1 == 0) {
    echo ('<a href=\'?joinTeam=view\'>Nothing to show!</a>'); }

  // / The following code represents the "My Teams" sidebar section.
  $myTeams = getMyTeamsQuietly($myTeamsList);
  $myTeamCounter = count($myTeams);
  $myTeamCounter1 = 0;
  echo ('<a href=\'?showTeams=1\'><strong>My Teams</strong></a>');
  foreach ($myTeams as $myTeam) { 
    if ($myTeamCounter1 >= $myTeamCounter or $myTeamCounter == 0 or $myTeam['name'] == '') continue;
    echo ('<a href=\'?joinTeam='.$myTeam['id'].'\'>'.$myTeam['name'].'</a>'); 
    echo ('<a href=\'?joinTeam='.$myTeam['id'].'\'><i>'.$myTeam['description'].'</i></a>'); 
    $myTeamCounter1++; }
  if ($myTeamCounter == 0 or $myTeamCounter1 == 0) {
    echo ('<a href=\'?joinTeam=view\'>Nothing to show!</a>'); } 
  echo('</div>'); 