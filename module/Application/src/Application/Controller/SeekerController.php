<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 7/2/14
 * Time: 8:14 PM
 */
namespace Application\Controller;

use Admin\Form\JobForm;
use Admin\Form\UserForm;
use Application\Form\RegisterForm;
use Application\Model\ResumeTable;
use Application\Model\UserTable;
use Zend\Db\Sql\Expression;
use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\LoginForm;
use Zend\Authentication\Adapter\DbTable;
use Zend\View\Model\ViewModel;

class SeekerController extends MainController{
    public function checkAuthornicationService(){
        // check authornication service
        $authService = $this->serviceLocator->get('auth_login');
        if($authService->hasIdentity()){
            return $user_id= $authService->getStorage()->read();
        }else {
            return $this->redirect()->toUrl('login');
        }
    }
    public function indexAction(){
        $authLogin = $this->serviceLocator->get('auth_login');

        if(!$authLogin->hasIdentity()){
            return $this->redirect()->toRoute('job-employer', array(
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
            return $this->redirect()->toRoute('job-employer', array(
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
            // user_type = 2 mean  login only for employer
            $authAdapter = new DbTable($dbAdapter, 'users', 'username', 'password', 'MD5(?) AND user_type=2');
            $authAdapter->setIdentity($loginData['username'])->setCredential($loginData['password']);

            $authService = $this->serviceLocator->get('auth_login');
            $authService->setAdapter($authAdapter);
            $result = $authService->authenticate();

            if ($result->isValid()) {

                $userId = $authAdapter->getResultRowObject('user_id')->user_id;
                $authService->getStorage()->write($userId);
                return $this->redirect()->toRoute('job-employer');
            }
        }
        return array( 'loginForm'  => $loginForm);
    }
    public function logoutAction()
    {
        $authService = $this->serviceLocator->get('auth_login');
        if (! $authService->hasIdentity()) {
            return $this->redirect()->toRoute('job-employer', array(
                'controller' => 'Seeker',
                'action' =>  'login'
            ));
        }

        $authService->clearIdentity();
        //$loginForm = new LoginForm();
        //$viewModel = new ViewModel(array('loginForm'=> $loginForm));
        return $this->redirect()->toRoute('job-employer', array(
            'controller' => 'Seeker',
            'action' =>  'logout'
        ));
    }
    public function _isLogin(){
        return false;
    }

    public function joblistingAction()
    {
        $userId = $this->checkAuthornicationService();
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');

        $jobData = $sm->getJobByUserId($userId);

        $page = $this->params()->fromQuery('page');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($jobData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);

        return array(
            'jobData'=>$paginator,
        );
    }

    /**
     * search resumes action
     * @return ViewModel
     */
    public function searchAction(){
        /*
         * declare variable
         */
        $search = $this->params()->fromQuery("s");
        $cate = $this->params()->fromQuery("c");
        $page = $this->params()->fromQuery("page",1);
        $db = new ResumeTable();

        $resume = $db->findResume($search,$cate);

        $paginate = $this->getPaginator($resume,$page,20);

        return new ViewModel(array(
            "resume" => $paginate
        ));
    }

    public function purchaseAction(){
        /*
        * declare variable
        */
        $search = $this->params()->fromQuery("s");
        $cate = $this->params()->fromQuery("c");
        $page = $this->params()->fromQuery("page",1);
        $authService = $this->serviceLocator->get('auth_login');

        $userId = $authService->getStorage()->read();
        $db = new ResumeTable();

        $resume = $db->getPurchaseResume($userId);
        $paginate = $this->getPaginator($resume,$page,20);

        return new ViewModel(array(
            "resume" => $paginate
        ));
    }

    /**
     * @return ViewModel
     */
    public function detailAction(){
        /*
         * declare variables
         */
        $id = $this->params()->fromRoute("id");
        $db = new ResumeTable();
        $generalInfo = $db->getSeekerGeneralInfo($id);
        $resumeDetail = $db->getResumeDetail($id);

        $userId = null;
        $isPurchased = '';

        $authService = $this->serviceLocator->get('auth_login');
        if($authService->hasIdentity()){
            $userId= $authService->getStorage()->read();
            $isPurchased = $db->checkIsPurchased($id, $userId);
        }


        return new ViewModel(array(
            "general" => current($generalInfo),
            "detail" => current($resumeDetail),
            "resumeId" =>$id,
            "isPurchased" => $isPurchased

        ));
    }


    public function newjobAction()
    {
        $user_id = $this->checkAuthornicationService();
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');

        $form = new JobForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $job_name = $this->params()->fromPost('job_name');
                $job_schedule = $this->params()->fromPost('job_schedule');
                $job_salary_from = $this->params()->fromPost('job_salary_from');
                $job_salary_to =$this->params()->fromPost('job_salary_to');
                $job_year_experience = $this->params()->fromPost('job_year_experience');
                $job_language = $this->params()->fromPost('job_language');
                $job_hiring_number = $this->params()->fromPost('job_hiring_number');
                $job_description = $this->params()->fromPost('job_description');
                $job_duty = $this->params()->fromPost('job_duty');
                $job_requirement = $this->params()->fromPost('job_requirement');
                $job_published_date = $this->params()->fromPost('job_published_date');
                $job_close_date = $this->params()->fromPost('job_close_date');
//            $job_status = $this->params()->fromPost('job_status');
                $gender = $this->params()->fromPost('gender');
                $city_id = $this->params()->fromPost('city_id');
                $job_age_from = $this->params()->fromPost('job_age_from');
                $job_age_to = $this->params()->fromPost('job_age_to');
                $jobCategory = $this->params()->fromPost("category_id");
                $job_contact = $this->params()->fromPost("job_contact");
                $jobStatus = $this->params()->fromPost("job_status");

                $values = array(
                    'user_id' =>$user_id,
                    'city_id' =>$city_id,
                    'category_id' => $jobCategory,
                    'job_name' => $job_name,
                    'job_schedule'=>$job_schedule,
                    'job_salary_from'=>$job_salary_from,
                    'job_salary_to'=>$job_salary_to,
                    'job_year_experience'=>$job_year_experience,
                    'job_language'=>$job_language,
                    'job_hiring_number'=>$job_hiring_number,
                    'job_description'=>$job_description,
                    'job_duty'=>$job_duty,
                    'job_requirement'=>$job_requirement,
                    'job_published_date'=>$job_published_date,
                    'job_close_date'=>$job_close_date,
                    'job_status'=>$jobStatus,
                    'job_gender'=>$gender,
                    'job_age_from' => $job_age_from,
                    'job_age_to' => $job_age_to,
                    'job_contact' => $job_contact
                );
                $sm->ZF2_Insert('job',$values);
                return $this->redirect()->toRoute('job-employer', array(
                    'controller' => 'Seeker',
                    'action' =>  'joblisting'
                ));
            }
        }
        $cityData = $sm->ZF2_Select_AllColumn('city',array());
        $cateData = $sm->ZF2_Select_AllColumn('categories',array());
        return array(
            'form' => $form,
            'cityData'=>$cityData,
            'cateData' => $cateData
        );
    }
    public function editjobAction()
    {
        $form = new JobForm();
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $job_id = $this->params()->fromRoute('id');
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $job_name = $this->params()->fromPost('job_name');
                $job_schedule = $this->params()->fromPost('job_schedule');
                $job_salary_from = $this->params()->fromPost('job_salary_from');
                $job_salary_to =$this->params()->fromPost('job_salary_to');
                $job_year_experience = $this->params()->fromPost('job_year_experience');
                $job_language = $this->params()->fromPost('job_language');
                $job_hiring_number = $this->params()->fromPost('job_hiring_number');
                $job_description = $this->params()->fromPost('job_description');
                $job_duty = $this->params()->fromPost('job_duty');
                $job_requirement = $this->params()->fromPost('job_requirement');
                $job_published_date = $this->params()->fromPost('job_published_date');
                $job_close_date = $this->params()->fromPost('job_close_date');
//            $job_status = $this->params()->fromPost('job_status');
                $gender = $this->params()->fromPost('gender');
                $city_id = $this->params()->fromPost('city_id');
                $job_age_from = $this->params()->fromPost('job_age_from');
                $job_age_to = $this->params()->fromPost('job_age_to');
                $job_contact = $this->params()->fromPost("job_contact");
                $job_status = $this->params()->fromPost("job_status");
                $values = array(
                    'city_id' =>$city_id,
                    'job_name' => $job_name,
                    'job_schedule'=>$job_schedule,
                    'job_salary_from'=>$job_salary_from,
                    'job_salary_to'=>$job_salary_to,
                    'job_year_experience'=>$job_year_experience,
                    'job_language'=>$job_language,
                    'job_hiring_number'=>$job_hiring_number,
                    'job_description'=>$job_description,
                    'job_duty'=>$job_duty,
                    'job_requirement'=>$job_requirement,
                    'job_published_date'=>$job_published_date,
                    'job_close_date'=>$job_close_date,
                    'job_status'=>$job_status,
                    'job_gender'=>$gender,
                    'job_age_from' => $job_age_from,
                    'job_age_to' => $job_age_to,
                    'job_contact' => $job_contact

                );
                $sm->ZF2_Update('job',$values,array('job_id'=>$job_id));
                return $this->redirect()->toRoute('job-employer', array(
                    'controller' => 'Seeker',
                    'action' =>  'joblisting'
                ));
            }
        }
        $jobData = $sm->getJobWithCity($job_id);

        $cityData = $sm->ZF2_Select_AllColumn('city');
        return array(
            'jobData' => $jobData,
            'form' => $form,
            'cityData'=>$cityData,
        );
    }
    public function deletejobAction()
    {
        $this->layout('layout/ajax_layout');
        $job_id = $this->params()->fromRoute('id');
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $sm->ZF2_Delete('job',array('job_id'=>$job_id));
        return false;
    }
    public function accountinfoAction()
    {
        $user_id = $this->checkAuthornicationService();
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $form = new UserForm();
        $request = $this->getRequest();
        if($request->isPost())
        {
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $username = $this->params()->fromPost('username');
                $pwd = $this->params()->fromPost('password');
                $gender = $this->params()->fromPost('gender');
                $phone = $this->params()->fromPost('phone');
                $email = $this->params()->fromPost('email');
                $website = $this->params()->fromPost('website');
                $address = $this->params()->fromPost('address');
                $info = $this->params()->fromPost('info');
                $values = array(
                    'username' => $username,
                    'password' => new Expression("MD5('$pwd')"),
                    'user_gender' => $gender,
                    'user_address'=> $address,
                    'user_email' => $email,
                    'user_website' => $website,
                    'user_info'=> $info,
                    'user_phone' => $phone
                );
                $sm->ZF2_Update('users',$values,array('user_id'=>$user_id));
                return $this->redirect()->toRoute('job-employer', array(
                    'controller' => 'Seeker',
                    'action' =>  'accountinfo'
                ));
            }
        }
        $userData = $sm->ZF2_Select('users',array('user_id'=>$user_id));
        return array(
            'form'=>$form,
            'userData' => $userData
        );
    }
    public function companyinfoAction()
    {
        $user_id = $this->checkAuthornicationService();
        $sm= $this->serviceLocator->get('admin\Model\GlobalModel');
        $form = new RegisterForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $optionRegister =3;  // 3 mean update company
            $form->optRegister=$optionRegister;
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $valueCom = array(
                    'com_name'=>$this->params()->fromPost("com_name"),
                    'com_contact_person'=>$this->params()->fromPost("contact_name"),
                    'com_phone'=>$this->params()->fromPost("com_phone"),
                    'com_email'=>$this->params()->fromPost("com_email"),
                    'com_website'=>$this->params()->fromPost("com_website"),
                    'com_phone_schedule'=>$this->params()->fromPost("com_service_phone"),
                    'com_info'=>$this->params()->fromPost("com_info"),
                    'com_address'=>$this->params()->fromPost("com_address")
                );
                $sm->ZF2_Update("company",$valueCom,array("user_id"=>$user_id));
                return $this->redirect()->toRoute('job-employer', array(
                    'controller' => 'Seeker',
                    'action' =>  'index'
                ));
            }
        }
        $comData = $sm->ZF2_Select("company",array("user_id"=>$user_id));
        return array(
            'form'=>$form,
            'comData' => $comData
        );
    }
}
