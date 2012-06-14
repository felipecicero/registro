<?php

class Admin_Form_Natureza extends Zend_Form
{

    public function init(){
       
		$this->setDecorators(array( 'FormElements', 'Form')); 
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
		
    	$natureza = new Zend_Form_Element_Text('nome');
		$natureza -> clearDecorators();
		$natureza -> addDecorators($decorator_default);
    	$natureza -> setLabel("Natureza:");
    	$natureza -> setAttrib('size', '40');
    		 	      	
        $submit = new Zend_Form_Element_Submit('Salvar');
        $submit -> setAttrib('id', 'submitbutton');
		$submit -> clearDecorators();
		$submit -> setDecorators(array('ViewHelper'));
 
        $this->addElements(array($natureza, $submit));
    }


}

