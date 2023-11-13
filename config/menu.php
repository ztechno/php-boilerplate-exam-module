<?php

return [
    [
        'label' => 'exam.menu.exams',
        'icon'  => 'fa-fw fa-xl me-2 fa-solid fa-graduation-cap',
        'activeState' => [
            'exam.exam_groups',
            'exam.exam_group_member',
            'exam.exam_questions',
            'exam.exam_schedules',
        ],
        'items' => [
            [
                'label' => 'exam.menu.groups',
                'route' => routeTo('crud/index',['table'=>'exam_groups']),
                'activeState' => [
                    'exam.exam_groups',
                    'exam.exam_group_member',
                ]
            ],
            [
                'label' => 'exam.menu.questions',
                'route' => routeTo('crud/index',['table'=>'exam_questions']),
                'activeState' => 'exam.exam_questions'
            ],
            [
                'label' => 'exam.menu.schedules',
                'route' => routeTo('crud/index',['table'=>'exam_schedules']),
                'activeState' => 'exam.exam_schedules'
            ]
        ]
    ],
];