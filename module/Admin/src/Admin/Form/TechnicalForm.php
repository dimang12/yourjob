<?php
namespace Admin\Form;
use Zend\Form\Form;
class TechnicalForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('technical');
		$this->setAttributes(array('method'=> 'post'));
		
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
				'name' => 'tech_field',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
						'label'=>'Field',
				),
		));
		$this->add(array(
				'name' => 'kh_tech_field',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
						'label'=>'Field(kh)',
				),
		));
		$this->add(array(
				'name' => 'tech_value',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
						'label'=>'Value',
				),
		));
		$this->add(array(
				'name' => 'kh_tech_value',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
						'label'=>'Value(kh)',
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