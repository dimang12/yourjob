<?php
namespace Admin\Form;
use Zend\Form\Form;
class CateForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('cateform');
		$this->setAttributes(array('method'=> 'post'));
		$this->setAttribute('class', 'form-inline');
		$this->add(array(
			'name' => 'cate_parent',
			'type' => 'Zend\Form\Element\Select',
			    'options' => array(
			    	'label'=>'Select parent',
			        'options' => array(
			            
			    ),
			 ),
		));
		
		$this->add(array(
				'name'	=>'cate_name',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Category Name'
				),
		));
		$this->add(array(
				'name'	=>'kh_cate_name',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Category(kh)'
				),
		));
		$this->add(array(
				'name'	=>'cate_order',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Ordering'
				),
		));
		
		$this->add(array(
				'name'	=>'cate_image',
				'attributes'	=>array(
						'type'		=>'file',
				),
				'options'	=>array(
						'label'	=>'Image (show on home page)'
				),
		));
		$this->add(array(
				'name'	=>'cate_details',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Textarea',
						'placeholder'=>'here...'
				),
				'options'	=>array(
						'label'	=>'Category Detail '
				),
		));
		$this->add(array(
				'name'	=>'kh_cate_details',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Textarea',
						'placeholder'=>'here...'
				),
				'options'	=>array(
						'label'	=>' Description(kh)'
				),
		));
		
		$this->add(array(
				'name'=>'submit',
				'attributes'=>array(
						'type'=>'Zend\Form\Element\Submit',
						'value'=>'Save'
				),
		));
	}
}