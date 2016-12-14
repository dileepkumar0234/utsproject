<?php

include( 'public/global/global_variables.php');
include( 'public/global/global_functions.php');
include( 'public/phpMailer/sendmail.php');

return array(
    'db' 					=>	array(
        'driver'         	=> 	'Pdo',
        'driver_options' 	=> array(
            PDO::MYSQL_ATTR_INIT_COMMAND 	=> 	'SET NAMES \'UTF8\''
        ),
		'driver_options' 	=> array(
            PDO::MYSQL_ATTR_INIT_COMMAND 	=> 	'SET SQL_BIG_SELECTS=1'
        ),
		'driver_options' 	=> array(
            PDO::MYSQL_ATTR_INIT_COMMAND 	=> 	'SET CHARSET \'UTF8\''
        ),
    ),
    'service_manager' 		=> 	array(
        'factories' 		=> 	array(
            'Zend\Db\Adapter\Adapter'
							=> 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
		'invokables' => array(
            'Zend\Session\SessionManager' => 'Zend\Session\SessionManager',
        ),
    ),
	 'abstract_factories' => array(
				'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
		  ),
);

?>