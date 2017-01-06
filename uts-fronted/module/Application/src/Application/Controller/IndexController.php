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
	public function privacyPolicyAction(){
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		return new viewModel(array(					
			'baseUrl' 						=> 	$baseUrl,
			'basePath'   					=>  $basePath,
		));
	}
	public function termsConditionsAction(){
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		return new viewModel(array(					
			'baseUrl' 						=> 	$baseUrl,
			'basePath'   					=>  $basePath,
		));
	}
	public function referralAction(){
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		return new viewModel(array(					
			'baseUrl' 						=> 	$baseUrl,
			'basePath'   					=>  $basePath,
		));
	}
	//Testimonail
	public function testimonialAction(){
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
	public function checkFgtUidAction()
	{
		$uid = "";$token = "";
		if(isset($_POST['uid']) && $_POST['uid']!= "")
		{
			$uid 						= $_POST['uid'];			
			$token 						= $_POST['token'];			
		}
		$user_session 					= new Container('user');
		$baseUrls 						= $this->getServiceLocator()->get('config');
		$baseUrlArr 					= $baseUrls['urls'];
		$baseUrl 						= $baseUrlArr['baseUrl'];
		$basePath 						= $baseUrlArr['basePath'];
		$forgotTable  					= $this->getServiceLocator()->get('Models\Model\ForgetpasswordFactory');			
		$usersTable  					= $this->getServiceLocator()->get('Models\Model\UserFactory');			
		$checkFuid						= $forgotTable->checktoken($uid,$token);		
		if(!empty($checkFuid) && !is_null($checkFuid))
		{
			return new JsonModel(array(					
				'output' 	=> 'sucess',				
			));
		}
		else{
			return new JsonModel(array(					
				'output' 	=> 'fail',				
			));
		}
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
	public function checkRegAuthAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$userTable  = $this->getServiceLocator()->get('Models\Model\UserFactory');
		if(isset($_POST['sguid']) && $_POST['sguid']!=""){
			$uid      = $_POST['sguid'];
			$checkUserloginemail = $userTable->userdetailsreg($uid);
			if(isset($checkUserloginemail->status) && $checkUserloginemail->status!=0){
				return new JsonModel(array(
					'output'	=>	'exists',
				));
			}else{
				$updatedid = $userTable->updateUid($uid);
				$user_type_id = $checkUserloginemail->user_type_id;
				$user_id = $checkUserloginemail->user_id;
				$user_session = new Container('user');
				$user_session->user_id		=	$user_id;
				$user_session->email		=	$checkUserloginemail->email;
				$user_session->user_name	=	ucwords(strtolower($checkUserloginemail->user_name));
				$user_session->userType	    =	$user_type_id;
				$status = $checkUserloginemail->ps_state;
				$statusName = getFileStatusName($status);
				$user_session->file_name	=	$statusName;
				$user_session->unique_code	=	$checkUserloginemail->unique_code;
				return new JsonModel(array(
					'output'	=>	'success',
				));
			}
		}else{
			return new JsonModel(array(
				'output'	=>	'notsuccess',
			));
		}
	}
	public function signUpAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];	
		$userTable  = $this->getServiceLocator()->get('Models\Model\UserFactory');
		$userDetailesTable  = $this->getServiceLocator()->get('Models\Model\UserDetailsFactory');
		if(isset($_POST['inputEmail']) && $_POST['inputEmail']!=""){
			$uemail     = $_POST['inputEmail'];
			$cntEmail = $userTable->checkUniqueRecord($uemail);
			if($cntEmail>0){
				return new JsonModel(array(
					'output'	=>	'emailexists',
				));
			}else{
				$addedid = $userTable->addedUser($_POST); 
				if($addedid){
					$detailsId  = $userDetailesTable->addedUserInfo($_POST,$addedid);	
					$upwd       = $_POST['userpwd'];
					$username   = ucfirst($_POST['inputFirstname']);
					$uts = 'UTS-'.$addedid;
					$uid = base64_encode($uts);
					global $regSubject;
					global $regMessage;
					$url = $baseUrl.'reg-auth?regid='.$uid.'&auth=1';
					$regMessage = str_replace("<siteUrl>",$url,$regMessage);
					$regMessage = str_replace("<username>",$username,$regMessage);
					$regMessage = str_replace("<useremail>",$uemail,$regMessage);
					$regMessage = str_replace("<userpassword>",$upwd,$regMessage);
					$to = $uemail; 
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= 'From: <Hello@umpiretaxsolutions.com>' . "\r\n";
					mail($to,$regSubject,$regMessage,$headers);
					return new JsonModel(array(					
						'output' 	=> 'success'
					));
				}
			}
		}else{
			return new JsonModel(array(
				'output'	=>	'notsuccess',
			));
		}		
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
			$user_session->unique_code	=	$checkUserloginemail->unique_code;
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
