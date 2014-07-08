<?php
namespace Admin\Form;
use Zend\Form\Form;
class MediaForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('media-form');
		$this->setAttributes(array('method'=>'post','enctype'=>'multipart/form-data'));
		
		$this->add(array(
				'name' => 'product_id',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
						'label'=>'Select product',
						'options' => array(
								 
						),
				),
		));
		$this->add(array(
				'name' => 'imag_name',
				'type' => 'file',
				'options' => array(
						'label'=>'Insert an image',
				),
		));
		$this->add(array(
				'name' => 'imag_size',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
						'label'=>'Size ',
				),
		));
		$this->add(array(
				'name' => 'imag_status',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
						'label'=>'Status',
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