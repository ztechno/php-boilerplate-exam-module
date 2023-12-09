<?php

return '<a href="'.routeTo('exam/schedules/groups/result',['schedule_group_id' => $data->id]).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> '.__('exam.label.result').'</a> 
<a href="'.routeTo('exam/schedules/groups/presence-list',['schedule_group_id' => $data->id]).'" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-print"></i> '.__('exam.label.presence list').'</a> ';