<?php

use Core\Database;

$schedule_id = $_GET['schedule_id'];

$db = new Database;

$db->delete('exam_schedule_user_data', [
    'schedule_id' => $schedule_id
]);

$schedule = $db->single('exam_schedules', ['id' => $schedule_id]);
$schedule->question = $db->single('exam_questions', "id = (SELECT question_id FROM exam_schedule_questions WHERE schedule_id = $schedule_id)");

$db->query = "SELECT * FROM users WHERE id IN (SELECT user_id FROM exam_group_member WHERE group_id IN (SELECT group_id FROM exam_schedule_groups WHERE schedule_id = $schedule_id))";
$users = $db->exec('all');
foreach($users as $user)
{    
    $db->query = "SELECT * FROM exam_question_items WHERE question_id = ".$schedule->question->id;
    // random
    if($schedule->randomize_question)
    {
        $db->query .= " ORDER BY RAND()";
    }

    // jumlah soal
    if($schedule->question_showed)
    {
        $db->query .= " LIMIT $schedule->question_showed";
    }
    $items = $db->exec('all');

    $randomize_answer = $schedule->randomize_answer;
    $items = array_map(function($item) use ($db, $randomize_answer){
        $db->query = "SELECT id, item_id, description FROM exam_question_answers WHERE item_id=$item->id";
        if($randomize_answer)
        {
            $db->query .= " ORDER BY RAND()";
        }

        $item->answers = $db->exec('all');

        return $item;
    }, $items);

    $db->insert('exam_schedule_user_data', [
        'schedule_id' => $schedule_id,
        'user_id' => $user->id,
        'data' => json_encode($items)
    ]);
}

set_flash_msg(['success'=>"Berhasil generate"]);

header('location:'.routeTo('crud/index',[
    'table' => 'exam_schedules'
]));
die();