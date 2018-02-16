
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="/HRProprietary/HRCloud2/Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="/HRProprietary/HRCloud2/Applications/meSpeak/mespeak.js"></script>

  <?php 
if (!file_exists('../commonCore.php')) {
  echo nl2br('ERROR!!! HRC2HMG35, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once ('../commonCore.php'); }
// / This file serves as the mini GUI for the HRAI module of HRCloud2. It was not intended to be used outside of 
// / HRCloud2, although this file provides an example of a simple HTML API call to an HRAI node.
if (!isset($noMINICore)) {
  $noMINICore = '0'; }

if ($noMINICore == '0') {
  require($InstLoc.'/Applications/HRAI/core.php'); } ?>
  <div align="center" id='HRAIButtons2' name='HRAIButtons2'>
  <hr />
  <form action="HRAIMiniGui.php" id="Corefile Input" method="post">
  <input type="hidden" name="HRAIMiniGUIPost" value="1">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <?php if (!isset($input)) {
    $input = ''; } ?>
  <input type="text" name="input" id="input"  value="">
  <input id='submitHRAI' type="submit" value="Hello HRAI"></form>
  </div>
</div><?php
if ($HRAIAudio == '1') { ?>
  <script type="text/javascript">
  meSpeak.speak('<?php echo $cleanOutput; ?>');
  meSpeak.loadConfig('Applications/meSpeak/mespeak_config.json');
  meSpeak.loadVoice('Applications/meSpeak/voices/en/en-us.json');
  </script>
<?php } ?>