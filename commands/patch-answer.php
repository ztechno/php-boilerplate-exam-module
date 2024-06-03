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
$question = $db->single('exam_question_items', ['id' => $question_id]);

if(empty($question))
{
    echo "Question not found!";
    die();
}

echo "Question found : ".$question->name."\n";
$items = $db->all('exam_question_items', ['question_id' => $question->id]);
foreach($items as $index => $item)
{
    $no = $index + 1;
    $answers = $db->all('exam_question_answers', ['item_id' => $item->id]);
    foreach(range('a', 'e') as $alpha)
    {
        $filename = 'q-'.$item->id.'/'.$no.$alpha.'.png';
        if(Storage::exists($filename))
        {
            echo $filename."\n";
        }
    }
}