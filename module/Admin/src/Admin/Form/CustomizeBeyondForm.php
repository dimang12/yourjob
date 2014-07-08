<?php 
namespace Admin\Form;

use Zend\Form\Form;
class CustomizeBeyondForm extends Form
{
	public function __construct($name=NULL)
	{
		parent::__construct('custom');
		$this->setAttributes(array('method','post'));
		$this->setUseInputFilterDefaults(false);
		
		
	}
}