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
}