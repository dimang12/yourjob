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
            $user_type = $authLogin->getStorage()->read('user_type');
            if($user_type==0){
                return $this->redirect()->toUrl($this->getRequest()->getBasePath()."/admin");
            }else{
                return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/login'); //go to login
            }
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
            $user_type = $authService->getStorage()->read('user_type');
            if($user_type=="0"){
               return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/admin');
            }else{
                $authService->clearIdentity();
            }
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
                $userType = $authAdapter->getResultRowObject('user_type')->user_type;
                if($userType=="0"){
                    $authService->getStorage()
                        ->write($userId);
                    $authService->getStorage()
                        ->write($userType);
                    return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/admin');
                }else{
                    $authService->clearIdentity();
                }
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
    public function employerloginAction()
    {
        $authService = $this->serviceLocator->get('auth_login');
        if ($authService->hasIdentity()) {
            // if not log in, redirect to login page
            return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/admin-member');
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
                return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/admin-member');
            }
        }
        return new ViewModel(array( 'loginForm'  => $loginForm	));
    }
    public function seekerloginAction()
    {
        $authService = $this->serviceLocator->get('auth_login');
        if ($authService->hasIdentity()) {
            // if not log in, redirect to login page
            return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/admin-seeker');
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
                return $this->redirect()->toUrl($this->getRequest()->getBasePath().'/admin-seeker');
            }
        }
        return new ViewModel(array( 'loginForm'  => $loginForm	));
    }
}
