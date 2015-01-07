<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 1/2/15
 * Time: 9:57 AM
 */
namespace Application\Model;

use Application\Model\SuperTableGateway;
use Zend\Session\Container;

class UserTable extends SuperTableGateway
{
    /**
     * declare properties
     */

    /**
     * create constructor
     */
    public function __construct(){
        $this->_table = "users";
        $this->_fieldId = "user_id";
        parent::__construct();
    }

    /**
     * login employer
     * @param $userName
     * @param $password
     * @return bool
     */
    public function loginEmployer($userName, $password){
        $sql = $this->db->select()
                        ->from($this->_table)
                        ->where("username='$userName'")
                        ->where("password=MD5($password)")
                        ->where("user_type=2")
            ;
        $res = $this->executeQuery($sql)->toArray();
        if(count($res)>0){
            $employerSession = new Container("seeker_session");
            $employerSession->employerUserId = $res[0]["user_id"];
            $employerSession->employerUserName = $res[0]["username"];
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $userName
     * @return bool
     */
    public function getUserIdByName($userName){
        $sql = $this->db->select()
                        ->from("users")
                        ->where("username='$userName'")
            ;
        $res = current($this->executeQuery($sql)->toArray());
        if(isset($res["user_id"])) return $res["user_id"];

        return false;
    }

    /**
     * add credit to employer
     * @param $employerId
     * @param $credit
     */
    public function addCreditToEmployer($employerId, $credit){
        if(!empty($employerId)){
            $sql = $this->db->update("users")->set(array("user_credit"=>$credit))->where("user_id=$employerId");
            $this->execute($sql);
        }
    }
}