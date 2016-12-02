<?php
include( 'public/global/globalvalues.php');
include( 'public/PHPMailer_5.2.4/sendmail.php' );
include( 'public/PHPMailer_5.2.4/smsmesg.php' );
return array(
    'db' 					=>	array(
        'driver'         	=> 	'Pdo',
        'driver_options' 	=> array(
            PDO::MYSQL_ATTR_INIT_COMMAND 	=> 	'SET NAMES \'UTF8\''
        ),
    ),	
    'service_manager' 		=> 	array(
        'factories' 		=> 	array(
            'Zend\Db\Adapter\Adapter'
							=> 'Zend\Db\Adapter\AdapterServiceFactory',
			'SlaveAdapter1' => 'Slave\Factory\Model\SlaveAdapter1ServiceFactory',
			'SlaveAdapter2' => 'Slave\Factory\Model\SlaveAdapter2ServiceFactory',
			'SlaveAdapter3' => 'Slave\Factory\Model\SlaveAdapter3ServiceFactory',
        ),
    ),
	'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
	),
);