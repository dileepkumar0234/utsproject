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
class RefferalFriendsTable
{
    protected $tableGateway;
	protected $select;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function saveRerfferal($uid,$rf)
    {
		if(isset($rf['rf_on_name']) && $rf['rf_on_name']!=''){
			$rf_on_name = $rf['rf_on_name'];
		}else{
			$rf_on_name = '';
		}
		if(isset($rf['rf_on_email']) && $rf['rf_on_email']!=''){
			$rf_on_email = $rf['rf_on_email'];
		}else{
			$rf_on_email ='';
		}		
		if(isset($rf['rf_on_phone']) && $rf['rf_on_phone']!=''){
			$rf_on_phone = $rf['rf_on_phone'];
		}else{
			$rf_on_phone ='';
		}
		if(isset($rf['rf_name']) && $rf['rf_name']!=''){
			$rf_name = $rf['rf_name'];
		}else{
			$rf_name ='';
		}
		if(isset($rf['rf_email']) && $rf['rf_email']!=''){
			$rf_email = $rf['rf_email'];
		}else{
			$rf_email ='';
		}
		if(isset($rf['rf_phone']) && $rf['rf_phone']!=''){
			$rf_phone = $rf['rf_phone'];
		}else{
			$rf_phone ='';
		}
		if(isset($rf['rf_comment']) && $rf['rf_comment']!=''){
			$rf_comment = $rf['rf_comment'];
		}else{
			$rf_comment ='';
		}
		$data = array(
			'rf_user_id'             => $uid,
			'rf_on_name' 	  	  => $rf_on_name,				
			'rf_on_email' 		  => $rf_on_email,  		
			'rf_on_phone' 		  => $rf_on_phone,		
			'rf_name'  	          => $rf_name,  	
			'rf_email' 	          => $rf_email,   
			'rf_phone'	  	      => $rf_phone, 	
			'rf_comment'	  	  => $rf_comment, 	
			'added_at' 		      => date('Y-m-d H:i:s'), 			
			'status' 		      => 1, 			
		);	
		$insertresult=$this->tableGateway->insert($data);	
		return $this->tableGateway->lastInsertValue;		
    }	
	public function checkRequestOneWay($refferedBy,$refferedon){
		$select = $this->tableGateway->getSql()->select();
		$select->where('rf_on_email= "'.$refferedBy.'"');
		$select->where('rf_email= "'.$refferedon.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->count();		
	}
	public function checkRequestsecondWay($refferedon,$refferedBy){
		$select = $this->tableGateway->getSql()->select();
		$select->where('rf_on_email= "'.$refferedon.'"');
		$select->where('rf_email= "'.$refferedBy.'"');
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet->count();		
	}
	public function getRefferal($id){
		$select = $this->tableGateway->getSql()->select();
		$select->where('rf_user_id= "'.$id.'"');
		// $select->group('rf_user_id');
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet;			
	}
	public function getAllRefferal(){
		$select = $this->tableGateway->getSql()->select();
		$select->join('user', new Expression('referral_friends.rf_user_id=user.user_id'),array('*'),'left');
		$select->join('user_details', new Expression('user_details.u_user_id=user.user_id'),array('*'),'left');
		$select->order('referral_friends.rf_id DESC');
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet;	
	}
}