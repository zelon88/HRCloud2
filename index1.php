<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 | Home </title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
</head>
<body>
  <?php require 'Applications/HRAI/HRAIHelper.php'; ?>
<div id="nav" align="center">
    <div class="nav">
      <ul>
        <li class="Cloud"><a href="index1.php">Cloud</a></li>
        <li class="Settings"><a href=""> Settings</a></li>
        <li class="Logs"><a href="">Logs</a></li>
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
  <iframe src="cloudCommands.php" id="cloudCommands" name="cloudCommands" width="415" height="105" scrolling="no" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
<script type="text/javascript">
document.getElementById("cloudCommands").submit();
</script>
</div>
<div id="HRAIDiv" style="float: right; ">

  <iframe src="Applications/HRAI/core.php" id="HRAIMini" name="HRAIMini" width="375" height="75" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
  <form action="Applications/HRAI/core.php#end" id="Corefile Input" method="post" target="HRAIMini">
  <input type="hidden" name="user_ID" value="<?php echo $user_ID;?>">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <?php if (!isset($input)) {
    $input = ''; } ?>
  <input type="text" name="input" id="input"  value="<?php echo $input; ?>">
  <input id='submitHRAI' type="submit" value="Hello HRAI"></form></div>
<script type="text/javascript">
document.getElementById("HRAIMini").submit();
</script>
<script>
jQuery('#input').on('input', function() {
  $("#logo").attr("src","Resources/logo.gif");
});
</script>
<script>
jQuery('#submitHRAI').on('submit', function() {
  $("#logo").attr("src","Resources/logo.gif");
});
</script>
<div id="cloudContentsDiv" align='center'>
  <iframe src="cloudCore.php" id="cloudContents" name="cloudContents" style="min-height:350px; max-height:950px;" width="800" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
</div>
<script>
;(function($){
    $(document).ready(function(){
        $('#cloudContents').height( $(window).height() - 185 );
        $(window).resize(function(){
            $('#cloudContents').height( $(this).height() - 185 );
        });
    });
})(jQuery);
</script>
</div>
</body>
</html>