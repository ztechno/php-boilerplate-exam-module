<?php

use Core\Utility;
use Core\Database;
use Core\Storage;

if (!isset($argv[2])) 
{
    echo "Question id is empty\n";
    die;
}

$question_id  = $argv[2];
$parent_path = Utility::parentPath();

$db = new Database;

// get questions
$questions = $db->all('exam_question_items', ['id' => $question_id]);
foreach($questions as $index => $question)
{
    $no = $index + 1;
    $answers = $db->all('exam_question_answers', ['item_id' => $question->id]);
    foreach(range('a', 'e') as $alpha)
    {
        $filename = 'q-'.$question->id.'/'.$no.$alpha.'.png';
        if(Storage::exists($filename))
        {
            echo $filename."\n";
        }
    }
}