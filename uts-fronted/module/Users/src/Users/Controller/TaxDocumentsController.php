<?php
namespace Users\Controller;

use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class TaxDocumentsController extends AbstractActionController
{
    public function indexAction(){
		$user_session 	= new Container('user');
		$baseUrls 		= $this->getServiceLocator()->get('config');
		$baseUrlArr 	= $baseUrls['urls'];
		$baseUrl 		= $baseUrlArr['baseUrl'];
		$basePath 		= $baseUrlArr['basePath'];
		$downloadUrl 		= $baseUrlArr['downloadUrl'];
		
		$uploadPdfsTable 	= $this->getServiceLocator()->get('Models\Model\UploadPdfsFactory');
		$uploadTypesTable 	= $this->getServiceLocator()->get('Models\Model\UploadTypesFactory');
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$user_id  = $user_session->user_id;
		}else{
			$user_id  = "";
		}
		if(isset($_FILES) && count($_FILES) != 0){
			$categories = $uploadTypesTable->getTaxDocumentCategories();
			$taxTypes	= array();
			if($categories->count()){
				foreach($categories as $c){
					$taxTypes[$c->upt_id] = $c->upt_name;
				}
			}
			foreach($_FILES as $taxType=>$taxFiles){
				foreach($taxFiles['name'] as $key=>$name){
					$taxId  = explode('-',$taxType); 
					$path	= "../uploads/".$user_id."/".$taxTypes[$taxId[1]];
					if(!is_dir($path)) {
						if(mkdir($path, 0777, true)){
							if (move_uploaded_file($taxFiles["tmp_name"][$key], $path."/".$name)){
								$uploadPdfsTable->addTaxUploadPdf($user_id,$taxId[1],$name);
							}
						}
					}else{
						if (move_uploaded_file($taxFiles["tmp_name"][$key], $path."/".$name)){
							$uploadPdfsTable->addTaxUploadPdf($user_id,$taxId[1],$name);
						}
					}
				}
			}
		}
		$result 	= $uploadPdfsTable->getUserTaxDocuments($user_id);
		$categories = $uploadTypesTable->getTaxDocumentCategories();
		$taxDocuments = array();
		if($result->count()){
			foreach($result as $t){
				$taxDocuments[$t->upt_name][$t->up_id] = $t->upload_file;
			}
		}
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
			'taxDocuments'  	=>  $taxDocuments,
			'categories'  		=>  $categories,
			'user_id'  			=>  $user_id,
			'downloadUrl'       => $downloadUrl,
		));
	}
	public function removeTaxFileAction(){
		$user_session 	= new Container('user');
		$baseUrls 		= $this->getServiceLocator()->get('config');
		$baseUrlArr 	= $baseUrls['urls'];
		$baseUrl 		= $baseUrlArr['baseUrl'];
		$basePath 		= $baseUrlArr['basePath'];
		
		$uploadPdfsTable 	= $this->getServiceLocator()->get('Models\Model\UploadPdfsFactory');
		$taxFileId 			= $_POST['taxFileId'];
		$uploadPdfsTable->deleteTaxFile($taxFileId);
		return new JsonModel(array(					
			'output'  =>  1
		));
	}
	public function summaryInfoAction(){
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		if(isset($user_session->user_id) && $user_session->user_id !=""){
			$user_id  = $user_session->user_id;
		}else{
			$user_id  = "";
		}
		$synopsysTable 	= $this->getServiceLocator()->get('Models\Model\SynopsysFactory');
		$taxSummary     = $synopsysTable->getSynopsys($user_id);
		return new ViewModel(array(					
			'baseUrl' 			=>  $baseUrl,
			'basePath'  		=>  $basePath,
			'taxSummary'  		=>  $taxSummary,
		));
	}
}	

