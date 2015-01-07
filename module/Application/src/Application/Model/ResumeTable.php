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

    public function __construct($adapter=null){
        $this->_table = "resume";
        $this->_fieldId = "resume_id";
        parent::__construct($adapter);
    }

    /*
     * get seeker general info
     */
    public function getSeekerGeneralInfo($resumeId=""){
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
//                    ->where("u.user_id = $userId")
        ;

        if(empty($resumeId)){
            $sql->where("u.user_id = $userId");
        }else{
            $sql->where("r.resume_id={$resumeId}");
        }
        $res = $this->executeQuery($sql)->toArray();

        // return value
        return $res;

    }

    /*
     * get resume detail
     */
    public function getResumeDetail($resumeId = ""){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //queries block
        $sql = $this->db->select()->columns(array())
            ->from(array("u"=>"users"))
            ->join(array("r"=>"resume"), "r.user_id = u.user_id", array(), "LEFT")
            ->join(array("edu"=>"resume_education"),"r.resume_id=edu.resume_id", array("edu_detail"),"LEFT")
            ->join(array("exp"=>"resume_experience"),"r.resume_id=exp.resume_id", array("exp_detail"),"LEFT")
            ->join(array("sk"=>"resume_skill"),"r.resume_id=sk.resume_id", array("skil_detail"),"LEFT")

//            ->where("u.user_id = $userId")
        ;

        if(empty($resumeId)){
            $sql->where("u.user_id = $userId");
        }else{
            $sql->where("r.resume_id = $resumeId");
        }
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

    /**
     * @return mixed
     */
    public function getExperience(){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //get resume idf
        $sql = $this->db->select()->from(array("red"=> "resume_experience"))
            ->join(array("r"=>"resume"), "red.resume_id = r.resume_id")
            ->where("r.user_id = $userId")
            ->limit(1)
        ;

        return $this->executeQuery($sql)->toArray();
    }

    /**
     * @return mixed
     */
    public function getSkill(){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //get resume idf
        $sql = $this->db->select()->from(array("red"=> "resume_skill"))
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
                ->join(array("re"=>"resume_education"),"resume.resume_id=re.resume_id")
                ->where("user_id = $userId")
                ->limit(1)
            ;

        $resume = $this->executeQuery($sql)->toArray();


        if(count($resume)>0){
            $sql = $this->db->update("resume_education")->set($data)->where("resume_id=" . $resume[0]["resume_id"]);
            $this->execute($sql);
        }else{
            $sql = $this->db->select()->from("resume")
                ->where("user_id = $userId")
                ->limit(1)
            ;
            $res = current($this->executeQuery($sql)->toArray());
            $data["resume_id"]=$res["resume_id"];

            $sql = $this->db->insert("resume_education")->values($data);
            $this->execute($sql);
        }
    }

    public function updateExperience($data){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //get resume idf
        $sql = $this->db->select()->from("resume")
            ->join(array("re"=>"resume_experience"), "resume.resume_id=re.resume_id")
            ->where("user_id = $userId")
            ->limit(1)
        ;

        $resume = $this->executeQuery($sql)->toArray();

        if(count($resume)>0){
            $sql = $this->db->update("resume_experience")->set($data)->where("resume_id=" . $resume[0]["resume_id"]);
            $this->execute($sql);
        }else{
            $sql = $this->db->select()->from("resume")
                ->where("user_id = $userId")
                ->limit(1)
            ;
            $res = current($this->executeQuery($sql)->toArray());
            $data["resume_id"]=$res["resume_id"];

            $sql = $this->db->insert("resume_experience")->values($data);
            $this->execute($sql);
        }
    }

    public function updateSkill($data){
        //declare variable
        $seekerSession = new Container("seeker_session");
        $userId = $seekerSession->seekerUserId;

        //get resume idf
        $sql = $this->db->select()->from("resume")
            ->join(array("rs"=>"resume_skill"), "resume.resume_id=rs.resume_id")
            ->where("user_id = $userId")
            ->limit(1)
        ;

        $resume = $this->executeQuery($sql)->toArray();

        if(count($resume)>0){
            $sql = $this->db->update("resume_skill")->set($data)->where("resume_id=" . $resume[0]["resume_id"]);
            $this->execute($sql);
        }else{
            $sql = $this->db->select()->from("resume")
                ->where("user_id = $userId")
                ->limit(1)
            ;
            $res = current($this->executeQuery($sql)->toArray());
            $data["resume_id"]=$res["resume_id"];

            $sql = $this->db->insert("resume_skill")->values($data);
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
    public function login($userName, $password, $type=1){
        $returnValue = false;
        if(!empty($userName) && !empty($password)){

            $sql = $this->db->select()
                            ->from("users")
                            ->where("username='$userName' AND password=MD5('$password') AND user_type=$type")
                ;
            $res = $this->executeQuery($sql)->toArray();

            //if count greater than 1 mean it match username and password
            if(count($res)>0){
                $seekerRes = current($res);
//                $seekerSession = new Container("employer_session");
                $seekerSession = new Container("seeker_session");
                $seekerSession->seekerUserId = $seekerRes["user_id"];
                $seekerSession->seekerUserName = $seekerRes["username"];
                $returnValue = true;

            }
        }
        return $returnValue;
    }

    /**
     * @param string $search
     * @param string $category
     * @return mixed
     */
    public function findResume($search = "", $category = ""){
        $sql = $this->db->select()
                        ->from(array("r"=>$this->_table))
                        ->join(array("c"=>"categories"),"r.category_id=c.category_id")
                        ->join(array("u"=>"users"),"r.user_id=u.user_id")
                        ;
        /*
         * check condition for search text
         */
        if(!empty($search)){
            $sql->where("r.resu_current_position='{$search}' OR r.resu_position_level={$search}")
            ;
        }

        /*
         * check condition to filder by category
         */
        if(!empty($category)){
            $sql->where("r.category_id=$category")
            ;
        }

        return $this->executeQuery($sql)->toArray();
    }

    /**
     * @param $employerId
     * @return mixed
     */
    public function getPurchaseResume($employerId){
        $sql = $this->db->select()
            ->from(array("r"=>$this->_table))
            ->join(array("er"=>"employer_resume"),"r.resume_id=er.resume_id")
            ->join(array("u"=>"users"),"r.user_id=u.user_id")
            ->where("er.user_id=$employerId")
        ;
        return $this->executeQuery($sql)->toArray();
    }

    /**
     * @param $resumeId
     * @param $employerId
     * @return int -1 is already purchased, 0 couldn't purchased, 1 is successful
     */
    public function purchaseResume($resumeId,$employerId){
        //declare variable
        $sql = $this->db->select()
                        ->from("employer_resume")
                        ->where("resume_id=$resumeId AND user_id=$employerId")
            ;
        $res = $this->executeQuery($sql);
        if(count($res)>0){
            return -1;
        }else{
//            try{
            $sql = $this->db->select()->from("users")->where("user_id=$employerId")->limit(1);
            $res = current($this->executeQuery($sql)->toArray());

            if($res["user_credit"]<1){
                return 0;
            }else{
                $values = array("user_id"=>$employerId, "resume_id"=>$resumeId,"purchase_date"=>date('Y-m-d'));
                $query = $this->db->insert("employer_resume")->values($values);
                $this->execute($query);
                /*
                 * cut credit from resume
                 */
                $sql = $this->db->update("users")
                    ->set(array("user_credit"=>new \Exception("user_creid-1")))
                    ->where("user_id=$employerId")
                ;
                $this->execute($sql);

                return 1;
            }


//            }catch (\Exception $e){
//                return 0;
//            }
        }
    }

    public function checkIsPurchased($resumeId, $emplolyerId){
        //declare variable
        $sql = $this->db->select()
            ->from("employer_resume")
            ->where("resume_id=$resumeId AND user_id=$emplolyerId")
        ;
        $res = $this->executeQuery($sql);

        if(count($res)>0){
            return 1;
        }else{
            return 0;
        }

    }


}