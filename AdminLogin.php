<!DOCTYPE html>
<html>
<head>
<title>DocumentControl | Admin Login Window </title>
<link rel="stylesheet" type="text/css" href="DocConCSS.css">
</head>
<?php
require ("config.php");
?>
<div align="center">
  <h3>Administrator Login</h3>
  <hr />
  <p>Please enter your login credentials below.</p>
<form action="/HRProprietary/HRAI/adminGUI.php" method="post">
  <p>Admin Username: <input type="text" name="adunm" value=""></p>
  <p>Admin Password: <input type="password" name="adpwd" value=""></p>
  <p><input type="submit" name='login' id='login' value="Login"></p>
  <input type="hidden" name="user_ID" value="<?php echo $AdmLogin;?>">

</form>
</div>
</div>
<hr />
</div>
</body>
</html>