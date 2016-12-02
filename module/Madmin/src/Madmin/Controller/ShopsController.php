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
class ShopsController extends AbstractActionController
{
	
	public function addShopAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$cityTable=$this->getServiceLocator()->get('Models\Model\CityNamesFactory');
		$specialBikesTable       = $this->getServiceLocator()->get('Models\Model\BikesFactory');
		$specialBikesModelsTable = $this->getServiceLocator()->get('Models\Model\SpecialBikesModelsFactory');
		$mechanicsTable=$this->getServiceLocator()->get('Models\Model\MechanicsFactory');
		$cities = $cityTable->getCities()->toArray();
		$sBList = $specialBikesTable->getSpBikes()->toArray();
		if(isset($_POST['me_fname']) && $_POST['me_fname']!=""){
			$lastInsertedId = $mechanicsTable->addShopReg($_POST);
			if($lastInsertedId){
				$me_id = $lastInsertedId;
				$me_unique_code = 'HYD'.str_pad((int)$me_id, 6, "0", STR_PAD_LEFT);
				$insertedUniqueCode = $mechanicsTable->insertedUnqiueCode($me_id,$me_unique_code);
			}
			return new JsonModel(array(
				'status'	=>	'success',
				'success'   =>  true,
				'me_id'     => $me_id
			));		
		}else{
			$viewModel = new ViewModel(
				array(
					'baseUrl'				 	=> $baseUrl,
					'basePath' 					=> $basePath,				
					'cities' 					=> $cities,				
					'sBList' 					=> $sBList				
			));
			return $viewModel;			
		}		
	}
	public function editShopAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_POST['me_fname']) && $_POST['me_fname']!=""){
			$mechanicsTable=$this->getServiceLocator()->get('Models\Model\MechanicsFactory');
			$lastInsertedId = $mechanicsTable->addShopReg($_POST);
			if($lastInsertedId){
				$me_id = $lastInsertedId;
				$me_unique_code = 'HYD'.str_pad((int)$me_id, 6, "0", STR_PAD_LEFT);
				$insertedUniqueCode = $mechanicsTable->insertedUnqiueCode($me_id,$me_unique_code);
				return new JsonModel(array(
					'status'	=>	'success',
					'success'   =>  true,
					'me_id'     => $me_id
				));	
			}else{
				return new JsonModel(array(
					'status'	=>	'not success',
					'success'   =>  false,
					'me_id'     => ''
				));
			}
		}else{
			$viewModel = new ViewModel(
				array(
					'baseUrl'				 	=> $baseUrl,
					'basePath' 					=> $basePath				
			));
			return $viewModel;			
		}	
				
	}
	public function viewShopAction()
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
	public function getLeadInfoAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$leadInfo = $userTable->getUserData($_POST['lead']);
		return new JsonModel(array(
			'output' 	=> 'success',
			'leadInfo' 	=> $leadInfo,
		));	
	}
	public function citiesAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$cityTable=$this->getServiceLocator()->get('Models\Model\CityNamesFactory');
		$cities = $cityTable->getCities();
			if(count($cities)>0){
				$cTcData = array();
				foreach($cities as $CTData){
					$cTcData[]=$CTData;
				}
				if(count($cTcData)>0){
					return new JsonModel(array(
						'output' 	=> 'success',
						'cities' 	=> $cTcData,
					));
				}else{
					return new JsonModel(array(
						'output' 	=> 'Fail',
						'cities' 	=> '',
					));
				}
			}else{
				return new JsonModel(array(
					'output' 	=> 'Fail',
					'cities' 	=> '',
				));
			}	
	}
	public function specialBikesAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$specialBikesTable=$this->getServiceLocator()->get('Models\Model\BikesFactory');
		$specialBikesModelsTable = $this->getServiceLocator()->get('Models\Model\SpecialBikesModelsFactory');
		$sBList = $specialBikesTable->getSpBikes();
		$lists = array();
		if(count($sBList)>0){
			$i = 0;
			foreach($sBList as $sList){
				$lists[] = $sList;
			}
			return new JsonModel(array(
				'status'	=>	'success',
				'sBList'     => $lists
			));	
		}else{ 
			return new JsonModel(array(
				'status'	=>	'Fail',
				'sBList'     => ''
			));
		}		
	}
	public function shopsListAction()
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
	public function pricingListAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$offersTable=$this->getServiceLocator()->get('Models\Model\OffersFactory');
		$allOffers = $offersTable->allOffers();
		if(count($allOffers)>0){
			$oFData = array();
			foreach($allOffers as $fData){
				$oFData[]=$fData;
			}
			if(count($oFData)>0){
				return new JsonModel(array(
					'output' 	=> 'success',
					'oFData' 	=> $oFData,
				));
			}else{
				return new JsonModel(array(
					'output' 	=> 'Fail',
					'oFData' 	=> '',
				));
			}
		}else{
			return new JsonModel(array(
				'output' 	=> 'Fail',
				'oFData' 	=> '',
			));
		}
	}
	public function pricingAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$offersTable=$this->getServiceLocator()->get('Models\Model\OffersFactory');
		$offerinfo = $offersTable->allOffers()->toArray();
		if(isset($_POST['of_price']) && $_POST['of_price']){
			$allOffers = $offersTable->allOffers()->toArray();
			if(count($allOffers)>0){
				$ofid=$allOffers['0']['of_id'];
			}else{
				$ofid=0;
			}
			$lastInserted = $offersTable->addOffers($_POST,$ofid);
			if($lastInserted){
				return new JsonModel(array(
					'output' 	=> 'success',
				));
			}else{
				return new JsonModel(array(
					'output' 	=> 'Fail',
				));
			}
		}else{
			$viewModel = new ViewModel(
				array(
					'baseUrl'				=> $baseUrl,
					'basePath' 				=> $basePath,				
					'offerinfo' 			=> $offerinfo				
			));
			return $viewModel;			
		}	
	}
	public function statusUpdateAction()
	{
		$params=$this->params()->fromRoute('id', 0);
		$id=$params;
		$baseUrls = $this->getServiceLocator()->get('config');
		$mechanicsTable=$this->getServiceLocator()->get('Models\Model\MechanicsFactory');
		$shopData = $mechanicsTable->getShopInfo($id);
		if($shopData!=""){
			return new JsonModel(array(
				'status'	=>	'success',
				'success'   =>  true,
				'shopinfo'     => $shopData
			));	
		}else{
			return new JsonModel(array(
				'status'	=>	'not success',
				'success'   =>  false,
				'shopinfo'     => ''
			));
		}	
	}
	public function activeShopAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$mechanicsTable=$this->getServiceLocator()->get('Models\Model\MechanicsFactory');
		$changeStatus = $mechanicsTable->activeDeactivateShop($_POST['id'],$_POST['status']);
		if($changeStatus>0){
			return new JsonModel(array(
				'status'	=>	'success',
				'state'	=>	$_POST['status']
			));
		}else{
			return new JsonModel(array(
				'status'	=>	'fail',
				'state'	=>	$_POST['status']
			));
		}
	}
	public function uploadShopImagesAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$imageName = $_POST['upload-name'];
		if($_POST['type-upload'] == 1){
			if($_POST['pre-file'] != "") {
				if (file_exists('./shopImages/'.$_POST['pre-file'])) {
					unlink('./shopImages/'.$_POST['pre-file']);
				}
			}
		}
		$path = "./shopImages/";
		if(isset($_FILES) && $_FILES['file']!=""){
			if( 0 < $_FILES['file']['error'] ) {
				return new JsonModel(array(
					'output' 	=> 'fail',
				));
			}else {
				if($_POST['type-upload'] == 2){
					if($_POST['pre-file'] != "") {
						if (file_exists('./shopImages/'.$_POST['pre-file'])) {
							unlink('./shopImages/'.$_POST['pre-file']);
						}
					}
				}
				$time = time() + sprintf("%06d",(microtime(true) - floor(microtime(true))) * 1000000);
				$info = pathinfo($_FILES['file']['name']);
				$extension=$info['extension'];
				$new_name=$imageName.'_'.$time.'.'.$extension; 
				move_uploaded_file($_FILES['file']['tmp_name'], $path.'/'. $new_name);
				$fileName = $new_name;
				return new JsonModel(array(
					'baseUrl'	=> $baseUrl,
					'basePath' 	=> $basePath,	
					'file_name' => $fileName,
					'output' 	=> 'success',
					'success' 	=> true
				));
			}
		}else{
			return new JsonModel(array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,	
				'output' 	=> 'fail'
			));
		}
			
	}
	public function shopsAction()
	{		
		$id=1;
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$mechanicsTable=$this->getServiceLocator()->get('Models\Model\MechanicsFactory');
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$checkUser = $userTable->getUserData($id);	
		if($checkUser!=""){
			$user_type_id = $checkUser->u_ut_type_id;
			$shopList = $mechanicsTable->getShopsInfo($user_type_id,$id);
			$lists = array();
			if(count($shopList)>0){
				$i = 0;
				foreach($shopList as $sList){
					if($sList->me_sta_status=='1'){
						$activeState = 0;
						$status = 'Active';
					}else if($sList->me_sta_status=='0'){
						$activeState = 1;
						$status = 'Deactivate';
					}else{
						$activeState = 1;
						if($user_type_id == '3'){
							$status = 'Pending';
						}else{
							$status = 'New Shop Activate';
						}
					}
					$data[$i]['me_unique_code']=$sList->me_unique_code;
					$data[$i]['me_shopname']= $sList->me_shopname;
					$data[$i]['u_name']= $sList->u_name;
					$data[$i]['action']= '<a href="javascript:void(0);" id="shop_edit'.$sList->me_id .'" name="shop_edit'.$sList->me_id .'" onclick="viewShop('.$sList->me_id.')" >View</a>/<a href="javascript:void(0);" id="shop_edit'.$sList->me_id .'" name="shop_edit'.$sList->me_id .'" onclick="editShop('.$sList->me_id.')" >Edit</a>';
					if($user_type_id == '3'){
						$data[$i]['status']= $status;
					}else{
						$data[$i]['status']= '<span id="shop_status_d'.$sList->me_id .'"><a href="javascript:void(0);" id="shop_status'.$sList->me_id .'" name="shop_status'.$sList->me_id .'" onclick="deactiveActiveShop('.$sList->me_id.','.$activeState.')" >'.$status.'</a></span>';
					}				
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
	public function stepsProcessAction()
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
	public function stepsAction()
	{
		$params=$this->params()->fromRoute('id', 0);
		$id=$params;		
		$bookingids = '';
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$bookingsTable=$this->getServiceLocator()->get('Models\Model\BookingsFactory');
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$BookingExecutiveTable=$this->getServiceLocator()->get('Models\Model\BookingExecutiveTableFactory');
		if(isset($_SESSION['user']['u_ut_type_id']) && $_SESSION['user']['u_ut_type_id']=="1"){
			if($id == 1){
				$checkingAssignedList = $BookingExecutiveTable->assignedList();
				if(count($checkingAssignedList)>0){
					foreach($checkingAssignedList as $assignedBooks){
						$bookingids .= "'".$assignedBooks->be_bo_id."'".",";						
					}
					$bIds = rtrim($bookingids,",");
					$bookingHistory = $bookingsTable->allStageOne($bIds);
				}else{
					$bookingHistory ='';
				}
			}else{
				$bookingHistory = $bookingsTable->stepsprocess($id);
			}
		}else{
			$bookingHistory = $bookingsTable->stepsprocess($id);
		}		
		if($bookingHistory!=""){
			if(count($bookingHistory)>0){
				$i = 0;
				foreach($bookingHistory as $bHistory){					
						if($bHistory->u_id!=0){
							$userName = $bHistory->u_name;
							$m_phone  = $bHistory->u_phone;
							$userType = "User";
						}else{
							$userName = $bHistory->gu_fname;
							$m_phone  = $bHistory->gu_phone;
							$userType = "Guest";							
						}
						$bookingDateTime = $bHistory->bo_estimated_date.' - '.$bHistory->bo_estimated_time;
						$data[$i]['bo_track_code']=$bHistory->bo_track_code;
						$data[$i]['u_name']= $userName;
						$data[$i]['u_type']= $userType;
						$data[$i]['u_phone']= $m_phone;
						$data[$i]['bo_created_at']= $bookingDateTime;
						$url = $baseUrl.'/services-proccessing?boid='.$bHistory->bo_id;
						if($bHistory->bo_sta_status=='1'){
							$bookStatus='Received';
							if($id=='2'){
								$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							}else{
								$data[$i]['action']= '<a href="javascript:void(0);" id="bookservice'.$bHistory->bo_id .'" name="bookservice'.$bHistory->bo_id .'" onclick="assignService('.$bHistory->bo_id.')" >Assign</a>';
							}
						}else if($bHistory->bo_sta_status=='2'){
							$bookStatus='Assigned';
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
						}else if($bHistory->bo_sta_status=='3'){
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							$bookStatus='Servicing';
						}else if($bHistory->bo_sta_status=='4'){
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							$bookStatus='Ready to deliver';
						}else if($bHistory->bo_sta_status=='5'){
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							$bookStatus='Delivered';
						}else if($bHistory->bo_sta_status=='6'){
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							$bookStatus='Cancelled';
						}
						if($bHistory->bo_sta_status=='7'){
							$data[$i]['action']='Closed';
							$data[$i]['bo_sta_status']= 'Closed';
						}else{
							$data[$i]['bo_sta_status']= $bookStatus;
						}									
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
	public function assignedServiceListAction()
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
	public function unassignedServiceListAction()
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
	public function assignedServicesAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$BookingExecutiveTable=$this->getServiceLocator()->get('Models\Model\BookingExecutiveTableFactory');
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$assignedServices = $BookingExecutiveTable->assignedServicesToExecutivesAndLeads(1);	
		if($assignedServices!=""){
			if(count($assignedServices)>0){
				$i = 0;
				foreach($assignedServices as $Services){						
						$data[$i]['bo_track_code']=$Services->bo_track_code;
						if($Services->be_assigned_u_id=='0'){
							$userType = ucfirst($Services->assigned_level);							
							$data[$i]['u_name']= ucfirst($Services->assigned_name).'( '.$userType.')';
						}else{
							$userType = ucfirst($Services->ut_type_name);
							$data[$i]['u_name']= ucfirst($Services->u_name).'('.$userType.')';
						}
						$data[$i]['bo_estimated_date']= $Services->bo_estimated_date;
						$data[$i]['bo_estimated_time']= $Services->bo_estimated_time;
						$data[$i]['action']= '<a href="'.$baseUrl.'/service-assigned-process?boid='.$Services->bo_id.'&reAssigned=returnAss" id="bookservice'.$Services->bo_id .'" name="bookservice'.$Services->bo_id .'">Re assign</a>';								
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
	public function unassignedServicesAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$bookingsTable=$this->getServiceLocator()->get('Models\Model\BookingsFactory');
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$BookingExecutiveTable=$this->getServiceLocator()->get('Models\Model\BookingExecutiveTableFactory');
		if(isset($_SESSION['user']['u_ut_type_id']) && $_SESSION['user']['u_ut_type_id']=="1"){
			$checkingAssignedList = $BookingExecutiveTable->assignedList();	
			$bookingids = '';	
			if(count($checkingAssignedList)>0){
					foreach($checkingAssignedList as $assignedBooks){
						$bookingids .= "'".$assignedBooks->be_bo_id."'".",";						
					}
					$bIds = rtrim($bookingids,",");
					$unassignedServices   = $bookingsTable->unassignedServicesToExecutives($bIds);
			}else{
				$unassignedServices   = $bookingsTable->stepsprocess($_SESSION['user']['userId']);
			}			
		}else{
			$unassignedServices = $BookingExecutiveTable->unassignedServicesToExecutives($_SESSION['user']['userId']);	
		}
		if($unassignedServices!=""){
			if(count($unassignedServices)>0){
				$i = 0;
				foreach($unassignedServices as $unassigned){					
						if($unassigned->u_id!=0){
							$userName = $unassigned->u_name;
							$m_phone  = $unassigned->u_phone;
							$userType = "User";
						}else{
							$userName = $unassigned->gu_fname;
							$m_phone  = $unassigned->gu_phone;
							$userType = "Guest";							
						}
						$bookingDateTime = $unassigned->bo_estimated_date.' - '.$unassigned->bo_estimated_time;
						$data[$i]['bo_track_code']=$unassigned->bo_track_code;
						$data[$i]['u_name']= $userName;
						$data[$i]['u_type']= $userType;
						$data[$i]['u_phone']= $m_phone;
						$data[$i]['bo_created_at']= $bookingDateTime;
						$url = $baseUrl.'/services-proccessing?boid='.$unassigned->bo_id;
						// if(isset($_SESSION['user']['ut_type_name']) && $_SESSION['user']['ut_type_name']=="admin"){
							// if($unassigned->bo_sta_status=='1'){
							// $bookStatus='Received';
							// $data[$i]['action']= '<a href="javascript:void(0);" id="bookservice'.$unassigned->bo_id .'" name="bookservice'.$unassigned->bo_id .'" onclick="assignServiceMembers('.$unassigned->bo_id.')" >Assign</a>';
							// }else if($unassigned->bo_sta_status=='2'){
								// $bookStatus='Assigned';
								// $data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							// }else if($unassigned->bo_sta_status=='3'){
								// $data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
								// $bookStatus='Servicing';
							// }else if($unassigned->bo_sta_status=='4'){
								// $data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
								// $bookStatus='Ready to deliver';
							// }else if($unassigned->bo_sta_status=='5'){
								// $data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
								// $bookStatus='Delivered';
							// }else if($unassigned->bo_sta_status=='6'){
								// $data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
								// $bookStatus='Cancelled';
							// }else if($unassigned->bo_sta_status=='7'){
								// $data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
								// $bookStatus='Closed';
							// }
						// }else{
							// $data[$i]['action']= '<a href="javascript:void(0);" id="bookservice'.$unassigned->bo_id .'" name="bookservice'.$unassigned->bo_id .'" onclick="assignServiceMembers('.$unassigned->bo_id.')" >Assign</a>';
							// $bookStatus='Servicing';
						// }
						
						if($unassigned->bo_sta_status=='1'){
							$bookStatus='Received';
							$data[$i]['action']= '<a href="javascript:void(0);" id="bookservice'.$unassigned->bo_id .'" name="bookservice'.$unassigned->bo_id .'" onclick="assignServiceMembers('.$unassigned->bo_id.')" >Assign</a>';
						}else if($unassigned->bo_sta_status=='2'){
							$bookStatus='Assigned';
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
						}else if($unassigned->bo_sta_status=='3'){
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							$bookStatus='Servicing';
						}else if($unassigned->bo_sta_status=='4'){
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							$bookStatus='Ready to deliver';
						}else if($unassigned->bo_sta_status=='5'){
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							$bookStatus='Delivered';
						}else if($unassigned->bo_sta_status=='6'){
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							$bookStatus='Cancelled';
						}else if($unassigned->bo_sta_status=='7'){
							$data[$i]['action']='<a href="'.$url.'">Proccessing</a>';
							$bookStatus='Closed';
						}
						$data[$i]['bo_sta_status']= $bookStatus;									
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
	public function serviceAssignedProcessAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$statusModeTable=$this->getServiceLocator()->get('Models\Model\StatusModeFactory');
		$statusAll = $statusModeTable->getAllStatus()->buffer();
		$userTable=$this->getServiceLocator()->get('Models\Model\UserFactory');
		$BookingExecutiveTable=$this->getServiceLocator()->get('Models\Model\BookingExecutiveTableFactory');
		$AssignedUserListTable=$this->getServiceLocator()->get('Models\Model\AssignedUserListFactory');
		$teamLeadsList = $userTable->teamLeadsList()->toArray();
		$executivesList = $userTable->listUsersExecu()->toArray();
		$checkBookingIdAssigned=$BookingExecutiveTable->checkServiceAssign($_GET['boid']);
		$leadExec = array();
		if(isset($_GET['reAssigned']) && $_GET['reAssigned']=="returnAss"){
			$bookingsTable=$this->getServiceLocator()->get('Models\Model\BookingsFactory');
			$gBInfof = $bookingsTable->getBkingInfomAll($_GET['boid']);
			$leadExec = $AssignedUserListTable->tExecutives($checkBookingIdAssigned->be_assigened_by_u_id)->toArray();
			if($gBInfof!=""){
				if($gBInfof->bo_u_id!=0){
					$lUType = "user";
				}else{
					$lUType = "guest";			
				}
				$gBInfo = $bookingsTable->getBkingInfomDetails($_GET['boid'],$lUType);	
				$viewModel = new ViewModel(
					array(
						'baseUrl'				 	=> $baseUrl,
						'basePath' 					=> $basePath,				
						'statusAll' 			    => $statusAll,				
						'teamLeadsList' 	        => $teamLeadsList,				
						'executivesList' 	        => $executivesList,				
						'assinedList' 	            => $checkBookingIdAssigned,				
						'leadExec' 	                => $leadExec,				
						'gBInfo' 					=> $gBInfo				
				));				
			}else{
				$viewModel = new ViewModel(
					array(
						'baseUrl'				 	=> $baseUrl,
						'basePath' 					=> $basePath,
						'teamLeadsList' 	        => $teamLeadsList,
						'executivesList' 	        => $executivesList,	
						'assinedList' 	            => $checkBookingIdAssigned,	
						'leadExec' 	                => $leadExec,	
						'statusAll' 			    => $statusAll	
				));
			}
		}else if(isset($_GET['boid']) && $_GET['boid']!=""){
			$bookingsTable=$this->getServiceLocator()->get('Models\Model\BookingsFactory');
			$gBInfof = $bookingsTable->getBkingInfomAll($_GET['boid']);
			if($gBInfof!=""){
				if($gBInfof->bo_u_id!=0){
					$lUType = "user";
				}else{
					$lUType = "guest";			
				}
				$gBInfo = $bookingsTable->getBkingInfomDetails($_GET['boid'],$lUType);	
				$viewModel = new ViewModel(
					array(
						'baseUrl'				 	=> $baseUrl,
						'basePath' 					=> $basePath,				
						'statusAll' 			    => $statusAll,				
						'teamLeadsList' 	        => $teamLeadsList,				
						'executivesList' 	        => $executivesList,	
						'assinedList' 	            => $checkBookingIdAssigned,	
						'leadExec' 	                => '',	
						'gBInfo' 					=> $gBInfo				
				));				
			}else{
				$viewModel = new ViewModel(
					array(
						'baseUrl'				 	=> $baseUrl,
						'basePath' 					=> $basePath,
						'teamLeadsList' 	        => $teamLeadsList,
						'executivesList' 	        => $executivesList,
						'assinedList' 	            => $checkBookingIdAssigned,	
						'leadExec' 	                => '',	
						'statusAll' 			    => $statusAll	
				));
			}						
		}else{
			$viewModel = new ViewModel(
				array(
					'baseUrl'				 	=> $baseUrl,
					'basePath' 					=> $basePath,
					'teamLeadsList' 	        => $teamLeadsList,
					'executivesList' 	        => $executivesList,
					'assinedList' 	            => $checkBookingIdAssigned,							
					'leadExec' 	                => $leadExec,						
					'statusAll' 			    => $statusAll	
			));
		}
		return $viewModel;	
	}
	public function leadBasedExecutiveAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$AssignedUserListTable=$this->getServiceLocator()->get('Models\Model\AssignedUserListFactory');
		if(isset($_POST['lead']) && $_POST['lead']!=""){
			$executivesList = $AssignedUserListTable->tExecutives($_POST['lead']);
				if(count($executivesList)>0){
					$cTcData = array();
					foreach($executivesList as $CTData){
						$cTcData[]=$CTData;
					}
					if(count($cTcData)>0){
						return new JsonModel(array(
							'output' 	=> 'success',
							'executives' 	=> $cTcData,
						));
					}else{
						return new JsonModel(array(
							'output' 	=> 'Fail',
							'executives' 	=> '',
						));
					}
				}else{
					return new JsonModel(array(
						'output' 	=> 'Fail',
						'executives' 	=> '',
					));
				}
		}else{
			return new JsonModel(array(
					'output' 	=> 'Fail',
					'executives' 	=> '',
			));
		}
	}
	public function assignedToExecutiveAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$BookingExecutiveTable=$this->getServiceLocator()->get('Models\Model\BookingExecutiveTableFactory');
		$bookingsTable=$this->getServiceLocator()->get('Models\Model\BookingsFactory');
		if(isset($_POST['boid']) && $_POST['boid']!=""){
			$checkAssigenedExecutive = $BookingExecutiveTable->checkAssigenedExecutive($_POST['boid']);
			if($checkAssigenedExecutive!=""){
				$be_id=$checkAssigenedExecutive->be_id;
				$updateBookService = $BookingExecutiveTable->updateAssigenedExecutive($be_id,$_POST['be_assigened_by_u_id'],$_POST['be_assigned_u_id']);
				return new JsonModel(array(
						'output'	=>	"success",
						'basePath'	=>	$basePath,
						'baseUrl'   =>  $baseUrl
				));
			}else{
				$addBookService = $BookingExecutiveTable->assigenedExecutive($_POST['boid'],$_POST['be_assigened_by_u_id'],$_POST['be_assigned_u_id']);
				if($addBookService!=0){
					//$status = 1;
					//$updateStatus = $bookingsTable->updateBookStatus($_POST['boid'],$status);
					return new JsonModel(array(
						'output'	=>	"success",
						'basePath'	=>	$basePath,
						'baseUrl'   =>  $baseUrl
					));
				}	
			}	
		}
	}
	public function searchShopListAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$mechanicsTable=$this->getServiceLocator()->get('Models\Model\MechanicsFactory');
		$recentAddedShops = $mechanicsTable->searcMechanicsList($_POST['search']);
		if(count($recentAddedShops)>0){
			return new JsonModel(array(
				'status'	=>	'success',
				'success'   =>  true,
				'shopinfo'     => $recentAddedShops->toArray()
			));	
		}else{
			return new JsonModel(array(
				'status'	=>	'not success',
				'success'   =>  false,
				'shopinfo'     => ''
			));
		}	
	}
	
}