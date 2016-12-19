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
class EmployeeinfoTable
{
    protected $tableGateway;
	protected $select;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function getData($id){
		$select = $this->tableGateway->getSql()->select();	
		$select->where('user_id = "'.$id.'"');
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet;		
	}
	public function addEmpInfo($empInfo,$userId){        
		$this->tableGateway->delete(array('(user_id IN ('.$userId.'))'));
		foreach($empInfo['cname'] as $k=>$cname){
			if($cname != ""){
				$data = array(        
				   'user_id' 			=> $userId, 
				   'company_name' 		=> $cname, 
				   'client_name' 		=> $empInfo['cnname'][$k], 
				   'proj_start_date'	=> $empInfo['psd'][$k],
				   'proj_end_date' 		=> $empInfo['ped'][$k], 
				   'added_at' 			=> date('Y-m-d H:i:s'), 
				   'updated_at' 		=> date('Y-m-d H:i:s'), 
				   'status'         	=>  1,
			   );   
			   $insertresult=$this->tableGateway->insert($data);
			}
		}   
		return 1;        
	}
}