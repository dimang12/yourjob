<?php
namespace Admin\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container as SessionContainer;
class AdminController extends AbstractActionController
{
	public function indexAction()
	{
		$authLogin = $this->serviceLocator->get('auth_login');
		
		if($authLogin->hasIdentity()){
			return $this->redirect()->toUrl($this->getRequest()->getBasePath()."/dashboard");
		
		}else{
		
			return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/login'); //go to login
		}
		return array();
	}
	
	public function dashboardAction()
	{
		$authLogin = $this->serviceLocator->get('auth_login');
		if($authLogin->hasIdentity())
		{
			
			return  array();
			
		}else
		{
			return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/login'); //go to login
		}
	}
    public function memberAction()
    {
        $authLogin = $this->serviceLocator->get('auth_login');
        if($authLogin->hasIdentity())
        {

            return  array();

        }else
        {
            return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/member'); //go to login
        }
    }
    public function seekerAction()
    {
        $authLogin = $this->serviceLocator->get('auth_login');
        if($authLogin->hasIdentity())
        {

            return  array();

        }else
        {
            return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/member'); //go to login
        }
    }
}