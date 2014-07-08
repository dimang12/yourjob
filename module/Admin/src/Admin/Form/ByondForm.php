<?php 
namespace Admin\Form;
use Zend\Form\Form;
class ByondForm extends Form
{
	public function __construct($n=null)
	{
		parent::__construct('Byond');
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
			'name' => 'live_title',
			'attributes' => array(
				'type' => 'Zend\Form\Element\Text'
			),
			'options' =>array(
				'label' => 'Title (en )',
			),				
		));
		
		$this->add(array(
			'name' => 'kh_live_title',
			'attributes' => array(
				'type' => 'Zend\Form\Element\Text',
			),
			'options' =>array(
				'label' => 'Title (kh)',
			),
		));
		
		$this->add(array(
			'name' =>'live_desc',
			'attributes' => array(
				'type' => 'Zend\Form\Element\Text',
			),
			'options' =>array(
				'label' => 'Description (en)',
			)
		));
		
		$this->add(array(
			'name'=>'kh_live_desc',
			'attributes' => array(
				'type' => 'Zend\Form\Element\Text',
			),
			'options' => array(
				'label' => 'Description (kh)',
			),
		));
		
		$this->add(array(
			'name'=>'live_parent',
			'type' => 'Zend\Form\Element\Select',
			'options' =>array(
				'label' => 'Classification',
				'options'=>array(
// 					'1'=>'Interior',
// 					'2'=>'Exterior'
				),
			),
		));
		$this->add(array(
			'name' => 'saveChange',
			'attributes'=> array(
				'type'=> 'Zend\Form\Element\Submit',
				'value' => 'SaveChange',
			),
		));
		
		$this->add(array(
				'name' => 'updatParent',
				'attributes'=> array(
						'type'=> 'Zend\Form\Element\Button',
						'value' => 'Update',
				),
		));
		
		$this->add(array(
			'name' => 'parent_title',
			'attributes'=> array(
				'type' => 'Zend\Form\Element\Text',
			),
			'options' => array(
				'label'=> 'Title ( en )',
			)
		));
		
		$this->add(array(
				'name' => 'kh_parent_title',
				'attributes'=> array(
						'type' => 'Zend\Form\Element\Text',
				),
				'options' => array(
						'label'=> 'Title ( kh )',
				)
		));
		
		$this->add(array(
				'name' => 'newParent',
				'attributes'=> array(
						'type'=> 'Zend\Form\Element\Submit',
						'value' => 'NewParent',
				),
		));
		
		$this->add(array(
				'name' => 'update_parent_title',
				'attributes'=> array(
						'type' => 'Zend\Form\Element\Text',
				),
				'options' => array(
						'label'=> 'Title ( en )',
				)
		));
		
		$this->add(array(
				'name' => 'update_kh_parent_title',
				'attributes'=> array(
						'type' => 'Zend\Form\Element\Text',
				),
				'options' => array(
						'label'=> 'Title ( kh )',
				)
		));
	}
}