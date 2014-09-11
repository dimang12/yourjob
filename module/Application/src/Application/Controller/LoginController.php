<?php
namespace Admin\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\LoginForm;
use Zend\Session\Container as SessionContainer;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable;
class LoginController extends AbstractActionController
{
	
	public function indexAction()
	{
		$authLogin = $this->serviceLocator->get('auth_login');
		
		if($authLogin->hasIdentity()){
			return $this->redirect()->toUrl($this->getRequest()->getBasePath()."/admin");
	
		}else{
	
			return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/login'); //go to login
		}
		return array();
	}
	
    public function loginAction()
    {    	
    	$authService = $this->serviceLocator->get('auth_login');
    	if ($authService->hasIdentity()) {
    		// if not log in, redirect to login page			
    		return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/admin');
    	}   
    	 	
    	$loginForm = new LoginForm();
    	
    	if ($this->getRequest()->isPost()) {
    		$loginForm->setData($this->getRequest()->getPost());
    		if (! $loginForm->isValid()) {
    			
    			// not valid form
    			return new ViewModel(array(
    					'loginForm'  => $loginForm
    			));
    			
    		} 
    		
    		$dbAdapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
    		$loginData = $loginForm->getData(); 
    		$authAdapter = new DbTable($dbAdapter, 'users', 'username', 'password', 'MD5(?)');
    		$authAdapter->setIdentity($loginData['username'])->setCredential($loginData['password']);

    		$authService = $this->serviceLocator->get('auth_login');
    		$authService->setAdapter($authAdapter);
    		$result = $authService->authenticate();
    		

    		if ($result->isValid()) {
    			$userId = $authAdapter->getResultRowObject('user_id')->user_id;
    			$authService->getStorage()
    			->write($userId);
    			return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/admin');
    		}
    	}
    	return new ViewModel(array( 'loginForm'  => $loginForm	));
    }
    
    public function logoutAction()
    {
    	$authService = $this->serviceLocator->get('auth_login');
    	if (! $authService->hasIdentity()) {
    		return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/login');    
    	}
    
    	$authService->clearIdentity();
    	$loginForm = new LoginForm();
    	$viewModel = new ViewModel(array('loginForm'=> $loginForm));
    	return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/logout');
    }
}
