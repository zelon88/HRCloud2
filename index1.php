<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 | Home </title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="nav" align="center">
    <div class="nav">
      <ul>
        <li class="Cloud"><a href="index1.php">Cloud</a></li>
        <li class="Settings"><a href=""> Settings</a></li>
        <li class="Logs"><a href="">Logging</a></li>
        <li class="Help"><a href="">Help</a></li>
      </ul>
    </div>
<script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block'; }
</script>

<div id="centerdiv" align='center' style="margin: 0 auto; max-width:800px;">
<div id="cloudCommandsDiv" style="float: left; ">
  <iframe src="cloudCommands.php" id="cloudCommands" name="cloudCommands" width="425" height="75" scrolling="no" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
<script type="text/javascript">
document.getElementById("cloudCommands").submit();
</script>
</div>
<div id="HRAIDiv" style="float: right; ">
  <iframe src="Applicatiosn/HRAI/core.php" id="HRAIMini" name="HRAIMini" width="275" height="75" scrolling="no" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
<script type="text/javascript">
document.getElementById("cloudCommands").submit();
</script>
</div>
<div id="cloudContentsDiv" style="float: left; ">
  <iframe src="cloudCore.php" id="cloudContents" name="cloudContents" width="800" height="500" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
<script type="text/javascript">
document.getElementById("cloudCoontents").submit();
</script>
</div>

</body>

</html>