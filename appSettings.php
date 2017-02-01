<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>HRCLoud2 | Application Settings</title>
<?php
// / -----------------------------------------------------------------------------------
// / The follwoing code checks for required core files and terminates if they are missing.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AppSettings11, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AppSettings19, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/compatibilityCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AppSettings19, Cannot process the HRCloud2 Compatibility Core file (compatibilityCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('/var/www/html/HRProprietary/HRCloud2/compatibilityCore.php'); }

// / -----------------------------------------------------------------------------------
// / Prepare the $SaltHash.
$SaltHash = $SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Set the echo value for the "Data Comrpession" option.
if ($DataCompression == '0' or $DataCompression == '' or !isset($DataCompression)) {
  $DCEcho = 'Disabled'; }
if ($DataCompression == '1') {
  $DCEcho = 'Enabled (Automatic)'; }
if ($DataCompression == '2') {
  $DCEcho = 'Enabled (High Performance)'; }
if ($DataCompression == '3') {
  $DCEcho = 'Enabled (High Capacity)'; }  
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Set the echo value for the "Color Scheme" option.
if ($ColorScheme == '1') {
  $CSEcho = 'Blue (Default)'; }
if ($ColorScheme == '2') {
  $CSEcho = 'Red'; }
if ($ColorScheme == '3') {
  $CSEcho = 'Green'; } 
if ($ColorScheme == '4') {
  $CSEcho = 'Grey'; }
if ($ColorScheme == '5') {
  $CSEcho = 'Black'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the show HRAI input field.
if ($ShowHRAI == '1') {
  $SHRAIEcho = 'Enabled'; }
if ($ShowHRAI !== '1') {
  $SHRAIEcho = 'Disabled'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the virus input field.
if ($VirusScan == '1') {
  $VSEcho = 'Enabled'; }
if ($VirusScan !== '1') {
  $VSEcho = 'Disabled'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the WordPress Integration input field.
if ($WordPressIntegration == '1') {
  $WPIEcho = 'Enabled'; }
if ($ShowHRAI == '0') {
  $WPIEcho = 'Disabled'; }
// / -----------------------------------------------------------------------------------
?>
</head>
<body>
<div align="center">
<h3>HRCloud2 Settings</h3>
<hr />
</div>
<div align='left'>
<form action="SAVEappSettings.php" method="post" name='NEWAppSettings' id='NEWAppSettings'> 

<p alt="Change the HRCloud2 color scheme." title="Change the HRCloud2 color scheme." style="padding-left:15px;"><strong>1.</strong> Color Scheme: </p>
  <p><select id="NEWColorScheme" name="NEWColorScheme" style="padding-left:30px; width:100%;"></p>
  <option value="<?php echo $ColorScheme; ?>">Current (<?php echo $CSEcho; ?>)</option>
  <option value="1">Blue (Default)</option>
  <option value="2">Red</option>
  <option value="3">Green</option>
  <?php // ADD NUMBER 4 NEXT!!!!! ?>
  <option value="5">Black</option>
</select></p>

<p alt="Show or Hide HRAI at the top of most windows." title="Show or Hide HRAI at the top of most windows." style="padding-left:15px;"><strong>2.</strong> HRAI Load Balancing Personal Assistant: </p>
  <p><select id="NEWShowHRAI" name="NEWShowHRAI" style="padding-left:30px; width:100%;">
  <option value="<?php echo $ShowHRAI; ?>">Current (<?php echo $SHRAIEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select></p>

<p alt="Delete all cache and temporary data related to your HRCloud2 user account. (Will NOT delete uploaded data or user content)" title="Delete all cache and temporary data related to your user account." style="padding-left:15px;"><strong>3.</strong> Clear User Cache Files: </p>
  <a style="padding-left:10%;">
    <input type='submit' name='ClearCache' id='ClearCache' value='Clear User Cache' style="padding-left:30px; padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p>

<?php
if ($UserIDRAW == 1) { ?>
<div align="center"><h3>Admin Settings</h3></div>
<hr />

<p alt="Options for updating and maintainging HRCloud2." title="Options for updating and maintainging HRCloud2." style="padding-left:15px;"><strong>4.</strong> System Update </p>
 <p style="float:center; padding-left:10%;">Automatic Update Options: </p>
 <p style="float:center; padding-left:10%;"><input type='submit' name='AutoUpdate' id='AutoUpdate' value='Automatic Update' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p>
 <p style="float:center; padding-left:10%;">Manual Update Options: </p>
 <p style="float:center; padding-left:10%;">
  <input type='submit' name='AutoDownload' id='AutoDownload' value='Download Update' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type='submit' name='AutoInstall' id='AutoInstall' value='Install Update' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type='submit' name='AutoClean' id='AutoClean' value='Clean Update' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type='submit' name='CheckCompatibility' id='CheckCompatibility' value='Compat Check' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p>

<p alt="Options for performing security scans on the server with ClamAV." title="Options for performing security scans on the server with ClamAV." style="padding-left:15px;"><strong>5.</strong> Virus Scanning (Requires ClamAV on server): </p>
  <p><select id="NEWVirusScan" name="NEWVirusScan" style="width:100%;"><p>
  <option value="<?php echo $VirusScan; ?>">Current (<?php echo $VSEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select>
<p style="float:center; padding-left:10%;"><input type='submit' name='Scan' id='Scan' value='Scan Cloud' style="padding-left:30px; padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p>
<?php } ?>

<div align="center" id="loading" name="loading" style="display:none;"><p><img src="Resources/logosmall.gif" /></p></div>
  <script type="text/javascript">
    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if(e.style.display == 'block')
         e.style.display = 'none';
      else
         e.style.display = 'block'; }
    function goBack() {
      window.history.back(); }
    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if(e.style.display == 'block')
        e.style.display = 'none';
      else
        e.style.display = 'block'; }
</script>
<hr />

<div align='center'>
  <p><input type='submit' name='Save' id='Save' value='Save Changes' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type='submit' name='LoadDefaults' id='LoadDefaults' value='Load Defaults' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type="hidden" name='YUMMYSaltHash' id='YUMMYSaltHash' value="<?php echo $SaltHash; ?>"></p>
</form>
<form action="appSettings.php">
  <p><input type='submit'  name='Clear' id='Clear' value='Clear Changes' style="padding: 2px; border: 1px solid black"></p>
</form>
<div id='end' name='end' class='end'>
</div>
<hr />
</body>
</html>