<?php if ($UpdateInterval !== '0' or $UpdateInterval !== 0 or $UpdateInterval !== '') { ?>
<script>
    $(document).ready(function(){
        setInterval(function() {
            $("#cpuGauge").load("cpuUpdate.php #cpuGauge");
        }, <?php echo $UpdateInt; ?>);
    });
</script>
<?php }
// / This file will retrieve information regarding the server's tempvolt.

$tempvoltCacheFile = 'Cache/tempvoltCACHE.php';
$tempvoltCacheFile1 = 'Cache/tempvoltCACHE1.php';

// / The following code creates a cache file, or returns an error if one cannot be created
if (file_exists($tempvoltCacheFile)) {
  @chmod('Cache/');
  @chmod($tempvoltCacheFile, 0755);
  @unlink($tempvoltCacheFile); }
if (file_exists($tempvoltCacheFile1)) {
  @chmod('Cache/');
  @chmod($tempvoltCacheFile1, 0755);
  @unlink($tempvoltCacheFile1); }

// / The following code retrieves basic statistics related to the server's temperature in degrees celcius and saves it into a cache file.
exec('acpi -t -c', $tempvoltDATA);
$MAKETempvoltCacheFile = file_put_contents($tempvoltCacheFile, implode('   ,   ', $tempvoltDATA).PHP_EOL, FILE_APPEND);
// / The following code retrieves basic statistics related to the server's temperature in degrees faranheit.
exec('acpi -t -f', $tempvoltDATA1);
$MAKETempvoltCacheFile1 = file_put_contents($tempvoltCacheFile, implode('   ,   ', $tempvoltDATA1).PHP_EOL, FILE_APPEND);
// / The following code retrieves basic statistics related to the server's battery, if one is isntalled and saves it into a cache file.
exec('acpi -i', $tempvoltDATA2);
$MAKETempvoltCacheFile2 = file_put_contents($tempvoltCacheFile, implode('   ,   ', $tempvoltDATA2).PHP_EOL, FILE_APPEND);
// / The following code retrieves basic statistics related to the server's AC power status, if one can be detected and saves it into a cache file.
exec('acpi -a', $tempvoltDATA3);
$MAKETempvoltCacheFile3 = file_put_contents($tempvoltCacheFile, implode('   ,   ', $tempvoltDATA3).PHP_EOL, FILE_APPEND);

// / The following code builds arrays of sensor output data in memory from the cache files.
$tempvoltCacheDATA = file($tempvoltCacheFile);
$thermalSensorArr = array();
$thermalSensorArr1 = array();
$batterySensorArr = array();
$batterySensorArr1 = array();
$adapterSensorArr = array();

// / The following code retreieves data from the cache file that is on it's own line.	
foreach ($tempvoltCacheDATA as $cacheDATALine) {
  if (strpos($cacheDATALine, 'Thermal') == 'true') {
    array_push($thermalSensorArr, $cacheDATALine); }
  if (strpos($cacheDATALine, 'Cooling') == 'true') {
    array_push($thermalSensorArr, $cacheDATALine); }
  if (strpos($cacheDATALine, 'Battery') == 'true') {
    array_push($batterySensorArr, $cacheDATALine); }
  if (strpos($cacheDATALine, 'Adapter') == 'true') {
    array_push($adapterSensorArr, $cacheDATALine); } }

$thermalSensorArr1 = explode(', ', $thermalSensorArr[0]);
$batterySensorArr1 = explode(', ', $batterySensorArr[0]);
$adapterSensorArr1 = explode(', ', $adapterSensorArr[0]);

// / The following code retrieves advanced statistics related to the server's temps and voltages using lm-sensors, if it is available.
// / The following code parses the output of sensors for Basic Temp information.
// / (array key 0 and 1)       
exec('sensors | awk -v ORS=, \'/temp/ {sub("°C", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA4);
$MAKETempvoltCacheFile4 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA4).PHP_EOL, FILE_APPEND);
exec('sensors | awk -v ORS=, \'/Temp/ {sub("°C", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA5);
$tempvoltDATA5 = str_replace(array("\r", "\n"), '', $tempvoltDATA5);
$MAKETempvoltCacheFile5 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA5).PHP_EOL, FILE_APPEND);

