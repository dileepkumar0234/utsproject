<?php
namespace Models\Model;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Expression;
class UserTable
{
    protected $tableGateway;
	protected $select;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	
	public function saveUserDataa($users)
    {
		$password=md5($users['userpwd']);
		if(isset($users['inputFirstname']) && $users['inputFirstname']!=''){
			$firstName = $users['inputFirstname'];
		}else{
			$firstName = '';
		}
		if(isset($users['inputEmail']) && $users['inputEmail']!=''){
			$email = $users['inputEmail'];
		}else{
			$email ='';
		}
		$data = array(
			'user_name' 	  	       => $firstName,				
			'email' 		           => $email,  		
			'password' 		           => $password,		
			'locked_pwd' 		       => $users['userpwd'],		
			'status'  	               => 1,  	
			'date_added' 	           => date('Y-m-d H:i:s'),   
			'date_updated'	  	       => date('Y-m-d H:i:s'), 	
			'user_type_id' 		       => 2, 			
		);	
		$insertresult=$this->tableGateway->insert($data);	
		return $this->tableGateway->lastInsertValue;		
    }
	
	
	public function saveUserData($users)
    {
		if(isset($users['email']) && $users['email']!=''){
			$email = $users['email'];
		}else{
			$email ='';
		}
		$data = array(			
			'email' 		           => $email,  		
			'status'  	               => 1,  	
			'date_updated'	  	       => date('Y-m-d H:i:s'), 				
		);	
		 $result = $this->tableGateway->update($data, array('user_id' => $users['hidUserId']));	   
	     return $result;   
    }		
	public function checkDetails($details)
    {	
		$select = $this->tableGateway->getSql()->select();
		$select->join('user_details', new Expression('user_details.u_user_id=user.user_id'),array('*'),'left');
		$select->join('processing_status', new Expression('processing_status.ps_user_id=user.user_id'),array('*'),'left');
		$select->where('user.email="'.$details['u_email'].'"');
		$select->where('user.password="'.md5($details['u_password']).'"');
		$select->where('user.status="1"');
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet;		
	}	
	public function getUserList(){
		$select = $this->tableGateway->getSql()->select();
		$select->join('user_details', new Expression('user_details.u_user_id=user.user_id'),array('*'),'left');
		$select->join('assign_user_list', new Expression('assign_user_list.client_id=user.user_id'),array('*'),'left');
		$select->join(array('u' => 'user'), 'assign_user_list.unlists_u_id=u.user_id',array('client_id' =>new Expression('u.user_id'),'client_name' =>new Expression('u.user_name'),'client_email' =>new Expression('u.email')),'left');
		$select->where('user.status="1"');                         
		$select->where('user.user_type_id="2"');  
		$select->order('user.user_id DESC');
		$resultSet = $this->tableGateway->selectWith($select);			
		return $resultSet;
		
	}
	public function getUnListUserList(){
		$select = $this->tableGateway->getSql()->select();
		$select->join('user_details', new Expression('user_details.u_user_id=user.user_id'),array('*'),'left');
		$select->where('user.status="1"');                         
		$select->where('user.user_type_id="3"'); 
		$select->order('user.user_id DESC');
		$resultSet = $this->tableGateway->selectWith($select);			
		return $resultSet;
	}
	public function getUserListAll(){
		$select = $this->tableGateway->getSql()->select();
		$select->join('user_details', new Expression('user_details.u_user_id=user.user_id'),array('*'),'left');
		$select->join('processing_status', new Expression('processing_status.ps_user_id=user.user_id'),array('*'),'left');
		$select->join('assign_user_list', new Expression('assign_user_list.client_id=user.user_id'),array('*'),'left');
		$select->join(array('u' => 'user'), 'assign_user_list.unlists_u_id=u.user_id',array('client_id' =>new Expression('u.user_id'),'client_name' =>new Expression('u.user_name'),'client_email' =>new Expression('u.email')),'left');
		$select->where('user.status="1"');                         
		$select->where('user.user_type_id="2"');  
		$select->order('user.user_id DESC');
		$resultSet = $this->tableGateway->selectWith($select);			
		return $resultSet;
		
	}
	public function checkAdminIp($data,$ip){
		$select = $this->tableGateway->getSql()->select();
		$select->join('user_type', new Expression('user_type.user_type_id=user.user_type_id'),array('*'),'left');
		$select->join('user_details', new Expression('user_details.u_user_id=user.user_id'),array('*'),'left');
		$select->where('user.email="'.$data['userEmail'].'"');
		$select->where('user.password="'.md5($data['pwd']).'"');
		$select->where('user.logged_ip="'.$ip.'"');
		$select->where('user.status="1"');
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet;		
	}
	public function getpassword($userid,$pwdd){ 
		$pwd=md5($pwdd);
		$select = $this->tableGateway->getSql()->select();
		$select->where('password="'.$pwd.'"');
		$select->where('user_id="'.$userid.'"');
		$resultSet = $this->tableGateway->selectWith($select);			
		return $resultSet->count();
	}
	public function userdetails($id)
    {	
		$select = $this->tableGateway->getSql()->select();
		$select->where('user_id="'.$id.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->current();
	}
	public function checkUniqueRecord($email){        
		$select = $this->tableGateway->getSql()->select()                        
			   ->where('email="'.$email.'"');                                         
	   $resultSet = $this->tableGateway->selectWith($select);                            
	   return $resultSet->count();
	} 
   
	public function getUserEmailData($email){        
		$select = $this->tableGateway->getSql()->select()                        
			   ->where('email="'.$email.'"');                                         
	   $resultSet = $this->tableGateway->selectWith($select);                            
	   return $resultSet->current();
	} 
   
	public function checkloginEmail($data){     
		$select = $this->tableGateway->getSql()->select();                        
			   $select->where('email="'.$data['email'].'"');                                         
			   $select->where('user_type_id="'.$data['user_type_id'].'"');                                         
	   $resultSet = $this->tableGateway->selectWith($select);                            
	   return $resultSet;
	} 
	public function changepwd($userid,$pwd){
	   $password=md5($pwd);
	   $data = array(
		   'password'        =>$password,
		   'locked_pwd'      =>$pwd,
		);
	   $changepassword=$this->tableGateway->update($data, array('user_id' => $userid));	   
	   return $changepassword;                        
   }
   public function updateUserRegAuth($userid){
	   $data = array(
			'status'          =>'1',
	   );
	   $updateuserid=$this->tableGateway->update($data, array('user_id' => $userid));
	   return $updateuserid;                        
	}
	public function updateUserData($users,$uid)
    {
			$data = array(
				'user_name' 	  	       => $users['user_name'], 				
				'status'  	               => 1,  	  
				'date_updated'	  	       => date('Y-m-d H:i:s'), 
			);	
			$updateuserid=$this->tableGateway->update($data, array('user_id' => $uid));
			return $updateuserid;
    }
    public function updateUniqueCode($ucode,$uid){
    	$data = array(
				'unique_code' 	  	       => $ucode, 				
			);	
			$updateuserid=$this->tableGateway->update($data, array('user_id' => $uid));
			return $updateuserid;
    }
	public function getUserData($user_id){        
		$select = $this->tableGateway->getSql()->select();
		$select->join('user_details', new Expression('user_details.u_user_id=user.user_id'),array('*'),'left');	
		$select->join('processing_status', new Expression('processing_status.ps_user_id=user.user_id'),array('*'),'left');	
		$select->where('user.user_id="'.$user_id.'"');                                         
		$resultSet = $this->tableGateway->selectWith($select);			
		return $resultSet->current();
    }	
	public function changeUserStatus($uid,$status)
    {
		$data = array(
			'status' 	  	       	   => $status['status'], 				
			'date_updated'	  	       => date('Y-m-d H:i:s'), 	
		);	
		$updateuserid=$this->tableGateway->update($data, array('user_id' => $uid));
		return $updateuserid;	
    }
	public function getUserInfo($user_id){        
		$select = $this->tableGateway->getSql()->select();
		$select->join('user_details', new Expression('user_details.u_user_id=user.user_id'),array('*'),'left');	
		$select->where('user.user_id="'.$user_id.'"');                                         
		$select->where('user.status="1"');                                         
		$resultSet = $this->tableGateway->selectWith($select);			
		return $resultSet->current();
    }
}