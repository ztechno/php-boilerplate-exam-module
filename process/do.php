<?php

use Core\Page;
use Core\Request;
use Core\Database;
use Core\Response;

$schedule_id = $_GET['schedule_id'];
$db = new Database;
$schedule = $db->single('exam_schedules',[
    'id' => $schedule_id,
    // 'start_at' => ['<=', date('Y-m-d H:i:s')],
    // 'end_at' => ['>=', date('Y-m-d H:i:s')],
]);

if($schedule)
{
    if(Request::isMethod('POST'))
    {
        $schedule_user_data = $db->single('exam_schedule_user_data', [
            'schedule_id' => $schedule_id,
            'user_id'     => auth()->id
        ]);

        $data = json_decode($schedule_user_data->data);

        // save jawaban
        $answers = $_POST['answer'];
        $query = "";
        $userId = auth()->id;
        foreach($data as $d)
        {
            $answer_id = $answers && isset($answers[$d->question_id]) ? $answers[$d->question_id] : 0;
            $query .= "INSERT INTO exam_member_answers(user_id,schedule_id,question_item_id,answer_id,score)VALUES($userId,$schedule_id,$d->question_id,$answer_id,(SELECT score FROM exam_question_answers WHERE id = $answer_id));";
        }

        $db->query = $query;
        $db->exec("multi_query");

        set_flash_msg(['success'=>"Ujian telah selesai"]);

        header('location:'.routeTo('crud/index',[
            'table' => 'exam_schedules'
        ]));
        die();
    }

    $now = strtotime('now');
    $startAt = strtotime($schedule->start_at);
    $endAt = strtotime($schedule->end_at);
    if($startAt <= $now && $endAt >= $now)
    {

        $schedule_user_data = $db->single('exam_schedule_user_data', [
            'schedule_id' => $schedule_id,
            'user_id'     => auth()->id
        ]);
        
        if($schedule_user_data)
        {
            $title = $schedule->name;
            Page::setTitle($title);
        
            $schedule_user_data->data = json_decode($schedule_user_data->data);
        
            return view('exam/views/do', compact('schedule_user_data','schedule'));
        }
    }
    else
    {
        set_flash_msg(['error'=>"Maaf! Waktu ujian telah selesai"]);

        header('location:'.routeTo('crud/index',[
            'table' => 'exam_schedules'
        ]));
        die();
    }
}


set_flash_msg(['error'=>"Maaf! Data tidak valid"]);

header('location:'.routeTo('crud/index',[
    'table' => 'exam_schedules'
]));
die();
