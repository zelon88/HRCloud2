<!DOCTYPE html>
<html>
<head>
<title>DocumentControl | Logging - Search </title>
<link rel="stylesheet" type="text/css" href="DocConCSS.css">
</head>
<body>
	<div align="center"><h3>Search Results</h3></div>
<hr />
<?php  
require("config.php");
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$SearchRAW = $_POST['search'];
$SearchLower = strtolower($SearchRAW);
if ($SearchRAW == '') {
	?><div align="center"><?php echo nl2br('Please enter a search keyword. s15.'); ?><hr /></div> <?php die(); }
$PendingResCount1 = 0;
$PendingResCount2 = 0;
$ResultFiles = scandir('AppLogs/');
if (isset($SearchRAW)) {       
foreach ($ResultFiles as $ResultFile) {
  if ($ResultFile == '.' or $ResultFile == '..') continue;
    if (is_dir('AppLogs/'.$ResultFile)) { 
      $ResultFile2 = scandir('AppLogs/'.$ResultFile); 
      foreach ($ResultFile2 as $ResultFile3) { 
        if ($ResultFile3 == '.' or $ResultFile3 == '..') continue;
    $PendingResCount1++; 
    $ResultFile1 = 'AppLogs/'.$ResultFile3;
    $ResultRAW = file_get_contents($InstLoc.'/AppLogs/'.$ResultFile.'/'.$ResultFile3);
    $Result = strtolower($ResultRAW);
      if (!preg_match("/$SearchLower/", $Result)) { continue; }
      if (preg_match("/$SearchLower/", $Result)) { 
        $PendingResCount2++;
        echo 'hello';
        ?><a href='<?php echo 'core.php/?UserDirPOST='.$ResultFile3; ?>'><?php echo nl2br($ResultFile3."\n"); ?></a>
        <hr /><?php } } } 
    elseif (!is_dir('AppLogs/'.$ResultFile)) {   
    $PendingResCount1++; 
    $ResultFile1 = 'AppLogs/'.$ResultFile;
    $ResultRAW = file_get_contents('AppLogs/'.$ResultFile1);
    $Result = strtolower($ResultRAW);
      if (!preg_match("/$SearchLower/", $Result)) { continue; }
      if (preg_match("/$SearchLower/", $Result)) { 
        $PendingResCount2++; 
        ?><a href='AppLogs/<?php echo ($ResultFile); ?>'><?php echo nl2br($ResultFile."\n"); ?></a>
        <hr /><?php } } } } ?>
<?php
echo nl2br('Searched '.$PendingResCount1.' files for "'.$SearchRAW.'" and found '.$PendingResCount2.' results on '.$Time.'.'); 
?>
<br>
<hr />
</body>
</html>
