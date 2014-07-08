<?php
namespace Admin\View;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;

class GetParams extends AbstractHelper
{

	protected $serviceLocator;


	public function __invoke($getName="")
	{
		 return $this->serviceLocator->get("request")->getQuery($getName);
	}

	public function setServiceLocator(ServiceManager $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
}