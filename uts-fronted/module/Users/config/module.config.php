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
			'social-sign-in' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/social-sign-in',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'socialSignIn',
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