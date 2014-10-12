<?php
namespace Admin\Controller;
use Admin\Form\ResumeForm;
use Admin\Form\UserForm;
use Zend\Db\Sql\Expression;
use Zend\Mvc\Controller\AbstractActionController;

class SeekerController extends AbstractActionController
{
    public function checkAuthornicationService(){
        // check authornication service
        $authService = $this->serviceLocator->get('auth_login');
        if($authService->hasIdentity()){
            return $user_id= $authService->getStorage()->read();
        }else {
            return $this->redirect()->toUrl('login');
        }
    }
    public function indexAction()
    {

        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $seekerData = $sm->getSeeker();

        $page = $this->params()->fromQuery('page');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($seekerData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);
        return array(
            'seekerData'=>$paginator,
        );
    }
    public function newresumeAction()
    {
        $user_id = $this->checkAuthornicationService();
        $sm= $this->serviceLocator->get('admin\Model\GlobalModel');
        $form = new ResumeForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $file = $this->params()->fromFiles('resu_image');
                $name = $file['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = uniqid(). '.' . $ext;

                $category_id = $this->params()->fromPost('category_id');
                $city_id = $this->params()->fromPost('city_id');
                $resu_current_position = $this->params()->fromPost('resu_current_position');
                $resu_position = $this->params()->fromPost('resu_position');
                $resu_schedule = $this->params()->fromPost('resu_schedule');
                $resu_age = $this->params()->fromPost('resu_age');
                $resu_gender = $this->params()->fromPost('resu_gender');
                $resu_salary = $this->params()->fromPost('resu_salary');
                $resu_language = $this->params()->fromPost('resu_language');
                $resu_interesting = $this->params()->fromPost('resu_interesting');
                $resu_skill = $this->params()->fromPost('resu_skill');

                $values = array(
                    'user_id' => $user_id,
                    'category_id' => $category_id,
                    'city_id' => $city_id,
                    'resu_current_position' => $resu_current_position,
                    'resu_position' => $resu_position,
                    'resu_schedule' => $resu_schedule,
                    'resu_age' => $resu_age,
                    'resu_gender' => $resu_gender,
                    'resu_salary' => $resu_salary,
                    'resu_language' => $resu_language,
                    'resu_interesting' => $resu_interesting,
                    'resu_skill' => $resu_skill,
                    'resu_image' => $newName,
                    'resu_posting_date' => new Expression('NOW()')
                );
                $sm->ZF2_Insert('resume',$values);
                return $this->redirect()->toUrl('admin-job-seeker');
            }
        }
        $catData = $sm->getCate();
        $cityData = $sm->ZF2_Select('city');
        return array(
            'form' => $form,
            'catData' => $catData,
            'cityData' => $cityData
        );
    }
    public function editresumeAction()
    {

        $sm= $this->serviceLocator->get('admin\Model\GlobalModel');
        $form = new ResumeForm();
        $resume_id = $this->params()->fromQuery('resumeId');
        $request = $this->getRequest();

        if($request->isPost()){
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $status = $this->params()->fromPost('status');
                if($status!=1){
                    $status=0;
                }

                $category_id = $this->params()->fromPost('category_id');
                $city_id = $this->params()->fromPost('city_id');
                $resu_current_position = $this->params()->fromPost('resu_current_position');
                $resu_position = $this->params()->fromPost('resu_position');
                $resu_schedule = $this->params()->fromPost('resu_schedule');
                $resu_age = $this->params()->fromPost('resu_age');
                $resu_gender = $this->params()->fromPost('resu_gender');
                $resu_salary = $this->params()->fromPost('resu_salary');
                $resu_language = $this->params()->fromPost('resu_language');
                $resu_interesting = $this->params()->fromPost('resu_interesting');
                $resu_skill = $this->params()->fromPost('resu_skill');

                $values = array(

                    'category_id' => $category_id,
                    'city_id' => $city_id,
                    'resu_current_position' => $resu_current_position,
                    'resu_position' => $resu_position,
                    'resu_schedule' => $resu_schedule,
                    'resu_age' => $resu_age,
                    'resu_gender' => $resu_gender,
                    'resu_salary' => $resu_salary,
                    'resu_language' => $resu_language,
                    'resu_interesting' => $resu_interesting,
                    'resu_skill' => $resu_skill,
                    'resu_status' => $status

                );
                $sm->ZF2_Update('resume',$values,array('resume_id'=>$resume_id));
                return $this->redirect()->toUrl('admin-job-seeker');
            }
        }
        $catData = $sm->getCate();
        $cityData = $sm->ZF2_Select('city');
        $resumeData = $sm->ZF2_Select('resume',array('resume_id'=> $resume_id));
        return array(
            'form' => $form,
            'catData' => $catData,
            'cityData' => $cityData,
            'resumeData' => $resumeData
        );
    }
    public function deleteresumeAction()
    {
        $this->layout('layout/ajax_layout');
        $resu_id = $this->params()->fromQuery('resumeId');
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $sm->ZF2_Delete('resume',array('resume_id'=>$resu_id));
        return false;
    }
    public function yearexperienceAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $resumeId = $this->params()->fromQuery('resumeId');
        $yearData = $sm->ZF2_Select('resume_experience',array('resume_id'=>$resumeId));
        return array(
            'yearData' => $yearData,
            'resumeId' => $resumeId
        );
    }
    public function newyearAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $form = new ResumeForm();
        $request = $this->getRequest();
        $resumeId = $this->params()->fromQuery('resumeId');
        if($request->isPost()){
            $values = array(
                'resume_id' => $this->params()->fromQuery('resumeId'),
                'exp_title' => $this->params()->fromPost('exp_title'),
                'exp_detail' => $this->params()->fromPost('exp_detail')
            );
            $sm->ZF2_Insert('resume_experience',$values);
            return $this->redirect()->toUrl('admin-resume-year?resumeId='.$resumeId.'');
        }
        return array(
            'form'=>$form,
            'resumeId' => $resumeId
        );
    }
    public function edityearAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $form = new ResumeForm();
        $request = $this->getRequest();
        $exp_id = $this->params()->fromQuery('expId');
        $resumeId = $this->params()->fromQuery('resumeId');
        if($request->isPost()){
            $values = array(
                'exp_title' => $this->params()->fromPost('exp_title'),
                'exp_detail' => $this->params()->fromPost('exp_detail')
            );
            $sm->ZF2_Update('resume_experience',$values,array('exp_id'=>$exp_id));
            return $this->redirect()->toUrl('admin-resume-year?resumeId='.$resumeId.'');
        }
        $expData = $sm->ZF2_Select('resume_experience',array('exp_id'=>$exp_id));

        return array(
            'form'=>$form,
            'expData' => $expData,
            'resumeId' => $resumeId
        );
    }
    public function deleteyearAction()
    {
        $this->layout('layout/ajax_layout');
        $exp_id = $this->params()->fromQuery('expId');
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $sm->ZF2_Delete('resume_experience',array('exp_id'=>$exp_id));
        return false;
    }
    public function educationAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $resumeId = $this->params()->fromQuery('resumeId');
        $eduData = $sm->ZF2_Select('resume_education',array('resume_id'=>$resumeId));
        return array(
            'eduData' => $eduData,
            'resumeId' => $resumeId
        );
    }
    public function neweducationAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $form = new ResumeForm();
        $request = $this->getRequest();
        $resumeId = $this->params()->fromQuery('resumeId');
        if($request->isPost()){
            $values = array(
                'resume_id' => $this->params()->fromQuery('resumeId'),
                'edu_title' => $this->params()->fromPost('exp_title'),
                'edu_detail' => $this->params()->fromPost('exp_detail')
            );
            $sm->ZF2_Insert('resume_education',$values);
            return $this->redirect()->toUrl('admin-resume-education?resumeId='.$resumeId.'');
        }
        $resumeId = $this->params()->fromQuery('resumeId');
        return array(
            'form'=>$form,
            'resumeId' => $resumeId
        );
    }
    public function editeducationAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $form = new ResumeForm();
        $request = $this->getRequest();
        $edu_id = $this->params()->fromQuery('eduId');
        $resumeId = $this->params()->fromQuery('resumeId');
        if($request->isPost()){
            $values = array(
                'edu_title' => $this->params()->fromPost('exp_title'),
                'edu_detail' => $this->params()->fromPost('exp_detail')
            );
            $sm->ZF2_Update('resume_education',$values,array('edu_id'=>$edu_id));
            return $this->redirect()->toUrl('admin-resume-education?resumeId='.$resumeId.'');
        }
        $eduData = $sm->ZF2_Select('resume_education',array('edu_id'=> $edu_id));

        return array(
            'form'=>$form,
            'eduData' => $eduData,
            'resumeId' => $resumeId
        );
    }
    public function deleteeducationAction()
    {
        $this->layout('layout/ajax_layout');
        $edu_id = $this->params()->fromQuery('eduId');
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $sm->ZF2_Delete('resume_education',array('edu_id'=>$edu_id));
        return false;
    }
    public function userinfoAction()
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
                return $this->redirect()->toUrl('admin-job-seeker');
            }
        }
        $userData = $sm->ZF2_Select('users',array('user_id'=>$user_id));
        return array(
            'form'=>$form,
            'userData' => $userData
        );
    }
    public function resumesampleAction()
    {

        return array(

        );
    }
    public function jobsearchAction()
    {
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $jobData = $sm->getJob();
        if($this->getRequest()->isGet()){
            $search = $this->params()->fromQuery('search');
            $jobData = $sm->searchJob($search);
        }
        return array(
            'jobData' => $jobData
        );
    }
}