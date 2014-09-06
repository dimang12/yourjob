<?php

namespace Application\Controller;


use Application\Form\RegisterForm;
use Zend\Mvc\Controller\AbstractActionController;
use Admin\Model\GlobalModel;

class RegisterController extends AbstractActionController{

    public function indexAction(){
        $sm= $this->serviceLocator->get('admin\Model\GlobalModel');
        $form = new RegisterForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $optionRegister = $this->params()->fromPost("option_register");
            $fn = $this->params()->fromPost("first_name");
            $ln = $this->params()->fromPost("last_name");
            $gender = $this->params()->fromPost("gender");
            $u_email = $this->params()->fromPost("user_email");
            $u_name = $this->params()->fromPost("user_name");
            $u_pwd = $this->params()->fromPost("password");
            $u_info = $this->params()->fromPost("user_info");
            $u_address = $this->params()->fromPost("user_address");
            $u_phone = $this->params()->fromPost("user_phone");
            $valueUser = array(
                'user_first_name'=>$fn,
                'user_last_name' => $ln,
                'user_gender' => $gender,
                'user_email' => $u_email,
                'user_phone' => $u_phone,
                'username' => $u_name,
                'password' => $u_pwd,
                'user_address' => $u_address,
                'user_info' => $u_info,
                'user_type'=> $optionRegister
            );
            if($optionRegister==1){
                $form->optRegister=$optionRegister;
                $form->setInputFilter($form->getInputFilter());
                $form->setData($request->getPost());
                if($form->isValid()){
                   $sm->ZF2_Insert("users",$valueUser);
                    return $this->redirect()->toRoute('job-seeker', array(
                        'controller' => 'Seeker',
                        'action' =>  'index'
                    ));
                }
            }else{
                $form->optRegister=$optionRegister;
                $form->setInputFilter($form->getInputFilter());
                $form->setData($request->getPost());
                if($form->isValid()){
                    $valueCom = array(
                        'user_id'=>'',
                        'com_name'=>$this->params()->fromPost("com_name"),
                        'com_contact_person'=>$this->params()->fromPost("contact_name"),
                        'com_phone'=>$this->params()->fromPost("com_phone"),
                        'com_email'=>$this->params()->fromPost("com_email"),
                        'com_website'=>$this->params()->fromPost("com_website"),
                        'com_phone_schedule'=>$this->params()->fromPost("com_service_phone"),
                        'com_info'=>$this->params()->fromPost("com_info"),
                        'com_address'=>$this->params()->fromPost("com_address")
                    );
                    $sm->saveUserWithCompany($valueUser,$valueCom);
                    return $this->redirect()->toRoute('job-seeker', array(
                        'controller' => 'Seeker',
                        'action' =>  'index'
                    ));
                }
            }
        }
        return array(
            'form'=>$form
        );
    }
}