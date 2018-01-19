<?php
date_default_timezone_set('UTC');
setlocale(LC_ALL, 'en_US');

// get the year and number of week from the query string and sanitize it
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
$week = filter_input(INPUT_GET, 'week', FILTER_VALIDATE_INT);

// initialize the calendar object
$calendar = new calendar();

// get the current week object by year and number of week
$currentWeek = $calendar->week($year, $week);

// get the first and last day of the week
$firstDay = $currentWeek->firstDay();
$lastDay  = $currentWeek->lastDay();

// get the previous and next week for pagination
$prevWeek = $currentWeek->prev();
$nextWeek = $currentWeek->next();

// generate the URLs for pagination
$prevWeekURL = sprintf('Calendar.php?gui=week&year=%s&week=%s', $prevWeek->year()->int(), $prevWeek->int());
$nextWeekURL = sprintf('Calendar.php?gui=week&year=%s&week=%s', $nextWeek->year()->int(), $nextWeek->int());

// set the active tab for the header
$activeTab = 'week';

require($InstLoc.'/Applications/Calendar/Resources/snippets/header.php');

?>

<section class="week">

  <h1>
    <a class="arrow" href="<?php echo $prevWeekURL ?>">&larr;</a> 
    <?php echo $firstDay->padded() ?> <a href="Calendar.php?gui=month&year=<?php echo $firstDay->year()->int() ?>&month=<?php echo $firstDay->month()->int() ?>"><?php echo $firstDay->month()->name() ?></a> <a href="Calendar.php?gui=year&year=<?php echo $firstDay->year()->int() ?>"><?php echo $firstDay->year()->int() ?></a> – 
    <?php echo $lastDay->padded() ?> <a href="Calendar.php?gui=month&year=<?php echo $lastDay->year()->int() ?>&month=<?php echo $lastDay->month()->int() ?>"><?php echo $lastDay->month()->name() ?></a> <a href="Calendar.php?gui=year&year=<?php echo $lastDay->year()->int() ?>"><?php echo $lastDay->year()->int() ?></a>
    <a class="arrow" href="<?php echo $nextWeekURL ?>">&rarr;</a>
  </h1>
  
  <table>
    <tr>
      <?php foreach($currentWeek->days() as $day): ?>
      <th><?php echo $day->name() ?>, <?php echo $day->int() ?></th>
      <?php endforeach ?>
    </tr>
    <tr>
      <?php foreach($currentWeek->days() as $day): ?>
      <td>
        <ul>
          <?php foreach($day->hours() as $hour): ?>      
          <li><?php echo $hour->format('H:i') ?></li>
          <?php endforeach ?>
        </ul>
      </td>
      <?php endforeach ?>
    </tr>
  </table>

</section>

<?php require($InstLoc.'/Applications/Calendar/Resources/snippets/footer.php'); ?>