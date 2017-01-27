<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Executor
App Version: 1.2 (1-26-2017 10:45)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 command-line for using PHP like it were Bash.
App Integration: 0 (False)
App Permission: 0 (Admin)
HRCLOUD2-PLUGIN-END
//*/

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
error_reporting(E_ALL);
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ExecutorApp26, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }
// / The following code checks if App permission is set to '1' and if the user is an administrator or not.
$initData = file_get_contents('Executor.php');
  if ($UserIDRAW !== 1) {
  	$txt = ('ERROR!!! HRC2ExecutorApp28, A non-administrator attempted to execute the Executor App on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);  
    die($txt); }
?>
<script src="sorttable.js"></script>
<script type="text/javascript">
// / Javascript to clear the newNote text input field onclick.
    function Clear() {    
      document.getElementById("executorInput").value= ""; }
</script>
<div id='executorAPP' name='executorAPP' align='center'><h3>Executor</h3><hr />
<div align="left"><p>Executor is a server-side command-line interpreter for remotely executing bash code on the server. 
  In addition to executing your commands, this tool is also the fastest way to "Execute" (<i>kill/destroy</i>) your server.</p>
<p>Please use this tool with extreme care! Serious server filesystem damage could result!</p></div>
<?php 
$cd = shell_exec('pwd');
if ($cd == '' or !isset($cd)) {
  $cd = '~'; }
if (!isset($_POST['executorInput'])) {  
  $executorValue = 'Execute'; } 
if (isset($_POST['executorInput'])) { 
  $executorValue = $_POST['executorInput']; }
?>
<form action="Executor.php" method="POST">
<p style="text-align:left; margin:15px;"><strong>www-data@www-data-<?php echo $UniqueServerName.':'.$cd; ?>$ </strong></p>
<p><textarea id="executorInput" name="executorInput" value="<?php echo $executorValue; ?>" cols="40" rows="5"></textarea></p>
<p><input type="submit" id="executorSubmit" name="executorSubmit" title="Execute" alt="Execute" value="Execute"></p>
</form>
</div>
<div id="executorOutput" name="executorOutput" align="left" style="margin:15px;">
<hr />
<?php 
if ($_POST['executorInput'] == '') {
  $txt = ('Notice: Executor input cannot be blank. HRC2ExecutorApp69');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die($txt); }
$safeArr1 = array('.','..','tmp','dev','run','sys','etc','boot','sbin','bin','lib','opt','usr',
  'var','root','home','cdrom','lost+found','srv','mnt','media','mysql');
$executorInput = $_POST['executorInput'];
// / Prompt the user when they do anything that requires elevation.
foreach ($safeArr1 as $safeCheck) {
  if (strpos($executorInput, $safeCheck) == 'true') { 
    if (!strpos($executorInput, ' | sudo -S') == 'false') {
      $txt1 = ('ERROR!!! HRC2ExecutorApp64: Could not execute "'.$executorInput.'" on '.$Time.'! Please specify a password with " echo \'password\' | sudo -S " to perform this operation.'); 
      $txt2 = ('ERROR!!! HRC2ExecutorApp64: Please specify a password with <p><i><strong>"echo \'password\' | sudo -S"</i></strong></p> to perform this operation.');
      $MAKELogFile = file_put_contents($LogFile, $txt1.PHP_EOL, FILE_APPEND); 
      die($txt2); } } }
if (strpos($executorInput, 'sudo') == 'false') { 
  if (!strpos($executorInput, ' | sudo -S') == 'false') {
    $txt1 = ('ERROR!!! HRC2ExecutorApp75: Could not execute "'.$executorInput.'" on '.$Time.'! Please specify a password with " echo \'password\' | sudo -S " to perform this operation.'); 
    $txt2 = ('ERROR!!! HRC2ExecutorApp75: Please specify a password with <p><i><strong>"echo \'password\' | sudo -S"</i></strong></p> to perform this operation.');
    $MAKELogFile = file_put_contents($LogFile, $txt1.PHP_EOL, FILE_APPEND); 
    die($txt2); } }
// / Display the selected directory when the user inputs a lonely cd command.
if (strpos($executorInput, 'cd ') == 'true') { 
  $executorInput1 = str_replace('cd ', 'pwd ', $executorInput); 
  $exec1 = shell_exec($executorInput1);
  echo nl2br('Note: When using "cd" the current directory is NOT maintained between page refreshes.'."\n".'To effectively use "cd", consider using "|" or "&&" in your code.'."\n\n");
  echo nl2br($exec1."\n"); }

  $exec = shell_exec($executorInput); 
  echo nl2br($exec."\n");
  $txt = ('OP-Act: Executed "'.$exec.'" on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);

// / echo 'password' | sudo -S cd

?>
</div>
