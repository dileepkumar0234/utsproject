<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements AutoloaderProviderInterface
{
	protected $whitelist = array('/admin', '/change-password', '/user-management', '/user-payment', '/reports-management',  '/client-management', '/ad-management', '/admin-logout', '/checking-login');
     public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
		$result=$eventManager->attach('route', array($this, 'loadConfiguration'), 2);
		$this -> initAcl($e);
		$e -> getApplication() -> getEventManager() -> attach('route', array($this, 'checkAcl'));
		$serviceManager      = $e->getApplication()->getServiceManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
	 public function loadConfiguration(MvcEvent $e)
    {
        $application   = $e->getApplication();
		$sm            = $application->getServiceManager();
		$sharedManager = $application->getEventManager()->getSharedManager();
        $router = $sm->get('router');
		$request = $sm->get('request');
		$list = $this->whitelist;
		
		$current_url= str_replace($request->getBaseUrl(),'',$request->getrequestUri());
		if($this->searchArray($current_url,$list))
		{
			$matchedRoute = $router->match($request);
			if (null !== $matchedRoute) {
				   $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController','dispatch',
						function($e) use ($sm) {
				   $sm->get('ControllerPluginManager')->get('Myplugin')
							  ->doAuthorization($e); 
				   },2
				   );
				}
		}
		
    }
	
	public function initAcl(MvcEvent $e) {
 
		$acl = new \Zend\Permissions\Acl\Acl();
		$acl->deny();
		$roles = include __DIR__ . '/config/module.acl.roles.php';
		$allResources = array();
		foreach ($roles as $role => $resources) {
			$role = new \Zend\Permissions\Acl\Role\GenericRole($role);
			$acl -> addRole($role);	
			foreach ($resources as $resource) {
				 if(!$acl ->hasResource($resource))
					$acl -> addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
			}
			
			foreach ($resources as $resource) {

				if ( $resource ) {
					$acl->allow($role, $resource);
				} else {
					$acl->deny($role, $resource);
				}
			}
			
		}
		// var_dump(!$acl->isAllowed('client','user-management'));exit;
		$e -> getViewModel() -> acl = $acl;
		

	}
 
	public function checkAcl(MvcEvent $e) {
		$route = $e -> getRouteMatch() -> getMatchedRouteName();
		session_start();
		
		if(isset($_SESSION['admin'])&& $_SESSION['admin']['user_type']!=""){
			if($_SESSION['admin']['user_type']=="1"){
				$userRole = 'admin';
			}else if($_SESSION['admin']['user_type']=="2"){
				$userRole = 'client';
			}
		}else{
			$userRole = 'guest';
		}
				//echo "<pre>";print_r(!$e -> getViewModel() -> acl -> isAllowed($userRole, $route));exit;

		if ($e -> getViewModel()->acl ->hasResource($route) && !$e -> getViewModel() -> acl -> isAllowed($userRole, $route)) {
			$response = $e -> getResponse();
			$response -> getHeaders() -> addHeaderLine('Location', $e -> getRequest() -> getBaseUrl() . '/404');
			$response -> setStatusCode(404);
		}
	}
	
	function searchArray($search, $array)
	{
		foreach($array as $key => $value)
		{
			if (stristr($search,$value))
			{
				return true;
			}
		}
		return false;
	}
    public function getConfig()
    {
		ini_set('session.save_path', __DIR__ . '/../../data/session/');
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
		 return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
       
    }
	 public function getServiceConfig() {
        return array(
            'factories' => array(
                'Application\Cache\Redis' => 'Application\Service\Factory\RedisCacheFactory',                
            )
        );
    }	
}
