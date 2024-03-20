<?php

use Core\Response;

$timeFirst  = strtotime($_POST['from']);
$timeSecond = strtotime(date('Y-m-d H:i:s'));
$differenceInSeconds = $timeSecond - $timeFirst;

return Response::json([
    'timer' => $differenceInSeconds
], 'timer retrieved');