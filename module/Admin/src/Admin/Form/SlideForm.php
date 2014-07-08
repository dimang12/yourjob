<?php
namespace Admin\Form;
use Zend\Form\Form;
class SlideForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('slide');
		$this->setAttributes(array('method'=>'post', 'enctype'=>'multipart/form-data'));
		
		$this->add(array(
				'name' => 'slid_control',
				'type' => 'Zend\Form\Element\Select',
				'options'=>array(
		            'label'=>'Select Control',
		        	'options'=>array(
		        		'All Control' =>'All',
						'Residential' => 'Residential ',
		        		'Commercial'  => 'Commercial ',
		        		'Industrial'  => 'Industrial ',
		        		'Professional'	=> 'Professional ',
		        		'Beyondliving'	=> 'Beyond Living',
		        		'Product'		=> 'Product',
		        		'Showcase'		=> 'Showcase',
		        		'Promotion'		=> 'Promotion',
		        		'Support'		=> 'Support',
		        		'About Us'		=> 'About Us',
		        		'Contact Us'		=> 'Contact Us',
					)
				),
		));
		$this->add(array(
				'name'	=>'slid_title',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Slide Title'
				),
		));
		$this->add(array(
				'name'	=>'slid_desc',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Description'
				),
		));
		$this->add(array(
				'name'	=>'kh_slid_desc',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Description (kh)'
				),
		));
		$this->add(array(
				'name'	=>'kh_slid_title',
				'attributes'	=>array(
						'type'	=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Title (kh)'
				),
		));
		$this->add(array(
				'name'	=>'slid_image',
				'attributes'	=>array(
						'type'		=>'file',
				),
				'options'	=>array(
						'label'	=>'Select image'
				),
		));
		$this->add(array(
				'name'	=>'slid_order',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Ordering'
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