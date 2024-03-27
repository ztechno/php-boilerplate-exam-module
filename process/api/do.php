<?php

use Core\Request;
use Core\Database;
use Core\Response;

$schedule_id = $_GET['schedule_id'];
$db = new Database;
$schedule = $db->single('exam_schedules',[
    'id' => $schedule_id,
]);

if($schedule)
{
    if(Request::isMethod('POST'))
    {
        // delete existing answer
        $db->delete('exam_member_answers', [
            'schedule_id' => $schedule_id,
            'user_id' => auth()->id
        ]);
        // save jawaban
        $answers = isset($_POST['answer']) ? $_POST['answer'] : [];
        $db->update('exam_schedule_user_data', [
            'answers' => json_encode($answers),
            'status'  => 'DONE'
        ], [
            'schedule_id' => $schedule_id,
            'user_id'     => auth()->id
        ]);

        return Response::json([], 'Ujian telah selesai');
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

            return Response::json(compact('schedule_user_data','schedule'), 'data retrieved');
        }
    }

    return Response::json([], "Maaf! Waktu ujian telah selesai", 403);
}

return Response::json([], "Maaf! Data tidak valid", 403);
