<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/4/14
 * Time: 10:39 PM
 */
namespace Application\Model;

class ShareTable extends SuperTableGateway
{


    /**
     * create constructor
     * @param string $adapter
     */
    public function __construct($adapter=null){
        parent::__construct($adapter);
        $this->_table = "share";
        $this->_fieldId = "share_id";
    }

    /**
     * get all share document
     * @return data of array
     */
    public function getAllShare($isApprove=null){
        $sql = $this->db->select()
                        ->from($this->_table)
                        ->order("shar_post_date DESC")
            ;
        if($isApprove!=null) {
            $sql->where("shar_approval=$isApprove");
        }
        return $this->executeQuery($sql)->toArray();
    }
}