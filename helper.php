<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>HRCLoud2 | Application Settings</title>
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
function goBack() {
    window.history.back(); }
</script>
<?php
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2Helper33, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('commonCore.php')) {
  echo nl2br('ERROR!!! HRC2Helper35, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require('commonCore.php'); }
 ?>
</head>
<body>
<div align="center">
 <h3>HRCloud2 Help</h3>
</div>
<hr />
<div align="center">
<p>NOTE: Selecting a help topic will bring you to the official HRCloud2 Github documentation!</p>
<form action="https://github.com/zelon88/HRCloud2/wiki" target="_parent" method"post">
<p><input type="submit" id="wikibutton" name="submitsmall" value="Official Wiki"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/wiki/About-HRCloud2" target="_parent" method"post">
<p><input type="submit" id="aboutbutton" name="submitsmall" value="About HRCloud2"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/commits/master" target="_parent" method"post">
<p><input type="submit" id="latestcommitsbutton" name="submitsmall" value="Latest Commits"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/wiki/Dependency-Requirements" target="_parent" method"post">
<p><input type="submit" id="dependencybutton" name="submitsmall" value="Dependency Info"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/wiki/Technical-Description-and-Breakdown" target="_parent" method"post">
<p><input type="submit" id="techbreakdownbutton" name="submitsmall" value="Technical Info"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/wiki/FAQ" target="_parent" method"post">
<p><input type="submit" id="faqbutton" name="submitsmall" value="FAQ"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/issues/new" target="_parent" method"post">
<p><input type="submit" id="bugbutton" name="submitsmall" value="Report A Bug"></input></p></form>
<form action="mailto:zelon88@gmail.com" method"post">
<p><input type="submit" id="contactbutton" name="submitsmall" value="Contact zelon88"></input></p></form>
</form>
</div>
</body>
</html>