<!doctype html>
    <meta charset="UTF-8">
    <script type="text/javascript" src="../../../../Applications/jquery-3.1.0.min.js" preload></script>
    <script type="text/javascript" src="../../../../Resources/HRC2-Lib.js" defer></script>
    <script type="text/javascript" src="../../../../Resources/sorttable.js" defer></script>
    <title>Shared Cloud Contents</title>

    <?php
    // / The following code will check for and initialize required HRCloud2 Core files.
    if (!file_exists('../../../../guiCore.php')) die ('ERROR!!! HRC2Index12, Cannot process the HRCloud2 GUI Core file (guiCore.php)!'.PHP_EOL); 
    else require_once ('../../../../guiCore.php'); 
    ?>

    <div style="font-family:<?php echo $Font; ?>;">
      <div align="center" id="container">
        <div align="center"><h3>Shared Files</h3></div>
        <div align="center" style="margin-bottom:10px;">
          <input type='submit' name="back" id="back" value='&#x2190;' target="cloudContents" class="submitsmall" onclick="goBack(); toggle_visibility('loadingCommandDiv');"> | 
          <input type='submit' name="refresh" id="refresh" value='&#x21BA;' class="submitsmall" onclick="toggle_visibility('loadingCommandDiv'); document.location.href = document.location.href;"></div>
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
            $name = $namehref = $shortName = str_replace('//', '/', str_replace('///', '/', $dirArray[$index]));
            $nameLength = $fixedLength = strlen($name);
            if ($nameLength > 35) { 
              $shortName = substr($name, 0, 24).'...'.substr($name, ($nameLength-8), $nameLength);
              $fixedLength = strlen($shortName); }
            foreach ($DangerousFiles as $DangerousFile) { 
              if (strpos($name, $DangerousFile) == TRUE) continue 2; } 
            $namehref = $dirArray[$index];
            $fileArray = array_push($fileArray1, $namehref);
            if (empty($namehref)) continue;
            if (substr_compare($namehref, '/', 1)) $namehref = substr_replace('/'.$namehref, $namehref, 0); 
            if (!file_exists($UserSharedDir.DIRECTORY_SEPARATOR.$dirArray[$index])) { 
              @unlink($UserSharedDir.DIRECTORY_SEPARATOR.$dirArray[$index]);
              continue; }
            $modtime = date("M j Y g:i A", filemtime($UserSharedDir.DIRECTORY_SEPARATOR.$dirArray[$index]));
            $timekey = date("YmdHis", filemtime($UserSharedDir.DIRECTORY_SEPARATOR.$dirArray[$index])); 
            if(is_dir($path)) {
              $extn = "&lt;Directory&gt;";
              $size = "&lt;Directory&gt;";
              $sizekey = "0";
              $class = "dir";
              if(file_exists($namehref."/favicon.ico")) {
                $favicon = " style='background-image:url($namehref/favicon.ico);'";
                $extn = "&lt;Website&gt;"; }
                if ($name == "."){$name=". (Current Directory)"; $extn = "&lt;System Dir&gt;"; $favicon = " style='background-image:url($namehref/.favicon.ico);'"; }
                if ($name == ".."){$name=".. (Parent Directory)"; $extn = "&lt;System Dir&gt;"; } }
            else {
              // Gets file extension.
              $extn = pathinfo($dirArray[$index], PATHINFO_EXTENSION);
              // Prettifies file type.
              switch ($extn) {
                case "png": $extn = "PNG Image"; break;
                case "bmp": $extn = "BMP Image"; break;
                case "jpg": $extn = "JPEG Image"; break;
                case "jpeg": $extn = "JPEG Image"; break;
                case "svg": $extn = "SVG Image"; break;
                case "gif": $extn = "GIF Image"; break;
                case "ico": $extn = "Windows Icon"; break;
                case "txt": $extn = "Text File"; break;
                case "log": $extn = "Log File"; break;
                case "htm": $extn = "HTML File"; break;
                case "sh": $extn = "Bash Script"; break;
                case "html": $extn = "HTML File"; break;
                case "xhtml": $extn = "HTML File"; break;
                case "shtml": $extn = "HTML File"; break;
                case "php": $extn = "PHP Script"; break;
                case "js": $extn = "Javascript File"; break;
                case "css": $extn = "Stylesheet"; break;
                case "pdf": $extn = "PDF Document"; break;
                case "xls": $extn = "Spreadsheet"; break;
                case "ods": $extn = "Spreadsheet"; break;
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
                default: if ($extn != ""){ $extn = strtoupper($extn)." File"; }
                  break; }
                if (strpos($extn, 'Directory') == TRUE or strpos($name, '.') == false) {
                  $extn = "Folder"; }
                if ($extn == 'HTML File' or $extn == 'PHP File' or $extn == 'CSS File') continue;
                  $size = getFilesize($CloudUsrDir.$dirArray[$index]);
                  $sizekey = $size; }
                $FileURL = 'DATA/'.$UserID.$UserDirPOST.$namehref;
                $extnRAW = pathinfo($dirArray[$index], PATHINFO_EXTENSION);
                if ($extnRAW == '' or $extnRAW == NULL or preg_match('~[0-9]~', $size) == FALSE) {
                  $extn = "Folder"; 
                  $size = "Unknown"; 
                  $size = "Unknown"; }
            if (in_array($name, $defaultApps)) continue;
           echo("<tr class='$class'>
              <td title='$name' alt='$name'><a href='$namehref'$favicon class='name'>$shortName</a></td>
              <td title='$name' alt='$extn'><a href='$namehref'>$extn</a></td>
              <td title='Select \"$name\"' alt='Select \"$name\"'><div><input type='checkbox' name='corePostSelect[]' id='$namehref' value='$name'></div></td>
              <td title='$size' alt='$size' sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
              <td title='$modtime' alt='$modtime' sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td></tr>");  
          $fileCounter++; } } ?>
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
      </div>
      </body>
</html>
