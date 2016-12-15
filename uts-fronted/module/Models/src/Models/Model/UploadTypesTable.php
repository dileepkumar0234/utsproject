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
class UploadTypesTable
{
    protected $tableGateway;
	protected $select;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function getTaxDocumentCategories(){        
		$select = $this->tableGateway->getSql()->select();                                                                                 
		$select->where('upt_status="1"');                                         
		$resultSet = $this->tableGateway->selectWith($select);			
		return $resultSet;
    }
}