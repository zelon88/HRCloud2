<?php 
// / This file was downloaded on 7/27/16 by Justin G. for HRCloud2 from 
// / https://css-tricks.com/snippets/php/display-styled-directory-contents/
// / Thank you to the author, Chris Coyier!!!
// / https://css-tricks.com/author/chriscoyier/
// / IMPORTANT NOTE: THIS SCRIPT IS NO LONGER EXECUTABLE OUTSIDE OF HRC2 !!!
// / IMPORTANT NOTE: THIS SCRIPT WILL ONLY FUNCTION WHEN INCLUDED OR REQUIRED BY HRC2 !!!

?>
<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>Cloud Contents</title>
</head>
    <script type="text/javascript" src="<?php echo $URL; ?>/HRProprietary/HRCloud2/Applications/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" href="Applications/displaydirectorycontents_72716/style.css">
    <script src="Applications/displaydirectorycontents_72716/sorttable.js"></script>
    <script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block'; }
    </script>

<body>
<div id="container">
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
	    <tbody><?php
$tableCount = 0;
	// Adds pretty filesizes
	function pretty_filesize($file) {
		$size=filesize($file);
		if($size<1024){$size=$size." Bytes";}
		elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
		elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
		else{$size=round($size/1073741824, 1)." GB";}
		return $size;
	}
 	// Checks to see if veiwing hidden files is enabled
	if($_SERVER['QUERY_STRING']=="hidden")
	{$hide="";
	 $ahref="./";
	 $atext="Hide";}
	else
	{$hide=".";
	 $ahref="./?hidden";
	 $atext="Show";}
$fileArray1 = array();
$ArchInc = 0;
while (file_exists($CloudUsrDir.$UserDirPOST.'Archive'.'_'.$Date.'_'.$ArchInc)) {
  $ArchInc++; }
?>
<form action="cloudCore.php" method="post" enctype="multipart/form-data">
<body><p><strong>Operations: </strong>
<img id='copyButton' name='copyButton' onclick="toggle_visibility('copyOptionsDiv');" src='Resources/copy.png'/> | <img id='deleteButton' name='deleteButton' onclick="toggle_visibility('deleteOptionsDiv');" src='Resources/deletesmall.png'/> | <img id='archive' name='archive' onclick="toggle_visibility('archiveOptionsDiv');" src='Resources/archiveFile.png'/> | <img id='dearchive' name='dearchive' onclick="toggle_visibility('loadingCommandDiv');" src='Resources/dearchive.png'/> | <img onclick="toggle_visibility('loadingCommandDiv');" src='Resources/docscan.png'/> | <img onclick="toggle_visibility('loadingCommandDiv');" src='Resources/convert.png'/> | <img onclick="toggle_visibility('loadingCommandDiv');" src='Resources/photoedit.png'/> | <img onclick="toggle_visibility('loadingCommandDiv');" src='Resources/makepdf.png'/> | <img onclick="toggle_visibility('loadingCommandDiv');" src='Resources/stream.png'/> | <img onclick="toggle_visibility('searchDiv');" src='Resources/searchsmall.png'/> | <input type="file" name="filesToUpload[]" id="filesToUpload" class="uploadbox" multiple>
<input type='submit' name="upload" id="upload" value='&#x21E7' class="submitsmall" onclick="toggle_visibility('loadingCommandDiv');"></p>
</form>
</div>
<div id='deleteOptionsDiv' name='deleteOptionsDiv' style="display:none;">
Are you sure?
<input type="submit" id="deleteFileSubmit" name="deleteFileSubmit" value='Confirm Delete' onclick="toggle_visibility('loadingCommandDiv');">
</div>

<div id='copyOptionsDiv' name='copyOptionsDiv' style="display:none;">
<input type="text" id='newcopyfilename' name='newcopyfilename' value='<?php echo $name.'_'.$Date; ?>'> 
<input type="submit" id="copyFileSubmit" name="copyFileSubmit" value='Copy Files' onclick="toggle_visibility('loadingCommandDiv');">
</div>
<div id='archiveOptionsDiv' name='archiveOptionsDiv' style="display:none;">
<input type="text" id='userfilename' name='userfilename' value='<?php echo 'Archive'.'_'.$Date.'_'.$ArchInc; ?>'> 
<select id='archextension' name='archextension'> 
  <option value="zip">Zip</option>
  <option value="rar">Rar</option>
  <option value="tar">Tar</option>
  <option value="7z">7z</option>
  <option value="tar.gz">Tar.gz</option>
  <option value="tar.bz2">Tar.bz2</option>
