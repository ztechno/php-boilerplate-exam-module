<?php

$role = get_role(auth()->id);
$button = "";
$doUrl = routeTo('exam/do',['schedule_id' => $data->id]);
$groupUrl = routeTo('crud/index',['table'=>'exam_schedule_groups','filter'=>['schedule_id' => $data->id]]);
$questionUrl = routeTo('crud/index',['table'=>'exam_schedule_questions','filter'=>['schedule_id' => $data->id]]);
$generateUrl = routeTo('exam/schedules/generate',['schedule_id' => $data->id]);
$generateTokenUrl = routeTo('exam/schedules/generate-token',['schedule_id' => $data->id]);

if(is_allowed(parsePath(routeTo('exam/do')), auth()->id) && $role->role_id == env('EXAM_MEMBER_ROLE_ID'))
{
    $start_at   = strtotime($data->start_at);
    $end_at     = strtotime($data->end_at);
    $now        = strtotime('now');
    $notStarted = $now < $start_at;
    $finished   = $data->is_answered;
    $isDone     = $data->exam_user_status == 'DONE';
    if($notStarted)
    {
        $button .= 'Belum Mulai';
    }
    else if($finished)
    {
        $button .= '<a href="'.routeTo('exam/result',['id'=>$data->id]).'" class="btn btn-sm btn-primary">'.__('exam.label.result').'</a> ';
    }
    else if($isDone)
    {
        $button .= 'Ujian Telah Selesai';
    }
    else
    {
        $button .= '<a href="'.$doUrl.'" class="btn btn-sm btn-primary" onclick="return validateToken(this)" data-token='.$data->token.'>'.__('exam.label.do').'</a> ';
    }
}

if(is_allowed(parsePath(routeTo('crud/index',['table'=>'exam_schedule_groups'])), auth()->id))
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

if(is_allowed(parsePath($generateTokenUrl), auth()->id))
{
    $button .= '<a href="'.$generateTokenUrl.'" class="btn btn-sm btn-primary"> '.__('exam.label.generate token').'</a> ';
}

return $button;