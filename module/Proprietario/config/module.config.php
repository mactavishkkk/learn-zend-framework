<?php

namespace Proprietario;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'proprietario' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/proprietario[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProprietarioController::class,
                        'action' => 'index',
                    ]
                ]
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ]
    ]

];
