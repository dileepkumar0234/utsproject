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
class UploadPdfsTable
{
    protected $tableGateway;
	protected $select;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function getUploadsData($id){
		$select = $this->tableGateway->getSql()->select();	
		$select->where('up_user_id= "'.$id.'"');
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet->current();			
	}
	public function deleteUploads($up_user_id){
		$row=$this->tableGateway->delete(array('(up_user_id IN ('.$up_user_id.'))'));
		return $row;		
	}
	public function getUserDataInfo($user_id,$utsYear){        
		$select = $this->tableGateway->getSql()->select();
		$select->join('upload_types', new Expression('upload_types.upt_id=upload_pdfs.upt_id'),array('*'),'left');	
		$select->where('upload_pdfs.up_user_id="'.$user_id.'"');                                         
		$select->where('upload_pdfs.current_year="'.$utsYear.'"');                                         
		$select->where('upload_pdfs.status="1"');                                         
		$resultSet = $this->tableGateway->selectWith($select);			
		return $resultSet;
    }
	public function getUserTaxDocuments($user_id){        
		$select = $this->tableGateway->getSql()->select();
		$select->join('upload_types', new Expression('upload_types.upt_id=upload_pdfs.upt_id'),array('*'),'left');	
		$select->where('upload_pdfs.up_user_id="'.$user_id.'"');                                                                                  
		$select->where('upload_pdfs.status="1"');                                         
		$resultSet = $this->tableGateway->selectWith($select);			
		return $resultSet;
    }
	public function deleteTaxFile($taxFileId){
		$row=$this->tableGateway->delete(array('(up_id IN ('.$taxFileId.'))'));
		return $row;		
	}
	public function addTaxUploadPdf($uid,$upt_id,$upload_file)
    {
		$curYear = date("Y");
		$data = array(
			'up_user_id' 	  	=> $uid, 	
			'upt_id' 		    => $upt_id,  		 		
			'upload_file' 		=> $upload_file,  		 		
			'current_year' 		=> $curYear,  		
			'status'		    => 1, 
			'created_at' 		=> date('Y-m-d H:i:s'),				
			'updated_at' 		=> date('Y-m-d H:i:s')				
		);
		
		$this->tableGateway->insert($data);	
		return $this->tableGateway->lastInsertValue;
    }
}