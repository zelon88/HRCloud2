<?php
echo ('<div id="nav" align="center">
    <div class="nav">
      <ul style="padding-left:115px;">
        <li class="Teams"><a onclick="toggle_visibility(\'teamsSidebarDiv\'); toggle_visibility(\'xteamsSidebarDiv1\');">Teams</a></li>
        <li class="Friends"><a onclick="toggle_visibility(\'friendsDiv\');">Friends</a></li>
        <li class="Files"><a onclick="toggle_visibility(\'filesDiv\');">Files</a></li>
        <li class="dropbtn" style="float:right;" onclick="toggle_visibility(\'hamburgerDropdown\');">&#9776;</li>
      </ul>
    </div>
<div class="dropdown">
  <div id="hamburgerDropdown" style="display:none;" class="dropdown-content">');
      $notificationCounter = count($notificationArray);
      $notificationCounter1 = 0;
      foreach ($notificationArray as $shortNotification) { 
        if ($notificationCounter1 >= $notificationCounter) continue;
        $notificationCounter1++;
        $shortNotification = substr($shortNotification, 0, 25).'...'; 
        echo ('<a href="?ShowNotifications=<?php echo $notificationCounter1; ?>">$shortNotification</a>'); } 
      if ($notificationCounter == 0) { 
        echo ('<a href="?ShowNotifications=0">No new notifications!</a>'); } 
echo('<a href="?ShowSetting=1">Settings</a>
    <a href="?ShowHelp=1">Help</a>
  </div>
</div>
</div>');