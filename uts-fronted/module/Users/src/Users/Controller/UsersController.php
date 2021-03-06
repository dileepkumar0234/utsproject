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
	public function scheduleTaxAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$scheduleTable  = $this->getServiceLocator()->get('Models\Model\SchedulesTimingsFactory');
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}
		$result = $scheduleTable->getTotalInfo($userId);
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
			'schData'  			=>  $result,
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
		$user_session 	= 	new Container('user');
		session_destroy();
		return new JsonModel(array(					
			'output' => 1
		));
	}
	
	Public function changePasswordAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		if(isset($_POST["oldPassword"]) && $_POST["oldPassword"]!=""){
			$userTable  = $this->getServiceLocator()->get('Models\Model\UserFactory');
			$u_id 		 = $_SESSION["user"]["user_id"];
			$oldPassword = $_POST["oldPassword"];
			$result		 = $userTable->getpassword($u_id,$_POST['oldPassword']);
			if($result!=0){
				$updatePassword		=  $userTable->changepwd($u_id,$_POST['confirmPassword']);
				return new JsonModel(array(					
					'output' 	=> 'success',
					'message' 	=> 'success'
				));
			}else{
				return new JsonModel(array(					
					'output' 	=> 'fail',
					'message' 	=> 'oldpasswordworng',
				));
			}
		}else{
			return new JsonModel(array(					
				'output' 	=> 'fail',
				'message' 	=> 'oldpasswordrequired',
			));
		}
	}
	public function taxInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		//$userId     = 23;
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}
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
	//Referels List
	
	
	public function referealListAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		//$userId     = 23;
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}
		return new ViewModel(array(					
			'baseUrl' 	=>  $baseUrl,
			'basePath'  =>  $basePath
		));
	}
	public function getReferelsInfoAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}
		$refTable = $this->getServiceLocator()->get('Models\Model\RefferalFriendsFactory');
		$getShedInfo    = $refTable->getRefInfo($userId);
			if(count($getShedInfo) > 0 ){
				$i = 0;
				$data = array();
				foreach($getShedInfo as $shedInfo){
					if($shedInfo->user_name != ""){
						$name = $shedInfo->user_name;
					}else{
						$name = $shedInfo->rf_on_name;
					}
					if($shedInfo->email != ""){
						$email = $shedInfo->email;
					}else{
						$email = $shedInfo->rf_on_email;
					}
					if($shedInfo->phone != ""){
						$phone = $shedInfo->phone;
					}else{
						$phone = $shedInfo->rf_on_phone;
					}
					$data[$i]['rf_name']      = $shedInfo->rf_name;
					$data[$i]['rf_email']     = $shedInfo->rf_email;
					$data[$i]['rf_phone']     = $shedInfo->rf_phone;
					$data[$i]['re_on_name']   = $name;
					$data[$i]['re_on_email']  = $email;
					$data[$i]['rf_on_phone']  = $phone;
					$data[$i]['rf_comment']   = $shedInfo->rf_comment;
					$i++;
				}	
				$datainfo['aaData'] = $data;	
			}else{ 
				$datainfo['aaData'] = array();
			}
			echo json_encode($datainfo); exit;
	}
	//Exit;
	public function spouseInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}
		   $spouseTable  = $this->getServiceLocator()->get('Models\Model\SpouseFactory');
		  
		  $getSpouseInfo  = $spouseTable->getSpousesData($userId);
		  if($_POST){
			   $spouse_id = '';
			   if(isset($_POST['hidspouse_id']) && $_POST['hidspouse_id']!=""){
				  $spouse_id = $_POST['hidspouse_id'];
			   }
			  $getSpouseInfo  = $spouseTable->checkSpouseId($spouse_id);
			  if(isset($getSpouseInfo->spouse_id) && $getSpouseInfo->spouse_id !=""){
				  $spouseTable->saveSpouseeData($_POST,$getSpouseInfo->spouse_id);
			  }else{
				  $spouseTable->saveSpouseeData($_POST,0);
			  }
			 return new JsonModel(array(					
				'output' 	=> 'success',
			 ));
		  }else{
			return new ViewModel(array(					
				'baseUrl' 	=>  $baseUrl,
				'basePath'  =>  $basePath,
				'userInfo'  =>  $getSpouseInfo,
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
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}
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
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}		
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
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}
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
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}
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
		$scheduleTable  = $this->getServiceLocator()->get('Models\Model\SchedulesTimingsFactory');
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}
		$result = $scheduleTable->getData($userId);
		if(isset($result->timing_id)){
			$ustatus = 1;
		}else{
			$ustatus = 0;
		}
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
			'ustatus'  			=>  $ustatus,
		));
	}
	public function schduleSubmitAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$user_session = new Container('user');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$userId  = $user_session->user_id;
		}else{
			$userId  = "";
		}
		$scheduleTable  = $this->getServiceLocator()->get('Models\Model\SchedulesTimingsFactory');
		$sdate	= $_POST['scDate'];
		$stime	= $_POST['scTime'];
		$scheduleTable->addScheduleDateTime($sdate,$stime,$userId);
		return new JsonModel(array(					
			'output' 			=> 1
		));
	}
	
	//Refer Friend 
	
	public function referFriendAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$user_session = new Container('user');
		$refTable = $this->getServiceLocator()->get('Models\Model\RefferalFriendsFactory'); 
		if(isset($_POST['friendEmail']) && $_POST["friendEmail"]!=""){
			$checkEmail  = $refTable->checkEmail($_POST['friendEmail']);
			if($checkEmail == 0){
				if(isset($user_session->user_id) && $user_session->user_id !=""){
					$u_id  = $user_session->user_id;
				}else{
					$u_id  = "";
				}
				$saveReferer = $refTable->saveReferer($u_id ,$_POST);
				return new JsonModel(array(
					'output'       =>  'success',
				));	
			}else{
				return new JsonModel(array(
					'output'       =>  'email exits',
				));	
			}
		}else{
			return new JsonModel(array(
				'output'       =>  'fail',
			));	
		}
		
	}
	public function getUserInfoAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$user_session = new Container('user');
		
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$u_id  = $user_session->user_id;
		}else{
			$u_id  = "";
		}
		$userTable  = $this->getServiceLocator()->get('Models\Model\UserFactory');
		$getUserInfo = $userTable->userdetails($u_id);
		if(isset($getUserInfo->user_id) && $getUserInfo->user_id != ""){
			return new JsonModel(array(
				'userInfo'     =>  $getUserInfo,
				'output'       =>  'success',
			));	
		}else{
			return new JsonModel(array(
				'output'       =>  'fail',
			));	
		}
	}
	
	public function checkEmailExitsAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$user_session = new Container('user');
		$forgetTable  = $this->getServiceLocator()->get('Models\Model\ForgetpasswordFactory');
		$userTable  = $this->getServiceLocator()->get('Models\Model\UserFactory');
		$saveReferer = $userTable->checkEmail($_POST['ForgetEmail']);
		if(isset($saveReferer->user_id) && $saveReferer->user_id !=""){
			$userName = ucfirst($saveReferer->user_name);
			global $forgetSubject;
			global $forgetMessage;
			$token = getUniqueCode('6');
			$uid = $saveReferer->user_id;
			$url = $baseUrl.'reset-mode?token='.$token.'&uid='.$uid.'&reset=1';
			$saveInfo  = $forgetTable->addForgetpwd($saveReferer->user_id,$_POST['ForgetEmail'],$token);
			$forgetMessage 	= str_replace("<SITELINK>",$url,$forgetMessage);
			$forgetMessage 	= str_replace("<FULLNAME>",$userName,$forgetMessage);
            $to = $_POST['ForgetEmail']; 
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <Reachus@umpiretaxsolutions.com>' . "\r\n";
			mail($to,$forgetSubject,$forgetMessage,$headers);
			return new JsonModel(array(					
				'output' 	=> 'success'
			));
			
			
			// if(sendMail($to,$forgetSubject,$forgetMessage)){
				// return new JsonModel(array(					
					// 'output' 	=> 'success'
				// ));
			// }else{
				// return new JsonModel(array(					
					// 'output' => 'success',
					// 'url' 	 => $url,
				// ));
			// }			
		}else{
			return new JsonModel(array(
				'output'    =>  'fail',
			));	
		}
	}
	
	public function resetPasswordAction(){
		$baseUrls     = $this->getServiceLocator()->get('config');
		$baseUrlArr   = $baseUrls['urls'];
		$baseUrl      = $baseUrlArr['baseUrl'];
		$basePath     = $baseUrlArr['basePath'];
		$forgetTable  = $this->getServiceLocator()->get('Models\Model\ForgetpasswordFactory');
		$token        = $this->params()->fromRoute('id', 0);
		$checkToken   = $forgetTable->checkToken();
		if($checkToken == 1){
			return new ViewModel(array(					
				'baseUrl' 			=>  $baseUrl,
				'basePath'  		=>  $basePath,
				'token'             => $token,
			));
		}else{
			return new ViewModel(array(					
				'baseUrl' 			=>  $baseUrl,
				'basePath'  		=>  $basePath,
				'token'				=> 0,
			));
		}
		
	}
	
	public function savePasswordAction(){
		$baseUrls     = $this->getServiceLocator()->get('config');
		$baseUrlArr   = $baseUrls['urls'];
		$baseUrl      = $baseUrlArr['baseUrl'];
		$basePath     = $baseUrlArr['basePath'];
		$forgetTable  = $this->getServiceLocator()->get('Models\Model\ForgetpasswordFactory');
		$userTable  = $this->getServiceLocator()->get('Models\Model\UserFactory');
		if(isset($_POST['f_UserId']) && $_POST['f_UserId']!=""){			
			$checktoken   = $forgetTable->checktoken($_POST['f_UserId'],$_POST['f_token']);
			$uid = $_POST['f_UserId'];
			$pwd = $_POST['f_confirmPassword'];
			if(isset($checktoken['forget_pwd_id']) && $checktoken['forget_pwd_id']!="")
			{				
				$forget_pwd_id = $checktoken['forget_pwd_id'];
				$deleteToken   = $forgetTable->deleteToken($forget_pwd_id);
				$savePassword  = $userTable->changepwd($uid,$pwd);
				return new JsonModel(array(					
					'output' => 'success',	
				));
			}else{
				return new JsonModel(array(					
					'output' => 'fail',	
				));
			}
		}else{
			return new JsonModel(array(					
				'output' => 'fail',	
			));
		}
	}	
}	

