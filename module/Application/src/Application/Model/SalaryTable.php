<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 1/2/15
 * Time: 4:55 PM
 */

namespace Application\Model;

class SalaryTable extends SuperTableGateway
{
    public function __construct(){
        $this->_table = "salary";
        $this->_fieldId = "salary_id";
        parent::__construct();
    }



}