<?php

namespace Documents\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;


/**
 * This form is used to collect documents. The form 
 * . 
 */
class DocumentsForm extends Form {

    private $entityManager = null;

    private $document = null;

    public function __construct( $entityManager = null, $document = null) {
        // Define form name
        parent::__construct('document-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
       
        $this->entityManager = $entityManager;
        $this->document = $document;

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        
        $this->add([
            'type' => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'Название документа',
            ],
        ]);

        
        $this->add([
            'type' => 'text',
            'name' => 'number',
            'options' => [
                'label' => 'Номер документа',
            ],
        ]);
        $this->add([
            'type' => 'text',
            'name' => 'depart_issue',
            'options' => [
                'label' => 'Кем выдан',
            ],
        ]);
        $this->add([
            'type' => 'dateselect',
            'name' => 'date_issue',
            'options' => [
                'label' => 'Дата выдачи',
            ],
        ]);
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => 'Отправить'
            ],
        ]);


    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);
        
        // Add input for "name" field
        $inputFilter->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 7,
                        'max' => 128
                    ],
                ],
                
                
            ],
        ]);

        // Add input for "number" field
        $inputFilter->add([
            'name' => 'number',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 7,
                        'max' => 10
                    ],
                ],
                [
                    'name' => 'Digits',
                    
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'date_issue',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim',
                    
                ],
            ],
            'validators' => [
                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => [$this, 'validateDateIssue'],
                        
                    ],
                ],
                
            ],
        ]);
        // Add input for "depart 0f issue" field
        $inputFilter->add([
            'name' => 'depart_issue',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 10,
                        'max' => 512
                    ],
                ],
                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => [$this, 'validateDepartIssue'],
                        
                    ],
                
                ],
            ],
        ]);
        
    }
    public function validateDepartIssue($value) 
    {
    // Определяем что в строке больше 1 слова.
      if($value) {
      
        $words=explode(" ",$value);
        
        return count($words)>1?true:false;
      }
    }
    public function validateDateIssue($value) 
    {
    // не позже сегоднешней даты.
      if($value) {
       $today=date('d.m.Y', strtotime('now'));
       if(strtotime($today)<strtotime($value))
           return false;
        else 
            return true;
        
      }
    }
}
