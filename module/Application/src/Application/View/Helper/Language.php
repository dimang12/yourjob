<?php 
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;
class Language extends AbstractHelper
{
	protected $serviceLocator;
	public function __invoke($data, $field)
	{
		$value="";
		$translator = $this->serviceLocator->get('translator');
		//$translator->setLocale('en_US');
		
		$locale = $translator->getLocale();
		if($locale == 'km_KH' && $field == true)
		{			
			$value = $data['kh_'.$field];
			if(empty($value)){
				$value = $data[$field];
			}
		}else{
			$value  = $data[$field];
			if(empty($value)){
				$value = $data["kh_" .$field];
			}
		}		
		
		return $value;
	}
	
	public function setServiceLocator(ServiceManager $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
}