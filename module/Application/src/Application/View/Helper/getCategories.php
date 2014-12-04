<?php
/**
 * User: dimang12
 * Date: 12/1/14
 * Time: 11:05 PM
 */
namespace Application\View\Helper;

use Application\Model\CategoriesTable;
use Application\Model\EducationTable;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\AbstractHelper;


class getCategories extends AbstractHelper
{


    /*
     * declare variable
     */
    private $sm;
    private $adapter;

    /*
     * initialize class
     */
    public function __construct($adapter){
        $this->adapter = $adapter;
    }

    /*
     * invoke start running when this class is called
     * @return array of categories
     */
    public function __invoke(){
        $dbCate = new CategoriesTable(new TableGateway("categories", $this->adapter));
        return $dbCate->getCategories();
    }

    /*
     * set service locator from view
     * @return service locator
     */
    public function setServiceLocator(ServiceManager $sm){
        $this->sm = $sm;
    }

    public function setAdapter($adapter){
        $this->adapter = $adapter;
    }

    /*
     * get adapter from service locator
     */
    public function getAdapter(){
        return $this->sm->get('Zend\Db\Adapter\Adapter');
    }
}

