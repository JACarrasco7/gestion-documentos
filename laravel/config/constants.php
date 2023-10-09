<?php

return [
    'ROLES' => [
        'ADMINISTRATOR' => [
            'ID' => 1,
            'NAME_ES' => 'Administrator',
            'NAME_EN' => 'Administrador',
            'DESCRIPTION_ES' => 'Todos los permisos',
            'DESCRIPTION_EN' => 'All permission'
        ],
        'COMPANY' => [
            'ID' => 2,
            'NAME_ES' => 'Empresa',
            'NAME_EN' => 'Company',
            'DESCRIPTION_ES' => 'Solo puede ver sus construcciones, y subir y eliminar sus documentos',
            'DESCRIPTION_EN' => 'He can only view your builds, and upload and delete your documents'
        ],
        'EXTERNAL' => [
            'ID' => 3,
            'NAME_ES' => 'Externo',
            'NAME_EN' => 'External',
            'DESCRIPTION_ES' => 'Solo puede ver sus obra asignadas y su documentación',
            'DESCRIPTION_EN' => 'He can only see your assigned works and their documentation'
        ],
        'CONSTRUCTION_MANAGER' => [
            'ID' => 4,
            'NAME_ES' => 'Jefe de obra',
            'NAME_EN' => 'Construction manager',
            'DESCRIPTION_ES' => 'Solo puede ver sus obra asignadas y su documentación',
            'DESCRIPTION_EN' => 'He can only see your assigned works and their documentation'
        ],
        'GUEST' => [
            'ID' => 5,
            'NAME_ES' => 'Invitado',
            'NAME_EN' => 'Guest',
            'DESCRIPTION_ES' => 'Puede ver todas las construcciones y documentación, pero nada más',
            'DESCRIPTION_EN' => 'He can see all the builds and documentation, but nothing else'
        ],
    ],
    'MESSAGES_ALERT_ES' => [
        'ENTITY' => [
            'CREATED' => [
                'TITLE' => 'Entidad creada!',
                'TEXT' => 'La entidad ha sido creada con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Entidad editada!',
                'TEXT' => 'La entidad ha sido editada con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar la entidad ',
                'TITLE' => 'Entidad eliminada!',
                'TEXT' => 'La entidad ha sido eliminada con éxito',
            ]
        ],
        'USER' => [
            'CREATED' => [
                'TITLE' => 'Usuario creado!',
                'TEXT' => 'El usuario ha sido creado con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Usuario editado!',
                'TEXT' => 'El usuario ha sido editado con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar al usuario ',
                'TITLE' => 'Usuario eliminado!',
                'TEXT' => 'El usuario ha sido eliminado con éxito',
            ]
        ],
        'PROMOTER' => [
            'CREATED' => [
                'TITLE' => 'Promotor creado!',
                'TEXT' => 'El promotor ha sido creado con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Promotor editado!',
                'TEXT' => 'El promotor ha sido editado con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar al promotor ',
                'TITLE' => 'Promotor eliminado!',
                'TEXT' => 'El promotor ha sido eliminado con éxito',
            ],
        ],
        'BUILD' => [
            'CREATED' => [
                'TITLE' => 'Obra creada!',
                'TEXT' => 'La obra ha sido creada con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Obra editada!',
                'TEXT' => 'La obra ha sido editada con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar la obra ',
                'TITLE' => 'Obra eliminada!',
                'TEXT' => 'la obra ha sido eliminada con éxito',
            ],
            'COMPANY' => [
                'TITLE' => 'Asignado',
                'TEXT' => 'Empresa/s asignada/s con éxito',
            ],
            'WORKERS' => [
                'TITLE' => 'Asignado',
                'TEXT' => 'Trabajadores/as asignados/as con éxito',
            ],
            'MACHINES' => [
                'TITLE' => 'Asignado',
                'TEXT' => 'Maquinaria asignada con éxito',
            ],
            "ERROR" => [
                'TITLE' => 'Error...',
                "TEXT" => 'Ocurrió un error al crear la estrucuta de carpetas'

            ]
        ],
        'CATEGORY' => [
            'CREATED' => [
                'TITLE' => 'CategorÍa creada!',
                'TEXT' => 'La categoría ha sido creada con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Categoría editada!',
                'TEXT' => 'La categoría ha sido editada con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar la categoría ',
                'TITLE' => 'Categoría eliminada!',
                'TEXT' => 'La categoría ha sido eliminada con éxito',
            ]
        ],
        'WORKER' => [
            'CREATED' => [
                'TITLE' => 'Trabajador creado!',
                'TEXT' => 'El Trabajador ha sido creado con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Trabajador editado!',
                'TEXT' => 'El trabajador ha sido editado con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar el trabajador ',
                'TITLE' => 'Trabajador eliminado!',
                'TEXT' => 'El trabajador ha sido eliminado con éxito',
            ]
        ],
        'TEMPLATE' => [
            'CREATED' => [
                'TITLE' => 'Plantilla creada!',
                'TEXT' => 'La plantilla ha sido creada con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Plantilla editada!',
                'TEXT' => 'La plantilla ha sido editada con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar la plantilla ',
                'TITLE' => 'Plantilla eliminada!',
                'TEXT' => 'La plantilla ha sido eliminada con éxito',
            ]
        ],
        'ESPECIALTY' => [
            'CREATED' => [
                'TITLE' => 'Especialidad creada!',
                'TEXT' => 'La especialidad ha sido creada con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Especialidad editada!',
                'TEXT' => 'La especialidad ha sido editada con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar la especialidad ',
                'TITLE' => 'Especialidad eliminada!',
                'TEXT' => 'La especialidad ha sido eliminada con éxito',
            ]
        ],
        'COMPANY' => [
            'CREATED' => [
                'TITLE' => 'Empresa creada!',
                'TEXT' => 'La empresa ha sido creada con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Empresa editada!',
                'TEXT' => 'La empresa ha sido editada con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar la empresa ',
                'TITLE' => 'Empresa eliminada!',
                'TEXT' => 'La empresa ha sido eliminada con éxito',
            ],
        ],
        'MACHINE' => [
            'CREATED' => [
                'TITLE' => 'Maquinaria creada!',
                'TEXT' => 'La maquinaria ha sido creada con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Maquinaria editada!',
                'TEXT' => 'La maquinaria ha sido editada con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar la maquinaria ',
                'TITLE' => 'Maquinaria eliminada!',
                'TEXT' => 'La maquinaria ha sido eliminada con éxito',
            ],
        ],
        'EXPIRATION' => [
            'CREATED' => [
                'TITLE' => 'Tipo de expiración creado!',
                'TEXT' => 'El tipo de expiración ha sido creado con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Tipo de expiración editado!',
                'TEXT' => 'El tipo de expiración ha sido editado con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar el tipo de expiración ',
                'TITLE' => 'Tipo de expiración eliminado!',
                'TEXT' => 'El tipo de expiración ha sido eliminado con éxito',
            ]
        ],
        'DOCUMENT_TYPE' => [
            'CREATED' => [
                'TITLE' => 'Tipo de documento creado!',
                'TEXT' => 'El tipo de documento ha sido creado con éxito',
            ],
            'MODIFIED' => [
                'TITLE' => 'Tipo de documento editada!',
                'TEXT' => 'El tipo de documento ha sido editado con éxito',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'Vas a borrar el tipo de documento ',
                'TITLE' => 'Tipo de documento eliminado!',
                'TEXT' => 'El tipo de documento ha sido eliminado con éxito',
            ]
        ],
    ],
    'MESSAGES_ALERT_EN' => [
        'ENTITY' => [
            'CREATED' => [
                'TITLE' => 'Created entity!',
                'TEXT' => 'The entity has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Modified entity!',
                'TEXT' => 'The entity has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the entity ',
                'TITLE' => 'Deleted entity!',
                'TEXT' => 'The entity has been successfully deleted',
            ]
        ],
        'USER' => [
            'CREATED' => [
                'TITLE' => 'Created user!',
                'TEXT' => 'The user has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Modified user!',
                'TEXT' => 'The user has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the user ',
                'TITLE' => 'Deleted user!',
                'TEXT' => 'The user has been successfully deleted',
            ]
        ],
        'PROMOTER' => [
            'CREATED' => [
                'TITLE' => 'Created promoter!',
                'TEXT' => 'The promoter has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Modified promoter!',
                'TEXT' => 'The promoter has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the user ',
                'TITLE' => 'Deleted promoter!',
                'TEXT' => 'The promoter has been successfully deleted',
            ],
        ],
        'BUILD' => [
            'CREATED' => [
                'TITLE' => 'Created build!',
                'TEXT' => 'The build has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Modified build!',
                'TEXT' => 'The build has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the build ',
                'TITLE' => 'Build eliminated!',
                'TEXT' => 'The build has been successfully deleted',
            ],
            'COMPANY' => [
                'TITLE' => 'Assigned',
                'TEXT' => 'Company/s assigned successfully!',
            ],
            'WORKERS' => [
                'TITLE' => 'Assigned',
                'TEXT' => 'Worker/s assigned successfully ',
            ],
            'MACHINES' => [
                'TITLE' => 'Assigned',
                'TEXT' => 'Machine/s assigned successfully ',
            ],
            "ERROR" => [
                'TITLE' => 'Error...',
                "TEXT" => 'An error occurred while creating folder structure'
            ]
        ],
        'CATEGORY' => [
            'CREATED' => [
                'TITLE' => 'Category created!',
                'TEXT' => 'The category has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Category modified!',
                'TEXT' => 'The category has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the category ',
                'TITLE' => 'Category deleted!',
                'TEXT' => 'The category has been successfully deleted',
            ]
        ],
        'WORKER' => [
            'CREATED' => [
                'TITLE' => 'Worker created!',
                'TEXT' => 'The worker has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Worker modified!',
                'TEXT' => 'The worker has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the worker ',
                'TITLE' => 'Worker deleted!',
                'TEXT' => 'The worker has been successfully deleted',
            ]
        ],
        'EXPIRATION_TYPE' => [
            'CREATED' => [
                'TITLE' => 'Expiration type created!',
                'TEXT' => 'The expiration has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Expiration type modified!',
                'TEXT' => 'The expiration has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the category ',
                'TITLE' => 'Expiration type deleted!',
                'TEXT' => 'The expiration type has been successfully deleted',
            ]
        ],
        'DOCUMENT_TYPE' => [
            'CREATED' => [
                'TITLE' => 'Document type created!',
                'TEXT' => 'The document has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Document type modified!',
                'TEXT' => 'The document has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the category ',
                'TITLE' => 'Document type deleted!',
                'TEXT' => 'The document type has been successfully deleted',
            ],
        ],
        'TEMPLATE' => [
            'CREATED' => [
                'TITLE' => 'Template created!',
                'TEXT' => 'The template has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Template modified!',
                'TEXT' => 'The template has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the template ',
                'TITLE' => 'Template deleted!',
                'TEXT' => 'The template has been successfully deleted',
            ]
        ],
        'ESPECIALTY' => [
            'CREATED' => [
                'TITLE' => 'Especialty created!',
                'TEXT' => 'The especialty has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Especialty modified!',
                'TEXT' => 'The especialty has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the especialty ',
                'TITLE' => 'Especialty deleted!',
                'TEXT' => 'The especialty has been successfully deleted',
            ]
        ],
        'COMPANY' => [
            'CREATED' => [
                'TITLE' => 'Company created!',
                'TEXT' => 'The company has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Company modified!',
                'TEXT' => 'The company has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the company ',
                'TITLE' => 'Company deleted!',
                'TEXT' => 'The company has been successfully deleted',
            ]
        ],
        'MACHINE' => [
            'CREATED' => [
                'TITLE' => 'Machine created!',
                'TEXT' => 'The machine has been created successfully',
            ],
            'MODIFIED' => [
                'TITLE' => 'Machine modified!',
                'TEXT' => 'The machine has been successfully modified',
            ],
            'DELETED' => [
                'TITLE_CONFIRM' => 'You are going to delete the company ',
                'TITLE' => 'Machine deleted!',
                'TEXT' => 'The machine has been successfully deleted',
            ]
        ],
    ],
    'ENTITY_TEMPLATE_ID' => [
        'Company' => 1,
        'Worker' => 3,
        'Machine' => 2,
    ],
    'ENTITY_TEMPLATE_es' =>
        [
            'name' => [
                'Empresa',
                'Maquinaria',
                'Trabajadores',

            ],
        ],
    'ENTITY_TEMPLATE_en' =>
        [
            'name' =>
                [
                    'Companies',
                    'Machines',
                    'Workers',

                ],
        ],
    'COMPANY_TEMPLATE_es' =>
        [
            'name' => [
                'Empresa',
                'Maquinaria',
                'Trabajadores',
                'Obra'
            ],
        ],
    'COMPANY_TEMPLATE_en' =>
        [
            'name' =>
                [
                    'Companies',
                    'Machines',
                    'Workers',
                    'Build'
                ],
        ],
    'DOCUMENT_VALIDATION_NAME_es' => [
        1 => 'Validado',
        2 => 'Rechazado',
        3 => 'Pendiente',
        4 => 'Caducado',
    ],
    'DOCUMENT_VALIDATION_NAME_en' => [
        1 => 'Validated',
        2 => 'Rejected',
        3 => 'Pending',
        4 => 'Expired',
    ],
    'DOCUMENT_VALIDATION_ID' => [
        'Validado' => 1,
        'Rechazado' => 2,
        'Pendiente' => 3,
        'Caducado' => 4,
    ],
    'ENTITY_CLASS_en' => [

        'Companies' => App\Models\Company::class,
        'Machines' => App\Models\Machine::class,
        'Workers' => App\Models\Worker::class,
    ],
    'ENTITY_CLASS_es' => [

        'Empresa' => App\Models\Company::class,
        'Maquinaria' => App\Models\Machine::class,
        'Trabajadores' => App\Models\Worker::class,
    ],
    'GENERIC_FAIL_ES' => [
        'TITLE' => 'Opps! El becario ha tocado algo',
        'TEXT' => 'El proceso no ha podido completarse correctamente'
    ],
    'GENERIC_FAIL_EN' => [
        'TITLE' => 'Opps! Something has gone wrong',
        'TEXT' => 'The process could not be completed correctly'
    ],
    "TYPE_DOCUMENT_TYPE_ES" => [
        0 => "Genérico",
        1 => "Específico",
    ],
    "TYPE_DOCUMENT_TYPE_EN" => [
        0 => "Generic",
        1 => "Specific",
    ]
];
