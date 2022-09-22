<?php

namespace Empresa;

return [
    'router' => [
        'routes' => [
            'empresa' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route' => '/empresa[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => Controller\EmpresaController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            //Controller\EmpresaController::class => InvokableFactory::class
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'empresa' => __DIR__ . '/../view'
        ]
    ]
];
