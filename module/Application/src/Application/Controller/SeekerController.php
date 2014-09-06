<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 7/2/14
 * Time: 8:14 PM
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\LoginForm;
use Zend\Authentication\Adapter\DbTable;

class SeekerController extends AbstractActionController{

    public function indexAction(){
        $authLogin = $this->serviceLocator->get('auth_login');

        if(!$authLogin->hasIdentity()){
            return $this->redirect()->toRoute('job-seeker', array(
                'controller' => 'Seeker',
                'action' =>  'login'
            ));
        }
        return array();


    }

    public function loginAction(){
        $authService = $this->serviceLocator->get('auth_login');
        if ($authService->hasIdentity()) {
            // if not log in, redirect to login page
            return $this->redirect()->toRoute('job-seeker', array(
                'controller' => 'Seeker',
                'action' =>  'index'
            ));
        }

        $loginForm = new LoginForm();

        if ($this->getRequest()->isPost()) {
            $loginForm->setData($this->getRequest()->getPost());
            if (!$loginForm->isValid()) {

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

                echo $userId = $authAdapter->getResultRowObject('user_id')->user_id;
                $authService->getStorage()
                    ->write($userId);
                return $this->redirect()->toRoute('job-seeker');
            }
        }
        return array( 'loginForm'  => $loginForm);
    }
    public function logoutAction()
    {
        $authService = $this->serviceLocator->get('auth_login');
        if (! $authService->hasIdentity()) {
            return $this->redirect()->toRoute('job-seeker', array(
                'controller' => 'Seeker',
                'action' =>  'login'
            ));
        }

        $authService->clearIdentity();
        $loginForm = new LoginForm();
        //$viewModel = new ViewModel(array('loginForm'=> $loginForm));
        return $this->redirect()->toRoute('job-seeker', array(
            'controller' => 'Seeker',
            'action' =>  'logout'
        ));
    }
    public function _isLogin(){
        return false;
    }

    public function joblistingAction()
    {
        return array();
    }
    public function newjobAction()
    {
        return array();
    }
    public function editjobAction()
    {
        return array();
    }
    public function deletejobAction()
    {

    }
    public function accountinfoAction()
    {
        return array();
    }
    public function companyinfoAction()
    {
        return array();
    }
}
