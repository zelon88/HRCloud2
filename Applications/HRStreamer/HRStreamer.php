<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>HRCloud2 Streamer</title>
    <script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
    <script src="Applications/displaydirectorycontents_72716/sorttable.js"></script>
    <link rel="stylesheet" href="Applications/displaydirectorycontents_72716/style.css">
    <script type="text/javascript">
    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if(e.style.display == 'block')
         e.style.display = 'none';
      else
         e.style.display = 'block'; }
      var songsrc = [];
    function goBack() {
      window.history.back(); }
      var index = 0;
</script>
</head>
<body>

<?php 
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRS10, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRS18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The following code gets global variables.
$getID3File = $InstLoc.'/Applications/getID3-1.9.12/getid3/getid3.php';
if (file_exists($getID3File)) {
  require($getID3File); }
if (!file_exists($getID3File)) {
  $txt = ('ERROR!!! HRS53, The getID3 module is not installed on the server on '.$Time.'!');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  die('ERROR!!! HRS53, The getID3 module is not installed on the server on '.$Time.'!'); }
// / The following code gets POST variables.-
if(isset($_GET['playlistSelected']) or isset($_POST['playlistSelected'])) {
  $_POST['playlistSelected'] = $_GET['playlistSelected']; }
// / The following code is performed whnenever there is a playlistSelected.
if(isset($_GET['playlistSelected']) or isset($_POST['playlistSelected'])) {
  $PlaylistName = $_POST['playlistSelected'];  
  $PlaylistDir = $CloudTempDir.'/'.$PlaylistName;
  if (!file_exists($PlaylistDir)) {
    mkdir($PlaylistDir, 0755);
    $txt = ('Creating '.$PlaylistDir.' on '.$Time.'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    if (file_exists($PlaylistUSRDir)) {
      foreach (glob($PlaylistUSRDir) as $PlaylistUSRFiles) {
        $txt = ('Copied '.$PlaylistUSRFiles.' to '.$PlaylistUSRDir.' on '.$Time.'!');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
        copy ($PlaylistUSRFiles, $PlaylistDir); } } } 
    if (!file_exists($PlaylistDir)) {
      $txt = ('ERROR!!! HRS86, The PlaylistDir does not exist on '.$Time.'!');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      die($txt); }
  $PlaylistNameRAW = str_replace('.Playlist', '', $PlaylistName); }
  else {
    $txt = ('ERROR!!! HRS70, There was no playlist selected on '.$Time.'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    die('ERROR!!! HRS70, There was no playlist selected on '.$Time.'!'); }
?>
  <div align="center">
  <h3><?php echo $PlaylistNameRAW; ?></h3>
  </div>
  <hr />
<?php  
  // / If the selected playlist name does not contain .playlist, kill the script.
  if (strpos($PlaylistDir, '.Playlist') == 'false') {
    $txt = ('ERROR!!! HRS60, The selected playlist is not a valid HRCloud2 ".playlist" file on '.$Time.'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    die('ERROR!!! HRS60, The selected playlist is not a valid HRCloud2 ".playlist" file on '.$Time.'!'); }
// If the playlist file exists, read the album art and song data to separate arrays.
if (file_exists($PlaylistDir)) {
  $txt = ('OP-Act: User '.$UserID.' initiated HRStreamer on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $PLImageArr = array('jpg', 'jpeg', 'bmp', 'png', 'gif');  
  $PLAudioArr =  array('mp3', 'mp4', 'wma', 'wav', 'aac');
  $PLAudioOGGArr =  array('ogg');  
  $PlaylistArtArr = array();
  $PlaylistSongArr = array();
  $PlaylistCacheDir = $PlaylistDir.'/.Cache';
  $PlaylistCacheFile = $PlaylistCacheDir.'/cache.php';
  $PlaylistFiles = scandir($PlaylistDir); 
  require($PlaylistCacheFile);
  if (!file_exists($PlaylisrCacheFile)) {
    @mkdir($PlaylistCacheDir, 0755); 
    $txt = '<?php';
    $MAKECacheFile = file_put_contents($PlaylistCacheFile, $txt.PHP_EOL , FILE_APPEND);
    touch($PlaylisrCacheFile); 
    $txt = ('OP-Act: Created a playlist cache file on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if (strpos($PlaylistDir, '.Playlist') == 'false') {
    $txt = ('ERROR!!! HRS68, '.$PlaylistDir.' is not a valid .Playlist file!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    die($txt); }
  // / Separate the album art from the songs within the $PlaylistFiles.
    $PLCount = 0;
    $PLImageCount = 0;
    $PLSongCount = 0;
  foreach ($PlaylistFiles as $PlaylistFile) {
    if ($PlaylistFile == '.' or $PlaylistFile == '..' or $PlaylistFile == '.Cache' or is_dir($PlaylistFile)) continue;     
      $PLCount++; 
      $pathname = $PlaylistDir.'/'.$PlaylistFile;
      $newPathname = $PlaylistDir.'/'.$PlaylistName.'.ogg';
      $filename = pathinfo($pathname, PATHINFO_FILENAME);
      $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    if (in_array($oldExtension, $PLAudioOGGArr)) {
      array_push($PlaylistSongArr, $PlaylistFile); 
      $PLSongCount++;}
    if (in_array($oldExtension, $PLImageArr)) {
      array_push($PlaylistArtArr, $PlaylistFile); 
      $PLImageCount++; } } }
usleep(300);
if (!file_exists($PlaylistDir)) { 
  $txt = ('ERROR!!! HRS122, The selected playlist does not exist on '.$Time.'!');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  die('ERROR!!! HRS122, The selected playlist does not exist on '.$Time.'!'); }
?>      
<div>
<?php
$SongCount = 0;
echo ('<div align="center" style="padding-bottom:2px; width:200px; float:right; clear:right;"><strong>Music</strong>');
foreach ($PlaylistSongArr as $PlaylistSong) {
  if ($PlaylistSong == '.' or $PlaylistSong == '..' or is_dir($PlaylistSong)) continue;
    $SongCount++; 
    echo('</div><div id="PlaylistSong'.$SongCount.'" name="PlaylistSong'.$SongCount.'" style="display:block; width:200px; float:right; clear:right;"><hr />'); ?>
    <div align="left"><p><strong><i><a style="float:left;"><?php echo $SongCount.'. '; ?></a></i></strong><img id="hideplay<?php echo $SongCount; ?>" name="hideplay<?php echo $SongCount; ?>" onclick="toggle_visibility('hideplay<?php echo $SongCount; ?>'); toggle_visibility('play<?php echo $SongCount; ?>'); toggle_visibility('buttonbar<?php echo $SongCount; ?>');" style="float:left; padding-right:5px; padding-left:5px; display:none;" src="Applications/HRStreamer/Resources/streamflipped.png">
    <img id="play<?php echo $SongCount; ?>" name="play<?php echo $SongCount; ?>" onclick="toggle_visibility('hideplay<?php echo $SongCount; ?>'); toggle_visibility('play<?php echo $SongCount; ?>'); toggle_visibility('buttonbar<?php echo $SongCount; ?>');" style="float:left; padding-right:5px; padding-left:5px; display:block;" src="Applications/HRStreamer/Resources/stream.png"></p></div>
  <?php
    echo nl2br("\n".'<strong>'.$PlaylistSong.'</strong>'."\n"); 
    echo nl2br('<div align="center"><p id="moreInfoLink'.$SongCount.'" style="display:block;" onclick="toggle_visibility(\'PlaylistSongInfo'.$SongCount.'\'); toggle_visibility(\'moreInfoLink'.$SongCount.'\');"><i>More Info</i></p></div>'); ?>
    <div id="PlaylistSongInfo<?php echo $SongCount; ?>" name="PlaylistSongInfo<?php echo $SongCount; ?>" style="display:none;"><?php 
    echo nl2br('<div align="center"><p onclick="toggle_visibility(\'PlaylistSongInfo'.$SongCount.'\'); toggle_visibility(\'moreInfoLink'.$SongCount.'\');"><i>Less Info</i></p></div>');
    echo nl2br('<a id="moreInfo" name="moreInfo"><i>Artist: </i>'.${'PLSongArtist'.$SongCount}."\n".'<i>Title: </i>'.${'PLSongTitle'.$SongCount}."\n".'<i>Album: </i>'.${'PLSongAlbum'.$SongCount}.'</a>'); ?>
</div></div>
<?php }
$RandomImageFile = 'Applications/HRStreamer/Resources/RandomImageFile.png'; ?>
<div id="artwork" name="artwork" align="center" style="max-width:65%;">
<div align="center"><p><strong>Artwork</strong></p>
<img id="AlbumImage" name="AlbumImage" style="max-width:400px; padding-left:15px; padding-top:15px;" src="<?php echo $RandomImageFile; ?>">
</div></div>
<div id="media" name="media" align="center" style="max-width:65%;">
<?php  
$SongCount = 0;    
foreach ($PlaylistFiles as $PlaylistFile) {
  if ($PlaylistFile == '.' or $PlaylistFile == '..' or $PlaylistFile == '.Cache' or is_dir($PlaylistFile)) continue;  
  $SongCount++; 
  $pathname = $PlaylistDir.'/'.$PlaylistFile; ?>
<script type="text/javascript">
var aud<?php echo $SongCount; ?> = document.getElementById("song<?php echo $SongCount; ?>");
aud.onended = function() {
    toggle_visibility(songDiv<?php echo $SongCount; ?>);
    toggle_visibility(songDiv<?php echo ($SongCount + 1); ?>);
    aud<?php echo ($SongCount + 1); ?>.play;
};
</script>
<div align="center" id="buttonbar<?php echo $SongCount; ?>" name="buttonbar<?php echo $SongCount; ?>" style="display:none;">
<strong><?php echo $PlaylistFile; ?></strong>
<hr />
<div align="center" id="songDiv<?php echo $SongCount; ?>" name="songDiv<?php echo $SongCount; ?>">
  <audio id="song<?php echo $SongCount; ?>" name="song<?php echo $SongCount; ?>" preload="auto" controls="true" onended="audio<?php echo $SongCount++; ?>.play;" src="<?php echo 'DATA/'.$UserID.'/'.$PlaylistName.'/'.$PlaylistFile; ?>" type="audio/ogg" style="width:390px;"></audio>
<hr />
</div> 
</div>        
<?php } ?> 
</div>