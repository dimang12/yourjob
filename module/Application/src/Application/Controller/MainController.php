<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/4/14
 * Time: 10:10 PM
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class MainController extends AbstractActionController
{
    public function getAdapter(){
        return $this->getServiceLocator()->get("Zend\Db\Adapter\Adapter");
    }
}