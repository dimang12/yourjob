<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 7/2/14
 * Time: 10:07 PM
 */

namespace Application\Controller;

use Application\Model\EducationTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EducationController extends  AbstractActionController{

    public function indexAction(){

        $db = new EducationTable($this->getAdapter());
        $eduData = $db->getAllEducation();

        return new ViewModel(array(
            "eduData"=>$eduData
        ));
    }

    public function getAdapter(){
        return $this->getServiceLocator()->get("Zend\Db\Adapter\Adapter");
    }
} 