<?php
namespace Models\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Expression;
class SchedulesTimingsTable
{
    protected $tableGateway;
	protected $select;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function addScheduleTime($timeD,$uid)
    {
		$data = array(
			'sc_user_id' 	  	=> $uid, 	
			'schedule_dt' 		=> $timeD['schedule_dt'],  		
			'schedule_period' 	=> $timeD['schedule_period'],  		
			'user_status' 	    => 1,  		
			'status'		    => 1, 
			'created_at' 		=> date('Y-m-d H:i:s'), 				
		);
		$this->tableGateway->insert($data);	
		return $this->tableGateway->lastInsertValue;
    }
	public function getData($id){
		$select = $this->tableGateway->getSql()->select();	
		$select->where('sc_user_id= "'.$id.'"');
		$select->where('user_status= "1"');
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet->current();		
	}
	public function getTotalData($id){
		$select = $this->tableGateway->getSql()->select();	
		$select->where('sc_user_id= "'.$id.'"');
		$select->order('timing_id DESC');
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet;		
	}
	public function updateScheduleTime($uid){
		$data = array( 		
			'user_status'		    => 2, 
			'updated_at' 		    => date('Y-m-d H:i:s')				
		);	
		$updatedstatus=$this->tableGateway->update($data, array('(sc_user_id IN('.$uid.'))'));
		return $updatedstatus;
		
	}
	public function deleteScH($uid){
		$row=$this->tableGateway->delete(array('(sc_user_id IN ('.$uid.'))'));
		return $row;		
	}
	public function getSheduleInfo(){
		$select = $this->tableGateway->getSql()->select();
		$select->columns(array('MaxFqNr' => new Expression('MAX(faq_cat_order)')));		
		$select->join('user', new Expression('user.user_id=schedules_timings.sc_user_id'),array('*'),'left');
		$select->join('processing_status', new Expression('schedules_timings.sc_user_id = processing_status.ps_user_id'),array('*'),'left');
		
		$select->order('schedules_timings.schedule_dt DESC');
		$select->group('user.user_id');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;	
	}
	public function addScheduleDateTime($sdate,$stime,$uid)
    {
		$checkAvailable = $this->getData($uid);
		if(isset($checkAvailable->timing_id)){
			$ustatus = 2;
		}else{
			$ustatus = 1;
		}
		$data = array(
			'sc_user_id' 	  	=> $uid, 	
			'schedule_dt' 		=> $sdate,  		
			'schedule_period' 	=> $stime,  		
			'user_status' 	    => $ustatus,  		
			'status'		    => 1, 
			'created_at' 		=> date('Y-m-d H:i:s'), 				
			'updated_at' 		=> date('Y-m-d H:i:s'), 				
		);
		$this->tableGateway->insert($data);	
		return $this->tableGateway->lastInsertValue;
    }
}