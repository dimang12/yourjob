<?php

namespace Application\Controller;

use Application\Model\AclTable;
use Application\Model\CategoriesTable;

use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Permissions\Acl\Acl;
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
        return new ViewModel(array(
            "categories" => $cateDb->getAllCate()
        ));
    }   
    


    private function getCategoiesTableGateway(){
        return new TableGateway("categories",$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
    }
}
