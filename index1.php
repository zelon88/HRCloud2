
<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 | Home </title>
<script type="text/javascript" src="/HRProprietary/HRCloud2/Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block'; }
    function Clear() {    
      document.getElementById("input").value= ""; }
</script>
<?php 
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2Index1-10, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2Index1-19, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/appCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AL34, Cannot process the HRCloud2 App Core file (appCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/appCore.php'); }

?>

<?php include('/var/www/html/HRProprietary/HRCloud2/header.php'); ?>

<div id="centerdiv" align='center' style="margin: 0 auto; max-width:815px;">
<?php if ($ShowHRAI == '1') {  ?>
<div id="HRAIDiv" style="float: center; ">
  <iframe src="Applications/HRAI/core.php" id="HRAIMini" name="HRAIMini" width="810" height="75" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';"></iframe>
  <div id='HRAIButtons1' name='HRAIButtons1' style="margin-left:15%;">
  <button id='button0' name='button0' class="button" style="float: left; display: block;" onclick="toggle_visibility('button0'); toggle_visibility('button1'); toggle_visibility('button2'); document.getElementById('HRAIMini').style.height = '0px';" >-</button>
  <button id='button1' name='button1' class="button" style="float: left; display: none;" onclick="toggle_visibility('button0'); toggle_visibility('button1'); toggle_visibility('button2'); document.getElementById('HRAIMini').style.height = '75px';" >+</button>
  <button id='button2' name='button2' class="button" style="float: left; display: block;" onclick="toggle_visibility('button0'); toggle_visibility('button2'); toggle_visibility('button3'); document.getElementById('HRAIMini').style.height = '100%';">+</button>
  <button id='button3' name='button3' class="button" style="float: left; display: none;" onclick="toggle_visibility('button0'); toggle_visibility('button2'); toggle_visibility('button3'); document.getElementById('HRAIMini').style.height = '75px';">-</button>
  <button id='button4' name='button4' class="button" style="float: left; display: block;" onclick="window.open('HRAIMiniGui.php','HRAI','resizable,height=400,width=650'); return false;">++</button>
  <form action="index1.php"><button id="button" name="button5" class="button" style="float:left;" href="#" onclick="toggle_visibility('loadingCommandDiv');">&#x21BA</button></form>
  </div>
  <form action="Applications/HRAI/core.php#end" id="Corefile Input" method="post" target="HRAIMini">
  <input type="hidden" name="user_ID" value="<?php echo $UserID;?>">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <?php if (!isset($input)) {
    $input = ''; } ?>
  <div id='HRAIButtons2' name='HRAIButtons2' style="margin-right:15%;">
  <input type="text" name="input" id="input"  value="<?php echo $input; ?>" onclick="Clear();">
  <input id='submitHRAI' type="submit" value="Hello HRAI"></div></form>
</div>
<script type="text/javascript">
document.getElementById("HRAIMini").submit;
</script>
<?php } ?>
<div id="cloudContentsDiv" align='center' style="width:404px; padding-top: 5px;">
<div id="filesOverview" name="filesOverview" style="float:left; height:160px; width:195px; border:inset; margin-bottom:2px;">
<div align="left" style="margin-left: 10px;"><p><h3>Files</h3></div>
  <div id="filesOverview1" name="fileOverview1">
    <form action="index2.php">
    <p><input type="submit" value="Go To Drive"></p></form>
    <p>Recent Files: <a href="index2.php"><i><?php echo substr($random_file, 0, 20); ?></i></a></p>
  </div>
</div>
<div id="appsOverview" name="appsOverview" style="float:right; height:160px; width:195px; border:inset; margin-bottom:2px;">
<div align="left" style="margin-left: 10px;"><p><h3>Apps</h3></div>
  <div id="appsOverview1" name="appsOverview1">
    <form action="appLauncher.php">
    <p><input type="submit" value="Go To Apps"></p></form>
    <p>Recent Apps: <a href="appLauncher.php"><i><?php echo substr($random_app, 0, 20); ?></i></a></p>
  </div>
</div>
<div align="center" id="<?php echo $appCounter; ?>Overview" name="<?php echo $appCounter; ?>Overview" style="float:left; height:160px; width:195px; border:inset; margin-bottom:2px;">
<div align="left" style="margin-left: 20px;"><p><h3>Notes</h3></div>  
  <div id="notesOverview1" name="notesOverview1">
    <p><input type="submit" value="Launch Notes" onclick="window.open('Applications/Notes/Notes.php','Notes','resizable,height=400,width=650'); return false;"></p>
    <p>Recent Notes: <a onclick="window.open('Applications/Notes/Notes.php?editNote=<?php echo $random_note; ?>','Notes','resizable,height=400,width=650'); return false;" href="Applications/Notes/Notes.php?editNote=<?php echo $random_note; ?>"><i></i><?php echo substr($random_note, 0, 20); ?></a></p>
  </div>
<?php $appCounter++; ?>
</div>
<div align="center" id="<?php echo $appCounter; ?>overview" name="<?php echo $appCounter; ?>overview" style="float:right; height:160px; width:195px; border:inset;">
<div align="left" style="margin-left: 20px;"><p><h3>Contacts</h3></div>
  <div id="contactsOverview" name="contactsOverview">
  <p><input type="submit" value="Launch Contacts" onclick="window.open('Applications/Contacts/Contacts.php','Contacts','resizable,height=400,width=650'); return false;"></p>
  <p>Recent Contacts: <a onclick="window.open('Applications/Contacts/Contacts.php?editContact=<?php echo $random_contact; ?>','Contacts','resizable,height=400,width=650'); return false;" href="Applications/Contacts/Contacts.php?editContact=<?php echo $random_contact; ?>"><i></i><?php echo substr($random_contact, 0, 20); ?></a></p>
  </div>
</div>
</div>
</div>
</body>
</html>