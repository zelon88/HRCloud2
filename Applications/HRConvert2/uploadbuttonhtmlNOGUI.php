<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
  <script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id); 
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block'; }
  </script>
<div>
 <div id="HRAIConvertOptions0" name="HRAIConvertOptions0" style="display: block;">
<?php
if ($user_ID == '0') {
echo nl2br('Unfortunately I cannot convert files for you at this time. Try logging in. '."\r".' I appologize, Commander.'); }
if ($user_ID > '0') {  ?>
<p>Step 1 of 2  |  <a id="nextbutton" name="nextbutton" href="#top" target="HRAIMini" style="max-width:100px; border-style: solid; border-color: MidnightBlue;" onclick="toggle_visibility('HRAIConvertSubmit'); toggle_visibility('HRAIConvertOptions1'); toggle_visibility('HRAIConvertOptions0');">Next &#x2192</a></p>
  <p>Please enter a Cloud directory/filename to convert:</p>
  <p><input type="text" name='convertSelected' id='convertSelected' value=""></p> 
<?php } ?>
  <div align="center">
  </div>
  </div>
 <div id="HRAIConvertOptions1" name="HRAIConvertOptions1" style="display: none;">
    <p>Step 2 of 2  |  <a id="previousbutton" name="previousbutton" href="#top" target="HRAIMini" style="max-width:100px; border-style: solid; border-color: MidnightBlue;" onclick="toggle_visibility('HRAIConvertSubmit'); toggle_visibility('HRAIConvertOptions1'); toggle_visibility('HRAIConvertOptions0');">&#x2190 Previous</a></p>
  <p>Please enter a name for your new file (no extension)...</p>
  <p><input type="text" id="userconvertfilename" name="userconvertfilename" value="<?php $Date = date("m_d_y"); echo 'Convert'.'_'.$Date; ?>"></p> 
  <p>Please choose an extension...</p>
  <p><select id='extension' name='extension'> 
    <option value="">Select Format</option>
      <option value="">--Audio Formats--</option>
    <option value="mp3">Mp3</option>
    <option value="avi">Avi</option>
    <option value="wav">Wav</option>
    <option value="ogg">Ogg</option>
      <option value="">--Document Formats--</option>
    <option value="doc">Doc</option>
    <option value="docx">Docx</option>
    <option value="rtf">Rtf</option>
    <option value="txt">Txt</option>
    <option value="odf">Odf</option>
    <option value="ods">Ods</option>
    <option value="pdf">Pdf</option>
      <option value="">--Spreadsheet Formats--</option>
    <option value="xls">Xls</option>
    <option value="xlsx">Xlsx</option>
    <option value="pdf">Pdf</option>
      <option value="">--Archive Formats--</option>
    <option value="zip">Zip</option>
    <option value="rar">Rar</option>
    <option value="tar">Tar</option>
    <option value="tar.bz2">Tar.bz2</option>
    <option value="7z">7z</option>
    <option value="iso">iso</option>
  </select></p>
  <p><input type="submit" id="HRAIConvertSubmit" style="display: none; border-style: solid; border-color: MidnightBlue;" value="Convert File" name='submit'></p>
  </div>
<script type="text/javascript">
$(document).ready(function () {
$("#HRAIConvertSubmit").click(function(){
$.ajax( {
    type: 'POST',
    url: '/HRProprietary/HRCloud2/cloudCore.php',
    data: { convertSelected : $("#convertSelected").val(),
        userconvertfilename : $("#userconvertfilename").val(),
        extension : $("#extension").val(),},

    success: function(data) {
        window.location.href = "core.php";
    }
} );
});
});
</script>
</div>
