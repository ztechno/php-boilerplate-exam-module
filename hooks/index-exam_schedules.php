<?php
$role = get_role(auth()->id);

if($filter)
{
    $filter_query = [];
    foreach($filter as $f_key => $f_value)
    {
        $filter_query[] = "$f_key = '$f_value'";
    }

    $filter_query = implode(' AND ', $filter_query);

    $where = (empty($where) ? 'WHERE ' : ' AND ') . $filter_query;
}

if($role->role_id == env('EXAM_MEMBER_ROLE_ID'))
{
    // get user group : SELECT group_id FROM exam_group_member WHERE user_id = auth()->id
    $where = (empty($where) ? 'WHERE ' : ' AND ') . " status='PUBLISH' AND id IN (SELECT schedule_id FROM exam_schedule_groups WHERE group_id IN (SELECT group_id FROM exam_group_member WHERE user_id = ".auth()->id."))";
}

$db->query = "SELECT *, IF(randomize_question=1,'Ya','Tidak') randomize_question, IF(randomize_answer=1,'Ya','Tidak') randomize_answer, (SELECT COUNT(*) FROM exam_member_answers WHERE exam_member_answers.schedule_id = exam_schedules.id) as is_answered FROM $this->table $where ORDER BY ".$col_order." ".$order[0]['dir']." LIMIT $start,$length";
$data  = $this->db->exec('all');

$total = $this->db->exists($this->table,$where,[
    $col_order => $order[0]['dir']
]);

return compact('data','total');