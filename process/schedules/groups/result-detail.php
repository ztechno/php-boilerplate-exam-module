<?php

use Core\Page;
use Core\Database;

$user_id = $_GET['user_id'];
$schedule_id = $_GET['schedule_id'];
$db = new Database;

$schedule = $db->single('exam_schedules',[
    'id' => $schedule_id
]);

$user = $db->single('users',[
    'id' => $user_id
]);

$userGroup = $db->single('exam_group_member',[
    'user_id' => $user_id
]);

$scheduleGroup =  $db->single('exam_schedule_groups',[
    'schedule_id' => $schedule_id,
    'group_id' => $userGroup->group_id
]);

// page section
$title = 'Detail Ujian - '.$schedule->name.' - '.$user->name;
Page::setActive("exam.exam_schedules");
Page::setTitle($title);
Page::setModuleName($title);
Page::setBreadcrumbs([
    [
        'url' => routeTo('/'),
        'title' => __('crud.label.home')
    ],
    [
        'title' => 'Rekapitulasi Ujian',
        'url' => routeTo('exam/schedules/groups/result', [
            'schedule_group_id' => $scheduleGroup->id
        ])
    ],
    [
        'title' => 'Detail Ujian'
    ]
]);


$schedule_user_data = $db->single('exam_schedule_user_data', [
    'schedule_id' => $schedule_id,
    'user_id'     => $user_id
]);
    
if($schedule_user_data)
{

    $schedule_user_data->data = json_decode($schedule_user_data->data);


    $answers = $db->all('exam_member_answers', [
        'schedule_id' => $schedule_id,
        'user_id' => $user_id
    ]);

    $normalizeAnswers = [];
    $totalScore = 0;
    foreach($answers as $answer)
    {
        $normalizeAnswers[$answer->question_item_id] = $answer;
        $totalScore += $answer->score;
    }

    return view('exam/views/schedules/groups/result-detail', compact('schedule_user_data','normalizeAnswers','totalScore'));
}

// return view('exam/views/schedules/groups/result', compact('title', 'member', 'group'));