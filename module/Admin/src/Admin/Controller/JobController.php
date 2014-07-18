<?php
namespace Admin\Controller;
use Admin\Form\JobForm;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 7/5/14
 * Time: 11:52 PM
 */

class JobController extends AbstractActionController{
    public function indexAction(){
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $jobData = $sm->ZF2_Query("SELECT * FROM  job INNER JOIN city ON job.city_id = city.city_id");
        return array(
            'jobData'=>$jobData,
        );
    }
    public function jobpostingAction()
    {
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
                    'gender'=>$gender,
                );
                $sm->ZF2_Insert('job',$values);
            }
        }
        $cityData = $sm->ZF2_Select_AllColumn('city',array());
        return array(
            'form' => $form,
            'cityData'=>$cityData,
        );
    }
}