<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>HRCloud2 Streamer</title>
    <script src="Applications/displaydirectorycontents_72716/sorttable.js"></script>
    <script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" href="Applications/displaydirectorycontents_72716/style.css">
    <script type="text/javascript">
    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if(e.style.display == 'block')
         e.style.display = 'none';
      else
         e.style.display = 'block'; }
    function goBack() {
      window.history.back(); }
    </script>
</head>
<body>

<?php 
// / Detect WordPress.
$WPFile = '/var/www/html/wp-load.php';
if (!file_exists($WPFile)) {
  echo nl2br('ERROR!!! HRS26, WordPress was not detected on the server.'."\n");
  die('ERROR!!! HRS26, WordPress was not detected on the server.'); }
  else {
    require($WPFile); } 

// / Detect WordPress and set global variables.
$getID3File = $InstLoc.'/Applications/getID3-1.9.12/getid3/getid3.php';
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppLogs';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$ClamLogDir = ($InstLoc.'/'.'VirusLogs'.'/'.$Date.'.txt');
$LogFile = ($SesLogDir.'/'.$Date.'.txt');
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;

if ($UserIDRAW == '0' or $UserIDRAW == '') {
  $txt = ('ERROR!!! HRS43, You are not logged in on '.$Time.'!');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  die('ERROR!!! HRS43, You are not logged in on '.$Time.'!'); }

if (file_exists($getID3File)) {
  require($getID3File); }
if (!file_exists($getID3File)) {
  $txt = ('ERROR!!! HRS53, the getID3 module is not installed on the server on '.$Time.'!');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  die('ERROR!!! HRS53, the getID3 module is not installed on the server on '.$Time.'!'); }

// / Set POST variables.
if(isset($_GET['playlistSelected']) or isset($_POST['playlistSelected'])) {
  $_POST['playlistSelected'] = $_GET['playlistSelected']; }

// / The following code is performed whnenever there is a playlistSelected.
if(isset($_GET['playlistSelected']) or isset($_POST['playlistSelected'])) {
  $PlaylistName = $_POST['playlistSelected'];  
  $PlaylistDir = $CloudTempDir.'/'.$PlaylistName;
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
  $PLAudioArr =  array('mp3', 'mp4', 'wma', 'wav', 'ogg', 'aac');
  $PlaylistArtArr = array();
  $PlaylistSongArr = array();
  $PlaylistCacheDir = $PlaylistDir.'/.Cache';
  $PlaylistCacheFile = $PlaylistCacheDir.'/cache.php';
  $PlaylistFiles = scandir($PlaylistDir); 
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
    $filename = pathinfo($pathname, PATHINFO_FILENAME);
    $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    if (in_array($oldExtension, $PLImageArr)) {
      array_push($PlaylistArtArr, $PlaylistFile); 
      $PLImageCount++; }
    if (in_array($oldExtension, $PLAudioArr)) {
      array_push($PlaylistSongArr, $PlaylistFile); 
      $PLSongCount++; } } }
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
    echo('</div><div id="PlaylistSong'.$SongCount.'" name="PlaylistSong'.$SongCount.'" style="display:block; width:200px; float:right; clear:right;"><hr />');
    $getID3 = new getID3;
    $id3Tags = $getID3->analyze($pathname);
    getid3_lib::CopyTagsToComments($pathname);
    $PLSongTitle = $id3Tags['tags']['id3v2']['title'][0];
    $PLSongArtist = $id3Tags['tags']['id3v2']['artist'][0]; 
    $PLSongAlbum = $id3Tags['tags']['id3v2']['album'][0]; ?>
    <div align="center"><p><strong><i><?php echo $SongCount.'. '; ?></i></strong><img id="play<?php echo $SongCount; ?>" name="play<?php echo $SongCount; ?>" onclick="toggle_visibility('buttonbar<?php echo$SongCount; ?>');" align="float:center; padding-left:5px;" src="Applications/HRStreamer/Resources/stream.png">
    <img id="Delete<?php echo $SongCount; ?>" name="Delete<?php echo $SongCount; ?>" style="float:center; padding-right:5px; margin-right:110px" src="Applications/HRStreamer/Resources/deletesmall.png"></p></div>
  <?php
    echo nl2br("\n".'<strong>'.$PlaylistSong.'</strong>'."\n"); 
    echo nl2br('<div align="center"><p id="moreInfoLink'.$SongCount.'" style="display:block;" onclick="toggle_visibility(\'PlaylistSongInfo'.$SongCount.'\'); toggle_visibility(\'moreInfoLink'.$SongCount.'\');"><i>More Info</i></p></div>'); ?>
    <div id="PlaylistSongInfo<?php echo $SongCount; ?>" name="PlaylistSongInfo<?php echo $SongCount; ?>" style="display:none;"><?php 
    echo nl2br('<div align="center"><p onclick="toggle_visibility(\'PlaylistSongInfo'.$SongCount.'\'); toggle_visibility(\'moreInfoLink'.$SongCount.'\');"><i>Less Info</i></p></div>');
    echo nl2br('<a id="moreInfo" name="moreInfo"><i>Artist: </i>'.$PLSongArtist."\n".'<i>Title: </i>'.$PLSongTitle."\n".'<i>Album: </i>'.$PLSongAlbum.'</a>'); 
    if(isset($id3Tags['comments']['picture'][0])) {
      $Image='data:'.$id3Tags['comments']['picture'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($id3Tags['comments']['picture'][0]['data']); ?>

<div align="center"><img id="FileImage" src="<?php echo @$Image;?>" style="max-width:100px; max-height:100px;"></div>
<?php } ?>
</div></div>
<?php }

