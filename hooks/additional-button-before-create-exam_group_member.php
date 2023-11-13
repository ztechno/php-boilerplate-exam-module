<?php

$group_id = $_GET['filter']['group_id'];
return '<a href="'.routeTo('exam/groups/member/import',['group_id'=>$group_id]).'" class="btn btn-sm btn-primary"><i class="fas fa-upload"></i> '.__('exam.label.import').'</a> ';