<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/10/14
 * Time: 1:24 PM
 */

namespace Admin\Controller;

use Application\Model\ShareTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class ShareController extends AbstractActionController
{

    /**
     * @return array|ViewModel
     */
    public function indexAction(){
        /*
         * declare variable
         */
        $page = $this->params()->fromQuery("page",1);
        $db = new ShareTable($this->getAdapter());

        $shares = $db->getAllShare();

        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($shares));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);

        return new ViewModel(array(
            "paginator" => $paginator
        ));
    }

    /**
     * @return bool
     */
    public function approveAction(){
        $this->layout("layout/ajax_layout");
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $id = $this->params()->fromRoute("id");
        $ch = $this->params()->fromQuery("ch");

        if(!empty($id)){
            $sm->ZF2_Update("share",array("shar_approval"=>$ch),array("share_id"=>$id));
        }
        return true;
    }

    /**
     * @return ViewModel
     */
    public function detailAction(){
        $id = $this->params()->fromRoute("id");
        $db = new ShareTable();
        $detail = $db->getDetail($id);

        return new ViewModel(array(
            "detail" => current($detail)
        ));
    }

    public function deleteAction(){
        $id = $this->params()->fromRoute("id");
        $db = new ShareTable();

        $db->deleteRow($id);
        return false;
    }



    /**
     * @return array|object
     */
    public function getAdapter(){
        return $this->getServiceLocator()->get("Zend\Db\Adapter\Adapter");
    }
}