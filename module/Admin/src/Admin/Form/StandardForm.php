<?php
namespace Admin\Form;
use Zend\Form\Form;
class StandardForm extends Form
{
	public function __construct($n = null)
	{
		parent:: __construct('standard');
		$this->setAttributes(array('method'=>'post', 'enctype'=>'multipart/form-data'));
		$this->setUseInputFilterDefaults(false);
		
		$this->add(array(
				'name' => 'category_id',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label'=>'Select category',
						'options' => array(
						),
				),
		));
		$this->add(array(
				'name'	=>'stan_image',
				'attributes'	=>array(
					'type'		=>'file',
				),
				'options'	=>array(
						'label'	=>'Choose an Image',
						
				),
		));
		$this->add(array(
				'name'	=>'stan_title',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Title(Description)',
		
				),
		));
		$this->add(array(
				'name'=>'submit',
				'attributes'=>array(
						'type'=>'Zend\Form\Element\Submit',
						'value'=>'Upload',
							
				),
		));
	}
}