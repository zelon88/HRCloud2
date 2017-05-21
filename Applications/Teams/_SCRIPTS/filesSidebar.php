<?php
  // / The following code represents the "My Friends" sidebar section.
  $myFriends = getMyFriendsQuietly($FriendsList);
  $myFriendCounter = count($myFriends);
  $myFriendCounter1 = 0;
  echo ('<a href=\'?showFriends=1\'><strong>My Friendss</strong></a>');
  foreach ($myFriends as $myFriend) { 
  if ($myFriendCounter1 >= $myFriendCounter or $myFriendCounter == 0 or $myFriend['name'] == '') continue;
    echo ('<a href=\'?viewFriend='.$myFriend['id'].'\'>'.$myFriend['name'].'</a>'); 
    echo ('<a href=\'?viewFriend='.$myFriend['id'].'\'><i>'.$myFriend['description'].'</i></a>'); 
    $myFriendCounter1++; }
  if ($myFriendCounter == 0 or $myFriendCounter1 == 0) {
    echo ('<a href=\'?addFriend=null\'>Nothing to show!</a>'); } 
  echo('</div></div>'); 