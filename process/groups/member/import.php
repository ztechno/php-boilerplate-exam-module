<?php

use Core\Page;
use Core\Request;
use Core\Utility;
use Core\Database;
use Modules\Crud\Libraries\Repositories\CrudRepository;
$group_id = $_GET['group_id'];


if(Request::isMethod('POST'))
{
    $db = new Database;
    $inputFileName = $_FILES['member_file']['tmp_name'];

    /**  Identify the type of $inputFileName  **/
    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
    /**  Create a new Reader of the type that has been identified  **/
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    /**  Load $inputFileName to a Spreadsheet Object  **/
    $spreadsheet = $reader->load($inputFileName);
    $worksheet   = $spreadsheet->getActiveSheet();
    $highestRow  = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    for ($row = 2; $row <= $highestRow; $row++) { 
        $name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
        $username = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        $password = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

        // create question
        $user = $db->insert('users', [
            'name' => $name,
            'username' => $username,
            'password' => md5($password),
        ]);

        $db->insert('user_roles', [
            'user_id' => $user->id,
            'role_id' => env('EXAM_MEMBER_ROLE_ID')
        ]);

        $db->insert('exam_group_member',[
            'user_id' => $user->id,
            'group_id' => $group_id
        ]);
    }

    set_flash_msg(['success'=>"Import peserta berhasil"]);

    header('location:'.routeTo('crud/index',[
        'table' => 'exam_group_member',
        'filter' => [
            'group_id' => $group_id
        ]
    ]));
    die();
}


// page section
$title = _ucwords(__("exam.label.import"));
Page::setActive("exam.exam_group_member");
Page::setTitle($title);
Page::setModuleName($title);
Page::setBreadcrumbs([
    [
        'url' => routeTo('/'),
        'title' => __('crud.label.home')
    ],
    [
        'url' => routeTo('crud/index', ['table' => 'exam_group_member', 'filter' => ['group_id' => $group_id]]),
        'title' => __('exam.label.exam_group_member')
    ],
    [
        'title' => 'Import'
    ]
]);

return view('exam/views/groups/member/import', compact('group_id'));