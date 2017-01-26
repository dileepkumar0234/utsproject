<?php
namespace Madmin\Controller;
use Zend\Form\Form;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Stdlib\Parameters;
use Zend\Authentication\AuthenticationService;
use SanAuthWithDbSaveHandler\Storage\IdentityManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\Cache\StorageFactory;
use ScnSocialAuth\Mapper\UserProviderInterface;
class MadminController extends AbstractActionController
{	
	public function signOutAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		session_destroy();
		return new JsonModel(array(
			'output'	=>	"success",
			'basePath'	=>	$basePath,
			'baseUrl'   =>  $baseUrl
		));	
	}
	public function indexAction()
	{
	
	}	
	public function referelsAction(){
		$baseUrls   = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl    = $baseUrlArr['baseUrl'];
		$basePath   = $baseUrlArr['basePath'];
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath
		));
		return $viewModel;
	}
	
	public function schedulesAction(){
		$baseUrls   = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl    = $baseUrlArr['baseUrl'];
		$basePath   = $baseUrlArr['basePath'];
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath
		));
		return $viewModel;
	}
	
	public function getReferelsInfoAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$refTable = $this->getServiceLocator()->get('Models\Model\RefferalFriendsFactory');
		$getShedInfo    = $refTable->getRefInfo();
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
	
	
	public function getScheduleInfoAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$sheduleTable = $this->getServiceLocator()->get('Models\Model\SchedulesTimingsFactory');
		$getShedInfo    = $sheduleTable->getSheduleInfo();
			if(count($getShedInfo) > 0 ){
				$i = 0;
				$data = array();
				foreach($getShedInfo as $shedInfo){
					if($shedInfo->user_type_id!=1){
						$data[$i]['client_name']=$shedInfo->user_name;
						$data[$i]['client_email']= '<a href="'.$baseUrl.'/all-tabs/'.$shedInfo->user_id.'-'.$shedInfo->ps_state.'">'.$shedInfo->email.'</a>';
						$data[$i]['shedule_date']= $shedInfo->schedule_dt;
						$data[$i]['shedule_period']= $shedInfo->schedule_period;
						$i++;
					}					
				}	
				$datainfo['aaData'] = $data;	
			}else{ 
				$datainfo['aaData'] = array();
			}
			echo json_encode($datainfo); exit;
	}
	
	
	public function allTabsAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$ids 		= $this->params()->fromRoute('id', 0);
		$id 				= explode('-',$ids);
		$userId				= $id[0];
		$processStatus		= $id[1];
		return new ViewModel(array(
			'basePath'			=>	$basePath,
			'baseUrl'   		=>  $baseUrl,
			'userId'   			=>  $userId,
			'processStatus'   	=>  $processStatus
		));	
	}
	public function checkLoginsModeAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$checkUserloginemail = $userTable->checkDetails($_POST)->current();	
		$user_session = new Container('user');
		if($checkUserloginemail!=''){
			$user_type_id = $checkUserloginemail->user_type_id;
			if($user_type_id!='2'){
				$user_id = $checkUserloginemail->user_id;
				$ip = '127.0.0.1';
				$checkIpAddress = $userTable->checkAdminIp($_POST,$ip)->current();
				if($checkIpAddress!=''){
					$uEmail		  = $checkIpAddress->email;
					$uName   	  = $checkIpAddress->user_name;
					$uPhone 	  = $checkIpAddress->phone;
					$user_id 	  = $checkIpAddress->user_id;
					$user_type    = $checkIpAddress->user_type;
					$user_type_id = $checkIpAddress->user_type_id;
					$user_session->userId       = $user_id; 
					$user_session->ut_type_name = $user_type; 
					$user_session->u_name       = $uName; 
					$user_session->u_email      = $uEmail; 
					$user_session->u_phone      = $uPhone; 
					$user_session->user_type_id = $user_type_id; 
					return new JsonModel(array(
						'output'       =>  'success',
						'status'	   =>	'',
						'userType'     =>  '',
						'u_ut_type_id' =>  $user_type_id
					));		
				}else{
					return new JsonModel(array(
						'status'	=>	'fail',
						'ip'		=>  'Login root is wrong',
						'UserType' 	=>  '',
					));			
				}
			}else{
				return new JsonModel(array(			
					'output'        =>  'fail',
					'status'	    =>	'not-allowed-you',
				));			
			}	
		}else{
			return new JsonModel(array(
				'output'        => 'fail',
				'status'		=>  'log-in-fails',
			));	
		}
	}
	public function wantUsToCallAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$viewModel = new ViewModel(
			array(
				'baseUrl'		=> $baseUrl,
				'basePath' 		=> $basePath				
		));
		return $viewModel;
	}
	
	public function assignedFileNumberAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$getNewUser = $userTable->getNewUsers();
		$viewModel = new ViewModel(
			array(
				'baseUrl'		=> $baseUrl,
				'basePath' 		=> $basePath,
				'newuser'		=> $getNewUser
		));
		return $viewModel;
	}
	
	public function checkUserExitsAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$getNewUser = $userTable->checkFileNumber($_POST['newUser'],$_POST['fileNumber']);
		if(isset($getNewUser->user_id) && $getNewUser->user_id !=""){
			return new JsonModel(array(
				'output'        => 'exits',
			));
		}else{
			$updateUser  = $userTable->updateUser($_POST['newUser'],$_POST['fileNumber']);
			return new JsonModel(array(
				'output'        => 'success',
		    ));	
		}
		
	}
	
	//Get want info 
	public function getWantUsInfoAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];	
		$contactTable=$this->getServiceLocator()->get('Models\Model\ContactUsFactory');
		$getOfInfo = $contactTable->getCallInfo();
		if($getOfInfo!=""){
			if(count($getOfInfo)>0){
				$i = 0;
				foreach($getOfInfo as $callInfo){
					$data[$i]['c_name'] =$callInfo->c_name;
					$data[$i]['c_phone']=$callInfo->c_email;
					$data[$i]['c_email']=$callInfo->c_phone;
					$data[$i]['c_message']= $callInfo->c_message;
					$i++;
				}	
				$datainfo['aaData'] = $data;	
				print_r(json_encode($datainfo));exit;
			}else{ 
				$datainfo['aaData'] = array();
				print_r(json_encode($datainfo));exit;
			}
		}else{
			$datainfo['aaData'] = array();
			print_r(json_encode($datainfo));exit;
		}	
	}
	public function allUsersAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath				
		));
		return $viewModel;
	}
	public function membersAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];	
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$getOfUsers = $userTable->getUserListAll();
		$status ="";
		if($getOfUsers!=""){
			if(count($getOfUsers)>0){
				$i = 0;
				foreach($getOfUsers as $bCData){
					if($bCData->ps_state=='1'){
						$status = 'To Be Assigned';
					}else if($bCData->ps_state=='1'){
						$status = 'Basic Info Pending';
					}else if($bCData->ps_state=='2'){
						$status = 'Scheduling Pending';
					}else if($bCData->ps_state=='3'){
						$status = 'Interview Pending';
					}else if($bCData->ps_state=='4'){
						$status = 'Docs Upload Pending';
					}else if($bCData->ps_state=='5'){
						$status = 'Other Docs Upload Pending';
					}else if($bCData->ps_state=='6'){
						$status = 'Preparation Pending';
					}else if($bCData->ps_state=='7'){
						$status = 'Synopsys Pending';
					}else if($bCData->ps_state=='8'){
						$status = 'Payment Pending';
					}else if($bCData->ps_state=='9'){
						$status = 'Review Pending';
					}else if($bCData->ps_state=='10'){
						$status = 'Confirmation Pending';
					}else if($bCData->ps_state=='11'){
						$status = 'E-Filing Pending';
					}else if($bCData->ps_state=='12'){
						$status = 'Paper-Filing Pending';
					}else if($bCData->ps_state=='13'){
						$status = 'E-Filing Complete';
					}else if($bCData->ps_state=='14'){
						$status = 'Filing Docs Sent';
					}else if($bCData->ps_state=='15'){
						$status = 'Cancel Filing';
					}
					$data[$i]['file_number']=$bCData->unique_code;
					$data[$i]['client_name']=$bCData->user_name;
					$data[$i]['u_email']= '<a href="'.$baseUrl.'/all-tabs/'.$bCData->user_id.'-'.$bCData->ps_state.'">'.$bCData->email.'</a>';
					$data[$i]['phone']= $bCData->phone;
					$data[$i]['file_status']= $status;
					$data[$i]['assigned']= $bCData->client_name;
					$i++;
				}	
				$datainfo['aaData'] = $data;	
				print_r(json_encode($datainfo));exit;
			}else{ 
				$datainfo['aaData'] = array();
				print_r(json_encode($datainfo));exit;
			}
		}else{
			$datainfo['aaData'] = array();
			print_r(json_encode($datainfo));exit;
		}	
	}
	public function assignUserAction(){
		$assignUserListTable =$this->getServiceLocator()->get('Models\Model\AssignUserListFactory');
		$client_id = $_POST['client_id'];
		$clientalreadyAssigned = $assignUserListTable->userAssignedAlready($client_id);
		if($clientalreadyAssigned!="0"){
			return new JsonModel(array(
				'assigned' 	=> 'User Already assigned',
				'output' 	=> 'success',
				'success' 	=> true,
			));
		}else{
			$allocatedUserId = $assignUserListTable->assignUser($_POST);
			$processStatusTable = $this->getServiceLocator()->get('Models\Model\ProcessingStatusFactory');
			$st =1;
			$updateProcessStatus = $processStatusTable->updateProcess($client_id,$st);
			if($allocatedUserId!=0){
				return new JsonModel(array(
					'assigned' 	=> $allocatedUserId,
					'output' 	=> 'success',
					'success' 	=> true,
				));
			}else{
				return new JsonModel(array(
					'assigned' 	=> '',
					'output' 	=> 'notsuccess',
					'success' 	=> false,
				));
			}	
		}	
	}
	public function allAssignedUsersAction()
	{
		$baseUrls   = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl    = $baseUrlArr['baseUrl'];
		$basePath   = $baseUrlArr['basePath'];
		$typeId     = $this->params()->fromRoute('id', 0);
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,
				'typeId'					=> $typeId
		));
		return $viewModel;	
	}	
    public function toBeAssignedAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_GET['type']) && $_GET['type']!=""){
			$id = $_GET['type'];
		}else{
			$id = 0;
		}
		$processStatusTable = $this->getServiceLocator()->get('Models\Model\ProcessingStatusFactory');
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$getAgents = $userTable->getUnListUserList()->toArray();
		//echo "<pre>"; print_r($getAgents); exit;
		$html = '';
		// $user_id = $_SESSION['user']['userId'];
		$getData =array();
		$getData = $processStatusTable->getToassignedData($id);
		
			if(!empty($getData)){
				$i = 0;
				$data = array();
				foreach($getData as $bCData){
					$user_id = $bCData->user_id;
					if($bCData->ps_state == '0'){
						$html = "<select id='a_user_id".$user_id."' name='a_user_id".$user_id."' onChange='assignedToUser(".$user_id.",".$id.");'>";
						$html .= "<option value ='select' >Select</option>";
						$selected =	"";				
						foreach($getAgents as $getagent){
							if($getagent['user_id'] == $bCData->unlists_u_id){
								$selected = "selected";
							}else{
								$selected = "";
							}
							$html .="<option value=".$getagent['user_id']." ".$selected.">".ucfirst($getagent['user_name'])."</option>";
						}
						$html.="</select>";
				   }
					if($bCData->ps_state=='0'){
						$status = 'To Be Assigned';
					}else if($bCData->ps_state=='1'){
						$status = 'Basic';
					}else if($bCData->ps_state=='2'){
						$status = 'Scheduling';
					}else if($bCData->ps_state=='3'){
						$status = 'Interview';
					}else if($bCData->ps_state=='4'){
						$status = 'Doc Pending';
					}else if($bCData->ps_state=='5'){
						$status = 'Other Doc';
					}else if($bCData->ps_state=='6'){
						$status = 'Preparation';
					}else if($bCData->ps_state=='7'){
						$status = 'Synopses';
					}else if($bCData->ps_state=='8'){
						$status = 'Payment';
					}else if($bCData->ps_state=='9'){
						$status = 'Review Upload';
					}else if($bCData->ps_state=='10'){
						$status = 'Review Pending';
					}else if($bCData->ps_state=='11'){
						$status = 'E-Filing Pening';
					}else if($bCData->ps_state=='12'){
						$status = 'P-Filing Pending';
					}else if($bCData->ps_state=='13'){
						$status = 'E-Filing Complete';
					}else if($bCData->ps_state=='14'){
						$status = 'E-Filing Doc Sent';
					}else if($bCData->ps_state=='15'){
						$status = 'File Cancelled';
					}
					$data[$i]['file_number']= '<a href="'.$baseUrl.'/all-tabs/'.$bCData->user_id.'-'.$bCData->ps_state.'">'.$bCData->unique_code.'</a>';
					$data[$i]['client_name']=$bCData->user_name;
					$data[$i]['u_email']= '<a href="'.$baseUrl.'/all-tabs/'.$bCData->user_id.'-'.$bCData->ps_state.'">'.$bCData->email .'</a>';
					$data[$i]['phone']= $bCData->phone;
					$data[$i]['file_status']= $status;
					if($bCData->ps_state == '0'){
						$data[$i]['assigned']= $html;
					}else{
						$data[$i]['assigned'] = "assigned";
					}
					$i++;
				}	
				$datainfo['aaData'] = $data;	
			}else{ 
				$datainfo['aaData'] = array();
			}
			echo json_encode($datainfo); exit;
	}
	public function assignedToUsersAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){
			$assignUserListTable =$this->getServiceLocator()->get('Models\Model\AssignUserListFactory');
			$client_id = $data['client_id'];
			$clientalreadyAssigned = $assignUserListTable->userAssignedAlready($client_id);
			if($clientalreadyAssigned!="0"){
				return new JsonModel(array(
					'assigned' 	=> 'User Already assigned',
					'output' 	=> 'success',
					'success' 	=> true,
				));
			}else{
				$allocatedUserId = $assignUserListTable->assignUser($data);
				$processStatusTable = $this->getServiceLocator()->get('Models\Model\ProcessingStatusFactory');
				$st =1;
				$updateProcessStatus = $processStatusTable->updateProcess($client_id,$st);
				if($allocatedUserId!=0){
					return new JsonModel(array(
						'assigned' 	=> $allocatedUserId,
						'output' 	=> 'success',
						'success' 	=> true,
					));
				}else{
					return new JsonModel(array(
						'assigned' 	=> '',
						'output' 	=> 'notsuccess',
						'success' 	=> false,
					));
				}	
			}
		}else{
			return new JsonModel(array(
				'status' 	=> 'Logged Required',
			));			
		}
	}
	public function commonProcessingAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_GET['type']) && $_GET['type']!=""){
			$id = $_GET['type'];
		}else{
			$id = 0;
		}
		$processStatusTable = $this->getServiceLocator()->get('Models\Model\ProcessingStatusFactory');
		$getData =array();
		if($id=='0'){
			$getData = $processStatusTable->getToassignedData($id);
		}else if($id=='1'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='2'){
			$getData = $processStatusTable->getScheduleData($id);
		}else if($id=='3'){
			$getData = $processStatusTable->getInterviewData($id);
		}else if($id=='4'){
			$getData = $processStatusTable->getDocsData($id);
		}else if($id=='5'){
			$getData = $processStatusTable->getOtherDocsData($id);
		}else if($id=='6'){
			$getData = $processStatusTable->getPreparationData($id);
		}else if($id=='7'){
			$getData = $processStatusTable->getSynopsisData($id);
		}else if($id=='8'){
			$getData = $processStatusTable->getPaymentData($id);
		}else if($id=='9'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='10'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='11'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='12'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='13'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='14'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='15'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}
		
		if($getData!=""){
			if(count($getData)>0){
				$i = 0;
				foreach($getData as $bCData){
					if($bCData->ps_state=='0'){
						$status = 'To Be Assigned';
					}else if($bCData->ps_state=='1'){
						$status = 'Basic Info Pending';
					}else if($bCData->ps_state=='2'){
						$status = 'Scheduling Pending';
					}else if($bCData->ps_state=='3'){
						$status = 'Interview Pending';
					}else if($bCData->ps_state=='4'){
						$status = 'Docs Upload Pending';
					}else if($bCData->ps_state=='5'){
						$status = 'Other Docs Upload Pending';
					}else if($bCData->ps_state=='6'){
						$status = 'Preparation Pending';
					}else if($bCData->ps_state=='7'){
						$status = 'Synopsys Pending';
					}else if($bCData->ps_state=='8'){
						$status = 'Payment Pending';
					}else if($bCData->ps_state=='9'){
						$status = 'Review Pending';
					}else if($bCData->ps_state=='10'){
						$status = 'Confirmation Pending';
					}else if($bCData->ps_state=='11'){
						$status = 'E-Filing Pending';
					}else if($bCData->ps_state=='12'){
						$status = 'Paper-Filing Pending';
					}else if($bCData->ps_state=='13'){
						$status = 'E-Filing Complete';
					}else if($bCData->ps_state=='14'){
						$status = 'Filing Docs Sent';
					}else if($bCData->ps_state=='15'){
						$status = 'Cancel Filing';
					}
					$data[$i]['file_number']=$bCData->unique_code;
					$data[$i]['client_name']=$bCData->user_name;
					$data[$i]['u_email']= $bCData->email;
					$data[$i]['ssn']= $bCData->ssnitin;
					$data[$i]['file_status']= $status;
					$data[$i]['assigned']= $bCData->unlist_name;
					$i++;
				}	
				$datainfo['aaData'] = $data;	
				print_r(json_encode($datainfo));exit;
			}else{ 
				$datainfo['aaData'] = array();
				print_r(json_encode($datainfo));exit;
			}
		}else{
			$datainfo['aaData'] = array();
			print_r(json_encode($datainfo));exit;
		}
	}
	function getUniqueCode($length = "")
	{
		$code = md5(uniqid(rand(), true));
		if ($length != "")
		return substr($code, 0, $length);
		else
		return $code;
	}
	public function tabsUserInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$utsYear 	= $baseUrlArr['utsYear'];
		$userTable				= $this->getServiceLocator()->get('Models\Model\UserFactory');
		$employeeinfoTable		= $this->getServiceLocator()->get('Models\Model\EmployeeinfoFactory');
		$spouseTable			= $this->getServiceLocator()->get('Models\Model\SpouseFactory');
		$schedulesTable			= $this->getServiceLocator()->get('Models\Model\SchedulesTimingsFactory');
		$uploadPdfsTable		= $this->getServiceLocator()->get('Models\Model\UploadPdfsFactory');
		$synopsysTable			= $this->getServiceLocator()->get('Models\Model\SynopsysFactory');
		$commentsTable			= $this->getServiceLocator()->get('Models\Model\CommentsFactory');
		$processingStatusTable	= $this->getServiceLocator()->get('Models\Model\ProcessingStatusFactory');
		$dependentTable			= $this->getServiceLocator()->get('Models\Model\DependentFactory');
		$userId				= $_POST['userId'];
		$processStatus		= $_POST['processStatus'];
		$tabType			= $_POST['tabType'];
		if($tabType == 1){
			$userInfo	= $userTable->getUserDataInfo($userId);
			$view = new ViewModel(array(
				'basePath'	=>	$basePath,
				'baseUrl'   =>  $baseUrl,
				'userInfo'  =>  $userInfo,
				'tabType'  	=>  $tabType
			));
		}else if($tabType == 2){
			$employeeeInfo	= $employeeinfoTable->getData($userId);
			$employeeInfo 	= array();
			if($employeeeInfo->count()){
				foreach($employeeeInfo as $key=>$sp){
					$employeeInfo[$key][0]['Company Name'] 			= $sp->company_name;
					$employeeInfo[$key][0]['Project Start Date'] 	= $sp->proj_start_date;
					$employeeInfo[$key][1]['Client Name(Any)'] 		= $sp->client_name;
					$employeeInfo[$key][1]['Project End Date'] 		= $sp->proj_end_date;
				}
			}
			$spousesInfo	= $spouseTable->getSpousesData($userId);
			$spouseInfo 	= array();
			if($spousesInfo->count()){
				foreach($spousesInfo as $key=>$sp){
					$spouseInfo[$key][0]['First Name'] 		= $sp->first_name;
					$spouseInfo[$key][0]['SSN'] 			= $sp->ssn;
					$spouseInfo[$key][0]['Date Of Birth'] 	= $sp->dob;
					$spouseInfo[$key][1]['Last Name'] 		= $sp->last_name;
					$spouseInfo[$key][1]['Occupation'] 		= $sp->occupation;
					$spouseInfo[$key][1]['Visa Type'] 		= $sp->visa_type;
				}
			}
			$dependentsInfo	= $dependentTable->getDependents($userId,$utsYear);
			$dependentInfo 	= array();
			if($dependentsInfo->count()){
				foreach($dependentsInfo as $key=>$dp){
					$dependentInfo[$key][0]['First Name'] 		= $dp->first_name;
					$dependentInfo[$key][0]['SSN'] 				= $dp->ssn;
					$dependentInfo[$key][0]['Date Of Birth'] 	= $dp->dob;
					$dependentInfo[$key][1]['Last Name'] 		= $dp->last_name;
					$dependentInfo[$key][1]['ITIN'] 			= $dp->itin;
					$dependentInfo[$key][1]['Occupation'] 		= $dp->occupation;
					$dependentInfo[$key][1]['Visa Type'] 		= $dp->visa_type;
				}
			}
			$view = new ViewModel(array(
				'basePath'		=>	$basePath,
				'baseUrl'   	=>  $baseUrl,
				'employeeInfo'  =>  $employeeInfo,
				'spouseInfo'  	=>  $spouseInfo,
				'dependentInfo' =>  $dependentInfo,
				'tabType'  		=>  $tabType
			));
		}else if($tabType == 3){
			$schedulesInfo	= $schedulesTable->getTotalData($userId);
			$scheduleInfo 	= array();
			if($schedulesInfo->count()){
				foreach($schedulesInfo as $key=>$sc){
					$scheduleInfo[$key][0]['Schedule Date']  = $sc->schedule_dt;
					$scheduleInfo[$key][1]['Schedule Time']  = $sc->schedule_period;
				}
			}
			$view = new ViewModel(array(
				'basePath'		=>	$basePath,
				'baseUrl'   	=>  $baseUrl,
				'scheduleInfo'  =>  $scheduleInfo,
				'tabType'  		=>  $tabType
			));
		}else if($tabType == 4){
			$downloadsInfo	= $uploadPdfsTable->getUserDataInfo($userId,$utsYear);
			$downloadInfo 	= array();
			if($downloadsInfo->count()){
				foreach($downloadsInfo as $key=>$dl){
					$downloadInfo[$dl->upt_name][$key] = $dl->upload_file;
				}
			}
			$view = new ViewModel(array(
				'basePath'		=>	$basePath,
				'baseUrl'   	=>  $baseUrl,
				'downloadInfo'  =>  $downloadInfo,
				'tabType'  		=>  $tabType,
				'userId'  		=>  $userId
			));
		}else if($tabType == 5){
			$taxInfo	= $synopsysTable->getSynopsys($userId);
			$userInfo	= $userTable->getUserDataInfo($userId);
			$view = new ViewModel(array(
				'basePath'		=>	$basePath,
				'baseUrl'   	=>  $baseUrl,
				'taxInfo'  		=>  $taxInfo,
				'tabType'  		=>  $tabType,
				'userInfo'  	=>  $userInfo,
				'userId'  		=>  $userId
			));
		}else if($tabType == 6){
			$commentsInfo	= $commentsTable->getComments($userId);
			$userInfo		= $userTable->getUserDataInfo($userId);
			$processInfo	= $processingStatusTable->getUserProcessState($userId);
			$view = new ViewModel(array(
				'basePath'		=>	$basePath,
				'baseUrl'   	=>  $baseUrl,
				'commentsInfo'  =>  $commentsInfo,
				'tabType'  		=>  $tabType,
				'userInfo'  	=>  $userInfo,
				'userId'  		=>  $userId,
				'processInfo'  	=>  $processInfo
			));
		}
		return $view->setTerminal(true);
	}
	public function uploadTaxFileAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$utsYear 	= $baseUrlArr['utsYear'];
		$synopsysTable		= $this->getServiceLocator()->get('Models\Model\SynopsysFactory');
		$name 				= $_FILES["taxUploadFile"]["name"];
		$newfilenamePath 	= "./../synopsys/".$_POST['userId']."/".$name;
		$name 				= $name;
		$path				= "./../synopsys/".$_POST['userId'];
		//if(!is_dir($path)) {
			//if(mkdir($path, 0777, true)){
				if (move_uploaded_file($_FILES["taxUploadFile"]["tmp_name"], $newfilenamePath)){
					$synopsysTable->assignSynopsys($_POST['userId'],$name,$_POST['title']);
					return new JsonModel(array(					
						'imageName' => 	$name
					));
				}
			//}
		//}
	}
	public function pushToStateAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$utsYear 	= $baseUrlArr['utsYear'];
		$user_session 	= new Container('user');
		$commttedBy 	= $user_session->userId;
		$commentsTable				= $this->getServiceLocator()->get('Models\Model\CommentsFactory');
		$processingStatusTable		= $this->getServiceLocator()->get('Models\Model\ProcessingStatusFactory');
		$processingStatusTable->updateProcess($_POST['userId'],$_POST['processState']);
		$commentsTable->addComment($_POST['userId'],$commttedBy,$_POST['commentClient']);
		return new JsonModel(array(					
			'output' => 1
		));
	}
	public function adminEmailsAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$utsYear 	= $baseUrlArr['utsYear'];
		global $emailMessage1;
		global $emailMessage2;
		return new ViewModel(array(					
			'baseUrl' 	=> $baseUrl,
			'basePath' 	=> $basePath,
			'emailMessage1' 	=> $emailMessage1,
			'emailMessage2' 	=> $emailMessage2
		));
	}
	public function sendAdminEmailsAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		$utsYear 	= $baseUrlArr['utsYear'];
		global $emailsSubject;
		global $emailsMessage;
		global $emailMessage1;
		global $emailMessage2;
		$email_type = $_POST['email_type'];
		if($email_type == 1){
			$message = $emailMessage1;
		}else{
			$message = $emailMessage2;
		}
		$emailNames = 	explode(',',$_POST['email_names']);
		$emailEmails = 	explode(',',$_POST['email_emails']);
		if(count($emailNames) != 0){
			foreach($emailNames as $key=>$name){
				global $emailsSubject;
				global $emailsMessage;
				$bodyMessage = $emailsMessage;
				$bodyMessage = str_replace("<FULLNAME>",$name, $bodyMessage);
				$bodyMessage = str_replace("<MESSAGE>",$message, $bodyMessage);
				$to	= $emailEmails[$key];
				// if(sendMail($to,$summaryUpdatesSubject,$bodyMessage)){
					// $bodyMessage = "";
				// }
				//echo $bodyMessage.'<br/>';
			}
		}
		return new JsonModel(array(					
			'output' => 1
		));
	}
	public function changePasswordAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_POST['u_password']) && $_POST['u_password']!=""){
			$u_id = $_POST['u_id'];
			$u_password = $_POST['u_password'];
			$old_password = $_POST['o_u_password'];
			$n_u_password = $_POST['n_u_password'];
			$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
			if($old_password!=$n_u_password){
				$checkOldPassword = $userTable->getpassword($u_id,$old_password);
				if($checkOldPassword>0){
					$statusRest = $userTable->changepwd($u_id,$u_password);
					if($statusRest!=0){
						$viewModel = new ViewModel(
						array(
							'baseUrl'	=> $baseUrl,
							'basePath' 	=> $basePath,				
							'sucMsg' 	=> "Successfully changed the password.",
							'errMsg' 	=> "",
							'ErrorM' 	=> "",
							'data'      => ''
						));
						return $viewModel;			
					}else{
						$viewModel = new ViewModel(
						array(
							'baseUrl'	=> $baseUrl,
							'basePath' 	=> $basePath,				
							'sucMsg' 	=> "Not changed the password .",
							'errMsg' 	=> "",
							'ErrorM' 	=> "",
							'data'      => $_POST
						));
						return $viewModel;
					}		
				}else{
					$viewModel = new ViewModel(
					array(
						'baseUrl'	=> $baseUrl,
						'basePath' 	=> $basePath,				
						'errMsg' 	=> "Your old password is wrong.",
						'sucMsg' 	=> "",
						'ErrorM' 	=> "",
						'data'      => $_POST
					));
					return $viewModel;	
				}
			}else{
				$viewModel = new ViewModel(
				array(
					'baseUrl'	=> $baseUrl,
					'basePath' 	=> $basePath,				
					'ErrorM' 	=> "Entered your Old password and New password is same.",
					'sucMsg' 	=> "",
					'data'      => $_POST
				));
				return $viewModel;	
			}
		}else{
			$viewModel = new ViewModel(
				array(
					'baseUrl'	=> $baseUrl,
					'basePath' 	=> $basePath,
					'sucMsg'	=> "",
					'ErrorM' 	=> "",
					'errMsg' 	=> ""
			));
			return $viewModel;	
		}
	}
}