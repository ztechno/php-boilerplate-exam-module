<?php

use Core\Scheduler;
use Core\Database;

Scheduler::register('exam/commands/process-answers');

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