// / The following code parses the output of sensors for Memory Temp information.
// / (array key 2)
exec('sensors | awk -v ORS=, \'/SODIMM/ {sub("°C", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA6);
$tempvoltDATA6 = str_replace(array("\r", "\n"), '', $tempvoltDATA6);
$MAKETempvoltCacheFile6 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA6).PHP_EOL, FILE_APPEND);

// / The following code parses the output of sensors for Voltage information.
// / (array key 3, 4, 5, and 6)
exec('sensors | awk -v ORS=, \'/in/ {sub(" V", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA7);
$tempvoltDATA7 = str_replace(array("\r", "\n"), '', $tempvoltDATA7);
$MAKETempvoltCacheFile7 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA7).PHP_EOL, FILE_APPEND);
exec('sensors | awk -v ORS=, \'/In/ {sub(" V", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA8);
$tempvoltDATA8 = str_replace(array("\r", "\n"), '', $tempvoltDATA8);
$MAKETempvoltCacheFile8 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA8).PHP_EOL, FILE_APPEND);
exec('sensors | awk -v ORS=, \'/voltage/ {sub(" V", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA9);
$tempvoltDATA9 = str_replace(array("\r", "\n"), '', $tempvoltDATA9);
$MAKETempvoltCacheFile9 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA9).PHP_EOL, FILE_APPEND);
exec('sensors | awk -v ORS=, \'/Voltage/ {sub(" V", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA10);
$tempvoltDATA10 = str_replace(array("\r", "\n"), '', $tempvoltDATA10);
$MAKETempvoltCacheFile10 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA10).PHP_EOL, FILE_APPEND);

// / The following code parses the output of sensors for Fan Speed information.
// / (array key 7 and 8)
exec('sensors | awk -v ORS=, \'/Fan/ {sub(" RPM", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA11);
$tempvoltDATA11 = str_replace(array("\r", "\n"), '', $tempvoltDATA11);
$MAKETempvoltCacheFile11 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA11).PHP_EOL, FILE_APPEND);
exec('sensors | awk -v ORS=, \'/fan/ {sub(" RPM", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA12);
$tempvoltDATA12 = str_replace(array("\r", "\n"), '', $tempvoltDATA12);
$MAKETempvoltCacheFile12 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA12).PHP_EOL, FILE_APPEND);

// / The following code parses the outpuf of sensors for Core CPU Temperature information.
// / (array key 9 and 10)
exec('sensors | awk -v ORS=, \'/core/ {sub("°C", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA13);
$tempvoltDATA13 = str_replace(array("\r", "\n"), '', $tempvoltDATA13);
$MAKETempvoltCacheFile13 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA13).PHP_EOL, FILE_APPEND);
exec('sensors | awk -v ORS=, \'/Core/ {sub("°C", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA14);
$tempvoltDATA14 = str_replace(array("\r", "\n"), '', $tempvoltDATA14);
$MAKETempvoltCacheFile14 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA14).PHP_EOL, FILE_APPEND);

// / The following code parses the outpuf of sensors for Other information.
// / (array key 11 and 12)
exec('sensors | awk -v ORS=, \'/other/ {sub("°C", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA15);
$tempvoltDATA15 = str_replace(array("\r", "\n"), '', $tempvoltDATA15);
$MAKETempvoltCacheFile15 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA15).PHP_EOL, FILE_APPEND);
exec('sensors | awk -v ORS=, \'/Other/ {sub("°C", "", $2); print($2)}\' | sed \'s/,$//\'', $tempvoltDATA16);
$tempvoltDATA16 = str_replace(array("\r", "\n"), '', $tempvoltDATA16);
$MAKETempvoltCacheFile16 = file_put_contents($tempvoltCacheFile1, implode(',', $tempvoltDATA16).PHP_EOL, FILE_APPEND);

/*
WORK STUFF 
sensors | awk -v ORS=, '/temp/ {sub("°C", "", $2); print($2)}' | sed 's/,$//'
CPU
SODIMM
CORE #
GPU

sudo apt-get install acpi
acpi -t

lm-sensors
sudo apt-get install acpi sensors-detect
sensors
*/

?>
