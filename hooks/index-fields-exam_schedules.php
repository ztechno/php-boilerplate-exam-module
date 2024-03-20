<?php

$role = get_role(auth()->id);

$fields['schedule_status'] = [
    'label' => __('exam.label.schedule_status'),
    'type'  => 'text'
];

if($role->role_id == env('EXAM_MEMBER_ROLE_ID'))
{
    unset($fields['status']);
    unset($fields['question_showed']);
    unset($fields['randomize_question']);
    unset($fields['randomize_answer']);
}
else
{
    $fields['randomize_question']['type'] = 'text';
    $fields['randomize_answer']['type'] = 'text';
    $fields['token'] = [
        'label' => 'Token',
        'type'  => 'text'
    ];
}

return $fields;