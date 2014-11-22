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
                           array("*"),
                           "LEFT")
                    ->join(array("cate"=>"categories"),"r.category_id=cate.category_id", array("cate_name"),"LEFT")
                    ->join(array("indu"=>"industries"),"r.industry_id=indu.industry_id", array("indu_name"),"LEFT")
                    ->where("u.user_id = $userId")
        ;

        $res = $this->executeQuery($sql)->toArray();

        // return value
        return $res;

    }

    public function getEducation(){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //get resume idf
        $sql = $this->db->select()->from(array("red"=> "resume_education"))
            ->join(array("r"=>"resume"), "red.resume_id = r.resume_id",array())
            ->where("r.user_id = $userId")
            ->limit(1)
        ;

        return $this->executeQuery($sql)->toArray();
    }

    public function getExperience(){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //get resume idf
        $sql = $this->db->select()->from(array("red"=> "resume_education"))
            ->join(array("r"=>"resume"), "red.resume_id = r.resume_id")
            ->where("r.user_id = $userId")
            ->limit(1)
        ;

        return $this->executeQuery($sql)->toArray();
    }

    public function updateGeneralInfo($data){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //update resume
        $newData = array(
            "resu_dob"=> $data["resu_dob"],
            "resu_pob"=> $data["resu_pob"],
            "resu_address"=> $data["resu_address"],
            "resu_nationality"=> $data["resu_nationality"],
        );

        //find if exist
        $sqlResume = $this->db->select()->from("resume")->where("user_id= $userId");
        $resResume = $this->executeQuery($sqlResume)->toArray();
        $sql= null;
        if(count($resResume)>0){
            $sql = $this->db->update("resume")->set($newData)->where("user_id=$userId");
        }else{
            $newData["user_id"] = $userId;
            $newData["resu_posting_date"] = date("Y-m-d");
            $sql = $this->db->insert("resume")->values($newData);
        }

        $this->execute($sql);
    }

    /*
     * update career profile
     */
    public function updateCareerProfile($data){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //update resume
        $newData = array(
            "resu_current_degree"=> $data["resu_current_degree"],
            "resu_position_level"=> $data["resu_position_level"],
            "resu_current_position"=> $data["resu_current_position"],
            "resu_year_experience"=> $data["resu_year_experience"],
            "category_id"=> $data["category_id"],
            "industry_id"=> $data["industry_id"],
            "resu_salary"=> $data["resu_salary"],
        );

        //find if exist
        $sqlResume = $this->db->select()->from("resume")->where("user_id= $userId");
        $resResume = $this->executeQuery($sqlResume)->toArray();
        $sql= null;
        if(count($resResume)>0){
            $sql = $this->db->update("resume")->set($newData)->where("user_id=$userId");
        }else{
            $newData["user_id"] = $userId;
            $newData["resu_posting_date"] = date("Y-m-d");
            $sql = $this->db->insert("resume")->values($newData);
        }

        $this->execute($sql);
    }

    public function updateEducation($data){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //get resume idf
        $sql = $this->db->select()->from("resume")
                ->where("user_id = $userId")
                ->limit(1)
            ;

        $resume = $this->executeQuery($sql)->toArray();


        if(count($resume)>0){
            $sql = $this->db->update("resume_education")->set($data)->where("resume_id=" . $resume[0]["resume_id"]);
            $this->execute($sql);
        }
    }

    /*
     * get all rows without condition
     */
    public function getAllRows($table){
        $sql = $this->db->select()
                        ->from($table)
                ;
        return $this->executeQuery($sql)->toArray();
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