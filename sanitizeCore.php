<?php
// / This file is intended to be included in PHP files that require safe sanitization of 
// / supported POST and GET inputs. If you're looking to add code to sanitize additional 
// / POST or GET inputs, you should put it in this file and then require this file into
// / your code project, or app.

// / The following code will sanitize API inputs.
if (isset($_GET['UserDirPOST'])) {
  $_GET['UserDirPOST'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['UserDirPOST']);
  $_POST['UserDirPOST'] = $_GET['UserDirPOST'];
  $_POST['UserDir'] = $_GET['UserDirPOST']; }
if (isset($_GET['UserDir'])) {
  $_GET['UserDirPOST'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['UserDir']);
  $_POST['UserDirPOST'] = $_GET['UserDir'];
  $_POST['UserDir'] = $_GET['UserDir']; }
  
if (isset($_GET['playlistSelected'])) {
  $_GET['playlistSelected'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['playlistSelected']);
  $_POST['playlistSelected'] = $_GET['playlistSelected']; }
if (isset($_POST['playlistSelected'])) {
  $_POST['playlistSelected'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['playlistSelected']);
  $_GET['playlistSelected'] = $_POST['playlistSelected']; }

// / Developers add your code between the following comment lines.....


$your_code_here = null;





// / Developers DO NOT add your code below this comment line.
set_time_limit(0);
?>