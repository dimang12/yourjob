<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 11/19/14
 * Time: 11:43 AM
 */
namespace Application\Model;

use Application\Model\SuperTableGateway;
use Zend\Session\Container;

class ResumeTable extends SuperTableGateway
{

    public function __construct($adapter){
        parent::__construct($adapter);
    }

    /*
     * get seeker general info
     */
    public function getSeekerGeneralInfo(){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //queries block
        $sql = $this->db->select()
                    ->from(array("u"=>"users"))
                    ->join(array("r"=>"resume"),
                           "r.user_id = u.user_id",
                           array("resu_dob","resu_pob", "resu_address", "resu_nationality"),
                           "LEFT")
                    ->where("u.user_id = $userId")
        ;

        $res = $this->executeQuery($sql)->toArray();

        // return value
        return $res;

    }

    /*
     * login
     * return true if found, else return false
     * create session if found
     */
    public function login($userName, $password){
        $returnValue = false;
        if(!empty($userName) && !empty($password)){

            $sql = $this->db->select()
                            ->from("users")
                            ->where("username='$userName' AND password=MD5($password) AND user_type=1")
                ;
            $res = $this->executeQuery($sql)->toArray();

            //if count greater than 1 mean it match username and password
            if(count($res)>0){
                $seekerRes = current($res);
                $seekerSession = new Container("seeker_session");
                $seekerSession->seekerUserId = $seekerRes["user_id"];
                $seekerSession->seekerUserName = $seekerRes["username"];
                $returnValue = true;
            }
        }
        return $returnValue;
    }
}