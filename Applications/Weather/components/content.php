<?php 
require_once 'config.php'; 

if (isset($key)) { 
  if ($key == '') { 
    $jumbotronTopText = $needKeyText; 
    $jumbotronBottomText = ''; }
  else if (isset($city)) if ($city !== '') list($weather, $weatherArray, $icon, $tempKelvin, $tempKelvinMin, $tempKelvinMax, $feelsLike, $pressure, $humidity, $cloudCover, $visibility, $windSpeed, $direction, $sunrise, $sunset) = getContents($city, $urlWithCity, $imageUrl); }

if (isset($weather)) if ($weather !== '') { 
  $jumbotronTopText = $city;
  $jumbotronBottomText = $weather; }
?>

<div class="jumbotron">
  <h1 class="display-4 hidden-xs-down"><?php echo ($jumbotronTopText); ?></h1>
  <p class="lead"><?php echo ($jumbotronBottomText); ?></p>

<section class="container">
   <div class="row-fluid">
     <div class="col-sm-12">
       <div class="icon">
        <div class="icon-box">
          <div id='weather-icon' class='col-lg-12 col-md-8 col-sm-12'>
            <?php echo '<img id="icon" name="icon" src="'.$icon.'"/>'; ?>
          </div>
        </div>
      </div>
      </div><?php if (isset($weather)) if ($weather !== '') { ?>
      <div id='weather-info' class="icon-box">
        <dl>
          <dt>Temperature</dt>
            <dd><strong><?php echo (kelvin_to_celsius($tempKelvin).'°C, '.kelvin_to_fahrenheit($tempKelvin).'°F'); ?></strong></dd>
          <dt>Feels Like</dt>
            <dd><strong><?php echo (kelvin_to_celsius($feelsLike).'°C, '.kelvin_to_fahrenheit($feelsLike).'°F'); ?></dd>
          <dt>Low</dt>
            <dd><strong><?php echo (kelvin_to_celsius($tempKelvinMin).'°C, '.kelvin_to_fahrenheit($tempKelvinMin).'°F'); ?></strong></dd>
          <dt>High</dt>
            <dd><strong><?php echo (kelvin_to_celsius($tempKelvinMax).'°C, '.kelvin_to_fahrenheit($tempKelvinMax).'°F'); ?></strong></dd>
        </dl>

        <dl>
          <dt>Wind Speed</dt>
            <dd><strong><?php echo (mps_to_kph($windSpeed).' KPH, '.mps_to_mph($windSpeed).' MPH'); ?></strong></dd>
          <dt>Wind Direction</dt>
            <dd><strong><?php echo ($direction.'°'); ?></dd>
        </dl>

        <dl>
          <dt>Sunrise</dt>
            <dd><strong><?php echo (date("g:i a", $sunrise)); ?></strong></dd>
          <dt>Sunset</dt>
            <dd><strong><?php echo (date("g:i a", $sunset)); ?></dd>
        </dl>

        <dl>
          <dt>Date</dt>
            <dd><strong><?php echo ($Date); ?></strong></dd>
          <dt>Time</dt>
            <dd><strong><?php echo ($Time); ?></dd>
        </dl>

        <dl>
          <dt>Pressure</dt>
            <dd><strong><?php echo ($pressure); ?></strong></dd>
          <dt>Humidity</dt>
            <dd><strong><?php echo ($humidity); ?></dd>
          <dt>Visibility</dt>
            <dd><strong><?php echo ($visibility); ?></dd>
          <dt>Cloud Cover</dt>
            <dd><strong><?php echo ($cloudCover); ?></strong></dd>
        </dl>

      </div><?php } ?>
    </div>
  </div>
</section>

  <div class='container'>
    <div class='row'>
      <div class='col-lg-12 col-md-8'>
        <form method='get'>
            <div class='form-group'>
              <label for='city'></label>
              <input type='text' class='form-control' name ='city' id='city' placeholder='London, Rome, Sydney' value='<?php if (isset($city)) if ($city !== '') echo $city;?>'/>
            </div>
          <button type='submit' class='btn btn-lg btn-primary'>Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>