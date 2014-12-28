<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 11/23/14
 * Time: 11:05 PM
 */
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ShareValidator implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory = new InputFactory();


        $inputFilter->add($factory->createInput(array(
            'name' => 'shar_post_by',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            ),
        )));


        $inputFilter->add($factory->createInput(array(
            'name' => 'shar_contact',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            ),
        )));

        $inputFilter->add($factory->createInput(array(
            'name' => 'image',
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(

            ),
        )));

        $inputFilter->add($factory->createInput(array(
            'name' => 'shar_detail',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            ),
        )));

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}

