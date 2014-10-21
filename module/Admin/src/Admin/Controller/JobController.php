<?php
namespace Admin\Controller;
use Admin\Form\JobForm;

use Zend\Db\Sql\Expression;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 7/5/14
 * Time: 11:52 PM
 */

class JobController extends AbstractActionController{
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
        $user_id = $this->checkAuthornicationService();
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $jobData = $sm->getJob();

        $page = $this->params()->fromQuery('page');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($jobData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);
        return array(
            'jobData'=>$paginator,
        );
    }
    public function jobpostingAction()
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
                    'job_status'=>1,
                    'gender'=>$gender,
                    'job_age_from' => $job_age_from,
                    'job_age_to' => $job_age_to
                );
                $sm->ZF2_Insert('job',$values);
                return $this->redirect()->toUrl("admin-job");
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
    public function jobeditingAction()
    {
        $form = new JobForm();
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $job_id = $this->params()->fromQuery('job_id');
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
                $values = array(
                    'user_id' =>1,
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
                    'job_status'=>1,
                    'Gender'=>$gender,
                    'job_age_from' => $job_age_from,
                    'job_age_to' => $job_age_to
                );
                $sm->ZF2_Update('job',$values,array('job_id'=>$job_id));
            }
        }
        $jobData = $sm->ZF2_Query("SELECT * FROM  job INNER JOIN city ON job.city_id = city.city_id WHERE job_id =$job_id");
        $cityData = $sm->ZF2_Select_AllColumn('city');
        return array(
            'jobData' => $jobData,
            'form' => $form,
            'cityData'=>$cityData,
        );
    }
    public function jobdeleteAction(){
        $this->layout('layout/ajax_layout');
        $job_id = $this->params()->fromQuery('jobId');
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $sm->ZF2_Delete('job',array('job_id'=>$job_id));
        return false;
    }
    public function resumesearchAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $resumeData = $sm->getResume();
        if($this->getRequest()->isGet()){
            $search = $this->params()->fromQuery('search');
            $resumeData = $sm->searchResume($search);
        }
        $page = $this->params()->fromQuery('page');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($resumeData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);
        return array(
            'resumeData' => $paginator
        );
    }
    public function resumepurchaseAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $purchaseData = $sm->getResumePurchase();

        $page = $this->params()->fromQuery('page');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($purchaseData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);
        return array(
            'purchaseData' => $paginator
        );
    }
    public function resumeviewAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $resume_id = $this->params()->fromQuery('resumeId');
        $resumeData = $sm->getResumeById($resume_id);
        return array('resumeData'=>$resumeData);
    }
    public function resumerequestAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $resumeData = $sm->getResumeRequest();
        if($this->getRequest()->isGet()){
            $search = $this->params()->fromQuery('search');
            $resumeData = $sm->searchResumeRequest($search);
        }
        $page = $this->params()->fromQuery('page');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($resumeData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);
        return array(
            'resumeData' => $paginator
        );
    }
    public function resumerequestviewAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $resume_id = $this->params()->fromQuery('resumeId');
        $resumeData = $sm->getResumeById($resume_id);
        return array('resumeData'=>$resumeData);
    }
    public function approvalresumeAction()
    {
        $this->layout("layout\ajax_layout");
        $resumeId = $this->params()->fromQuery("resumeId");
        $ch = $this->params()->fromQuery("ch");
        if(!empty($resumeId)){
            $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
            $sm->ZF2_Update("resume",array("resu_status"=>$ch),array("resume_id"=>$resumeId));
        }
        return false;
    }
    public function newpurchaseAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $request = $this->getRequest();
        if($request->isPost()){
            $numberPurchase = $this->params()->fromPost("num_purchase");
            $userId = $this->params()->fromPost("user_id");
            $values = array(
                "user_id" => $userId,
                "rsp_number_purchase" => $numberPurchase,
                "rsp_dates" => new Expression("NOW()")
            );
            $sm->ZF2_Insert("resume_purchase",$values);
            return $this->redirect()->toUrl("resume-purchase");
        }

        $employerData = $sm->getEmployerForPurchase();
        $page = $this->params()->fromQuery('page');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($employerData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);
        return array(
            'employerData' => $paginator
        );
    }
}