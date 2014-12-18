<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/14/14
 * Time: 11:18 PM
 */

namespace Application\Model;

use Zend\Db\Sql\Expression;

class ExperienceShareTable extends SuperTableGateway
{
    /**
     * create constructor
     */
    public function __construct(){
        $this->_table = "experience_share";
        $this->_fieldId = "experience_id";
        parent::__construct();
    }


    /**
     * get related experience share which are shame posted by
     * @param $id
     * @return mixed
     */
    public function getRelated($id){
       $sql = $this->db->select()
                        ->from($this->_table)
                        ->where("experience_id <> $id")
                        ->where(new Expression("expr_post_by=SELECT expr_post_by experience_share WHERE experience_id=$id"))
           ;
       return $this->executeQuery($sql)->toArray();
    }




}
?>
