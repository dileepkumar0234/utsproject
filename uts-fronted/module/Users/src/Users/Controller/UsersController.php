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
	public function viewProfileAction(){
		$user_session  = 	new Container('user');
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];		
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));
	}
	
	//Outsourcing Community list
	public function outsourcingViewallAction(){
		$user_session = new Container('user');
		$baseUrls 	  = $this->getServiceLocator()->get('config');
		$baseUrlArr   = $baseUrls['urls'];
		$baseUrl 	  = $baseUrlArr['baseUrl'];
		$basePath 	  = $baseUrlArr['basePath'];
		$userTable    = $this->getServiceLocator()->get('Models\Model\UsersFactory');
		$recentUsers  = $userTable->getRecentUsers();
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
			'recentUsers'  		=>  $recentUsers
		));
	}
	//Outsourcing Ajax  list
	public function outsourcingViewallAjaxAction(){
		$user_session = new Container('user');
		$baseUrls 	  = $this->getServiceLocator()->get('config');
		$baseUrlArr   = $baseUrls['urls'];
		$baseUrl 	  = $baseUrlArr['baseUrl'];
		$basePath 	  = $baseUrlArr['basePath'];
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));
	}
	
	//updateProfile
	public function updateProfileAction(){
		$user_session = new Container('user');
		$baseUrls 	  = $this->getServiceLocator()->get('config');
		$baseUrlArr   = $baseUrls['urls'];
		$baseUrl 	  = $baseUrlArr['baseUrl'];
		$basePath 	  = $baseUrlArr['basePath'];  
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
		));
	}
	//Upload Profile Image 
	public function uploadProfileImageAction(){
		if(isset($_FILES) && isset($_FILES['fileCropInp']['name'])){
			@unlink('./public/uploads/'.$_POST['imageId']);
			$croppedNewWidth 	= 	$_POST['croppedNewWidth'];
			$croppedNewHeight 	= 	$_POST['croppedNewHeight'];
			$croppedX 			= 	$_POST['croppedX'];
			$croppedY 			= 	$_POST['croppedY'];
			$image 				= 	stripslashes($_FILES['fileCropInp']['name']);
			$temp 				= 	explode(".", $_FILES["fileCropInp"]["name"]);
			$extension 			= 	end($temp);
			$uploadedfile		=	$_FILES['fileCropInp']['tmp_name'];
			
			if($extension=="jpg" || $extension=="jpeg" || $extension=="jpe"){
				$src = imagecreatefromjpeg($uploadedfile);
			}
			else if($extension=="png"){
				$src = imagecreatefrompng($uploadedfile);
			}
			else{
				$src = imagecreatefromgif($uploadedfile);
			}
			
			list($width,$height)	=	getimagesize($uploadedfile);
			$tmp					=	imagecreatetruecolor($croppedNewWidth,$croppedNewHeight);
			imagecopyresampled($tmp,$src,0,0,$croppedX,$croppedY,$croppedNewWidth,$croppedNewHeight,$croppedNewWidth,$croppedNewHeight);
			
			$imageName = date('Ymd') ."_". date("His") .'.' . $extension;
			$newfilenamePath = "./public/uploads/profiles/".$imageName;
			imagejpeg($tmp,$newfilenamePath,100);
			imagedestroy($tmp);
			imagedestroy($src);
			$user_session 			= 	new Container('admin');
			
			// if($user_session->userId == $_POST['u_id']){
				// $user_session->profile  =   $imageName;
			// }
			$userTable  = 	$this->getServiceLocator()->get('Models\Model\UsersFactory');
			//$result		=	$userTable->updateUserProfileImage($imageName,$_POST['u_id']);
			return $view = new JsonModel(array(
				'output'  		=> 1,
				'imageName' 	=> $imageName
			));
		}
	}
	
	//Privacy policy 
	
	public function termsConditionsAction(){
		$user_session = new Container('user');
		$baseUrls 	  = $this->getServiceLocator()->get('config');
		$baseUrlArr   = $baseUrls['urls'];
		$baseUrl 	  = $baseUrlArr['baseUrl'];
		$basePath 	  = $baseUrlArr['basePath'];  
		return new ViewModel(array(
			'baseUrl'		=> $baseUrl,
			'basePath' 		=> $basePath
		));
	}	
	
	public function socialSignInAction(){
		$user_session = new Container('user');
		$baseUrls 	  = $this->getServiceLocator()->get('config');
		$baseUrlArr   = $baseUrls['urls'];
		$baseUrl 	  = $baseUrlArr['baseUrl'];
		$basePath 	  = $baseUrlArr['basePath'];
		$email = $_GET['id'];
		if($email == 'facebook'){
			global $Social_obj;
			$login_Info = $Social_obj->facebook();
			exit;
		}else if($email == 'info'){
			global $Social_obj;
			$flogin_Info = $Social_obj->facebook();
			$socialPTable=$this->getServiceLocator()->get('Models\Model\SocialProvidersFactory');
			$userTable   = $this->getServiceLocator()->get('Models\Model\UsersFactory');
			$userDetailsTable   = $this->getServiceLocator()->get('Models\Model\UserInfoFactory');
			$checkingProvider = $socialPTable->checkProvider($flogin_Info['User']);
			if($checkingProvider!=''){					
				$updateEmail = $userTable->updateEmail($flogin_Info['User'],$flogin_Info['facebook_logout'],$checkingProvider->sp_u_id);
				$getUserInfo = $userTable->getUserInfoF($checkingProvider->sp_u_id);	
				$user_session = new Container('user');
				$user_session->userId       =  $getUserInfo->u_id;
				$user_session->email		=  $getUserInfo->u_email;
				$user_session->displayName	=  ucwords(strtolower($getUserInfo->uf_fname));
				$user_session->userType	    =  $getUserInfo->u_ut_id;
				$user_session->new_user     = 0;
				$user_session->loginwithsc    = "fb";
			}else{
				$email = $flogin_Info['User']['email'];
				$u_social_logout = $flogin_Info['facebook_logout'];
				$emailChecking = $userTable->checkEmailExists($email);
				if($emailChecking=='0'){
					if($flogin_Info['User']['email']!=""){
						$insertedUser = $userTable->addSUserProvider($flogin_Info['User'],$flogin_Info['facebook_logout']);
						$insertedProdiver = $socialPTable->addSocialProvide($insertedUser,$flogin_Info['User']);				
						$insertedUserD = $userDetailsTable->addSUserProviderD($insertedUser,$flogin_Info['User']);
						$getUserInfo = $userTable->getUserInfoF($insertedUser);
						$user_session = new Container('user');
						$user_session->userId       =  $getUserInfo->u_id;
						$user_session->email		=  $getUserInfo->u_email;
						$user_session->displayName	=  ucwords(strtolower($getUserInfo->uf_fname));
						$user_session->userType	    =  $getUserInfo->u_ut_id;
						$user_session->new_user     = 1;
						$user_session->loginwithsc    = "fb";
					}
				}else{
					$user_session = new Container('user');
					$user_session->alreadyExists='fb';
					$user_session->u_social_logout=$u_social_logout;
				}
			}			
?>
<script>
self.close();
</script>
<?
			exit;
		}
		else if($email == 'fdata'){	
			$userTable  = $this->getServiceLocator()->get('Models\Model\UsersFactory');
			if(isset($_SESSION['user']['userId']) && $_SESSION['user']['userId']!=""){
				$getUserInfo = $userTable->getUserInfoF($_SESSION['user']['userId']);			
				if($_SESSION['user']['new_user'] == 1){					
					$_SESSION['user']['new_user'] = 0;
					return $result = new JsonModel(array(
						'output'     => "loginsuccess",
					));
				}else{
					return $result = new JsonModel(array(
						'output'     => "loginsuccess",
					));
				}			
			}else if(isset($_SESSION['user']['alreadyExists']) && $_SESSION['user']['alreadyExists']=='fb'){
				$data['existsUser'] = 1;
				$data['u_social_logout'] = $_SESSION['user']['u_social_logout'];
				return $result = new JsonModel(array(
					'output'     => 1,
					'fbdata' 	 => $data,
				));
			}else{
				return $result = new JsonModel(array(
					'noStatus' 	=> "No Data"
				));
			}
		}
		if($email == 'google'){
			global $Social_obj;
			$google_login_Info = $Social_obj->google();			
			$socialPTable=$this->getServiceLocator()->get('Models\Model\SocialProvidersFactory');
			$userTable   = $this->getServiceLocator()->get('Models\Model\UsersFactory');
			$userDetailsTable   = $this->getServiceLocator()->get('Models\Model\UserInfoFactory');
				$checkingProvider = $socialPTable->checkProvider($google_login_Info['User']);		
				if(isset($checkingProvider->sp_u_id) && $checkingProvider->sp_u_id!=''){	
					$getUserInfo = $userTable->getUserInfoF($checkingProvider->sp_u_id);	
					$user_session = new Container('user');
					$user_session->userId       =  $getUserInfo->u_id;
					$user_session->email		=  $getUserInfo->u_email;
					$user_session->displayName	=  ucwords(strtolower($getUserInfo->uf_fname));
					$user_session->userType	    =  $getUserInfo->u_ut_id;
					$user_session->new_user     = 0;
					$user_session->loginwithsc    = "ge";					
				}else{					
					if($google_login_Info['User']!=""){
						$email = $google_login_Info['User']['email'];
						$emailChecking = $userTable->checkEmailExists($email);
						if($emailChecking=='0'){
							if($google_login_Info['User']['name']!=""){
								$insertedUser = $userTable->addSGoogleProvider($google_login_Info['User']);
								$insertedProdiver = $socialPTable->addSocialProvide($insertedUser,$google_login_Info['User']);				
								$insertedUserD = $userDetailsTable->addSGoogleProviderD($insertedUser,$google_login_Info['User']);
								$getUserInfo = $userTable->getUserInfoF($insertedUser);	
								$user_session = new Container('user');
								$user_session->userId       =  $getUserInfo->u_id;
								$user_session->email		=  $getUserInfo->u_email;
								$user_session->displayName	=  ucwords(strtolower($getUserInfo->uf_fname));
								$user_session->userType	    =  $getUserInfo->u_ut_id;
								$user_session->new_user     = 1;
								$user_session->loginwithsc    = "ge";
							}
						}else{
							$user_session = new Container('user');
							$user_session->alreadyExists='ge';							
						}
					}
				}
			
?>
<script>
self.close();
</script>
<?		
		exit;
		}else if($email == 'google_login'){
			$userTable   = $this->getServiceLocator()->get('Models\Model\UsersFactory');
			// echo "<pre>";print_r($_SESSION);exit;
			if(isset($_SESSION['user']['userId']) && $_SESSION['user']['userId']!=""){
				if($_SESSION['user']['new_user'] == 1){					
					$_SESSION['user']['new_user'] = 0;					
					return $result = new JsonModel(array(
						'output'     => "loginsuccess",
					));
				}else{
					return $result = new JsonModel(array(
						'output'     => "loginsuccess",
					));
				}
			}else if(isset($_SESSION['user']['alreadyExists']) && $_SESSION['user']['alreadyExists']=='ge'){
				return $result = new JsonModel(array(
					'output'     => 1,
				));
			}else{
				return $result = new JsonModel(array(
					'noStatus' 	=> "No Data"
				));
			}
		}
	}
}	

