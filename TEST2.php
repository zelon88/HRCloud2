<!DOCTYPE html>
<html>
<head>
<title>DocumentControl | TEST </title>
<link rel="stylesheet" type="text/css" href="DocConCSS.css">
</head>
<?php
require ("config.php");
?>
<div align="center">
  <h3>Administrator Login</h3>
  <hr />
  <p>Please enter your login credentials below.</p>
<form action="/HRProprietary/HRCloud2/cloudCore.php" method="post" enctype="multipart/form-data">
  <p><input type="text" name='scanDocSelected' id='scanDocSelected' value="scanDocSelected"></p>
  <p><input type="text" name='scandocuserfilename' id='scandocuserfilename' value="scandocuserfilename"></p>
   <p><input type="text" name='outputScanDocToPDF' id='outputScanDocToPDF' value="outputScanDocToPDF"></p> 

    <p><input type="submit" value="submit" name='submit'></p>
  <input type="hidden" name="user_ID" value="<?php echo $AdmLogin;?>">

</form>
</div>
</div>
<hr />
</div>
</body>
</html>