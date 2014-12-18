<?php

namespace Admin\Controller;

use Application\Model\EducationTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EducationController extends  AbstractActionController{

    public function indexAction(){
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $eduData = $sm->getAllEducation();


        $page = $this->params()->fromQuery('page');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($eduData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);
        return new ViewModel(array(
            "eduData"=>$paginator
        ));
    }
    public function approvalAction(){
        $this->layout("layout/ajax_layout");
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $education_id = $this->params()->fromQuery("educationId");
        $ch = $this->params()->fromQuery("ch");
        if(!empty($education_id)){
            $sm->ZF2_Update("education",array("educ_approval"=>$ch),array("education_id"=>$education_id));
        }
        return true;
    }
    public function deleteAction(){
        $this->layout("layout/ajax_layout");
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $education_id = $this->params()->fromQuery("educationId");
        if(!empty($education_id)){
            $sm->ZF2_Delete("education",array("education_id"=>$education_id));
        }
        return true;
    }
    /*
     * preview education
     */
    public function detailAction(){
        // params or variable
        $id = $this->params()->fromRoute("id");
        $db = new EducationTable($this->getAdapter());

        $education = $db->getDetail($id);

        return new ViewModel(array(
            "education" => current($education)
        ));
    }

    /*
     * create adapter
     */
    public function getAdapter(){
        return $this->getServiceLocator()->get("Zend\Db\Adapter\Adapter");
    }

}