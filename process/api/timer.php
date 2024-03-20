<?php

use Core\Response;

$timeFirst  = strtotime($_POST['from']);
$timeSecond = strtotime($_POST['to']);
$differenceInSeconds = $timeSecond - $timeFirst;

return Response::json([
    'timer' => $differenceInSeconds
], 'timer retrieved');