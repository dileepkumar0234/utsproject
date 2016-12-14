<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Users'		 			=> 'Users\Controller\UsersController',
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
			'upload-documents-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/upload-documents-info',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'uploadDocumentsInfo',
					),
				),
			),	
			'summary-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/summary-info',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
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