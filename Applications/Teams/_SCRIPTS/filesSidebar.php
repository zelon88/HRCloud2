<?php
  // / The following code represents the "My Files" sidebar section.
echo ('<div id=\'filesSidebarDiv\' style=\'display:none;\' class=\'sidebar-content\'>');
  $myFiles = scandir($UserFilesDir);
  $myFileCounter = count($myFiles);
  $myFileCounter1 = 0;
  echo ('<a href=\'?showFiles=1\'><strong>My Files</strong></a>');
  foreach ($myFiles as $myFile) { 
  if ($myFileCounter1 >= $myFileCounter or $myFileCounter == 0 or $myFile == '' or in_array($myFile, $dangerArr)) continue;
    echo ('<a href=\'?viewFile='.$myFile.'\'>'.$myFile.'</a>'); 
    $myFileCounter1++; }
  if ($myFileCounter == 0 or $myFileCounter1 == 0) {
    echo ('<a href=\'?addFile=view\'>Nothing to show!</a>'); } 
  echo('</div>'); 