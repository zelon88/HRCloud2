
<html>

 <head>
  <title>File Uploader</title>
  <script type="text/javascript" src="http://localhost/HRProprietaryHRCloud2/HRCHRClou2/Applications/jquery-3.1.0.min.js"></script>
  <script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block'; }
  </script>
 </head>

 <body>
<div align="center">
<?php 
$allowed =  array('dat', 'cfg', 'txt', 'doc', 'docx', 'rtf' ,'xls', 'xlsx', 'ods', 'odf', 'odt', 'jpg', 'mp3', 
   'avi', 'wma', 'wav', 'ogg', 'jpeg', 'bmp', 'png', 'gif', 'pdf', 'abw', 'zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
$docarray =  array('dat', 'pages', 'cfg', 'txt', 'doc', 'docx', 'rtf', 'odf', 'odt', 'abw');
$spreadarray = array ('xls', 'xlsx', 'ods');
$imgarray = array('jpg', 'jpeg', 'bmp', 'png', 'gif');
$audioarray =  array('mp3', 'avi', 'wma', 'wav', 'ogg');
$pdfarray = array('pdf');
$gifarray = array('gif');
$abwarray = array('abw');
$archarray = array('zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
$filename = str_replace(" ", "_", $_FILES['file']['name']);
$filename1 = pathinfo($filename, PATHINFO_FILENAME);
$ext = pathinfo($filename, PATHINFO_EXTENSION);
$file = $_FILES;
if(!in_array($ext,$allowed) ) {
  die( "Unsupported File Format" ); }
if( $filename != "" ) {
  if(!in_array($ext,$audioarray) ) {
    copy ( $_FILES['file']['tmp_name'], "/var/www/html/cloud/temp/" . $filename ); }
      elseif (in_array($ext,$audioarray) ) {
        copy ( $_FILES['file']['tmp_name'], "/var/www/html/cloud/temp/" . $filename ); } }
else {
  die( "No file specified" ); }
if (in_array($ext,$gifarray) ) {
  echo 'Sorry, gif images are currently only supported as an output format. We hope to support gif images in the future.';
  die; }
if (in_array($ext,$gifarray) ) {
  echo 'Sorry, pdf files are currently only supported as an output format. We are currently working to support pdf files in the near future.';
  die; }
?>
</div> 
<div align="center">
<div style="max-width:400px">
<div align="center"><h3>File Upload Complete!</h3></div>
  <div align="left"><ul>
   <li>Sent: <?php echo $file['file']['name']; ?></li>
   <li>Size: <?php echo $file['file']['size']; ?> bytes</li>
   <li>Type: <?php echo $file['file']['type']; ?></li>
  </div>
<?php if (in_array($ext,$docarray) ) { ?>
<div align="center"><img src="http://localhost/HRProprietary/HRCloud2/HRConvert2/document.png" alt="Your Document"> </a></div>
<?php } ?>
<?php if (in_array($ext,$spreadarray) ) { ?>
<div align="center"><img src="http://localhost/HRProprietary/HRCloud2/HRConvert2/document.png" alt="Your Document"> </a></div>
<?php } ?>
<?php if (in_array($ext,$imgarray) ) { ?>
<div align="center"><img src="http://localhost/HRProprietary/HRCloud2/HRConvert2/document.png" alt="Your Image"> </a></div>
<?php } ?>
<?php if (in_array($ext,$audioarray) ) { ?>
<div align="center"><img src="http://localhost/HRProprietary/HRCloud2/HRConvert2/document.png" alt="Your File"> </a></div>
<?php } ?>
<?php if (in_array($ext,$pdfarray) ) { ?>
<div align="center"><img src="http://localhost/HRProprietary/HRCloud2/HRConvert2/document.png" alt="Your File"> </a></div>
<?php } ?>
<?php if (in_array($ext,$abwarray) ) { ?>
<div align="center"><img src="http://localhost/HRProprietary/HRCloud2/HRConvert2/document.png" alt="Your File"> </a></div>
<?php } ?>
<?php if (in_array($ext,$archarray) ) { ?>
<div align="center"><img src="http://localhost/HRProprietary/HRCloud2/HRConvert2/document.png" alt="Your File"> </a></div>
<?php } ?>
<br><hr></div></div>

<div align="center"><h3>Convert This File...</h3></div>
<div align="center">
<?php if (in_array($ext,$docarray) ) { ?>
<div style="max-width:400px">
<div align="center">
<form action="/HRProprietary/HRCloud2/Applications/HRConvert2/converter.php" method="post" enctype="multipart/form-data">
 <select name="selected">
  <option value="pdf">Convert to  pdf</option>
  <option value="txt">Convert to  txt</option>
  <option value="rtf">Convert to  rtf</option>
  <option value="doc">Convert to  doc</option>
  <option value="docx">Convert to  docx</option>
  <option value="odt">Convert to  odt</option>
  <option value="abw">Convert to  abw</option>
 </select>
  <input type="hidden" name="hiddenFile" value="<?php echo $file['file']['name']; ?>" />
  <div id="loading" style="display:none;"><img 
    src="/HRProprietary/HRCloud2/Applications/HRConvert2/converter/pacman.gif" /> • • • • •</div>
  <p><input type="submit" name="convertCloud" value="Convert File to Cloud Drive" onclick="$('#loading').show();"/></p>
  <p><input type="submit" name="convertDownload" value="Convert File and Download Now" onclick="$('#loading').show();"/></p>
 </form>
</div></div>
<?php } ?>

<?php if (in_array($ext,$spreadarray) ) { ?>
<div style="max-width:400px">
<div align="center">
<form action="/HRProprietary/HRCloud2/Applications/HRConvert2/converter.php" method="post" enctype="multipart/form-data">
 <select name="selected">
  <option value="xls">Convert to  xls</option>
  <option value="xlsx">Convert to  xlsx</option>
  <option value="pdf">Convert to  pdf</option>  
  <option value="odf">Convert to  odf</option>
 </select>
  <input type="hidden" name="hiddenFile" value="<?php echo $file['file']['name']; ?>" />
  <div id="loading" style="display:none;"><img 
    src="/HRProprietary/HRCloud2/Applications/HRConvert2/onverter/pacman.gif" /> • • • • •</div>
  <p><input type="submit" name="convertCloud" value="Convert File to Cloud Drive" onclick="$('#loading').show();"/></p>
  <p><input type="submit" name="convertDownload" value="Convert File and Download Now" onclick="$('#loading').show();"/></p>
 </form>
</div></div>
<?php } ?>

<?php if (in_array($ext,$imgarray) ) { ?>
<div style="max-width:400px">
<div align="center">
<form action="/HRProprietary/HRCloud2/Applications/HRConvert2/converter.php" method="post" enctype="multipart/form-data">
 <select name="selected">
  <option value="jpg">Convert to  jpg</option>
  <option value="bmp">Convert to  bmp</option>
  <option value="png">Convert to  png</option>
  <option value="gif">Convert to  gif</option>
 </select>
  <br>
  <br>
  Width and height:
  <br>
  <input type="number" size="4" value="0" name="width" min="0" max="3000"> X <input type="number" size="4" value="0" name="height" min="0"  max="3000">
  <br>
  Maintain aspect ratio:<input type="checkbox" name="maintainAR" value="maintainAR">
  <br>
  <br>
  Rotate:
  <br>
  <input type="number" size="3" value="0" name="rotate" min="0" max="359">
  <input type="hidden" name="hiddenFile" value="<?php echo $file['file']['name']; ?>" />
  <div id="loading" style="display:none;"><img 
    src="/HRProprietary/HRCloud2/Applications/HRConvert2/converter/pacman.gif" /> • • • • •</div>
  <p><input type="submit" name="convertCloud" value="Convert File to Cloud Drive" onclick="$('#loading').show();"/></p>
  <p><input type="submit" name="convertDownload" value="Convert File and Download Now" onclick="$('#loading').show();"/></p>
 </form>
</div></div>
<?php } ?>

<?php if (in_array($ext,$audioarray) ) { ?>
<div style="max-width:500px">
<div align="center">
<form action="/HRProprietary/HRCloud2/Applications/HRConvert2/converter.php" method="post" enctype="multipart/form-data">
 <select name="selected">
  <option value="mp3">Convert to  mp3</option>
  <option value="avi">Convert to  avi</option>
  <option value="wav">Convert to  wav</option>
  <option value="wma">Convert to  wma</option>
  <option value="ogg">Convert to  ogg</option>
 </select>
 <br>
 <br>
 Select a bitrate (optional):
 <br>
  <select name="bitrate">
  <option value="auto">Auto</option>
  <option value="128">128 Kb/s</option>
  <option value="192">192 Kb/s</option>
  <option value="256">256 Kb/s</option>
  <option value="392">392 Kb/s</option>
 </select>
  <input type="hidden" name="hiddenFile" value="<?php echo $file['file']['name']; ?>" />
   <div id="loading" style="display:none;"><img 
    src="/HRProprietary/HRCloud2/HRConvert2/pacman.gif" /> • • • • •</div>
  <p><input type="submit" name="convertCloud" value="Convert File to Cloud Drive" onclick="$('#loading').show();"/></p>
  <p><input type="submit" name="convertDownload" value="Convert File and Download Now" onclick="$('#loading').show();"/></p>
 </form>
</div></div>
<?php } ?>

<?php if (in_array($ext,$pdfarray) ) { ?>
<div style="max-width:500px">
<div align="center">
<form action="/HRProprietary/HRCloud2/Applications/HRConvert2/converter.php" method="post" enctype="multipart/form-data">
 <select name="selected">
  <option value="doc">Convert to  doc</option>
  <option value="docx">Convert to  docx</option>
  <option value="abw">Convert to  abw</option>
  <option value="txt">Convert to  txt</option>
  <option value="rtf">Convert to  rtf</option>
  <option value="odf">Convert to  odf</option>
  <option value="jpg">Convert to  jpg</option>
  <option value="bmp">Convert to  bmp</option>
  <option value="png">Convert to  png</option>
  <option value="gif">Convert to  gif</option>
 </select>
 <br>
Remove Images:<input type="checkbox" name="RImages" value="checked">
<br>
Complex Mode:<input type="checkbox" name="complex" value="complex">
  <p>First Page: <input type="number" size="3" value="0" name="fPage" min="0" max="999"></p>
  <p>Last Page: <input type="number" size="3" value="1" name="lPage" min="1" max="999"></p>
  <input type="hidden" name="hiddenFile" value="<?php echo $file['file']['name']; ?>" />
  <div id="loading" style="display:none;"><img 
    src="/HRProprietary/HRCloud2/HRConvert2/pacman.gif" /> • • • • •</div>
  <p><input type="submit" name="convertCloud" value="Convert File to Cloud Drive" onclick="$('#loading').show();"/></p>
  <p><input type="submit" name="convertDownload" value="Convert File and Download Now" onclick="$('#loading').show();"/></p>
 </form>
</div></div>
<?php } ?>

<?php if (in_array($ext,$archarray) ) { ?>
<div style="max-width:400px">
<div align="center">
<form action="/HRProprietary/HRCloud2/Applications/HRConvert2/converter.php" method="post" enctype="multipart/form-data">
 <select name="selected">
  <option value="zip">Convert to  zip</option>
  <option value="rar">Convert to  rar</option>
  <option value="tar">Convert to  tar</option>
  <option value="tar.gz">Convert to  tar.gz</option>
  <option value="tar.bz2">Convert to  tar.bz2</option>
  <option value="7z">Convert to  7z</option>
 </select>
  <input type="hidden" name="hiddenFile" value="<?php echo $file['file']['name']; ?>" />
  <div id="loading" style="display:none;"><img 
    src="/HRProprietary/HRCloud2/HRConvert2/pacman.gif" /> • • • • •
  <p>Note: Large archives, or archives that contain a high number of small files can sometimes take a while to scan and convert. This could take a short while.</p>
  <p>Please wait ...</p></div>
  <p><input type="submit" name="convertCloud" value="Convert File to Cloud Drive" onclick="$('#loading').show();"/></p>
  <p><input type="submit" name="convertDownload" value="Convert File and Download Now" onclick="$('#loading').show();"/></p>
 </form>
</div></div>
<?php } ?>

</div>
</body>

</html>


