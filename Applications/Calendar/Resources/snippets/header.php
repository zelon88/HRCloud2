<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Calendar</title>
  <meta charset="utf-8" />

  <link rel="stylesheet" href="../Calendar/Resources/css/calendar.css" type="text/css" />

</head>

<body>

  <header>
    <nav>
      <ul>  
        <li><a<?php if($activeTab == 'week') echo ' class="active"' ?> href="Calendar.php?gui=week">Week</a></li>
        <li><a<?php if($activeTab == 'month') echo ' class="active"' ?> href="Calendar.php?gui=month">Month</a></li>
        <li><a<?php if($activeTab == 'year') echo ' class="active"' ?> href="Calendar.php?gui=year">Year</a></li>
      </ul>
    </nav>
  </header>