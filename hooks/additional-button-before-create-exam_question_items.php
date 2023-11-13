<?php

$question_id = $_GET['filter']['question_id'];
return '<a href="'.routeTo('exam/questions/items/import',['question_id'=>$question_id]).'" class="btn btn-sm btn-primary"><i class="fas fa-upload"></i> '.__('exam.label.import').'</a> ';