$RandomImageFile = 'Applications/HRStreamer/Resources/RandomImageFile.png'; ?>

<div id="artwork" name="artwork" align="center" style="max-width:65%;">
  <div align="center"><strong>Artwork</strong>
  <hr />
  <img id="AlbumImage" name="AlbumImage" style="max-width:400px; padding-left:15px; padding-top:15px;" src="<?php echo $RandomImageFile; ?>"></div>
</div> 

<div id="media" name="media" align="center" style="max-width:65%;">

<?php  
$SongCount = 0;    
foreach ($PlaylistFiles as $PlaylistFile) {
  if ($PlaylistFile == '.' or $PlaylistFile == '..' or $PlaylistFile == '.Cache' or is_dir($PlaylistFile)) continue;  
  $SongCount++; 
  $pathname = $PlaylistDir.'/'.$PlaylistFile; ?>
<script type="text/javascript">
    function vidplay<?php echo $SongCount; ?>() {
       var audio<?php echo $SongCount; ?> = document.getElementById("song<?php echo $SongCount; ?>");
       var button<?php echo $SongCount; ?> = document.getElementById("play<?php echo $SongCount; ?>");
       if (audio<?php echo $SongCount; ?>.paused) {
          audio<?php echo $SongCount; ?>.play();
          button<?php echo $SongCount; ?>.textContent = "||"; } 
       else {
          audio<?php echo $SongCount; ?>.pause();
          button<?php echo $SongCount; ?>.textContent = ">"; } }
    function restart<?php echo $SongCount; ?>() {
        var audio<?php echo $SongCount; ?> = document.getElementById("song<?php echo $SongCount; ?>");
        audio<?php echo $SongCount; ?>.currentTime = 0; }
    function skip<?php echo $SongCount; ?>(value) {
        var audio<?php echo $SongCount; ?> = document.getElementById("song<?php echo $SongCount; ?>");
        audio<?php echo $SongCount; ?>.currentTime += value; }      
</script>
<div align="center" id="buttonbar<?php echo $SongCount; ?>" name="buttonbar<?php echo $SongCount; ?>" style="display:none;">
<strong><?php echo $PlaylistFile; ?></strong>
<hr />
<audio id="song<?php echo $SongCount; ?>" name="song<?php echo $SongCount; ?>" preload="auto" src="<?php echo 'DATA/'.$UserID.'/'.$PlaylistName.'/'.$PlaylistFile; ?>" type="audio/mp3" />
     <a href="demo.mp4">Download this song.</a> 
</audio>
    <button id="restart" onclick="restart<?php echo $SongCount; ?>();">&#8634;</button> 
    <button id="rew" onclick="skip<?php echo $SongCount; ?>(-10)">&lt;&lt;</button>
    <button id="play" onclick="vidplay<?php echo $SongCount; ?>()">&gt;</button>
    <button id="fastFwd" onclick="skip<?php echo $SongCount; ?>(10)">&gt;&gt;</button>
</div>         
<?php } ?>
</div>









</body>
</html>

