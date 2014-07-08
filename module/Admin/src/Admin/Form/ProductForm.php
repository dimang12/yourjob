<?php
namespace Admin\Form;
use Zend\Form\Form;
class ProductForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('product-form');
		$this->setAttributes(array('method'=>'post','enctype'=>'multipart/form-data'));
		//$this->setAttribute('class', 'form-inline');
		
		$this->add(array(
				'name' => 'category_id',
				'type' => 'Zend\Form\Element\Select',
				'options'=>array(
		            'label'=>'Select Cates...',
		            'empty_options'=>'Please Select'
		        ),
		));
		$this->add(array(
				'name'	=>'imag_name',
				'attributes'	=>array(
						'type'		=>'file',
				),
				'options'	=>array(
						'label'	=>'Default an image'
				),
		));
		$this->add(array(
				'name'	=>'prod_name',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Product name'
				),
		));
		
		$this->add(array(
				'name'	=>'kh_prod_name',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Product(kh)'
				),
		));
		
		$this->add(array(
				'name'	=>'prod_mate_code',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Material Code '
				),
		));
		
		$this->add(array(
				'name'	=>'prod_size',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Size '
				),
		));
		
		$this->add(array(
				'name'	=>'kh_prod_size',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Size(kh)'
				),
		));
		
		$this->add(array(
				'name'	=>'prod_deal',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Product Highlight'
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