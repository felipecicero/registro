<?php

class Admin_Form_Login extends Zend_Form
{

    public function init()
    {
		$this->setDecorators(array( 'FormElements', 'Form')); 
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
		
        $this->setName('login');
 
        $login = new Zend_Form_Element_Text('login');
		$login -> clearDecorators();
		$login -> addDecorators($decorator_default);
        $login -> setLabel('Login:');
        $login -> setRequired(true);
        $login -> addFilter('StripTags');
        $login -> addFilter('StringTrim');
        $login -> addValidator('NotEmpty');
 
        $senha = new Zend_Form_Element_Password('senha');
		$senha -> clearDecorators();
		$senha -> addDecorators($decorator_default);
        $senha -> setLabel('Senha:')
        $senha -> setRequired(true)
        $senha -> addFilter('StripTags')
        $senha -> addFilter('StringTrim')
        $senha -> addValidator('NotEmpty');
 
        $submit = new Zend_Form_Element_Submit('Entrar');
        $submit -> setAttrib('id', 'submitbutton');
		$submit -> clearDecorators();
		$submit -> setDecorators(array('ViewHelper'));
 
        $this->addElements(array($login, $senha, $submit));
    }


}

