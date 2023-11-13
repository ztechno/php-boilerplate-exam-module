<?php

use Core\Database;

$auth = auth();

if(in_array($route,['crud/edit','crud/delete']) && $_GET['table'] == 'exam_questions')
{
    $db = new Database();
    $question = $db->single('exam_questions', [
        'id' => $_GET['id']
    ]);

    if($question->created_by != $auth->id)
    {
        set_flash_msg(['error'=>__("exam.label.unauthorized")]);
        header("location: ".$_SERVER['HTTP_REFERER']);
        die();
    }
}

return true;