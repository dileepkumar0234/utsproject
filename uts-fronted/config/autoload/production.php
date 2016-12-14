<?php

$dbParams = array(
    'database'  			=> 	'umpiretaxpayer',
    'username'  			=> 	'root',
    'password'  			=> 	'',
    'hostname'  			=> 	'localhost',
);
return array(
    'db' 					=> 	array(
		'dsn'      			=> 	'mysql:dbname=umpiretaxpayer;host=localhost',
        'username' 			=> 	'root',
        'password' 			=> 	'',
    ),
    'urls' 					=> 	array(
        'CASURL' 			=> 	'www.yahoo.com',
    ),
	'service_manager' 		=> array(
        'factories' 		=> array(
            'Zend\Db\Adapter\Adapter' 		=> function ($sm) use ($dbParams) {
                return new Zend\Db\Adapter\Adapter(array(
                    'driver'    			=> 	'pdo',
                    'dsn'       			=> 	'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
                    'database'  			=> 	$dbParams['database'],
                    'username'  			=> 	$dbParams['username'],
                    'password'  			=> 	$dbParams['password'],
                    'hostname'  			=> 	$dbParams['hostname'],
                ));
            },
        ),
    ),
);

?>