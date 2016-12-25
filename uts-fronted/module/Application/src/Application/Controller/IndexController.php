<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use ScnSocialAuth\Mapper\Exception as MapperException;
use ScnSocialAuth\Mapper\UserProviderInterface;
use ScnSocialAuth\Options\ModuleOptions;
use Zend\View\Model\JsonModel;
class IndexController extends AbstractActionController
{
	protected $mapper;
    protected $options;
   	public function setOptions(ModuleOptions $options){
        $this->options = $options;
        return $this;
    }	
	public function getOptions(){
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('ScnSocialAuth-ModuleOptions'));
        }
        return $this->options;
    }
	public function firmProfileAction(){
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		return new viewModel(array(					
			'baseUrl' 						=> 	$baseUrl,
			'basePath'   					=>  $basePath,
		));
	}
	public function servicesAction(){
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		return new viewModel(array(					
			'baseUrl' 						=> 	$baseUrl,
			'basePath'   					=>  $basePath,
		));
	}
	public function contactUsAction(){
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		return new viewModel(array(					
			'baseUrl' 						=> 	$baseUrl,
			'basePath'   					=>  $basePath,
		));
	}
	public function carrersAction(){
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		return new viewModel(array(					
			'baseUrl' 						=> 	$baseUrl,
			'basePath'   					=>  $basePath,
		));
	}
	public function taxCenterAction(){
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		return new viewModel(array(					
			'baseUrl' 						=> 	$baseUrl,
			'basePath'   					=>  $basePath,
		));
	}
	public function indexAction()
    {
		
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		
		return new viewModel(array(					
			'baseUrl' 						=> 	$baseUrl,
			'basePath'   					=>  $basePath,
		));
    }
	public function checkingLoginAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];	
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$email = $_POST['u_email'];
		$checkUserloginemail = $userTable->checkDetails($_POST)->current();	
		if(isset($checkUserloginemail->user_id) && $checkUserloginemail->user_id!=''){
			$user_type_id = $checkUserloginemail->user_type_id;
			$user_id = $checkUserloginemail->user_id;
			$user_session = new Container('user');
			$user_session->user_id		=	$user_id;
			$user_session->email		=	$checkUserloginemail->email;
			$user_session->user_name	=	ucwords(strtolower($checkUserloginemail->user_name));
			$user_session->userType	    =	$user_type_id;
			$user_session->phone	    =	$checkUserloginemail->phone;
			$status = $checkUserloginemail->ps_state;
			$statusName = getFileStatusName($status);
			$user_session->file_name	=	$statusName;
			$user_session->phone	    =	$checkUserloginemail->phone;
			return new JsonModel(array(
				'output'	=>	'success',
			));
		}else{
			return new JsonModel(array(
				'output'	=>	'wrongdeatils',
			));
		}		
	}
	public function headerAction($params)
    {
		$user_session 						=  new Container('user');
		$admin_session 						= new Container('admin');		
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		
		return $this->layout()->setVariable(
			"headerarray",array(
				'baseUrl' 					=> $baseUrl,
				'basePath' 					=> $basePath,
			)
		);
	}
	public function contactFormAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$contactTable = $this->getServiceLocator()->get('Models\Model\ContactUsFactory'); 
		$saveReferer = $contactTable->inserContact($_POST);
		return new JsonModel(array(
			'output'    =>  'success',
		));	
	}
}
