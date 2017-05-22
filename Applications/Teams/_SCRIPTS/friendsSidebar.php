<?php
  // / The following code represents the "My Friends" sidebar section.
echo ('<div id=\'friendsSidebarDiv\' style=\'display:none;\' class=\'sidebar-content\'>');
  $myFriends = $FRIENDS;
  $myFriendCounter = count($myFriends);
  $myFriendCounter1 = 0;
  echo ('<a href=\'?showFriends=1\'><strong>My Friends</strong></a>');
  foreach ($myFriends as $myFriend) { 
  if ($myFriendCounter1 >= $myFriendCounter or $myFriendCounter == 0 or $myFriend == '') continue;
    $FriendCacheFile = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS/'.$myFriend.'/'.$myFriend.'.php');
    if (file_exists($FriendCacheFile)) {
      include($FriendCacheFile);
      $friendName = $USER_NAME;
      $friendStatusEcho = '';
      if ($STATUS = 1) {
        $friendStatus = 1; 
        $friendStatusEcho = '<img src=\''.$ResourcesDir.'/online.png'.'\' alt=\''.$friendName.$friendStatusEcho.'\' title=\''.$friendName.$friendStatusEcho.'\'>'; }
      echo ('<a href=\'?viewFriend='.$myFriend.'\'>'.$friendName.$friendStatusEcho.'</a>'); 
    $myFriendCounter1++; } }
  if ($myFriendCounter == 0 or $myFriendCounter1 == 0) {
    echo ('<a href=\'?addFriend=null\'>Nothing to show!</a>'); } 
  echo('</div>'); 