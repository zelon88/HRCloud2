<?php if ($UpdateInterval !== '0' or $UpdateInterval !== 0 or $UpdateInterval !== '') { ?>
<script>
    $(document).ready(function(){
        setInterval(function() {
            $("#cpuGauge").load("cpuUpdate.php #cpuGauge");
        }, <?php echo $UpdateInt; ?>);
    });
</script>
<?php }

// / This file will retrieve information regarding the server's disk performance and statistics.
$diskCacheFile = 'Cache/diskCACHE.php';

// / The following code sets the POST and GET variables for the session, if there were any.
if (!isset($diskID) or !isset($_GET['diskID']) or !isset($_POST['diskID'])) {
  $diskID = ""; }
if (isset($_GET['diskID'])) {
  $diskID = $_GET['diskID']; }
if (isset($_POST['diskID'])) {
  $diskID = $_POST['diskID']; }

// / The following code creates a cache file, or returns an error if one cannot be created
if (file_exists($diskCacheFile)) {
  @chmod('Cache/');
  @chmod($diskCacheFile, 0755);
  @unlink($diskCacheFile); }

// / The following code caches the disk utilization statistics for all filesystems mounted to the server.
exec('df -k /tmp | tail -1 | tr -s \' \' | cut -d\' \' -f1', $diskName);
exec('df -k /tmp | tail -1 | tr -s \' \' | cut -d\' \' -f2', $diskTotal);
exec('df -k /tmp | tail -1 | tr -s \' \' | cut -d\' \' -f3', $diskUsed);
exec('df -k /tmp | tail -1 | tr -s \' \' | cut -d\' \' -f4', $diskFree);
exec('df -k /tmp | tail -1 | tr -s \' \' | cut -d\' \' -f5', $diskUsage);

