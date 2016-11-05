<?php
// / This file is intended to be included in PHP files that require safe sanitization of 
// / supported POST and GET inputs.

// / This file can be called by Apps if needed.

// / The following code will sanitize API inputs.
if (isset($_GET['UserDirPOST'])) {
  $_GET['UserDirPOST'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['UserDirPOST']);
  $_POST['UserDirPOST'] = $_GET['UserDirPOST'];
  $_POST['UserDir'] = $_GET['UserDirPOST']; }
if (isset($_GET['UserDir'])) {
  $_GET['UserDirPOST'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['UserDir']);
  $_POST['UserDirPOST'] = $_GET['UserDir'];
  $_POST['UserDir'] = $_GET['UserDir']; }

set_time_limit(0);
?>