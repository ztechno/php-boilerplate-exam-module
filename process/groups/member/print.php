<?php

use Core\Database;
use Core\Response;

$params   = "";
if(isset($_GET['group_id']))
{
    $params = " WHERE group_id = $_GET[group_id]";
}

$db = new Database;

$db->query  = "SELECT name, username FROM users WHERE id IN (SELECT user_id FROM exam_group_member $params)";
$member     = $db->exec('all');

return view('exam/views/groups/member/print', compact('member'));