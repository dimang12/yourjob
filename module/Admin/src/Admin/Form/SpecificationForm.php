<?php 
namespace Admin\Form;

use Zend\Form\Form;
class SpecificationForm extends Form
{
	public function __construct($name=NULL)
	{
		parent::__construct('Specification');
		$this->setAttributes(array('method'=>'post','enctype'=>'multipart/form-data'));
		$this->setUseInputFilterDefaults(false);
		
		$this->add(array(
				'name' =>'show_image',
				'attributes' => array(
						'type' 	=>'file'
				),
				'options'  =>array(
						'label' =>'Choose an Image',
				),
		));
		
		$this->add(array(
				'name' => 'submit',
				'attributes'	=> array(
						'type' => 'Zend\Form\Element\Submit',
						'value' => 'Upload',
				)
		));
		
		$this->add(array(
				'name' => 'spec_title',
				'attributes' => array(
						'type' => 'Zend\Form\Element\Text'
				),
				'options' =>array(
						'label' => 'Title (en )',
				),
		));
		
		$this->add(array(
				'name' => 'kh_spec_title',
				'attributes' => array(
						'type' => 'Zend\Form\Element\Text'
				),
				'options' =>array(
						'label' => 'Title (kh )',
				),
		));
		
		$this->add(array(
			'name' => 'category_id',
			'type'=> 'Zend\Form\Element\Select',
			'options'=> array(
			 	'label' => 'Select Category',
				'options'=> array(
				 )
			 ),
		));
	}
}