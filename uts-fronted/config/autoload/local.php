<?php

return array(
    'db' 				=> 	array(
		'dsn' 			=>	'mysql:dbname=umpiretaxpayer;host=localhost',
        'username' 		=> 	'root',
        'password' 		=> 	'',
    ),
	'urls' 				=> 	array(
		'baseUrl' 		=> 	'http://localhost/utsproject/trunk/uts-fronted/',
		'basePath' 		=> 	'http://localhost/utsproject/trunk/uts-fronted/public',
		'imageUrl' 		=> 	'http://localhost/utsproject/trunk/uts-fronted/',
		'year' 			=> 	2016,
	),
	'service_manager' 	=> 	array(
        'factories' 	=> 	array(  
        ),
    ),
	'cache' => array(
		'adapter' => array(
			'name'    => 'Filesystem',
			'options' => array(
				'cache_dir' => __DIR__ . '/../../../data/cache',
				'ttl'       => '3600'
			)
		),
		'plugins' => array(
			array(
				'name'    => 'serializer',
				'options' => array()
			),
			'exception_handler' => array(
				'throw_exceptions' => true
			)
		)
	),
	
);

?>
