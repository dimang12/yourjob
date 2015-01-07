<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/4/14
 * Time: 10:10 PM
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\Session\Container;

class MainController extends AbstractActionController
{
    /**
     * create an object of adapter to connect to db
     * @return array|object
     */
    public function getAdapter(){
        return $this->getServiceLocator()->get("Zend\Db\Adapter\Adapter");
    }

    /**
     * create a pagination data
     * @param $data is an array
     * @param int $page is current page
     * @param int $limit limits how many rows are presented per-page
     * @return Paginator
     */
    public function getPaginator($data, $page, $limit=25){
        $paginator = new Paginator(new ArrayAdapter($data));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }

    /**
     * check employer login or not
     * @return bool
     */
    public static function isEmployer(){
        $employerSession = new Container("employer_session");
        if(!empty($employerSession->employerUserId)){
            return true;
        }
        return false;
    }
}