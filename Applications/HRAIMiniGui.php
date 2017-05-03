<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 | HRAIMini </title>
</head>
<body>
  <?php 
if (!isset($noMINICore)) {
  $noMINICore = '0'; }

$includeMINIIframerURL = 'core.php#end';  
if (!isset($includeMINIIframer)) {
  $includeMINIIframer = '1';
  $includeMINIIframerURL = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/core.php#end'; }

if ($noMINICore == '0') {
  require('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/core.php'); }
if ($includeMINIIframer == '1') { ?>
  <div align="center" id='HRAIButtons2' name='HRAIButtons2'>
  <hr />
  <form action="<?php echo $includeMINIIframerURL; ?>" id="Corefile Input" method="post">
  <input type="hidden" name="HRAIMiniGUIPost" value="1">
  <?php if (!isset($input)) {
    $input = ''; } ?>
  <input type="text" name="input" id="input"  value="<?php echo $input; ?>">
  <input id='submitHRAI' type="submit" value="Hello HRAI">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>"></form>
  </div>
<?php } ?>

</body>
</html>