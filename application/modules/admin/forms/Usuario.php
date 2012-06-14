<?php

class Admin_Form_Usuario extends Zend_Form
{

    public function init()
    {	
		$this->setDecorators(array( 'FormElements', 'Form')); 
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
	
		/* Form Elements & Other Definitions Here ... */
    	$idUsuario = new Zend_Form_Element_Hidden('idUsuario');   
		$idUsuario -> clearDecorators();
		$idUsuario -> addDecorators($decorator_default);
    	
    	$nome = new Zend_Form_Element_Text('nome');
		$nome -> clearDecorators();
		$nome -> addDecorators($decorator_default);
    	$nome -> setLabel("Nome:");
    	$nome -> setRequired(true);
    	$nome -> setAttrib('size', '40');
    	$nome -> setAttrib('maxlength', '60');    		 
    	
    	$email = new Zend_Form_Element_Text('email');
		$email -> clearDecorators();
		$email -> addDecorators($decorator_default);
    	$email->setLabel("E-mail:");
    	$email -> setRequired(true);
    	$email -> addValidator('EmailAddress');
    	$email -> setAttrib('size', '40');
    	$email -> setAttrib('maxlength', '60');
    	$email -> addValidator('Db_NoRecordExists', false,
						 array('table' => 'car_usuarios',
							   'field' => 'email'));
    		      	
    	$login = new Zend_Form_Element_Text('login');
		$login -> clearDecorators();
		$login -> addDecorators($decorator_default);
    	$login -> setLabel("Login:");
    	$login -> setAttrib('size', '15');
    	$login -> setAttrib('maxlength', '20');
    	$login -> addValidator('Db_NoRecordExists', false,
						 array('table' => 'car_usuarios',
							   'field' => 'login'));
    	      
    	$senha = new Zend_Form_Element_Password('senha', true);
		$senha -> clearDecorators();
		$senha -> addDecorators($decorator_default);
    	$senha -> setLabel("Senha:");
    	$senha -> setAttrib('size', '15');
    	$senha -> setAttrib('maxlength', '20');    	      
    	      
    	$confirmasenha = new Zend_Form_Element_Password('confirmasenha', true);
		$confirmasenha -> clearDecorators();
		$confirmasenha -> addDecorators($decorator_default);
    	$confirmasenha -> setLabel("Confirmar Senha:");
    	$confirmasenha -> setAttrib('size', '15');
    	$confirmasenha -> setAttrib('maxlength', '20');
    	$confirmasenha -> addValidators(array(
            						    array('identical', false, 
										array('token' => 'senha')))); 
    	
    	$validate = new Zend_Validate_Date(array('locale' => 'pt-Br'));
    	$nascimento = new Zend_Form_Element_Text('nascimento');
		$nascimento -> clearDecorators();
		$nascimento -> addDecorators($decorator_default);
    	$nascimento -> setLabel("Nascimento:"); 
    	$nascimento -> setAttrib('size', '10');
    	$nascimento -> setAttrib('maxlength', '10');
    	$nascimento -> addValidator($validate);//valida a data    			   
    	
    	$telefone = new Zend_Form_Element_Text('telefone');
		$telefone -> clearDecorators();
		$telefone -> addDecorators($decorator_default);
    	$telefone -> setLabel("Telefone:");
    	$telefone -> setAttrib('maxlength', '14');
    	$telefone -> setAttrib('size', '14');
    	
    	            
        $model_perfil = new Papel();
	    $perfil = new Zend_Form_Element_Select('idPapel');
		$perfil -> clearDecorators();
		$perfil -> addDecorators($decorator_default);
		$perfil -> setLabel('Tipo do Cadastro: ');
    	foreach ($model_perfil->getPapeis() as $perfi) {
	    	$perfil->addMultiOption($perfi->idPapel, $perfi->papel);
		}
		$perfil -> setValue('2');

        $submit = new Zend_Form_Element_Submit('Salvar');
		$submit -> clearDecorators();
		$submit -> setDecorators(array('ViewHelper'));

        $this->addElements(array($idUsuario, $nome, $email, $login, $senha, $confirmasenha, $nascimento, $telefone, $perfil, $submit));
    }

    public function setAsEditForm(Zend_Db_Table_Row $row){
        $this->populate($row->toArray());
        $this->setAction(sprintf('editarusuario/idUsuario/%d', $row->idUsuario));

        $this->getElement('nome');
        $this->getElement('email');
        $this->getElement('login');
        $this->getElement('senha');
        $this->getElement('confirmasenha');
        $this->getElement('nascimento');
        $this->getElement('telefone');
        $this->getElement('idPerfil');
            

        return $this;
    }


}

