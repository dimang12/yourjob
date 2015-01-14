<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 1/8/15
 * Time: 12:05 PM
 */
namespace Application\View\Helper;

use Application\Model\UserTable;
use Zend\View\Helper\AbstractHelper;

class GetLoginName extends AbstractHelper
{
    /*
     * declare variable
     */
    private $sm;
    private $adapter;


    /**
     * @return string
     */
    public function __invoke(){
        $authService = $this->sm->get('auth_login');
        if($authService->hasIdentity()){
            $userId= $authService->getStorage()->read();
            $db = new UserTable();
            $userData = current($db->getList("user_id= $userId"));
            ;
            return $userData["user_first_name"]. " ". $userData["user_last_name"];
        }

        return "";
    }

    /*
     * set service locator from view
     * @return service locator
     */
    public function setServiceLocator($sm){
        $this->sm = $sm;
    }


}
