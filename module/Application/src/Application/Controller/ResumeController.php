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
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ResumeController extends AbstractActionController{



    public function indexAction(){
        $this->checkLogin();

        $db = new ResumeTable($this->getAdapter());
        $generalInfo = $db->getSeekerGeneralInfo();

        return new ViewModel(array(
            "general" => current($generalInfo)
        ));
    }

    /*
     * action edit data of general information
     */
    public function generalAction(){
        $this->checkLogin();

        $db = new ResumeTable($this->getAdapter());
        $generalInfo = $db->getSeekerGeneralInfo();

        return new ViewModel(array(
            "general" => current($generalInfo)
        ));
    }

    /*
     * action edit career profile
     */
    public function careerprofileAction(){
        $this->checkLogin();

        $db = new ResumeTable($this->getAdapter());
        $categories = $db->getAllRows("categories");
        $industies = $db->getAllRows("industries");
        $generalInfo = $db->getSeekerGeneralInfo();

        return new ViewModel(array(
            "categories" => $categories,
            "industries" => $industies,
            "general" => current($generalInfo)
        ));
    }

    /*
     * action edit education
     */
    public function educationAction(){
        $this->checkLogin();
    }

    /*
     * action edit preference
     */
    public function preferenceAction(){
        $this->checkLogin();
    }

    /*
     * action edit experience
     */
    public function experienceAction(){
        $this->checkLogin();
    }

    /*
     * action edit skill
     */
    public function skillAction(){
        $this->checkLogin();
    }

    /*
     * ajax action general
     */
    public function updategeneralAction(){
        //init
        $this->layout("layout/ajax_layout");

        //declare params
        $db= new ResumeTable($this->getAdapter());
        $data = $this->params()->fromPost();

        $db->updateGeneralInfo($data);
        return false;
    }


    /*
     * ajax action general
     */
    public function updatecareerAction(){
        //init
        $this->layout("layout/ajax_layout");

        //declare params
        $db= new ResumeTable($this->getAdapter());
        $data = $this->params()->fromPost();

        $db->updateCareerProfile($data);
        return false;
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
                $this->request()->toUrl($this->getRequest()->getBaseUrl(). "/resume/login");
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
        $this->redirect()->toUrl($this->getRequest()->getBaseUrl(). "/resume/login");
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