<?php
date_default_timezone_set('UTC');
setlocale(LC_ALL, 'en_US');

// get the year from the query string and sanitize it
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);

$calendar    = new calendar();
$currentYear = $calendar->year($year);

// get the previous and next year for pagination
$prevYear = $currentYear->prev();
$nextYear = $currentYear->next();

// generate the URLs for pagination
$prevYearURL = sprintf('Calendar.php?gui=year&year=%s', $prevYear->int());
$nextYearURL = sprintf('Calendar.php?gui=year&year=%s', $nextYear->int());

// set the active tab for the header
$activeTab = 'year';

require($InstLoc.'/Applications/Calendar/Resources/snippets/header.php');

?>

<section class="year">

  <h1>
    <a class="arrow" href="<?php echo $prevYearURL ?>">&larr;</a> 
    <?php echo $currentYear->name() ?> 
    <a class="arrow" href="<?php echo $nextYearURL ?>">&rarr;</a>
  </h1>
  
  <ul>
    <?php foreach($currentYear->months() as $month): ?>
    <li>
      <h2><a href="Calendar.php?gui=month&year=<?php echo $month->year()->int() ?>&month=<?php echo $month->int() ?>"><?php echo $month->name() ?></a></h2>
      <table>
        <tr>
          <?php foreach($month->weeks()->first()->days() as $weekDay): ?>
          <th><?php echo $weekDay->shortname() ?></th>
          <?php endforeach ?>
        </tr>
        <?php foreach($month->weeks(6) as $week): ?>
        <tr>  
          <?php foreach($week->days() as $day): ?>
          <td<?php if($day->month() != $month) echo ' class="inactive"' ?>><?php echo ($day->isToday()) ? '<strong>' . $day->int() . '</strong>' : $day->int() ?></td>
          <?php endforeach ?>  
        </tr>
        <?php endforeach ?>
      </table>
    </li>    
    <?php endforeach ?>
  </ul>

</section>

<?php require($InstLoc.'/Applications/Calendar/Resources/snippets/footer.php'); ?>