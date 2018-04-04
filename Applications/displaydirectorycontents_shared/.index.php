<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="../../../../Applications/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="../../../../Resources/HRC2-Lib.js"></script>
    <script type="text/javascript" src="../../../../Resources/sorttable.js"></script>
    <title>Cloud Contents</title>

    <?php
    // / The following code will check for and initialize required HRCloud2 Core files.
    if (!file_exists('../../../../guiCore.php')) {
      echo nl2br('ERROR!!! HRC2Index12, Cannot process the HRCloud2 GUI Core file (guiCore.php)!'."\n".''); 
      die (); }
    else {
      require_once ('../../../../guiCore.php'); }
    ?>
    </head>

    <body style="font-family:<?php echo $Font; ?>;">
      <div align="center" id="container">
        <div align="center"><h3>Shared Files</h3></div>
        <div align="center" style="margin-bottom:10px;">
          <input type='submit' name="back" id="back" value='&#x2190' target="cloudContents" class="submitsmall" onclick="goBack(); toggle_visibility('loadingCommandDiv');"> | 
          <input type='submit' name="refresh" id="refresh" value='&#x21BA' class="submitsmall" onclick="toggle_visibility('loadingCommandDiv'); refresh();"></div>
        <div align="center" name="unshareButton" id="unshareButton" style="margin-bottom:10px;"><img src="/HRProprietary/HRCloud2/Resources/deletesmall.png" title="Remove Shared File" alt="Remove Shared File" onclick="toggle_visibility('loadingCommandDiv');"></div>
        <div align="center" id='loadingCommandDiv' name='loadingCommandDiv' style="float:center; display:none; margin-bottom:10px; max-width:64px; max-height:64px;"><img src='/HRProprietary/HRCloud2/Resources/logosmall.gif'></div>
      </div>
      <table class="sortable">
        <thead>
    	  <tr>
    	    <th>Filename</th>
    	    <th>Type</th>
    	    <th>Select</th>
    	    <th>Size</th>
    	    <th>Date Modified</th>
    	  </tr>
    	  </thead>
    	  <tbody>
        <?php
        if($_SERVER['QUERY_STRING'] == "hidden") { $hide = "";
         $ahref = "./";
         $atext = "Hide";}
        else { $hide = ".";
         $ahref = "./?hidden";
         $atext = "Show"; }
         $myDirectory = opendir($UserSharedDir);
        while ($entryName = readdir($myDirectory)) {
          $dirArray[] = $entryName; }
        closedir($myDirectory);
        $indexCount = count($dirArray);
        sort($dirArray);
        for ($index = 0; $index < $indexCount; $index++) {
          if (substr("$dirArray[$index]", 0, 1) != $hide) {
          $favicon = "";
          $class = "file";
          $name = $dirArray[$index];
          $path = $UserSharedDir.'/'.$name;
          $modtime = date("M j Y g:i A", filemtime($path));
          $namehref = $UserShared.'/'.$name;
          $timekey = date("YmdHis", filemtime($path));
          if(is_dir($path)) {
            $extn = "&lt;Directory&gt;";
            $size = "&lt;Directory&gt;";
            $sizekey = "0";
            $class = "dir";
            if(file_exists($namehref."/favicon.ico")) {
              $favicon = " style='background-image:url($namehref/favicon.ico);'";
              $extn = "&lt;Website&gt;"; }
              if ($name == "."){$name=". (Current Directory)"; $extn = "&lt;System Dir&gt;"; $favicon = " style='background-image:url($namehref/.favicon.ico);'";}
              if ($name == ".."){$name=".. (Parent Directory)"; $extn = "&lt;System Dir&gt;"; } }
            else {
            $extn = pathinfo($path, PATHINFO_EXTENSION);
            switch ($extn) {
              case "png": $extn = "PNG Image"; break;
              case "jpg": $extn = "JPEG Image"; break;
              case "jpeg": $extn = "JPEG Image"; break;
              case "svg": $extn = "SVG Image"; break;
              case "gif": $extn = "GIF Image"; break;
              case "ico": $extn = "Windows Icon"; break;
              case "txt": $extn = "Text File"; break;
              case "log": $extn = "Log File"; break;
              case "htm": $extn = "HTML File"; break;
              case "html": $extn = "HTML File"; break;
              case "xhtml": $extn = "HTML File"; break;
              case "shtml": $extn = "HTML File"; break;
              case "php": $extn = "PHP Script"; break;
              case "js": $extn = "Javascript File"; break;
              case "css": $extn = "Stylesheet"; break;
              case "pdf": $extn = "PDF Document"; break;
              case "xls": $extn = "Spreadsheet"; break;
              case "xlsx": $extn= "Spreadsheet"; break;
              case "doc": $extn = "Microsoft Word Document"; break;
              case "docx": $extn = "Microsoft Word Document"; break;
              case "zip": $extn = "ZIP Archive"; break;
              case "playlist": $extn = "Playlist"; break;
              case "htaccess": $extn = "Apache Config File"; break;
              case "exe": $extn = "Windows Executable"; break;
              case '<Directory>': $extn = 'Folder'; break;
              case 'Directory': $extn = 'Folder'; break;
              case '<directory>': $extn = 'Folder'; break;
              case 'directory': $extn = 'Folder'; break;
              break;
              default: 
              if ($extn != "") {
                $extn = strtoupper($extn)." File"; } 
              else {$extn = "Unknown"; } break; }
              $size = getFilesize($path);
              $sizekey = filesize($path); }
          if (in_array($name, $defaultApps)) continue;
         echo("<tr class='$class'>
            <td><a href='$namehref'$favicon class='name'>$name</a></td>
            <td><a href='$namehref'>$extn</a></td>
            <td><div><input type='checkbox' name='corePostSelect[]' id='$namehref' value='$name'></div></td>
                  <td sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
            <td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td></tr>");  
          $fileCounter++;
          } } ?>
        </tbody>
        </table>

        <script type="text/javascript">
          $(document).ready(function () {
          $("#unshareButton").click(function(){
          var unshareSelected = new Array();
          $('input[name="corePostSelect[]"]:checked').each(function() {
          unshareSelected.push(this.value);
          });
          $.ajax( {
              type: 'POST',
              url: '<?php echo $URL; ?>/HRProprietary/HRCloud2/cloudCore.php',
              data: { unshareConfirm : "1", filesToUnShare : unshareSelected},
              success: function(data) {
                  window.location.href = "<?php echo $UserSharedIndex; ?>";
              }
          } );
          });
          });
        </script>
      </body>
</html>
