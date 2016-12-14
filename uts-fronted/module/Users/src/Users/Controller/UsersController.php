<?php
namespace Users\Controller;

use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class UsersController extends AbstractActionController
{
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
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));
		
	}
	public function spouseInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];	
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));
		
	}
	public function dependentsInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];	
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));
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
	public function uploadDocumentsInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];	
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));
	}
	public function summaryInfoAction(){
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

