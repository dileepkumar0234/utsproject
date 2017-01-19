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
	protected $whitelist = array('/dashboard','/team-leads','/reset-password','/client-view','/add-team-member','/edit-member','/add-shop','/shops-list','/pricing','/view-shop','/edit-shop','/steps-process','/change-password','/edit-profile','/complaint-list','/bookings-info','manage-team','leads-executives','user-logs','all-present-logins','last-logs-list','assigned-service-list','service-assigned-process','unassigned-service-list','bookings-info','leads-reports','users-guest-list','security-questions','all-users');
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
		$result=$eventManager->attach('route', array($this, 'loadConfiguration'), 2);
		$this -> initAcl($e);
		$e -> getApplication() -> getEventManager() -> attach('route', array($this, 'checkAcl'));
		//echo "<pre>";print_r($result);exit;
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
							  ->doAuthorization($e); //pass to the plugin...   
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
			//$allResources = array_merge($resources, $allResources);
			//adding resources
			foreach ($resources as $resource) {
				 // Edit 4
				 if(!$acl ->hasResource($resource))
					$acl -> addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
			}
			//adding restrictions
			foreach ($resources as $resource) {
				//$acl -> allow($role, $resource);
				if ( $resource ) {
					$acl->allow($role, $resource);
				} else {
					$acl->deny($role, $resource);
				}
			}
		}
		//testing
		//var_dump($acl->isAllowed('executive','forget-password'));exit;
		//true
	 
		//setting to view
		$e -> getViewModel() -> acl = $acl;
	}
 
	public function checkAcl(MvcEvent $e) {
		$route = $e -> getRouteMatch() -> getMatchedRouteName();
		//you set your role
		if(isset($_SESSION['user'])&& $_SESSION['user']['user_type_id']!=""){
			if($_SESSION['user']['user_type_id']=="1"){
				$userRole = 'admin';
			}else if($_SESSION['user']['user_type_id']=="2"){
				$userRole = 'lead';
			}else if($_SESSION['user']['user_type_id']=="3"){
				$userRole = 'team-lead';
			}
		}else{
			$userRole = 'guest';
		}
		if (!$e -> getViewModel() -> acl -> isAllowed($userRole, $route)) {
			$response = $e -> getResponse();
			//location to page or what ever
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
		//ini_set('display_error',1);
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
