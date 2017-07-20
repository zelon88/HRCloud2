<?php 
/*//
HRCLOUD2-PLUGIN-START
App Name: Pell for HRC2
App Version: v1.1 (6-19-2017 01:00)
App License: GPLv3
App Author: jaredreich & zelon88
App Description: A simple HRCloud2 document writer.
App Integration: 0 (False)
App Permission: 0 (Admin)
HRCLOUD2-PLUGIN-END
//*/

// / The following code loads required HRCloud2 corefiles and resources.
$noStyles = 1;
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2PellApp33, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/securityCore.php')) {
  echo nl2br('ERROR!!! HRC2PellApp47, Cannot process the HRCloud2 Security Core file (securityCore.php).'."\n"); 
  die (); }
else {
  require ('/var/www/html/HRProprietary/HRCloud2/securityCore.php'); }
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('ERROR!!! HRC2PellApp35, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/Applications/Pell/dist/PellHRC2Lib.php')) {
  echo nl2br('ERROR!!! HRC2PellApp35, Cannot process the HRC2 library for Pell file (PellHRC2Lib.php).'."\n"); 
  die (); }
else {
  require ('/var/www/html/HRProprietary/HRCloud2/Applications/Pell/dist/PellHRC2Lib.php'); }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="user-scalable=1.0,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
    <title>Pell for HRC2</title>
    <link rel="stylesheet" type="text/css" href="dist/pell.css">
    <style>
      body {
        margin: 0;
        padding: 0; }

      .content {
        box-sizing: border-box;
        margin: 0 auto;
        max-width: 600px;
        padding: 20px; }

      #html-output {
        white-space: pre-wrap; }
    </style>
  </head>
  <body>
<a id="header" name="header" align="center"><h1>Pell Editor for HRC2</h1></a>
<hr />
<div id="hrc2Toolbar" name="hrc2Toolbar" style="float:left;">
  <img src="resources/save.png" onclick="toggle_visibility('saveOptions');">
  <img src="resources/load.png" onclick="toggle_visibility('openOptions');">
</div>
  
<div id="saveOptions" name="saveOptions" align="center" style="display:none;">
<form action="Pell.php" id="saveForm" name="saveForm" method="post" enctype="multipart/form-data">
<a style="float:left;">Save File: </a>
<br>
  <input type="hidden" name="htmlOutput" id="htmlOutput" value="">
  Filename: <input type="text" name="filename" id="filename" value="">
  Extension: <select name="extension" id="extension">
    <option value="txt">Txt</option>
    <option value="doc">Doc</option>
    <option value="docx">Docx</option>
    <option value="rtf">Rtf</option>
    <option value="odf">Odf</option>
    <option value="pdf">Pdf</option>
  </select>
  <a href="#" onclick="setValue();">Save</a>
</form>
</div>

<div id="openOptions" name="openOptions" align="center" style="display:none;">
<a style="float:left;">Open File: </a>
<br>
<table id="openFiles" name="openFiles">
  <tr>
    <th>Filename</th>
    <th>Last Modified</th>
  </tr>
<?php 
// / The following code builds the table of files from the CloudUsrDir.
foreach ($pellFiles as $file) {
  if (in_array($file, $pellDangerArr)) continue;
  $fileExtension = pathinfo($CloudUsrDir.$file, PATHINFO_EXTENSION);
  if (!in_array($fileExtension, $pellDocArray)) continue;
  $lastmodified = filemtime($CloudUsrDir.$file);
  echo('<tr><td><a href="dist/PellHRC2Lib.php?pellOpen='.$file.'">'.$file.'</a></td><td><a href="dist/PellHRC2Lib.php?pellOpen='.$file.'">'.$lastmodified.'</a></td></tr>'); }

?>
</table>
</div>
<div class="content">
  <div id="pell" class="pell"></div>
  <div style="margin-top:20px;">
    <h3>Text output:</h3>
    <div id="text-output"></div>
    </div>
    <div style="margin-top:20px;">
      <h3>HTML output:</h3>
      <pre id="html-output"></pre>
    </div>
</div>
<script src="dist/HRC2.js"></script>
 <script src="dist/pell.js"></script>
 <script>
 function toggle_visibility(id) {
  var e = document.getElementById(id);
  if(e.style.display == 'block')
    e.style.display = 'none';
    else
      e.style.display = 'block'; }

      function ensureHTTP (str) {
        return /^https?:\/\//.test(str) && str || `http://${str}`
      }
      var editor = window.pell.init({
        element: document.getElementById('pell'),
        styleWithCSS: false,
        actions: [
          'bold',
          'underline',
          'italic',
          {
            name: 'zitalic',
            icon: 'Z',
            title: 'Zitalic',
            result: () => window.pell.exec('italic')
          },
          {
            name: 'image',
            result: () => {
              const url = window.prompt('Enter the image URL')
              if (url) window.pell.exec('insertImage', ensureHTTP(url))
            }
          },
          {
            name: 'link',
            result: () => {
              const url = window.prompt('Enter the link URL')
              if (url) window.pell.exec('createLink', ensureHTTP(url))
            }
          }
        ],
        onChange: function (html) {
          document.getElementById('text-output').innerHTML = html
          document.getElementById('html-output').textContent = html
        }
      })
</script>
</body>
</html>
