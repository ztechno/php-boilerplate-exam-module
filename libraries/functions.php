<?php

use Core\Scheduler;
use Core\Database;

Scheduler::register('exam/commands/process-answers');
Scheduler::register('exam/commands/auto-generate');

\Modules\Default\Libraries\Sdk\Dashboard::add('examDashboardStatistic');

function examDashboardStatistic()
{
    $db = new Database;

    $data = [];
    $data['groups'] = $db->exists('exam_groups');
    $data['members'] = $db->exists('exam_group_member');
    $data['questions'] = $db->exists('exam_questions');
    $data['schedules'] = $db->exists('exam_schedules');


    return view('exam/views/dashboard/statistic', compact('data'));
}

function generateQuestionSchedule($schedule_id, $message = true)
{
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

        $data = json_encode($items);
        $db->query = "INSERT INTO exam_schedule_user_data (schedule_id, user_id, `data`) VALUES ($schedule_id, $user->id, ?)";
        $db->exec(false, [$data]);
    }

    $msg = "$schedule->name generate success\n";
    if($message)
    {
        echo $msg;
    }
    
    return $msg;
}

// Fungsi untuk memparsing soal
function parseSoal($text) {
    // Pisahkan soal berdasarkan baris
    $lines = explode("\n", $text);
    
    // Inisialisasi array untuk soal
    $soalList = [];

    // Proses setiap 9 baris menjadi satu soal
    for ($i = 0; $i < count($lines); $i += 9) {
        // Pastikan ada cukup baris untuk soal
        // if ($i + 8 < count($lines)) {
            // Inisialisasi soal
            $soal = [];
            
            // Deskripsi soal
            $soal['description'] = trim($lines[$i + 1]);

            // Pilihan jawaban
            $pilihan = [];
            $kunci_jawaban = strtolower(trim(substr($lines[$i + 7], 14))); // Mengambil kunci jawaban setelah "Kunci Jawaban: "
            for ($j = 2; $j <= 6; $j++) {
                $alphabet = strtolower(substr($lines[$i + $j], 0, 1));
                $pilihan[$alphabet] = [
                    'description' => substr($lines[$i + $j], 3),
                    'score' => $alphabet == $kunci_jawaban
                ];
            }
            $soal['answers'] = $pilihan;
            
            // Simpan soal ke dalam list
            $soalList[] = $soal;
        // }
    }

    return $soalList;
}