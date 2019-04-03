
    <meta charset="UTF-8">
    <script type="text/javascript" src="Applications/jquery-3.1.0.min.js" preload></script>
    <script type="text/javascript" src="Resources/HRC2-Lib.js" defer></script>
    <script type="text/javascript" src="Resources/sorttable.js" defer></script>
    <title>Cloud Contents</title>

    <?php
    // / The following code will check for and initialize required HRCloud2 Core files.
    if (!file_exists('././guiCore.php')) die ('ERROR!!! HRC2Index12, Cannot process the HRCloud2 GUI Core file (guiCore.php)!'.PHP_EOL); 
    else require_once ('././guiCore.php'); 
    ?>

    <body style="font-family:<?php echo $Font; ?>;">
    <div id="container">
    <div align='center'><h3>
      <?php
      echo rtrim(ltrim($Udir, '/'), '/');
      if ($showFavorites === '1') echo 'Favorites'; 
      require($FavoritesCacheFileInst);
      ?>
      </h3></div>

      <div align="center" style="margin-bottom:5px;">
        <input type='submit' name="back" id="back" value='&#x2190;' class="submitsmall" target="cloudContents" onclick="goBack(); toggle_visibility('loadingCommandDiv');"> |
        <input type='submit' name="refresh" id="refresh" value='&#x21BA;' class="submitsmall" onclick="document.location.href = document.location.href; toggle_visibility('loadingCommandDiv');"> | 
        <input type='submit' value='+' onclick="toggle_visibility('newOptionsDiv');">
      </div>
      <div align="center" style="margin-bottom:5px;">
        <img id='favoritesButton' name='favoritesButton' title='Favorites' alt='Favorites' onclick="toggle_visibility('favoritesOptionsDiv');" src='Resources/favorites.png'/> | 
        <img id='copyButton' name='copyButton' title="Copy" alt="Copy" onclick="toggle_visibility('copyOptionsDiv');" src='Resources/copy.png'/> | 
        <img id='renameButton' name='renameButton' title="Rename" alt="Rename" onclick="toggle_visibility('renameOptionsDiv');" src='Resources/rename.png'/> | 
        <img id='deleteButton' name='deleteButton' title="Delete" alt="Delete" onclick="toggle_visibility('deleteOptionsDiv');" src='Resources/deletesmall.png'/> | 
        <img id='archive' name='archive' title="Archive" alt="Archive" onclick="toggle_visibility('archiveOptionsDiv');" src='Resources/archiveFile.png'/> | 
        <img id='dearchiveButton' name='dearchiveutton' title="Dearchive" alt="Dearchive" onclick="toggle_visibility('loadingCommandDiv');" src='Resources/dearchive.png'/> | 
        <img id="convertButton" name="convertButton" title="Convert" alt="Convert" onclick="toggle_visibility('convertOptionsDiv');" src='Resources/convert.png'/> | 
        <img id="imgeditButton" name="imgeditButton" title="Image / Photo Editing Tools" alt="Image / Photo Editing Tools" onclick="toggle_visibility('photoOptionsDiv');" src='Resources/photoedit.png'/> | 
        <img id="pdfworkButton" name="pdfworkButton" title="OCR (Optical Character Recognition) Tools" alt="OCR (Optical Character Recognition) Tools" onclick="toggle_visibility('PDFOptionsDiv');" src='Resources/makepdf.png'/> | 
        <img id="streamButton" name="streamButton" title="Create Playlist" alt="Create Playlist" onclick="toggle_visibility('StreamOptionsDiv');" src='Resources/stream.png'/> | 
        <img id='shareButton' name="shareButton" title="Share" alt="Share" onclick="toggle_visibility('ShareOptionsDiv');" src='Resources/triangle.png'/> | 
        <img id='clipboardButton' name="clipboardButton" title="Clipboard" alt="Clipboard" onclick="toggle_visibility('ClipboardOptionsDiv');" src='Resources/clipboard.png'/> | 
        <img id='SearchButton' name="SearchButton" title="Search" alt="Search" onclick="toggle_visibility('SearchOptionsDiv');" src='Resources/searchsmall.png'/> | 
        <img id="NewWindowButton" name="NewWindowButton" title="New Winow" alt="New Window" onclick="window.open('cloudCore.php');" src='Resources/newwindow.png'/>
      </div>

      <div align="center" id='newOptionsDiv' name='newOptionsDiv' style="display:none;">
        <p><input type='submit' name="newFolder" id="newFolder" value='New Folder' onclick="toggle_visibility('makedirDiv'); toggle_visibility('makedir'); toggle_visibility('dirToMake');">
        <input type='submit' name="newFile" id="newFile" value='New File' onclick="toggle_visibility('uploadDiv'); toggle_visibility('upload'); toggle_visibility('filesToUpload');"></p>
      </div>

      <div align="center" id='favoritesOptionsDiv' name='favoritesOptionsDiv' style="display:none;">
        <?php
        if ($showFavorites !== '1') { ?>
        <p><form action="cloudCore.php" method="post" enctype="multipart/form-data"><input type='submit' id='showFavorites' name='showFavorites' value='View Favorites' onclick="toggle_visibility('loadingCommandDiv');"></form></p>
        <p><input type='submit' id="favoriteSubmit" name="favoriteSubmit" value='Add to Favorites' onclick="toggle_visibility('loadingCommandDiv');"></p>
        <?php }
        if ($showFavorites === '1') { ?>
        <p><input type='submit' id="favoriteDelete" name="favoriteDelete" value='Un-Favorite' onclick="toggle_visibility('loadingCommandDiv');"></p>
        <?php } ?>
      </div>

      <form action="cloudCore.php?UserDirPOST=<?php echo $Udir; ?>" method="post" enctype="multipart/form-data">
        <div align="center" name="makedirDiv" id="makedirDiv" style="display:none;">
        <input type="text" name="dirToMake" id="dirToMake" value="<?php echo $Udir; ?>" style="display:none;">
        <input type='submit' name="makedir" id="makedir" value='Create Folder' style="display:none;" onclick="toggle_visibility('loadingCommandDiv');">
        </div>
      </form>
      <form action="cloudCore.php?UserDirPOST=<?php echo $Udir; ?>" method="post" enctype="multipart/form-data">
        <div align="center" name="uploadDiv" id="uploadDiv" style="display:none;">
        <input type="file" name="filesToUpload[]" id="filesToUpload" class="uploadbox" multiple style="display:none;">
        <input type='submit' name="upload" id="upload" value='&#x21E7;' style="display:none;" onclick="toggle_visibility('loadingCommandDiv');">
        </div>
      </form>
      <div align="center" id='deleteOptionsDiv' name='deleteOptionsDiv' style="display:none;">
        Are you sure?
        <input type="submit" id="deleteFileSubmit" name="deleteFileSubmit" value='Confirm Delete' onclick="toggle_visibility('loadingCommandDiv');">
      </div>
      <div align="center" id='copyOptionsDiv' name='copyOptionsDiv' style="display:none;">
        <input type="text" id='newcopyfilename' name='newcopyfilename' value='<?php echo $Udir.'Copied_'.$Date; ?>'> 
        <input type="submit" id="copyFileSubmit" name="copyFileSubmit" value='Copy Files' onclick="toggle_visibility('loadingCommandDiv');">
      </div>
      <div align="center" id='renameOptionsDiv' name='renameOptionsDiv' style="display:none;">
        <input type="text" id='renamefilename' name='renamefilename' value='<?php echo $Udir.'Renamed_'.$Date; ?>'> 
        <input type="submit" id="renameFileSubmit" name="renameFileSubmit" value='Rename Files' onclick="toggle_visibility('loadingCommandDiv');">
      </div>
      <div align="center" id='archiveOptionsDiv' name='archiveOptionsDiv' style="display:none;">
        <input type="text" id='userfilename' name='userfilename' value='<?php echo $Udir.'Archive'.'_'.$Date.'_'.$ArchInc; ?>'> 
        <select id='archextension' name='archextension'> 
          <option value="zip">Zip</option>
          <option value="rar">Rar</option>
          <option value="tar">Tar</option>
          <option value="7z">7z</option>
        </select>
        <input type="submit" id="archiveFileSubmit" name="archiveFileSubmit" value='Archive Files' onclick="toggle_visibility('loadingCommandDiv');">
      </div>
      <div align="center" id='convertOptionsDiv' name='convertOptionsDiv' style="display:none;">
        <input type="text" id="userconvertfilename" name="userconvertfilename" value="<?php echo $Udir.'Convert'.'_'.$Date; ?>"> 
        <select id='extension' name='extension'> 
          <option value="">Select Format</option>
            <option value="mp3">--Audio Formats--</option>
          <option value="mp2">Mp2</option>  
          <option value="mp3">Mp3</option>
          <option value="wav">Wav</option>
          <option value="wma">Wma</option>
          <option value="m4a">M4a</option>
          <option value="flac">Flac</option>  
          <option value="ogg">Ogg</option>
            <option value="mp3">--Video Formats--</option>
          <option value="3gp">3gp</option> 
          <option value="mkv">Mkv</option> 
          <option value="avi">Avi</option>
          <option value="mp4">Mp4</option>
          <option value="flv">Flv</option>
          <option value="mpeg">Mpeg</option>
          <option value="m4v">M4v</option>
          <option value="wmv">Wmv</option>
            <option value="mp3">--Image Formats--</option>
          <option value="jpg">Jpg</option>  
          <option value="bmp">Bmp</option>
          <option value="png">Png</option>
          <option value="gif">Gif</option>
            <option value="txt">--Document Formats--</option>
          <option value="doc">Doc</option>
          <option value="docx">Docx</option>
          <option value="rtf">Rtf</option>
          <option value="txt">Txt</option>
          <option value="odf">Odf</option>
          <option value="pdf">Pdf</option>
            <option value="ods">--Spreadsheet Formats--</option>
          <option value="xls">Xls</option>
          <option value="xlsx">Xlsx</option>
          <option value="ods">Ods</option>
          <option value="pdf">Pdf</option>
            <option value="zip">--Archive Formats--</option>
          <option value="zip">Zip</option>
          <option value="rar">Rar</option>
          <option value="tar">Tar</option>
          <option value="7z">7z</option>
            <option value="zip">--Presentation Formats--</option>
          <option value="pages">Pages</option>
          <option value="pptx">Pptx</option>
          <option value="ppt">Ppt</option>
          <option value="xps">Xps</option>
          <option value="potx">Potx</option>
          <option value="pot">Pot</option>
          <option value="ppa">Ppa</option>
          <option value="odp">Odp</option>
            <option value="zip">--3D Model Formats--</option>
          <option value="3ds">3ds</option>
          <option value="collada">Collada</option>
          <option value="obj">Obj</option>
          <option value="off">Off</option>
          <option value="ply">Ply</option>
          <option value="stl">Stl</option>
          <option value="ptx">Ptx</option>
          <option value="dxf">Dxf</option>
          <option value="u3d">U3d</option>
          <option value="vrml">Vrml</option>
            <option value="zip">--Drawing Formats--</option>
          <option value="svg">Svg</option>
          <option value="dxf">Dxf</option>
          <option value="vdx">Vdx</option>
          <option value="fig">Fig</option>
        </select>
        <input type="submit" id="convertSubmit" name="convertSubmit" value='Convert Files' onclick="toggle_visibility('loadingCommandDiv');">
      </div>
      <div align="center" id='photoOptionsDiv' name='photoOptionsDiv' style="display:none;">
        <p>Filename: <input type="text" id='userphotofilename' name='userphotofilename' value='<?php echo $Udir.'Edited'.'_'.$Date; ?>'>
          <select id='photoextension' name='photoextension'>
          <option value="jpg">Jpg</option>
          <option value="bmp">Bmp</option>
          <option value="png">Png</option>
        </select></p>
        <p>Width and height: </p>
        <p><input type="number" size="4" value="0" id='width' name='width' min="0" max="3000"> X <input type="number" size="4" value="0" id="height" name="height" min="0"  max="3000"></p> 
        <p>Rotate: <input type="number" size="3" id='rotate' name='rotate' value="0" min="0" max="359"></p>
        <input type="submit" id='convertPhotoSubmit' name='convertPhotoSubmit' value='Convert Files' onclick="toggle_visibility('loadingCommandDiv');">
      </div>
      <div align="center" id='PDFOptionsDiv' name='PDFOptionsDiv' style="display:none;">
        <p><a id='makePDFbutton' name='makePDF' value='makePDF' ></a></p> 
        <p><select id='method1' name='method1'>   
          <option value="0">Select Method</option>  
          <option value="1">Automatic</option>  
          <option value="1">Method 1 (Simple)</option>
          <option value="2">Method 2 (Advanced)</option>
        </select></p>
        <p><a id='userpdfconvertfilename1'><input type="text" id='userpdfconvertfilename' name='userpdfconvertfilename' value='<?php echo $Udir.'Converted'.'_'.$Date; ?>'></a>
          <select id='pdfextension' name='pdfextension'>   
            <option value="">Select Format</option> 
            <option value="pdf">Pdf</option>   
            <option value="doc">Doc</option>
            <option value="docx">Docx</option>
            <option value="rtf">Rtf</option>
            <option value="txt">Txt</option>
            <option value="odf">Odf</option>
          </select></p>
        <p><input type="submit" id='pdfwork' name='pdfwork' value='Perform PDFWork' onclick="toggle_visibility('loadingCommandDiv');"></p>
      </div>
      <div align="center" id='StreamOptionsDiv' name='StreamOptionsDiv' style="display:none;">
        <p><input type="text" id='playlistname' name='playlistname' value='<?php echo $Udir.'Playlist'.'_'.$Date; ?>'>
          <input type='submit' id='createplaylistbutton' name='createplaylistbutton' value='Create Playlist' onclick="toggle_visibility('loadingCommandDiv');"></p>
      </div>
      <div align="center" id='ShareOptionsDiv' name='ShareOptionsDiv' style="display:none;">
        <p><form action="<?php echo $UserSharedIndex; ?>" enctype="multipart/form-data"><input type='submit' id='viewsharebutton' name='viewsharebutton' value='View Shared' onclick="toggle_visibility('loadingCommandDiv');"></form></p>
        <p><input type='submit' id='sharebutton' name='sharebutton' value='Share Files' onclick="toggle_visibility('loadingCommandDiv');"></p>
      </div>
      <div align="center" id='SearchOptionsDiv' name='SearchOptionsDiv' style="display:none;">
        <form action="cloudCore.php" method="post" enctype="multipart/form-data">
          <p><input type="text" id='search' name='search' value='Search...' onclick="ClearSearch();">
            <input type='submit' id='searchbutton' name='searchbutton' value='Search Cloud' onclick="toggle_visibility('loadingCommandDiv');"></p>
        </form>
      </div>
      <div align="center" id='ClipboardOptionsDiv' name='ClipboardOptionsDiv' style="display:none;">
        <p><input type='submit' id='clipboardCopy' name='clipboardCopy' value='Copy' onclick="toggle_visibility('loadingCommandDiv');">
          | <input type='submit' id='clipboardPaste' name='clipboardPaste' value='Paste' onclick="toggle_visibility('loadingCommandDiv');"></p>
      </div>
      <div align="center" id='loadingCommandDiv' name='loadingCommandDiv' style="display:none;"><img src='Resources/logoSmall.gif' style="max-width:64px; max-height:64px;" preload/></div>
    </div>  
    <table class="sortable">
      <thead>
      <tr>
        <th>Filename</th>
        <th>Select</th>
        <th>Type</th>
        <th>Size</th>
        <th>Date Modified</th>
      </tr>
      </thead>
      <tbody>
    <?php
    if ($showFavorites == '1') {
      $dirArray = $FavoriteFiles; }
    if ($showFavorites !== '1') {
      $myDirectory = str_replace('//', '/', str_replace('///', '/', rtrim($CloudLoc.'/'.$UserID.$UserDirPOST, '/')));
      if (!is_dir($myDirectory)) {
        $txt = ('ERROR!!! HRC2Index284, The selected file is not actually a directory on '.$Time.'!'."\n");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        die($txt); }
      $myDirectory = opendir($myDirectory);
      while ($entryName = readdir($myDirectory)) $dirArray[] = $entryName; 
      closedir($myDirectory); }
    $indexCount = count($dirArray);
    if ($indexCount > 1) sort($dirArray);
    for ($index = 0; $index < $indexCount; $index++) {
      if (substr("$dirArray[$index]", 0, 1) != $hide) {
        $class = "file";
        $name = $namehref = $shortName = str_replace('//', '/', str_replace('///', '/', $dirArray[$index]));
        $nameLength = $fixedLength = strlen($name);
        if ($nameLength > 28) { 
          $shortName = substr($name, 0, 17).'...'.substr($name, ($nameLength-8), $nameLength);
          $fixedLength = strlen($shortName); }
        $fileArray = array_push($fileArray1, $namehref);
        if (!file_exists($CloudUsrDir.$dirArray[$index])) continue; 
        if (empty($namehref)) continue;
        if (substr_compare($namehref, '/', 1)) $namehref = substr_replace('/'.$namehref, $namehref, 0); 
        $modtime = date("M j Y g:i A", filemtime($CloudUsrDir.$dirArray[$index]));
        $timekey = date("YmdHis", filemtime($CloudUsrDir.$dirArray[$index])); 
        if (is_dir($dirArray[$index])) {
          $extn = "&lt;Directory&gt;";
          $size = "&lt;Directory&gt;";
          $sizekey = "0";
          $class = "dir";
            if ($name == ".") $name = ". (Current Directory)"; $extn = "&lt;System Dir&gt;"; $favicon = " style='background-image:url($slash$namehref/favicon.ico);'";
            if ($name == "..") $name = ".. (Parent Directory)"; $extn = "&lt;System Dir&gt;"; }
      // File-only operations.
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
            default: if ($extn != "") $extn = strtoupper($extn)." File";
              break; }
            if ($extn == 'HTML File' or $extn == 'PHP File' or $extn == 'CSS File') continue;
            foreach ($DangerousFiles as $DangerousFile) { 
              if (strpos($name, $DangerousFile) == TRUE) continue 2; } 
            $size = getFilesize($CloudUsrDir.$dirArray[$index]);
            $sizekey = filesize($CloudUsrDir.$dirArray[$index]); }
            $FileURL = 'DATA/'.$UserID.$UserDirPOST.$namehref;
            $extnRAW = pathinfo($dirArray[$index], PATHINFO_EXTENSION);
            if (strpos($extn, 'Directory') == TRUE or strpos($name, '.') == FALSE) {
              $extn = "Folder"; }
            if ($extnRAW == '' or $extnRAW == NULL or preg_match('~[0-9]~', $size) == FALSE) {
              $extn = "Folder"; 
              $size = "Unknown"; 
              $size = "Unknown"; }
            $CleanUdir = str_replace('//', '/', str_replace('//', '/', str_replace('///', '/', $Udir.$name)));

            // / Handle the AJAX post for if a user clicks on a folder in their drive.
            if (strpos($name, '.') == FALSE) { ?>
              <script type="text/javascript">
              $(document).ready(function () {
              $("#corePostDL<?php echo $tableCount; ?>").click(function(){
              $.ajax( {
                  type: 'POST',
                  url: 'cloudCore.php',
                  data: { download : "1", dirToMake : "<?php echo $CleanUdir; ?>", filesToDownload : "<?php echo $name; ?>"},
                  success: function(returnFile) {
                    toggle_visibility('loadingCommandDiv');
                      window.location.href = "<?php echo ('cloudCore.php?UserDirPOST='.$CleanUdir); ?>";
                  }
              } );
              });
              });
              </script>
              <?php }
            // / Handle the AJAX post for if a use clicks on a .Playlist file in their drive.
            if (strpos($name, '.Playlist') == TRUE) { 
              if (isset ($_POST['UserDirPOST']) && $_POST['UserDirPOST'] !== '' && $_POST['UserDirPOST'] !== '/') { 
                $PLSpecialEcho = '?UserDirPOST='.$UserDirPOST; } 
              else {
                $PLSpecialEcho = ''; } ?>
              <script type="text/javascript">
              $(document).ready(function () {
              $("#corePostDL<?php echo $tableCount; ?>").click(function(){
              $.ajax( {
                  type: 'POST',
                  url: "<?php echo ('cloudCore.php?UserDirPOST='.$Udir); ?>",
                  data: { playlistSelected : "<?php echo $name; ?>"},
                  success: function(returnFile) {
                    toggle_visibility('loadingCommandDiv');
                    window.location.href = "<?php echo ('cloudCore.php?playlistSelected='.$name); ?>";
                  }
              } );
              });
              });
              </script>
              <?php }
            if (strpos($name, '.') == TRUE && strpos($name, '.Playlist') == FALSE) { ?>
              <script type="text/javascript">
              $(document).ready(function () {
              $("#corePostDL<?php echo $tableCount; ?>").click(function(){
              $.ajax( {
                  type: 'POST',
                  url: "<?php echo ('cloudCore.php?UserDirPOST='.$Udir); ?>",
                  data: { download : "1", filesToDownload : "<?php echo $name; ?>"},
                  success: function(returnFile) {
                    toggle_visibility('loadingCommandDiv');
                    window.location.href = "<?php echo 'DATA/'.$UserID.$UserDirPOST.$name; ?>"; }
              } );
              });
              });
              </script>
              <?php }
               $Folder = $Favorited = $Shared = '';
               if ($extn == "Folder") $Folder = '<img src="'.$FolderIcon.'" title="Folder" alt="Folder"/>';
               if (in_array($name, $FavoriteFiles)) $Favorited = '<img src="'.$FavoritedIcon.'" title="Favorite File" alt="Favorite File"/>';
               if (in_array($name, $SharedFiles)) $Shared = '<img src="'.$SharedIcon.'" title="Shared File" alt="Shared File"/>';
               echo("
                <tr class='$class'>
                  <td title='$name' alt='$name'><a id='corePostDL$tableCount' $favicon class='name' onclick=".'"toggle_visibility(\'loadingCommandDiv\');"'.">$Folder $Favorited $Shared $shortName</a></td>
                  <td title='Select \"$name\"' alt='Select \"$name\"'><div><input type='checkbox' name='corePostSelect[]' id='$Udir$namehref' value='$Udir$namehref'></div></td>
                  <td title='$extn' alt='$extn'><a id='corePostDL$tableCount' name='corePostDL$tableCount'>$extn</a></td>
                  <td title='$size' alt='$size' sorttable_customkey='$sizekey'><a id='corePostDL$tableCount' name='corePostDL$tableCount'>$size</a></td>
                  <td title='$modtime' alt='$modtime' sorttable_customkey='$timekey'><a id='corePostDL$tableCount' name='corePostDL$tableCount'>$modtime</a></td>
                </tr>");
                $tableCount++; } } ?>
      </tbody>
    </table>
    <div align='center' id='loading' name='loading' style="display:none;"><img src='Resources/pacman.gif'/></div>
    <script type="text/javascript">
      $(document).ready(function () {
      $("#copyFileSubmit").click(function(){
      var copySelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      copySelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { copy : "1", filesToCopy : copySelected, 
          newcopyfilename : $("#newcopyfilename").val()},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      <?php 
      if ($showFavorites === '1') { ?>
      $(document).ready(function () {
      $("#favoriteDelete").click(function(){
      var favoritesSelectedDelete = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      favoritesSelectedDelete.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { favoriteDelete : favoritesSelectedDelete},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?showFavoritesPOST=1'; ?>";
          }
      } );
      });
      });
      <?php } ?>
      $(document).ready(function () {
      $("#favoriteSubmit").click(function(){
      var favoritesSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      favoritesSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { favoriteConfirm : favoritesSelected},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?showFavoritesPOST=1'; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#renameFileSubmit").click(function(){
      var renameSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      renameSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { rename : "1", filesToRename : renameSelected, 
          renamefilename : $("#renamefilename").val()},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#dearchiveButton").click(function(){
      var dearchiveSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      dearchiveSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { filesToDearchive : dearchiveSelected, dearchiveButton : "1"},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#archiveFileSubmit").click(function(){
      var archiveSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      archiveSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { archive : "1", filesToArchive : archiveSelected, 
          userfilename : $("#userfilename").val(), archextension : $("#archextension").val()},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#deleteFileSubmit").click(function(){
      var deleteSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      deleteSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { deleteconfirm : "1", filesToDelete : deleteSelected},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#scandocSubmit").click(function(){
      var scandocSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      scandocSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { scanDocSelected : scandocSelected, scandocuserfilename : $("#scandocuserfilename").val(), 
          outputScanDocToPDF : $("#outputtopdf").val()},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#convertSubmit").click(function(){
      var convertSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      convertSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { convertSelected : convertSelected,
            userconvertfilename : $("#userconvertfilename").val(),
            extension : $("#extension").val(), width : 0, height : 0, rotate : 0},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      } );
      });
      $(document).ready(function () {
      $("#convertPhotoSubmit").click(function(){
      var convertphotoSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      convertphotoSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { convertSelected : convertphotoSelected,
              userconvertfilename : $("#userphotofilename").val(),
              height : $("#height").val(), 
              width : $("#width").val(), 
              rotate : $("#rotate").val(), 
              extension : $("#photoextension").val()},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#pdfwork").click(function(){
      var pdfworkSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      pdfworkSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { pdfworkSelected : pdfworkSelected,
              userpdfconvertfilename : $("#userpdfconvertfilename").val(),
              pdfextension : $("#pdfextension").val(),
              method1 : $("#method1").val()},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#createplaylistbutton").click(function(){
      var streamSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      streamSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { streamSelected : streamSelected,
              playlistname : $("#playlistname").val()},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#streambutton").click(function(){
      var streamSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      streamSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: { streamSelected : streamSelected,
              play : "1"},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#clipboardCopy").click(function(){
      var clipboardCopySelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      clipboardCopySelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: {
              clipboard : "1",
              clipboardCopy: "1",
              clipboardSelected: clipboardCopySelected,
              clipboardCopyDir : "<?php echo $Udir; ?>"},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#clipboardPaste").click(function(){
      var clipboardPasteSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      clipboardPasteSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: 'cloudCore.php',
          data: {
              clipboard : "1",
              clipboardPaste: "1",
              clipboardPasteDir : "<?php echo $UserDirPOST; ?>"},
          success: function(data) {
              window.location.href = "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>";
          }
      } );
      });
      });
      $(document).ready(function () {
      $("#sharebutton").click(function(){
      var shareSelected = new Array();
      $('input[name="corePostSelect[]"]:checked').each(function() {
      shareSelected.push(this.value);
      });
      $.ajax( {
          type: 'POST',
          url: "cloudCore.php<?php echo '?UserDirPOST='.$UserDirPOST; ?>",
          data: { shareConfirm : "1", filesToShare : shareSelected},
          success: function(data) {
              window.location.href = "cloudCore.php?showShared=1";
          }
      } );
      });
      });
    </script>
  </body>
</html>