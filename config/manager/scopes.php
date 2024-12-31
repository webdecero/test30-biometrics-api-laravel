<?php

return [

    'Admin' =>
        [
            [
                'label' => 'Administradores',
                'description' => 'Grupo de permisos para Administradores',
                'scopes' => [
                    'admin-show' => 'Ver de Administradores',
                    'admin-store' => 'Crear de Administrador',
                    'admin-update' => 'Editar de Administrador',
                    'admin-delete' => 'Borrar de Administrador',
                ],
            ],
            [
                'label' => 'Usuarios',
                'description' => 'Grupo de permisos para Usuarios',
                'scopes' => [
                    'user-show' => 'Ver de Usuarios',
                    'user-store' => 'Crear de Usuarios',
                    'user-update' => 'Editar de Usuarios',
                    'user-delete' => 'Borrar de Usuarios',
                ],
            ],

            [
                'label' => 'Huellas',
                'description' => 'Grupo de permisos para Huellas',
                'scopes' => [
                    'fingerprint-show' => 'Ver de Huellas',
                    'fingerprint-store' => 'Crear de Huellas',
                    'fingerprint-update' => 'Editar de Huellas',
                    'fingerprint-delete' => 'Borrar de Huellas',
                ],
            ],

            [
                'label' => 'Grupos',
                'description' => 'Grupo de permisos para Grupos',
                'scopes' => [
                    'group-show' => 'Ver de Grupos',
                    'group-store' => 'Crear de Grupo',
                    'group-update' => 'Editar de Grupo',
                    'group-delete' => 'Borrar de Grupo',
                ],
            ],
            [
                'label' => 'Terminales Registry',
                'description' => 'Grupo de permisos para Terminales Registry',
                'scopes' => [
                    'registry-show' => 'Ver de Terminales Registry',
                    'registry-config' => 'Ajustar de Terminales Registry',
                ],
            ],
            [
                'label' => 'Terminales Kiosks',
                'description' => 'Grupo de permisos para Terminales Kiosks',
                'scopes' => [
                    'kiosk-show' => 'Ver de Terminales Kiosks',

                    'kiosk-delete' => 'Borrar de Terminales Kiosks',
                ],
            ],
            [
                'label' => 'Terminales Torniquete',
                'description' => 'Grupo de permisos para Terminales Torniquete',
                'scopes' => [
                    'torniquet-show' => 'Ver de Terminales Torniquete',

                    'torniquet-delete' => 'Borrar de Terminales Torniquete',
                ],
            ],
            [
                'label' => 'Locaciones',
                'description' => 'Grupo de permisos para Locaciones',
                'scopes' => [
                    'location-show' => 'Ver de Locaciones',
                    'location-update' => 'Editar de Locaciones',
                ],
            ],
            [
                'label' => 'Registros accesos',
                'description' => 'Grupo de permisos para Registros accesos',
                'scopes' => [
                    'access-show' => 'Ver de Registros accesos',
                    'access-delete' => 'Borrar de Registros accesos',
                ],
            ],
            [
                'label' => 'Registros Pagos',
                'description' => 'Grupo de permisos para Registros pagos',
                'scopes' => [
                    'payment-show' => 'Ver de Registros pagos',
                    'payment-update' => 'Editar de Registros pagos',
                    'payment-delete' => 'Borrar de Registros pagos',
                ],
            ],
            [
                'label' => 'Compañia',
                'description' => 'Grupo de permisos para Compañia',
                'scopes' => [
                    'company-show' => 'Ver de Compañia',
                    'company-update' => 'Editar de Compañia',
                ],
            ],

        ],
    'User' =>
        [
            [
                'label' => 'Usuarios',
                'description' => 'Grupo de permisos para Usuarios',
                'scopes' => [
                    'user-show' => 'Ver de Usuarios',
                    'user-store' => 'Crear de Usuarios',
                    'user-update' => 'Editar de Usuarios',
                    'user-delete' => 'Borrar de Usuarios',
                ],
            ]


        ],

];
