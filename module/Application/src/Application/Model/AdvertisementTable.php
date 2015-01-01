<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/28/14
 * Time: 9:14 PM
 */
namespace Application\Model;

class AdvertisementTable extends SuperTableGateway
{

    public function __construct(){
        $this->_table = "advertisement";
        $this->_fieldId = "adv_id";

        parent::__construct();
    }


}