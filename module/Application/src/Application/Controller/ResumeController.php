<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 7/2/14
 * Time: 10:11 PM
 */

namespace Application\Controller;


use Admin\Form\LoginForm;

use Application\Model\ResumeTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class ResumeController extends AbstractActionController{



    public function indexAction(){
        $this->checkLogin();
    }


    /*
     * member login
     */
    public function loginAction(){
        $seekerSession = new Container("seeker_session");
        if(!empty($seekerSession->seekerUserId)){
            $this->redirect()->toUrl( $this->getRequest()->getBaseUrl(). "/resume/index");
        }

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
            }else{
                $dbSeeker = new ResumeTable($this->getAdapter());
                $username = $this->params()->fromPost("username");
                $password = $this->params()->fromPost("password");
                $dbSeeker->login($username, $password);
            }

        }
//        return array( 'loginForm'  => $loginForm);
        return new ViewModel(array(
            "loginForm" => $loginForm
        ));
    }

    /*
     * logout job seeker
     */
    public function logoutAction(){
        $this->checkLogin();


        $seekerSession = new Container("seeker_session");
        $seekerSession->seekerUserId = "";
        $seekerSession->seekerUserName = "";
        $this->redirect()->toUrl("login");
    }

    private function getAdapter(){
        return $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    }

    private function checkLogin(){
        $seekerSession = new Container("seeker_session");

        if(empty($seekerSession->seekerUserId)){
            $this->redirect()->toUrl($this->getRequest()->getBaseUrl(). "/resume/login");
        }
    }

} 