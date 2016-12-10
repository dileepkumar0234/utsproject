<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return array(
 'db' => array(
		'dsn'      => 'mysql:dbname=umpiretaxpayer;host=localhost',
        'username' => 'root',
        'password' => '',
    ),
	 'urls'                 =>     array(
        'baseUrl'         =>     'http://localhost/utsproject/trunk',
        'basePath'         =>    'http://localhost/utsproject/trunk/public',
        'imagesUrl'        =>    '#',
    ),
    'service_manager'     =>     array(
        'factories'     =>     array(  
        ),
    ),
);