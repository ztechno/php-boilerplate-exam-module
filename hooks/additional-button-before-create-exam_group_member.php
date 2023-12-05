<?php

$params = [];
if(isset($_GET['filter']) && isset($_GET['filter']['group_id']))
{
    $params['group_id'] = $_GET['filter']['group_id'];
}
return '<a href="'.routeTo('exam/groups/member/import',$params).'" class="btn btn-sm btn-primary"><i class="fas fa-upload"></i> '.__('exam.label.import').'</a> ';