<?php 
/*//
HRCLOUD2-PLUGIN-START
App Name: Pell for HRC2
App Version: v3.4 (7-7-2018 00:00)
App License: GPLv3
App Author: jaredreich & zelon88
App Description: A simple HRCloud2 document writer.
App Integration: 0 (False)
App Permission: 1 (Everyone)
HRCLOUD2-PLUGIN-END
//*/

// / The following code loads required HRCloud2 corefiles and resources.
$noStyles = 1;
if (!file_exists('../../sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2PellApp33, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('../../sanitizeCore.php'); }
if (!file_exists('../../securityCore.php')) {
  echo nl2br('ERROR!!! HRC2PellApp47, Cannot process the HRCloud2 Security Core file (securityCore.php).'."\n"); 
  die (); }
else {
  require ('../../securityCore.php'); }
if (!file_exists('../../commonCore.php')) {
  echo nl2br('ERROR!!! HRC2PellApp35, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once ('../../commonCore.php'); }
if (!file_exists('../../Applications/Pell/dist/PellHRC2Lib.php')) {
  echo nl2br('ERROR!!! HRC2PellApp35, Cannot process the HRC2 library for Pell file (PellHRC2Lib.php).'."\n"); 
  die (); }
else {
  require ('../../Applications/Pell/dist/PellHRC2Lib.php'); }

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
  <a href="Pell.php"><img src="resources\new.png" title="New File" alt="New File" onclick="toggle_visibility('loading');"></a>
  <img src="resources/save.png" title="Save File" alt="Save File" onclick="toggle_visibility('saveOptions');">
  <img src="resources/load.png" title="Open File" alt="Open File" onclick="toggle_visibility('openOptions');">
</div>
    <div align="center"><h3><?php if ($_GET['saved'] ==1) echo 'Saved '; echo ($fileEcho1); ?></h3></div>
<img id="loading" name="loading" src="resources/loading.gif" style="display:none;">
<br>
<div id="saveOptions" name="saveOptions" align="center" style="display:none;">
<form action="Pell.php" id="saveForm" name="saveForm" method="post" enctype="multipart/form-data">
<a style="float:left;">Save File: </a>
<br>
  Filename: <input type="text" name="filename" id="filename" value="<?php echo $fileEcho; ?>"> | 
  Extension: <select name="extension" id="extension">
    <option value="txt">Txt</option>
    <option value="doc">Doc</option>
    <option value="docx">Docx</option>
    <option value="rtf">Rtf</option>
    <option value="odt">Odt</option>
  </select>
  <input type="hidden" name="htmlOutput" id="htmlOutput" value="">
  <input type="hidden" name="fileOutput" id="fileOutput" value="">
  <br>
  <button href="#" onclick="setValue();">Save</button>
</form>
</div>
<div id="openOptions" name="openOptions" align="center" style="display:none;">
<a style="float:left;">Open File: </a>
<br>
<form action="Pell.php" id="deleteForm" name="deleteForm" method="post" enctype="multipart/form-data">
<table id="openFiles" name="openFiles" class="sortable">
  <tr>
    <th>Filename</th>
    <th>Delete</th>
    <th>Last Modified</th>
  </tr>
<?php 
// / The following code builds the table of files from the CloudUsrDir.
foreach ($pellFiles as $file) {
  if (in_array($file, $pellDangerArr)) continue;
  $fileExtension = pathinfo($CloudUsrDir.$file, PATHINFO_EXTENSION);
  if (!in_array($fileExtension, $pellDocArray)) continue;
  if (!file_exists($CloudUsrDir.$file)) continue;
  $lastmodified = date("M j Y g:i A", filemtime($CloudUsrDir.$file));
  $timekey=date("YmdHis", filemtime($CloudUsrDir.$file));
  echo('<tr><td><a href="Pell.php?pellOpen='.$file.'">'.$file.'</a></td>
    <td><input type="image" id="deleteFile" name="deleteFile" value="'.$file.'" src="'.$URL.'/HRProprietary/HRCloud2/Applications/Pell/resources/deletesmall.png" alt="Delete '.$file.'" title="Delete '.$file.'"></td>
    <td sorttable_customkey=\''.$timekey.'\'><a href="Pell.php?pellOpen='.$file.'">'.$lastmodified.'</a></td></tr>'); }

?>
</table>
</form>
</div>
<div class="content">
  <div id="pell" class="pell"></div>
  <div style="margin-top:20px;">
    <h3>Text output:</h3>
    <div id="textoutput"></div>
    </div>
    <div style="margin-top:20px;">
      <h3>HTML output:</h3>
      <pre id="htmloutput"></pre>
    </div>
</div>
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
            name: 'heading1',
            result: () => window.pell.exec('formatBlock', '<H1>')
          },
          {
            name: 'heading2',
            result: () => window.pell.exec('formatBlock', '<H2>')
          },
          {
            name: 'paragraph',
            result: () => window.pell.exec('formatBlock', '<P>')
          },
          {
            name: 'quote',
            result: () => window.pell.exec('formatBlock', '<BLOCKQUOTE>')
          },
          {
            name: 'olist',
            result: () => window.pell.exec('insertOrderedList')
          },
          {
            name: 'ulist',
            result: () => window.pell.exec('insertUnorderedList')
          },
          {
            name: 'line',
            result: () => window.pell.exec('insertHorizontalRule')
          },
          {
            name: 'undo',
            result: () => window.pell.exec('undo')
          },
          {
            name: 'redo',
            result: () => window.pell.exec('redo')
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
          document.getElementById('textoutput').innerHTML = html;
          document.getElementById('htmloutput').textContent = html;
        }
      })
  document.getElementById('htmloutput').textContent = '<?php echo str_replace('\'', '\\\'', str_replace("\n", '', preg_replace('/\s\s+/', ' ', htmlspecialchars_decode(trim($pellOpenFileData))))); ?>';
<?php
if (isset($_POST['pellOpen']) && $pellOpen !== '') {
  echo('
    var pellc = document.getElementsByClassName(\'pell-content\'),
        i = pellc.length;
    while(i--) {
        pellc[i].innerHTML = \''.str_replace('\'', '\\\'', str_replace("\n", '', preg_replace('/\s\s+/', ' ', htmlspecialchars_decode(trim($pellOpenFileData))))).'\';
    }'); }
?>
</script>
</body>
</html>
