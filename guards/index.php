<?php

use Core\Database;

$auth = auth();

if(in_array($route,['crud/edit','crud/delete']) && $_GET['table'] == 'exam_questions')
{
    $db = new Database();
    $question = $db->single('exam_questions', [
        'id' => $_GET['id']
    ]);

    $isSuperAdmin = false;
    $allowedRoutes = get_allowed_routes($auth->id);
    foreach($allowedRoutes as $path)
    {
        if($path->route_path == '*')
        {
            $isSuperAdmin = true;
            break;
        }
    }
    if($question->created_by != $auth->id && !$isSuperAdmin)
    {
        set_flash_msg(['error'=>__("exam.label.unauthorized")]);
        header("location: ".$_SERVER['HTTP_REFERER']);
        die();
    }
}

return true;