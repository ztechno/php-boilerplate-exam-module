<?php

use Core\Database;

$schedule_group_id = $_GET['schedule_group_id'];
$user_id = $_GET['user_id'];
$schedule_id = $_GET['schedule_id'];
$db = new Database;

$exam_group = $db->single('exam_schedule_groups', ['id' => $schedule_group_id]);
$db->query = "DELETE FROM exam_member_answers WHERE schedule_id = $exam_group->schedule_id AND user_id IN (SELECT user_id FROM exam_group_member WHERE group_id = $exam_group->group_id)";
$db->exec();

set_flash_msg(['success'=>"Reset hasil berhasil"]);

header('location:'.routeTo('exam/schedules/groups/result',[
    'schedule_group_id' => $schedule_group_id
]));
die();