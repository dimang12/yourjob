<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/4/14
 * Time: 10:03 PM
 */
namespace Application\Controller;

use Application\Model\EducationTable;
use Zend\Mvc\Controller\AbstractActionController;

class ShareController extends MainController
{

    /*
     * index action
     */
    public function indexAction(){
        $page = $this->params()->fromQuery("page",1);

        $db = new EducationTable($this->getAdapter());
        $eduData = $db->getAllEducation();


        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($eduData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);

        return new ViewModel(array(
            "eduData"=>$paginator
        ));
    }
}