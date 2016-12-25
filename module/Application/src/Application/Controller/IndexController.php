<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
class IndexController extends AbstractActionController
{
	public function indexAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];		
		return new viewModel(array(
			'baseUrl'	=> $baseUrl,
			'basePath' 	=> $basePath,
		));	
	}
	public function headerAction($params)
    {
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$processStatusTable = $this->getServiceLocator()->get('Models\Model\ProcessingStatusFactory');
		$userTable = $this->getServiceLocator()->get('Models\Model\UserFactory');
		$allrecords = $userTable->getUserListAllCount();
		$assFile = $processStatusTable->getToassignedDataCount(0);
		$assFile1 = $processStatusTable->getToassignedDataCount(1);
		$assFile2 = $processStatusTable->getToassignedDataCount(2);
		$assFile3 = $processStatusTable->getToassignedDataCount(3);
		$assFile4 = $processStatusTable->getToassignedDataCount(4);
		$assFile5 = $processStatusTable->getToassignedDataCount(5);
		$assFile6 = $processStatusTable->getToassignedDataCount(6);
		$assFile7 = $processStatusTable->getToassignedDataCount(7);
		$assFile8 = $processStatusTable->getToassignedDataCount(8);
		$assFile9 = $processStatusTable->getToassignedDataCount(9);
		$assFile10 = $processStatusTable->getToassignedDataCount(10);
		$assFile11 = $processStatusTable->getToassignedDataCount(11);
		$assFile12 = $processStatusTable->getToassignedDataCount(12);
		$assFile13 = $processStatusTable->getToassignedDataCount(13);
		$assFile14 = $processStatusTable->getToassignedDataCount(14);
		$assFile15 = $processStatusTable->getToassignedDataCount(15);
			return $this->layout()->setVariable(
			"headerarray",array(
				'baseUrl' 		=> 	$baseUrl,
				'basePath'		=>	$basePath,
				'assFile'		=>  $assFile,
				'assFile1'		=>  $assFile1,
				'assFile2'		=>  $assFile2,
				'assFile3'		=>  $assFile3,
				'assFile4'		=>  $assFile4,
				'assFile5'		=>  $assFile5,
				'assFile6'		=>  $assFile6,
				'assFile7'		=>  $assFile7,
				'assFile8'		=>  $assFile8,
				'assFile9'		=>  $assFile9,
				'assFile10'		=>  $assFile10,
				'assFile11'		=>  $assFile11,
				'assFile12'		=>  $assFile12,
				'assFile13'		=>  $assFile13,
				'assFile14'		=>  $assFile14,
				'assFile15'		=>  $assFile15,
				'allrecords'	=> $allrecords,
			)
		);
	}	
}
