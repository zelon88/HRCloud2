<?php
/*//
HRCLOUD2-PLUGIN-START
App Name: UberGallery
App Version: 3.4 (7-10-2018 19:00)
App License: GPLv3
App Author: UberGallery & zelon88
App Description: A simple HRCloud2 App for viewing photos.
App Integration: 0 (False)
App Permission: 1 (Everyone)
HRCLOUD2-PLUGIN-END
//*/
$noStyles = 1;

// / The follwoing code checks for the HRC2 core files and terminates if any are missing.
if (!file_exists('../../commonCore.php')) {
  $txt = 'ERROR!!! HRC2UG4, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n";
  echo nl2br($txt); 
  die ($txt); }
else {
  require('../../commonCore.php'); }

$galleryExt = array('.jpeg', '.jpg', '.png', '.png', '.bmp');
$userInstDir = $AppDir.'UberGallery';
$tempGalleryDir = $appDataInstDir.'/UberGallery';
$userGalleryDir = $appDataCloudDir.'/UberGallery';
$userGalleryIndex = $tempGalleryDir.'/index.php';
$serverGalleryIndex = $AppDir.'UberGallery/index.php';
$userGalleryURL = $URL.'';
$directory = $CloudUsrDir;
$excludedFiles = array('index.php');

if (file_exists($userGalleryIndex)) unlink($userGalleryIndex);

// / The following code creates a tempGalleryDir in the users hosted AppData folder if none exits.
if (!is_dir($tempGalleryDir)) {
  mkdir($tempGalleryDir);
  if (is_dir($tempGalleryDir)) {
    foreach ($iterator = new \RecursiveIteratorIterator (
      new \RecursiveDirectoryIterator ($userInstDir, \RecursiveDirectoryIterator::SKIP_DOTS),
      \RecursiveIteratorIterator::SELF_FIRST) as $item) {
      @chmod($item, 0755);
      if ($item->isDir()) {
        if (!file_exists($tempGalleryDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName())) {
          mkdir($tempGalleryDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName()); } }
      else {
        if (!is_link($item) or !file_exists($tempGalleryDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName())) {
          copy($item, $tempGalleryDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName()); } } } } }

// / The following code creates a userGalleryDir in the users temporary AppData folder if none exits.
if (!is_dir($userGalleryDir)) {
  mkdir($userGalleryDir);
  if (is_dir($userGalleryDir)) {
    foreach ($iterator = new \RecursiveIteratorIterator (
      new \RecursiveDirectoryIterator ($userInstDir, \RecursiveDirectoryIterator::SKIP_DOTS),
      \RecursiveIteratorIterator::SELF_FIRST) as $item) {
      @chmod($item, 0755);
      if ($item->isDir()) {
        if (!file_exists($userGalleryDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName())) {
          mkdir($userGalleryDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName()); } }
      else {
        if (!is_link($item) or !file_exists($userGalleryDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName())) {
          copy($item, $userGalleryDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName()); } } } } }

if (!is_dir($tempGalleryDir)) {
	$txt = 'ERROR!!! HRC2UGI12, Could not create a temporary gallery directory on '.$Time.'.';
	$MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die($txt); }

foreach (scandir($CloudUsrDir) as $CloudFile) {
  foreach ($galleryExt as $ext) {
  	if (strpos($CloudFile, $ext) == true && !in_array($CloudFile, $excludedFiles)) {
      copy($CloudUsrDir.'/'.$CloudFile, $tempGalleryDir.'/gallery-images/'.$CloudFile);
      copy($CloudUsrDir.'/'.$CloudFile, $userGalleryDir.'/gallery-images/'.$CloudFile); } } } 

copy($serverGalleryIndex, $userGalleryIndex);
require($userGalleryIndex);

