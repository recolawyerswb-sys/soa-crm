<?php
namespace App\Data\Pages\Dashboard;

class Help
{
    public function getSections()
    {
        $sections = [
            [
                'id' => 'getting-started',
                'title' => 'Primeros Pasos',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    // NUEVO: Tipo 'heading' para un encabezado dentro de la sección.
                    [
                        'type' => 'heading',
                        'text' => 'Configuración de tu Perfil',
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Para comenzar, asegúrate de haber completado la configuración inicial de tu perfil. Esto es crucial para personalizar tu experiencia.'
                    ],
                    [
                        'type' => 'list',
                        'listType' => 'ol',
                        'items' => [
                            'Navega al Dashboard principal.',
                            'Haz clic en tu nombre de usuario en la esquina superior derecha.',
                            'Selecciona "Mi Perfil" y completa los campos requeridos.'
                        ]
                    ]
                ]
            ],
            [
                'id' => 'clientes',
                'title' => 'Clientes',
                'canRead' => 'admin|agent',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'El módulo de Clientes permite registrar, consultar y administrar toda la información de los clientes del banco. Desde aquí se pueden crear nuevos clientes, actualizar sus datos, adjuntar documentos y consultar su historial financiero.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                    [
                        'type' => 'list',
                        'items' => [
                            'Navega al Dashboard principal.',
                            'Haz clic en tu nombre de usuario en la esquina superior derecha.',
                            'Selecciona "Mi Perfil" y completa los campos requeridos.'
                        ]
                    ]
                ]
            ],
            [
                'id' => 'agentes',
                'title' => 'Agentes',
                'canRead' => 'admin|agent',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                ]
            ],
            [
                'id' => 'equipos',
                'title' => 'Equipos',
                'canRead' => 'admin|agent',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                ]
            ],
            [
                'id' => 'asignaciones',
                'title' => 'Asignaciones',
                'canRead' => 'admin|agent',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                ]
            ],
            [
                'id' => 'seguimientos',
                'title' => 'Seguimientos',
                'canRead' => 'admin|agent',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                ]
            ],
            [
                'id' => 'roles y permisos',
                'title' => 'Roles y permisos',
                'canRead' => 'admin',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                ]
            ],
            [
                'id' => 'historial',
                'title' => 'Historial',
                'canRead' => 'admin|agent',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                ]
            ],
            [
                'id' => 'pruebas',
                'title' => 'Pruebas',
                'canRead' => 'admin|agent',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                ]
            ],
            [
                'id' => 'reportes',
                'title' => 'Reportes',
                'canRead' => 'admin|agent',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                ]
            ],
            [
                'id' => 'cuentas',
                'title' => 'Cuentas',
                'canRead' => 'admin|agent|customer',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                ]
            ],
            [
                'id' => 'movimientos',
                'title' => 'Movimientos',
                'canRead' => 'admin|agent|customer',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'text' => 'Bienvenido a nuestra plataforma. Esta guía te ayudará a familiarizarte con las funciones principales. Nuestra interfaz está diseñada para ser intuitiva y eficiente.'
                    ],
                    [
                        'type' => 'paragraph',
                        'text' => 'Esta sesion es de suma importancia para administrar los clientes.'
                    ],
                ]
            ],

        ];

        return $sections;
    }
}
