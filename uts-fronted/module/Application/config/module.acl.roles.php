<?php 
return array(
    'guest'=> array(
		'home',
		'zfcadmin/forgot-password',
		'zfcadmin/reset-password',
		'zfcadmin/checking-login',
    ),
	// Admin Accessing Controllers
    'admin'=> array(
		'zfcadmin/change-password',
        'zfcadmin/user-management',
		'zfcadmin/client-management',
        'zfcadmin/ad-management',
        'zfcadmin/reports-management',
        'zfcadmin/user-payment',
        'zfcadmin/admin-logout'
    ),	
	// client Controllers
	'client'=> array(
        'zfcadmin/change-password',
        'zfcadmin/ad-management',
        'zfcadmin/admin-logout'
    ),
);

