<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use ScnSocialAuth\Mapper\Exception as MapperException;
use ScnSocialAuth\Mapper\UserProviderInterface;
use ScnSocialAuth\Options\ModuleOptions;
use Zend\View\Model\JsonModel;
class IndexController extends AbstractActionController
{
	protected $mapper;
    protected $options;
   	public function setOptions(ModuleOptions $options){
        $this->options = $options;
        return $this;
    }	
	public function getOptions(){
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('ScnSocialAuth-ModuleOptions'));
        }
        return $this->options;
    }
	public function indexAction()
    {
		
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		
		return new viewModel(array(					
			'baseUrl' 						=> 	$baseUrl,
			'basePath'   					=>  $basePath,
		));
    }
	public function headerAction($params)
    {
		$user_session 						=  new Container('user');
		$admin_session 						= new Container('admin');		
		$baseUrls 							= $this->getServiceLocator()->get('config');
		$baseUrlArr 						= $baseUrls['urls'];
		$baseUrl 							= $baseUrlArr['baseUrl'];
		$basePath 							= $baseUrlArr['basePath'];
		
		return $this->layout()->setVariable(
			"headerarray",array(
				'baseUrl' 					=> $baseUrl,
				'basePath' 					=> $basePath,
			)
		);
	}
}
