<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 10/12/14
 * Time: 10:07 AM
 */

namespace Application\Model;

class FeatureTable extends SuperTableGateway{

    public function __construct($adapter){
        parent::__construct($adapter);
    }

    public function getFeatures(){
        $sql = $this->db->select()
                        ->from("feature")
                        //->join("company","feature.company_id=company.company_id")
                        ->order("feat_ordering ASC")
            ;

        return $this->executeQuery($sql)->toArray();
    }

}