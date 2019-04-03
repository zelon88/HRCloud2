<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="../../../../Applications/jquery-3.1.0.min.js" preload></script>
    <script type="text/javascript" src="../../../../Resources/HRC2-Lib.js" defer></script>
    <script type="text/javascript" src="../../../../Resources/sorttable.js" defer></script>
    <title>Log Viewer</title>

    <?php
    // / The following code will check for and initialize required HRCloud2 Core files.
    if (!file_exists('../../../../guiCore.php')) die ('ERROR!!! HRC2Index12, Cannot process the HRCloud2 GUI Core file (guiCore.php)!'.PHP_EOL);
    else require_once ('../../../../guiCore.php');
    ?>
    </head>

    <body style="font-family:<?php echo $Font; ?>;">
      <div align="center" id="container">
        <div align="center"><h3>HRCloud2 Logs</h3></div>
        <div align="center" style="margin-bottom:10px;">
          <input type='submit' name="back" id="back" value='&#x2190;' target="cloudContents" class="submitsmall" onclick="goBack(); toggle_visibility('loadingCommandDiv');"> | 
          <input type='submit' name="refresh" id="refresh" value='&#x21BA;' class="submitsmall" onclick="toggle_visibility('loadingCommandDiv'); document.location.href = document.location.href;"></div>
        <div align="center" id='loadingCommandDiv' name='loadingCommandDiv' style="float:center; display:none; margin-bottom:10px; max-width:64px; max-height:64px;"><img src='/HRProprietary/HRCloud2/Resources/logosmall.gif'></div>
      </div>
      <table class="sortable">
  <thead>
    <tr>
      <th>Filename</th>
      <th>Type</th>
      <th>Size</th>
      <th>Date Modified</th>
    </tr>
      </thead>
      <tbody>
<?php
    // Adds pretty filesizes
    function pretty_filesize($file) {
      $size=filesize($file);
      if($size<1024){$size=$size." Bytes";}
      elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
      elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
      else{$size=round($size/1073741824, 1)." GB";}
      return $size; }
    // Checks to see if veiwing hidden files is enabled
    if($_SERVER['QUERY_STRING']=="hidden") { $hide="";
     $ahref="./";
     $atext="Hide";}
    else { $hide=".";
     $ahref="./?hidden";
     $atext="Show"; }
     $myDirectory=opendir(".");
    while ($entryName=readdir($myDirectory)) {
      $dirArray[]=$entryName; }
    closedir($myDirectory);
    $indexCount=count($dirArray);
    sort($dirArray);
    for ($index=0; $index < $indexCount; $index++) {
      if (substr("$dirArray[$index]", 0, 1)!=$hide) {
      $favicon="";
      $class="file";
      $name=$dirArray[$index];
      foreach ($DangerousFiles as $DangerousFile) { 
        if (strpos($name, $DangerousFile) == TRUE) continue 2; } 
      $modtime=date("M j Y g:i A", filemtime($dirArray[$index]));
      $namehref=$dirArray[$index];
          if (strpos($namehref, 'html') == 'true' or strpos($namehref, 'php') == 'true' or strpos($namehref, 'css') == 'true') continue;
      $timekey=date("YmdHis", filemtime($dirArray[$index]));
      if(is_dir($dirArray[$index])) {
        $extn="&lt;Directory&gt;";
        $size="&lt;Directory&gt;";
        $sizekey="0";
        $class="dir";
        if(file_exists($namehref."/favicon.ico")) {
          $favicon=" style='background-image:url($namehref/favicon.ico);'";
          $extn="&lt;Website&gt;"; }
        if ($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($namehref/.favicon.ico);'";}
        if ($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;"; } }
        else {
        $extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);
        switch ($extn) {
          case "txt": $extn="Text File"; 
          break;
          default: 
        if ($extn!=""){$extn=strtoupper($extn)." File"; } 
        else {$extn="Unknown"; } break; }
      $size=pretty_filesize($dirArray[$index]);
      $sizekey=filesize($dirArray[$index]); }

      if (in_array($name, $defaultApps) or strpos($name, '.css')) continue; 
        
    // Output
     echo("<tr class='$class'>
        <td><a href='./$namehref'$favicon class='name'>$name</a></td>
        <td><a href='./$namehref'>$extn</a></td>
        <td sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
        <td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td>
      </tr>"); } }
  // / -----------------------------------------------------------------------------------
    ?>
        </tbody>
    </table>
</body>
</html>
