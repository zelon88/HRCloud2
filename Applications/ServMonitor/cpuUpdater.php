<?php
// / The following code will return the server's CPU load percentage average for the past 5 minutes.
$exec_loads = sys_getloadavg();
$exec_cores = trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
$cpu = round($exec_loads[1]/($exec_cores + 1)*100, 0);
?>