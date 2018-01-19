<?php

date_default_timezone_set('UTC');
setlocale(LC_ALL, 'en_US');

// get the year and number of week from the query string and sanitize it
$year  = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
$month = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT);

// initialize the calendar object
$calendar = new calendar();

// get the current month object by year and number of month
$currentMonth = $calendar->month($year, $month);

// get the previous and next month for pagination
$prevMonth = $currentMonth->prev();
$nextMonth = $currentMonth->next();

// generate the URLs for pagination
$prevMonthURL = sprintf('Calendar.php?gui=month&year=%s&month=%s', $prevMonth->year()->int(), $prevMonth->int());
$nextMonthURL = sprintf('Calendar.php?gui=month&year=%s&month=%s', $nextMonth->year()->int(), $nextMonth->int());

// set the active tab for the header
$activeTab = 'month';

require($InstLoc.'/Applications/Calendar/Resources/snippets/header.php'); 

?>

<section class="month">

  <h1>
    <a class="arrow" href="<?php echo $prevMonthURL ?>">&larr;</a> 
    <?php echo $currentMonth->name() ?> <a href="Calendar.php?gui=year&year=<?php echo $currentMonth->year()->int() ?>"><?php echo $currentMonth->year()->int() ?></a>
    <a class="arrow" href="<?php echo $nextMonthURL ?>">&rarr;</a>
  </h1>
  
  <table>
    <tr>
      <?php foreach($currentMonth->weeks()->first()->days() as $weekDay): ?>
      <th><?php echo $weekDay->shortname() ?></th>
      <?php endforeach ?>
    </tr>
    <?php foreach($currentMonth->weeks(6) as $week): ?>
    <tr>  
      <?php foreach($week->days() as $day): ?>
      <td<?php if($day->month() != $currentMonth) echo ' class="inactive"' ?>><?php echo ($day->isToday()) ? '<strong>' . $day->int() . '</strong>' : $day->int() ?></td>
      <?php endforeach ?>  
    </tr>
    <?php endforeach ?>
  </table>

</section>

<?php require($InstLoc.'/Applications/Calendar/Resources/snippets/footer.php'); ?>