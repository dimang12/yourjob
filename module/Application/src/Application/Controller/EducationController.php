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

class EducationController extends  AbstractActionController{

    public function indexAction(){

        $db = new EducationTable($this->getAdapter());
        print_r($db->getAllEducation());
    }

    public function getAdapter(){
        return $this->getServiceLocator()->get("Zend\Db\Adapter\Adapter");
    }
} 