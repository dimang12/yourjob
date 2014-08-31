<?php
namespace Admin\Form;


use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class JobForm extends Form
{
    protected $inputFilter;
    public function __construct($name=null)
    {
        parent::__construct('job');
        $this->setAttributes(array('method'=>'post'));
        $this->add(array(
            'name'=>'job_id',
            'type' => 'hidden'
        ));
        $this->add(array(
            'name'=>'user_id',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'category_id',
            'type' => 'Select',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'city_id',
            'type' => 'Select',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_name',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'gender',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_schedule',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_salary_type',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_salary_from',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_salary_to',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_age_from',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_age_to',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_year_experience',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_language',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_hiring_number',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_description',
            'type' => 'Textarea',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_duty',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_requirement',
            'type' => 'Textarea',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_published_date',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_close_date',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_date_reseted',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_status',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
    }
    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $inputFilter->add(array(
            'name'=>'job_name',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_schedule',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_salary_from',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_salary_to',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_year_experience',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_language',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_hiring_number',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_description',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_duty',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_requirement',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_published_date',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_close_date',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_age_from',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'job_age_to',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'gender',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        return $this->inputFilter = $inputFilter;
    }
}
