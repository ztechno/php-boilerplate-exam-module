<?php

$role = get_role(auth()->id);
$button = "";
$doUrl = routeTo('exam/do',['schedule_id' => $data->id]);
$groupUrl = routeTo('crud/index',['table'=>'exam_schedule_groups','filter'=>['schedule_id' => $data->id]]);
$questionUrl = routeTo('crud/index',['table'=>'exam_schedule_questions','filter'=>['schedule_id' => $data->id]]);
$generateUrl = routeTo('exam/schedules/generate',['schedule_id' => $data->id]);

if(is_allowed(parsePath(routeTo('exam/do')), auth()->id) && $role->role_id == env('EXAM_MEMBER_ROLE_ID'))
{
    $start_at   = strtotime($data->start_at);
    $end_at     = strtotime($data->end_at);
    $now        = strtotime('now');
    $notStarted = $now < $start_at;
    $finished   = $now > $end_at || $data->is_answered;
    $button     .= $notStarted ? 'Belum Mulai' : ($finished ? '<a href="'.routeTo('exam/result',['id'=>$data->id]).'" class="btn btn-sm btn-primary">'.__('exam.label.result').'</a> ' : '<a href="'.$doUrl.'" class="btn btn-sm btn-primary">'.__('exam.label.do').'</a> ');
}

if(is_allowed(parsePath($groupUrl), auth()->id))
{
    $button .= '<a href="'.$groupUrl.'" class="btn btn-sm btn-info"> '.__('exam.label.group').'</a> ';
}

if(is_allowed(parsePath($questionUrl), auth()->id))
{
    $button .= '<a href="'.$questionUrl.'" class="btn btn-sm btn-primary"> '.__('exam.label.exam_question').'</a> ';
}

if(is_allowed(parsePath($generateUrl), auth()->id))
{
    $button .= '<a href="'.$generateUrl.'" class="btn btn-sm btn-primary"> '.__('exam.label.generate').'</a> ';
}

return $button;