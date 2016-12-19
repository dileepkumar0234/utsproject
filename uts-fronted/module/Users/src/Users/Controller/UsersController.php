<?php
namespace Users\Controller;

use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class UsersController extends AbstractActionController
{
	public function dashboardAction(){
		$user_session 				= new Container('user');
		$baseUrls 					= $this->getServiceLocator()->get('config');
		$baseUrlArr 				= $baseUrls['urls'];
		$baseUrl 					= $baseUrlArr['baseUrl'];
		$basePath 					= $baseUrlArr['basePath'];
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));
	}
    public function indexAction(){
		$user_session 				= new Container('user');
		$baseUrls 					= $this->getServiceLocator()->get('config');
		$baseUrlArr 				= $baseUrls['urls'];
		$baseUrl 					= $baseUrlArr['baseUrl'];
		$basePath 					= $baseUrlArr['basePath'];
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));
	}
	public function userLoginAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];	
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));		
	}
	
	//LOGOUT CONFIRMATION
	
	public function logoutAction(){
		if(isset($_GET['id']) && $_GET['id']=="google"){
			$user_session 	= 	new Container('user');			
		}else{
			$user_session 	= 	new Container('user');
			$admin_session 	= 	new Container('admin');
		}
		session_destroy();
		return new JsonModel(array(					
			'output' => 1
		));
	}
	
	Public function changePasswordAction(){
		$user_session  = 	new Container('user');
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$userTable  = $this->getServiceLocator()->get('Models\Model\UsersFactory');
		$u_id 		= $user_session->userId;
		$result		= $userTable->checkPassword($u_id,$_POST['oldPassword'])->current();
		if($result){
			$user_id 			= $result->u_id;
			$updatePassword		=  $userTable->updatePassword($user_id,$_POST['cnfPassword']);
			return new JsonModel(array(					
				'output' 	=> 'success'
			));
		}else{
			return new JsonModel(array(					
				'output' 	=> 'fail'
			));
		}
	}
	public function taxInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$userId     = 23;
		$userTable  = $this->getServiceLocator()->get('Models\Model\UserFactory');
		$userDetailesTable  = $this->getServiceLocator()->get('Models\Model\UserDetailsFactory');
		$getUserInfo = $userTable->getUserInfo($userId);
		if($_POST){
		    $userTable->saveUserData($_POST);
			$userDetailesTable->saveUserDetails($_POST);
			return new JsonModel(array(					
				'output' 	=> 'success',
			));
		}else{
			return new ViewModel(array(					
				'baseUrl' 	=>  $baseUrl,
				'basePath'  =>  $basePath,
				'userInfo'  =>  $getUserInfo,
			));
		}
		
	}
	public function spouseInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$userId     = 23;
		$userDetailesTable  = $this->getServiceLocator()->get('Models\Model\UserDetailsFactory');
		$userTable  = $this->getServiceLocator()->get('Models\Model\UserFactory');
		$getUserInfo = $userTable->getUserInfo($userId);
		if($_POST){
			$userDetailesTable->saveUserSpouseDetails($_POST);
			return new JsonModel(array(					
				'output' 	=> 'success',
			));
		}else{
			return new ViewModel(array(					
				'baseUrl' 	=>  $baseUrl,
				'basePath'  =>  $basePath,
				'userInfo'  =>  $getUserInfo,
			));
		}
	}
	public function empInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$year 		= $baseUrlArr['year'];
		$empTable   = $this->getServiceLocator()->get('Models\Model\EmployeeinfoFactory');
		$userId 	= 23;
		$empInfo 	= $empTable->getData($userId,$year);
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
			'empInfo'  			=>  $empInfo->toArray(),
		));
	}
	
	public function empEditInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$year 		= $baseUrlArr['year'];
		$empTable   = $this->getServiceLocator()->get('Models\Model\EmployeeinfoFactory');
		$userId 	= 23;
		if(isset($_POST) && count($_POST) != 0){
			$empInfo = $_POST;
			$empTable->addEmpInfo($empInfo,$userId);
			return $this->redirect()->toUrl($baseUrl.'emp-info');
		}else{
			$empInfo 	= $empTable->getData($userId);
			return new ViewModel(array(					
				'baseUrl' 			=>  $baseUrl,
				'basePath'  		=>  $basePath,
				'empInfo'  			=>  $empInfo->toArray(),
			));
		}
	}
	public function dependentsInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$year 		= $baseUrlArr['year'];
		$dependentTable  = $this->getServiceLocator()->get('Models\Model\DependentFactory');
		$userId = 23;
		$dependentsInfo = $dependentTable->getDependents($userId,$year);
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
			'dependentsInfo'  	=>  $dependentsInfo->toArray(),
		));
	}
	
	public function dependentsEditInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$year 		= $baseUrlArr['year'];
		$dependentTable  = $this->getServiceLocator()->get('Models\Model\DependentFactory');
		$userId = 23;
		if(isset($_POST) && count($_POST) != 0){
			$dependentInfo = $_POST;
			$dependentTable->addDependentInfo($dependentInfo,$userId);
			return $this->redirect()->toUrl($baseUrl.'dependents-info');
		}else{
			$dependentsInfo = $dependentTable->getDependents($userId,$year);
			return new ViewModel(array(					
				'baseUrl' 			=>  $baseUrl,
				'basePath'  		=>  $basePath,
				'dependentsInfo'  	=>  $dependentsInfo->toArray(),
			));
		}
	}
	
	public function scheduleTaxInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];	
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));
	}
}	

