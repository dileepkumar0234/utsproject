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
					$data[$i]['u_email']= $bCData->email;
					$data[$i]['ssn']= $bCData->ssnitin;
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
		$getAgents = $userTable->getUnListUserList();
		$html = '';
		// $user_id = $_SESSION['user']['userId'];
		$getData =array();
		$getData = $processStatusTable->getToassignedData($id);	
		if($getData!=""){
			if(count($getData)>0){
				$i = 0;
				foreach($getData as $bCData){
					$user_id = $bCData->user_id;
					$html = "<select id='a_user_id' name='a_user_id' onChange='assignedToUser(".$user_id.");'>";
					foreach($getAgents as $getagent){
						$html.="<option value=".$getagent->user_id.">".ucfirst($getagent->user_name)."</option>";
					}
					$html.="</select>";
					if($bCData->ps_state=='0'){
						$status = 'To Be Assigned';
					}
					$data[$i]['file_number']=$bCData->unique_code;
					$data[$i]['client_name']=$bCData->user_name;
					$data[$i]['u_email']= $bCData->email;
					$data[$i]['ssn']= $bCData->ssnitin;
					$data[$i]['file_status']= $status;
					$data[$i]['assigned']= $html;
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
}