<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>HRCloud2 Streamer</title>
</head>
    <script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" href="Applications/displaydirectorycontents_72716/style.css">
    <script src="Applications/displaydirectorycontents_72716/sorttable.js"></script>
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

<?php 

if(isset($_GET['playlistSelected'])) {
  $_POST['playlistSelected'] = $_GET['playlistSelected']; }

if (file_exists ($PlaylistDir)) {
  $txt = ('OP-Act: User '.$UserID.' initiated HRStreamer on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $PLImageArr = array('jpg', 'jpeg', 'bmp', 'png', 'gif');  
  $PLAudioArr =  array('mp3', 'mp4', 'wma', 'wav', 'ogg', 'aac');
  $AlbumArtArr = array();
  $AlbumSongArr = array();
  $PlaylistCacheDir = $PlaylistDir.'/.Cache';
  $PlaylistCacheFile = $PlaylistCacheDir.'/cache.php';
  $PlaylistFiles = scandir($PlaylistDir);  
  if (!file_exists()) {
    mkdir($PlaylistCacheDir, 0755); 
    touch($PlaylisrCacheFile); 
    $txt = ('OP-Act: Created a playlist cache file on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if (!strpos($PlaylistDir, '.Playlist')) {
    $txt = ('ERROR!!! HRS34, '.$PlaylistDir.' is not a valid .Playlist file!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    die($txt); }
  foreach ($PlaylistFiles as $PlaylistFile) {
    $pathname = $CloudTmpDir.$StreamFile;
    $oldPathname = $CloudUsrDir.$StreamFile;
    $filename = pathinfo($pathname, PATHINFO_FILENAME);
    $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    if (!in_array($oldExtension, $PLImageArr)) {
      array_push($AlbumArtArr, $PlaylistFile); }
    if (!in_array($oldExtension, $PLSongArr)) {
      array_push($AlbumSongArr, $PlaylistFile); } } 


if (!file_exists($RandomSongFile)) {
  $RandomSongFile = ''; }

$RandomImage = array_rand($AlbumArtArr, '1'); 
$RandomImageFile1 = $PlaylistDir.'/'.$PlaylistFile.'/'.$RandomImage;
if (!file_exists($RandomImageFile1)) {
  // / This code replaces a non-existent RandomImageFile with an awesoe icon
    // / created by Eugen Buzuk of www.icondrawer.com. Thank you, Eugen!!!
  $RandomImageFile = $URL.'/HRProprietary/HRCloud2/Applications/HRStreamer/Resources/RandomImageFile.png'; 
  $RandomImageURL = $URL.'/HRProprietary/HRCloud2/Applications/HRStreamer/Resources/RandomImageFile.png'; }
if (file_exists($RandomImageFile1)) {
  $RandomImageFile = $PlaylistDir.'/'.$PlaylistFile;
  $RandomImageURL = $URL.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/'.$PlaylistDir.'/'.$RandomSongFile;  }
$RandomSong = array_rand($AlbumSongArr, '1'); 
$RandomSongFile = $PlaylistDir.'/'.$PlaylistFile;
}
?> 
<div id="playliststart" name="playliststart" align='left' style="max-width:65%;">
  <img id="AlbumImage" name="AlbumImage" align='center' src="<?php echo $RandomImageURL; ?>">
</div>
<?php
