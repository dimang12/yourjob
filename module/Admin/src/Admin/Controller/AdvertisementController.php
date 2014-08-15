<?php

namespace Admin\Controller;

use Admin\Form\AdvForm;
use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\SlideForm;
use Zend\Validator\File\Size;
use Admin\Model\GlobalModel;

class AdvertisementController extends AbstractActionController {
    public function indexAction() {
        $sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
        $advData = $sm->ZF2_Select("advertisement");
        return array (
            'advData'=> $advData
        );
    }
    public function newAction()
    {
        $form = new AdvForm();
        $sm= $this->serviceLocator->get('admin\Model\GlobalModel');
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $file = $this->params()->fromFiles('adv_image');
                $name = $file['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = uniqid(). '.' . $ext;

                $adv_title = $this->params()->fromPost("adv_title");
                $adv_desc = $this->params()->fromPost("adv_desc");
                $adv_ordering = $this->params()->fromPost("adv_ordering");
                $values = array(
                    'adv_title' => $adv_title,
                    'adv_desc' => $adv_desc,
                    'adv_ordering' => $adv_ordering,
                    'adv_image' => $newName
                );
                $sm->ZF2_Insert('advertisement',$values);
                return $this->redirect()->toRoute('advertisement');
            }
        }
        return array(
            'form' => $form
        );
    }
    public function editAction()
    {
        $form = new AdvForm();
        $sm= $this->serviceLocator->get('admin\Model\GlobalModel');
        $request = $this->getRequest();
        $adv_id = $this->params()->fromRoute("id");
        if($request->isPost()){
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $file = $this->params()->fromFiles('adv_image');
                $name = $file['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = uniqid(). '.' . $ext;

                $adv_title = $this->params()->fromPost("adv_title");
                $adv_desc = $this->params()->fromPost("adv_desc");
                $adv_ordering = $this->params()->fromPost("adv_ordering");
                $values = array(
                    'adv_title' => $adv_title,
                    'adv_desc' => $adv_desc,
                    'adv_ordering' => $adv_ordering,
                    'adv_image' => $newName
                );
                $sm->ZF2_Update('advertisement',$values,array("adv_id"=>$adv_id));
                return $this->redirect()->toRoute('advertisement');
            }
        }
        $advData = $sm->ZF2_Select("advertisement",array("adv_id"=>$adv_id));
        return array(
            'form' => $form,
            'advData'=>$advData
        );
    }
    public function deleteAction()
    {
        $this->layout('layout/ajax_layout');
        $adv_id = $this->params()->fromRoute("id");
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $sm->ZF2_Delete('advertisement',array('adv_id'=>$adv_id));
        return false;
    }
}