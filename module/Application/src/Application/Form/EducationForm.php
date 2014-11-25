<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 11/23/14
 * Time: 9:49 PM
 */

namespace Application\Form;


use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;


class EducationForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'educ_title',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Type something...',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Title:',
            ),
        ));

        $this->add(array(
            'name' => 'educ_post_by',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'company or university name',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Post by:',
            ),
        ));

        $this->add(array(
            'name' => 'educ_start_date',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Type something...',
                'required' => 'required',
                'step' => '1',
            ),
            'options' => array(
                'label' => 'Start Date:',
            ),
        ));

        $this->add(array(
            'name' => 'educ_close_date',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Type something...',
                'required' => 'required',

                'step' => '1',
            ),
            'options' => array(
                'label' => 'Close date:',
            ),
        ));

        $this->add(array(
            'name' => 'educ_contact',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Type something...',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Contact information',
            ),
        ));

        $this->add(array(
            'name' => 'image',
            'type' => 'file',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Image',
            ),
        ));

        $this->add(array(
            'name' => 'educ_detail',
            'type' => 'Zend\Form\Element\Textarea',
             'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => "Detail:"
            ),
        ));

        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
    }
}