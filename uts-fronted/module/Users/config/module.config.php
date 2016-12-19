<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Users'		 			=> 'Users\Controller\UsersController',
            'Users\Controller\TaxDocuments'		 		=> 'Users\Controller\TaxDocumentsController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
			'index' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/home',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'index',
					),
				),
			),	
			'user-login' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/user-login',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'userLogin',
					),
				),
			),
			'dashboard' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/dashboard',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'dashboard',
					),
				),
			),		
			'tax-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/tax-info',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'taxInfo',
					),
				),
			),
			'emp-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/emp-info',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'empInfo',
					),
				),
			),
			'emp-edit-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/emp-edit-info',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'empEditInfo',
					),
				),
			),			
			'spouse-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/spouse-info',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'spouseInfo',
					),
				),
			),	
			'dependents-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/dependents-info',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'dependentsInfo',
					),
				),
			),
			'dependents-edit-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/dependents-edit-info',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'dependentsEditInfo',
					),
				),
			),
			'schdule-submit' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/schdule-submit',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'schduleSubmit',
					),
				),
			),
			'schedule-tax-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/schedule-tax-info',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'scheduleTaxInfo',
					),
				),
			),
			'remove-tax-file' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/remove-tax-file',
					'defaults' => array(
						'controller' => 'Users\Controller\TaxDocuments',
						'action'     => 'removeTaxFile',
					),
				),
			),			
			'upload-documents-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/upload-documents-info',
					'defaults' => array(
						'controller' => 'Users\Controller\TaxDocuments',
						'action'     => 'index',
					),
				),
			),	
			'summary-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/summary-info',
					'defaults' => array(
						'controller' => 'Users\Controller\TaxDocuments',
						'action'     => 'summaryInfo',
					),
				),
			),	
			'logout' => array(
				'type' => 'segment',
				'options' => array(
					'route'    => '/logout',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'logout',
					),
				),
			),
			'change-password' => array(
				'type' => 'segment',
				'options' => array(
					'route'    => '/change-password',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'changePassword',
					),
				),
			),
			'view-profile' => array(
				'type' => 'segment',
				'options' => array(
					'route'    => '/view-profile[/:id]',
					'constraints' => array(
						   'id' => '[%&;a-zA-Z0-9][%&+;a-zA-Z0-9_~-]*',
						),
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'viewProfile',
					),
				),
			),
        ),
	),     
    'view_manager' => array(
        'template_path_stack' => array(
            'Users' => __DIR__ . '/../view',
        ),
		'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
?>