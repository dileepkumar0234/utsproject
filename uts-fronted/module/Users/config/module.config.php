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
			'schedule-tax' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/schedule-tax',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'scheduleTax',
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
			//Referrelas
			'refereal-list' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/refereal-list',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'referealList',
					),
				),
			),
			'get-referels-info' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/get-referels-info',
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'getReferelsInfo',
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
			//Refer Friend 
			'refer-friend' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/refer-friend[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action'     => 'referFriend',
                    ),
                ),
            ),
			//End 
			//get-user-info
			'get-user-info' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/get-user-info[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action'     => 'getUserInfo',
                    ),
                ),
            ),
			//End
			'check-email-exits' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/check-email-exits[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action'     => 'checkEmailExits',
                    ),
                ),
            ),
			'reset-password' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/reset-password[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action'     => 'resetPassword',
                    ),
                ),
            ),
			'save-password' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/save-password[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action'     => 'savePassword',
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