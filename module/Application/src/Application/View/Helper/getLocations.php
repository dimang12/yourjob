<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/3/14
 * Time: 12:29 PM
 */

namespace Application\View\Helper;

use Application\Model\LocationTable;
use Zend\View\Helper\AbstractHelper;

class getLocations extends AbstractHelper
{
    /*
     * declare variable
     */
    private $adapter;

    /*
     * initialize helper
     */
    public function __construct($adapter){
        $this->adapter =$adapter;
    }

    /*
     *
     */
    public function __invoke(){
        $db = new LocationTable($this->adapter);
        return $db->getAllLocation();
    }
}
