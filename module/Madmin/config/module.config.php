<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Madmin\Controller\Madmin' => 'Madmin\Controller\MadminController',
			'Madmin\Controller\Shops'   => 'Madmin\Controller\ShopsController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'madmin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/madmin[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Madmin\Controller\Madmin',
                        'action'     => 'index',
                    ),
                ),
            ),
			'sign-out' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/sign-out[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Madmin\Controller\Madmin',
                        'action'     => 'signOut',
                    ),
                ),
            ),
			'members' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/members[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Madmin\Controller\Madmin',
                        'action'     => 'members',
                    ),
                ),
            ),
			'all-assigned-users' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/all-assigned-users[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Madmin\Controller\Madmin',
                        'action'     => 'allAssignedUsers',
                    ),
                ),
            ),
			'assign-user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/assign-user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Madmin\Controller\Madmin',
                        'action'     => 'assignUser',
                    ),
                ),
            ),
			'to-be-assigned' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/to-be-assigned[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Madmin\Controller\Madmin',
                        'action'     => 'toBeAssigned',
                    ),
                ),
            ),
			'assigned-to-users' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/assigned-to-users[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Madmin\Controller\Madmin',
                        'action'     => 'assignedToUsers',
                    ),
                ),
            ),
			'common-processing' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/common-processing[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Madmin\Controller\Madmin',
                        'action'     => 'commonProcessing',
                    ),
                ),
            ),
			'check-logins-mode' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/check-logins-mode[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Madmin\Controller\Madmin',
                        'action'     => 'checkLoginsMode',
                    ),
                ),
            ),
			'all-users' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/all-users[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Madmin\Controller\Madmin',
                        'action'     => 'allUsers',
                    ),
                ),
            ),
		),
	),     
    'view_manager' => array(
        'template_path_stack' => array(
            'madmin' => __DIR__ . '/../view',
        ),
		'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
	
);
?>