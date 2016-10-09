<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 | HRAIMini </title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="/HRProprietary/HRCloud2/Applications/jquery-3.1.0.min.js"></script>
</head>
<body>
  <?php 
// / This file serves as the mini GUI for the HRAI module of HRCloud2. It was not intended to be used outside of 
// / HRCloud2, although this file provides an example of a simple HTML API call to an HRAI node.
if (!isset($noMINICore)) {
  $noMINICore = '0'; }

$includeMINIIframerURL = 'core.php#end';  
if (!isset($includeMINIIframer)) {
  $includeMINIIframer = '1';
  $includeMINIIframerURL = 'Applications/HRAI/core.php#end'; }

if ($noMINICore == '0') {
  require('Applications/HRAI/core.php'); }
if ($includeMINIIframer == '1') { ?>
  <hr />
  <form action="<?php echo $includeMINIIframerURL; ?>" id="Corefile Input" method="post">
  <input type="hidden" name="user_ID" value="<?php echo $user_ID;?>">
  <input type="hidden" name="HRAIMiniGUIPost" value="1">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <?php if (!isset($input)) {
    $input = ''; } ?>
  <div align="center" id='HRAIButtons2' name='HRAIButtons2'>
  <input type="text" name="input" id="input"  value="<?php echo $input; ?>">
  <input id='submitHRAI' type="submit" value="Hello HRAI"></form>
  </div>
<?php } ?>

</body>
</html>