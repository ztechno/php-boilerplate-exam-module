<?php

use Core\Database;
use Core\Response;

$params   = "";
if(isset($_GET['group_id']))
{
    $params = " WHERE exam_group_member.group_id = $_GET[group_id]";
}

$db = new Database;

$db->query  = "SELECT 
                 users.name, 
                 username,
                 exam_groups.id group_id,
                 exam_groups.name group_name
                FROM 
                 users
                JOIN
                 exam_group_member ON user_id = users.id
                JOIN
                 exam_groups ON exam_groups.id = exam_group_member.group_id
                $params
                ";
$member     = $db->exec('all');

return view('exam/views/groups/member/print', compact('member'));