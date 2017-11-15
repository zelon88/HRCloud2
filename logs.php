<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="shortcut icon" href="/HRProprietary/HRCloud2/favicon.ico">
<title>HRCloud2 | Logs </title>
<script type="text/javascript" src="/HRProprietary/HRCloud2/Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="/HRProprietary/HRCloud2/Resources/HRC2-Lib.js"></script>
<?php
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2Logs12, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('commonCore.php')) {
  echo nl2br('ERROR!!! HRC2Logs20, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require('commonCore.php'); }

include('header.php'); ?>
<div id="centerdiv" align='center' style="margin: 0 auto; max-width:815px;">
<?php if ($ShowHRAI == '1') { ?>
<div id="HRAIDiv" style="float: center; ">
  <iframe src="Applications/HRAI/core.php" id="HRAIMini" name="HRAIMini" width="810" height="75" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';"></iframe>
  <div id='HRAIButtons1' name='HRAIButtons1' style="margin-left:15%;">
  <button id='button0' name='button0' class="button" style="float: left; display: block;" onclick="toggle_visibility('button0'); toggle_visibility('button1'); toggle_visibility('button2'); document.getElementById('HRAIMini').style.height = '0px';" >-</button>
  <button id='button1' name='button1' class="button" style="float: left; display: none;" onclick="toggle_visibility('button0'); toggle_visibility('button1'); toggle_visibility('button2'); document.getElementById('HRAIMini').style.height = '75px';" >+</button>
  <button id='button2' name='button2' class="button" style="float: left; display: block;" onclick="toggle_visibility('button0'); toggle_visibility('button2'); toggle_visibility('button3'); document.getElementById('HRAIMini').style.height = '100%';">+</button>
  <button id='button3' name='button3' class="button" style="float: left; display: none;" onclick="toggle_visibility('button0'); toggle_visibility('button2'); toggle_visibility('button3'); document.getElementById('HRAIMini').style.height = '75px';">-</button>
  <button id='button4' name='button4' class="button" style="float: left; display: block;" onclick="window.open('Applications/HRAIMiniGui.php','HRAI','resizable,height=400,width=650'); return false;">++</button>
  <form action="logs.php"><button id="button" name="button5" class="button" style="float:left;" href="#" onclick="toggle_visibility('loadingCommandDiv');">#x21BA</button></form>
  </div>
  <form action="Applications/HRAI/core.php#end" id="Corefile Input" method="post" target="HRAIMini">
  <input type="hidden" name="user_ID" value="<?php echo $user_ID;?>">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <?php if (!isset($input)) {
    $input = ''; } ?>
  <div id='HRAIButtons2' name='HRAIButtons2' style="margin-right:15%;">
  <input type="text" name="input" id="input"  value="<?php echo $input; ?>" onclick="ClearInput();">
  <input id='submitHRAI' type="submit" value="Hello HRAI"></div></form>
</div>
<?php } 
if ($ShowTips == '1' && isset($Tip)) {
  $tipsHeight = '60';
  echo '<p><strong>Tip: </strong>'.$Tip.'</p>'; } ?>
<div id="logsContentsDiv" align='center'>
  <iframe src="DATA/<?php echo $UserID; ?>/.AppData/.index.php" id="logsContents" name="logsContents" width="815px" style="min-height:450px; max-height:950px; padding-top:-4px; padding-left:-4px; border:inset;" onload="document.getElementById('loading').style.display='none';"></iframe>
</div>
</div>
<?php
if ($ShowHRAI == '1') {
  $hraiHeight = '185'; }
if ($ShowHRAI !== '1') {
  $hraiHeight = '80'; } 
$heightAdjuster = $hraiHeight + $tipsHeight; ?>
<script>
;(function($){
  //Resizes the div to the remaining page size.
    $(document).ready(function(){
        $('#logsContents').height( $(window).height() - <?php echo $heightAdjuster; ?> );
        $(window).resize(function(){
            $('#logsContents').height( $(this).height() - <?php echo $heightAdjuster; ?> );
        });
    });
})(jQuery);
</script>
</body>
</html>
