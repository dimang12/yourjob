<?php
/**
 * User: dimang12
 * Date: 8/30/14
 * Time: 3:00 PM
 */
namespace Application\Controller;

use Application\Model\JobTable;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\AbstractActionController;

class AjaxController extends  AbstractActionController{

    public function searchAction(){


        //params
        $db = new JobTable($this->getJobTableGateway());
        $searchText  = $this->params()->fromQuery("s");

        $searchData = $db->search($searchText);
        echo json_encode($searchData);
        exit;
        return false;
    }

    private function getJobTableGateway(){
        return new TableGateway("job",$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
    }
}
