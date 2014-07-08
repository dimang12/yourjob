<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\GlobalModel;
class SupportController extends AbstractActionController
{
	
	public function indexAction()
	{
		$sm = $this->serviceLocator->get("Admin\Model\GlobalModel");
		$slide = $sm->getSlideByController("Support");
		$this->layout()-> img = $slide;
		return new ViewModel();
	}
}