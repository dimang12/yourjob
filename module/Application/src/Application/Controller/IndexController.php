<?php

namespace Application\Controller;

use Application\Model\AclTable;
use Application\Model\CategoriesTable;

use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\Permissions\Acl\Acl;
use Zend\View\Helper\Json;
use Zend\View\Model\ViewModel;
use Zend\I18n\Translator\Translator;
use Zend\Session\Container;;
use Zend\Session\Container as SessionContainer;
use Zend\Http\Header\SetCookie;

class IndexController extends AbstractActionController
{
	public function indexAction()
    {
        $cateDb = new CategoriesTable($this->getCategoiesTableGateway());
        $urgentJob = $cateDb->getNewestJob();
        return new ViewModel(array(
            "categories" => $cateDb->getAllCate(),
            "urgentJob" => json_encode($urgentJob)
        ));
    }



    public function categoryAction(){
        //declare params
        $cateId =  $this->params()->fromQuery("c");
        $page = $this->params()->fromQuery("page",1);
        $cateDb = new CategoriesTable($this->getCategoiesTableGateway());
        $jobs = array();

        //it is won't works if category id is empty
        if(!empty($cateId)){
            $jobs = $cateDb->getJobByCate($cateId);
        }

        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($jobs));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(20);


        //pass params to view
        return new ViewModel(array(
            "jobs" => $jobs,
            'paginator'=>$paginator,
            "category"=>$cateId
        ));
    }

    public function jobdtAction(){
        //declare params
        $jobId = $this->params()->fromQuery("job");
        $db = new CategoriesTable($this->getCategoiesTableGateway());
        $jobDetail = null;

        if(!empty($jobId)){
            $jobDetail = $db->getJobDetail($jobId);
        }

        return new ViewModel(
            array(
                "jobDetail"=>current($jobDetail)
            )
        );
    }

    public function searchAction(){
        //get and declare params
        $txtSearch = $this->params()->fromQuery("s");
        
    }
    

    private function getCategoiesTableGateway(){
        return new TableGateway("categories",$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
    }
}
