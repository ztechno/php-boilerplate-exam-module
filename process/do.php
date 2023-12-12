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
        // save jawaban
        $answers = isset($_POST['answer']) ? $_POST['answer'] : [];
        $db->update('exam_schedule_user_data', [
            'answers' => json_encode($answers),
            'status'  => 'DONE'
        ], [
            'schedule_id' => $schedule_id,
            'user_id'     => auth()->id
        ]);

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

            if(!$schedule_user_data->status)
            {
                $db->update('exam_schedule_user_data', [
                    'status' => 'ON PROGRESS'
                ], [
                    'schedule_id' => $schedule_id,
                    'user_id'     => auth()->id
                ]);
            }
        
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