</select>
<input type="submit" id="archiveFileSubmit" name="archiveFileSubmit" value='Archive Files' onclick="toggle_visibility('loadingCommandDiv');">
</div>
<div align='center'><img src='Resources/logosmall.gif' id='loadingCommandDiv' name='loadingCommandDiv' style="display:none; max-width:64px; max-height:64px;"/></div>
<?php
	 // Opens directory
	 $myDirectory=opendir($CloudLoc.$UserDirPOST.$UserID);
	// Gets each entry
	while($entryName=readdir($myDirectory)) {
	   $dirArray[]=$entryName;
	}
	// Closes directory
	closedir($myDirectory);
	// Counts elements in array
	$indexCount=count($dirArray);
	// Sorts files
	sort($dirArray);
	// Loops through the array of files
	for($index=0; $index < $indexCount; $index++) {
	// Decides if hidden files should be displayed, based on query above.
	    if(substr("$dirArray[$index]", 0, 1)!=$hide) {
	// Resets Variables
		$favicon="";
		$class="file";
	// Gets File Names
		$name=$dirArray[$index];
		$namehref=$dirArray[$index];
        $fileArray = array_push($fileArray1, $namehref);
		if (substr_compare($namehref, '/', 1)) { 
			$namehref = substr_replace('/'.$namehref, $namehref, 0); }
	// Gets Date Modified
		$modtime=date("M j Y g:i A", filemtime($CloudUsrDir.$dirArray[$index]));
		$timekey=date("YmdHis", filemtime($CloudUsrDir.$dirArray[$index]));
	// Separates directories, and performs operations on those directories
		if(is_dir($dirArray[$index]))
		{
				$extn="&lt;Directory&gt;";
				$size="&lt;Directory&gt;";
				$sizekey="0";
				$class="dir";
			// Gets favicon.ico, and displays it, only if it exists.
				if(file_exists("$namehref/favicon.ico"))
					{
                        $slash = '/';
						$favicon=" style='background-image:url($slash$namehref/favicon.ico);'";
						$extn="&lt;Website&gt;";
					}
			// Cleans up . and .. directories
				if($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($slash$namehref/favicon.ico);'";}
				if($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;";}
		}

	// File-only operations
		else{
			// Gets file extension
			$extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);

			// Prettifies file type
			switch ($extn){
				case "png": $extn="PNG Image"; break;
				case "jpg": $extn="JPEG Image"; break;
				case "jpeg": $extn="JPEG Image"; break;
				case "svg": $extn="SVG Image"; break;
				case "gif": $extn="GIF Image"; break;
				case "ico": $extn="Windows Icon"; break;

				case "txt": $extn="Text File"; break;
				case "log": $extn="Log File"; break;
				case "htm": $extn="HTML File"; break;
				case "html": $extn="HTML File"; break;
				case "xhtml": $extn="HTML File"; break;
				case "shtml": $extn="HTML File"; break;
				case "php": $extn="PHP Script"; break;
				case "js": $extn="Javascript File"; break;
				case "css": $extn="Stylesheet"; break;

				case "pdf": $extn="PDF Document"; break;
				case "xls": $extn="Spreadsheet"; break;
				case "xlsx": $extn="Spreadsheet"; break;
				case "doc": $extn="Microsoft Word Document"; break;
				case "docx": $extn="Microsoft Word Document"; break;

				case "zip": $extn="ZIP Archive"; break;
				case "htaccess": $extn="Apache Config File"; break;
				case "exe": $extn="Windows Executable"; break;

				default: if($extn!=""){$extn=strtoupper($extn)." File";} else{$extn="Folder";} break;
  
			}

			// Gets and cleans up file size
				$size=pretty_filesize($CloudUsrDir.$dirArray[$index]);
				$sizekey=filesize($CloudUsrDir.$dirArray[$index]);
		}
if (isset($_POST['UserDirPOST'])) {
  $namehref1 = $namehref.' UserDirPOST : '.$UserDirPOST; }
if (!isset($_POST['UserDirPOST'])) {
  $namehref1 = $namehref; }
$FileURL = 'DATA/'.$UserID.$UserDirPOST.$namehref;
$ArchiveArray = array('zip', 'rar', 'tar', 'bz', 'gz', 'bz2', '7z', 'iso', 'vhd');
$DearchiveArray = array('zip', 'rar', 'tar', 'bz', 'gz', 'bz2', '7z', 'iso', 'vhd');
$DocumentArray = array('txt', 'doc', 'docx', 'rtf', 'xls', 'xlsx', 'odf', 'ods');
$ImageArray = array('jpeg', 'jpg', 'png', 'bmp', 'gif', 'pdf');
$MediaArray = array('3gp', 'avi', 'mp3', 'mp4', 'mov', 'aac', 'oog');
$extnRAW=pathinfo($dirArray[$index], PATHINFO_EXTENSION);
if (in_array($extnRAW, $DearchiveArray)) {
	$specialHTML = ('<img id=\'dearchivebutton$tableCount\' name=\'dearchiveButton$tableCount\' href=\'#\' src=\'Resources/dearchive.png\' alt=\'Unpack\'/>'); }
if (in_array($extnRAW, $DocumentArray)) {
	$specialHTML = '<img src="Resources/makepdf.png" alt=\'Create PDF\'/>'; }
if (in_array($extnRAW, $ImageArray)) {
	$specialHTML = '<img src="Resources/photoedit.png" alt=\'Edit Photo\'/>'; }
if (in_array($extnRAW, $MediaArray)) {
	$specialHTML = '<img src="Resources/stream.png" alt=\'Stream Media\'/>'; }
if ($extn == "Folder") {
	$specialHTML = '<img src="Resources/archive.png" alt=\'Compress\'/>'; } 
?>
<script type="text/javascript">
$(document).ready(function () {
$("#corePostDL<?php echo $tableCount; ?>").click(function(){
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { download : "1", filesToDownload : "<?php echo $name; ?>"},

    success: function(data) {
    	toggle_visibility('loadingCommandDiv');
        window.location.href = "<?php echo 'DATA/'.$UserID.$UserDirPOST.$name;?>";
    }
} );

});
});
</script>
<?php
	 echo("
		<tr class='$class'>
			<td><a id='corePostDL$tableCount' href='#'$favicon class='name' onclick=".'toggle_visibility(\'loadingCommandDiv\');'.">$name</a></td>
			<td><div><input type='checkbox' name='corePostSelect[]' id='$namehref' value='$namehref' onclick=".'toggle_visibility(\'loadingCommandDiv\');'."</div></td>
            <td><a id='corePostDL$tableCount' name='corePostDL$tableCount' href='#' onclick=".'toggle_visibility(\'loadingCommandDiv\');'.">$extn</a></td>
			<td sorttable_customkey='$sizekey'><a id='corePostDL$tableCount' href='#' name='corePostDL$tableCount' onclick=".'toggle_visibility(\'loadingCommandDiv\');'.">$size</a></td>
			<td sorttable_customkey='$timekey'><a id='corePostDL$tableCount' href='#' name='corePostDL$tableCount' onclick=".'toggle_visibility(\'loadingCommandDiv\');'.">$modtime</a></td>
		
		</tr>");
    $tableCount++;
?>

    <?php

	   }
	}


	?>
	</table>
<div align='center' id='loading' name='loading' style="display:none;"><img src='Resources/pacman.gif'/></div>

</div>
<script type="text/javascript">
$(document).ready(function () {
$("#dearchive").click(function(){
var dearchiveSelected = new Array();
$('input[name="corePostSelect[]"]:checked').each(function() {
dearchiveSelected.push(this.value);
});
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { dearchive : "1", filesToDearchive : dearchiveSelected},

    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );

});
});
</script>
<script type="text/javascript">
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
        window.location.href = "cloudCore.php";
    }
} );

});
});
</script>
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
        window.location.href = "cloudCore.php";
    }
} );

});
});
</script>
<script type="text/javascript">
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
        window.location.href = "cloudCore.php";
    }
} );

});
});
</script>
</body>
</html>