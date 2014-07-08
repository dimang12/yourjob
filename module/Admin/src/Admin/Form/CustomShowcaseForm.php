<?php
namespace Admin\Form;
use Zend\Form\Form;
class CustomShowcaseForm extends Form{
	public function __construct($n = null)
	{
		parent:: __construct('customize');
		$this->setAttributes(array('method'=>'post'));
		$this->setUseInputFilterDefaults(false);
		
		$this->add(array(
				'name'	=>'scen_desc',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Description ',
		
				),
		));
		$this->add(array(
				'type' => 'Zend\Form\Element\Text',
				'name' => 'prod_alias',
				'options' => array(
						'label'=>'Create link',
				),
		));
		$this->add(array(
				'name'	=>'scen_top',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Position top:',
		
				),
		));
		$this->add(array(
				'name'	=>'scen_left',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Position left:',
		
				),
		));
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'scen_placement',
				'options' => array(
						'label'=>'Tooltip placement',
						'options' => array(
							'left'=>'Left',
							'right'=>'Right',
							'top'=>'Top',
							'bottom'=>'Bottom'		
						),
				),
		));
		$this->add(array(
				'name'	=>'scen_skewx',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Skewx ',
		
				),
		));$this->add(array(
				'name'	=>'scen_skewy',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Skewy',
		
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