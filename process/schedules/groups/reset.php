<?php

use Core\Database;

$user_id = $_GET['user_id'];
$schedule_id = $_GET['schedule_id'];
$db = new Database;

$db->delete('exam_member_answers', [
    'schedule_id' => $schedule_id,
    'user_id'     => $user_id
]);

$user_group = $db->single('exam_group_member',[
    'user_id' => $user_id
]);

$exam_schedule_group = $db->single('exam_schedule_groups', [
    'schedule_id' => $schedule_id,
    'group_id'    => $user_group->group_id
]);

set_flash_msg(['success'=>"Reset hasil berhasil"]);

header('location:'.routeTo('exam/schedules/groups/result',[
    'schedule_group_id' => $exam_schedule_group->id
]));
die();