<?php
return array(
	'controller_plugins' => array(
		'invokables' => array(
		   'Myplugin' => 'Application\Controller\Plugin\Myplugin',
		 )
	 ),
	'view_helpers' 				=> 	array(
		'invokables' 			=> 	array(
			'action' 			=> 	'Eva\View\Helper\Action',
		),  
	),
	'router' 					=> 	array(
		'routes' 				=> 	array(
			'home' 				=> 	array(
				'type' 			=> 	'Zend\Mvc\Router\Http\Literal',
				'options' 		=> 	array(
					'route'    	=> 	'/',
					'defaults' 	=> 	array(
						'controller' 	=> 	'Application\Controller\Index',
						'action'     	=> 	'index',
					),
				),
			),
			'reset-mode' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/reset-mode',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'index',
					),
				),
			),
			'check-fuid' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/check-fuid',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'checkFgtUid',
					),
				),
			),
			'checking-login' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/checking-login',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'checkingLogin',
					),
				),
			),
			'firm-profile' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/firm-profile',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'firmProfile',
					),
				),
			),
			'referral' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/referral',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'referral',
					),
				),
			),
			'services' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/services',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'services',
					),
				),
			),
			'tax-center' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/tax-center',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'taxCenter',
					),
				),
			),
			'carrers' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/carrers',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'carrers',
					),
				),
			),
			'contact-us' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/contact-us',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'contactUs',
					),
				),
			),
			'contact-form' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/contact-form',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'contactForm',
					),
				),
			),
			'application' 		=> 	array(
				'type'    		=> 	'Zend\Mvc\Router\Http\Segment',
				'options' 		=> 	array(
					'route'    	=> 	'/application',
					'defaults' 	=> 	array(
						'__NAMESPACE__' 	=> 	'Application\Controller',
						'controller'    	=> 	'Index',
						'action'       		=> 	'index',
					),
				),
				
				'may_terminate' 	=> 	true,
				'child_routes' 		=> 	array(
					'default' 		=> 	array(
						'type'    	=> 	'Segment',
						'options' 	=> 	array(
							'route'    			=> 	'/[:controller[/:action]]',
							'constraints' 		=> 	array(
								'controller' 	=> 	'[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     	=> 	'[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' 			=> array(
							),
						),
					),
					
					
				),
			),
		),
	),
	'service_manager' 			=> 	array(
		'abstract_factories' 	=> 	array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		'aliases' 				=> 	array(
			'translator' 		=> 	'MvcTranslator',
		),
	),
	'translator' => array(
		'locale' => 'en_US',
		'translation_file_patterns' => array(
			array(
				'type'     => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern'  => '%s.mo',
			),  
		),       
	),
	'default' => array(  
	  'type' => 'Segment',   
	  'options' => array(       
		'route' => '/[:controller[/:action][/:locale]]',     
		'constraints' => array(            
		  'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',            
		  'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',           
		  'locale'     => '[a-zA-Z]{2}_[a-zA-Z]{2}',       
		),       
		'defaults' => array(           
		  'locale' => 'en_US'       
		),   
	  ),
	),
	'controllers' 					=> 	array(
		'invokables' 				=> 	array(
			'Application\Controller\Index' 	=> 	'Application\Controller\IndexController'
		),
	),
	'view_manager' 						=> 	array(
		'display_not_found_reason' 		=> 	true,
		'display_exceptions'       		=> 	true,
		'doctype'                  		=> 	'HTML5',
		'not_found_template'       		=> 	'error/404',
		'exception_template'       		=> 	'error/index',
		'template_map' => array(
			'layout/layout'           	=> 	__DIR__ . '/../view/layout/layout.phtml',
			'application/index/index' 	=> 	__DIR__ . '/../view/application/index/index.phtml',
			'error/404'               	=> 	__DIR__ . '/../view/error/404.phtml',
			'error/index'             	=>	__DIR__ . '/../view/error/index.phtml',
		),
		'template_path_stack' 			=> array(
			__DIR__ . '/../view',
		),
		'strategies' 					=> array(
			'ViewJsonStrategy',
		),
	),	
);
