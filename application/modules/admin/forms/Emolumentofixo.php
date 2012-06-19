<?php

class Admin_Form_Emolumentofixo extends Zend_Form
{
	
    public function init(){
		
		$this->setDecorators(array( 'FormElements', 'Form')); 
		
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
	   
    	$idEmolumentoFixo = new Zend_Form_Element_Hidden('idEmolumentoFixo'); 
        
		$idTipoEmolumento = new Zend_Form_Element_Text('idTipoEmolumento');
		$idTipoEmolumento -> clearDecorators();
		$idTipoEmolumento -> addDecorators($decorator_default);
		$idTipoEmolumento -> setLabel('Tipo de Emolumento:');
		$idTipoEmolumento -> setAttrib('disabled', 'disabled');
	   
	    $idTipoEmolumento -> setLabel("Tipo do Emolumento:");
	    $idTipoEmolumento -> clearDecorators();
	    $idTipoEmolumento -> addDecorators($decorator_default);
	    $idTipoEmolumento -> setAttrib('size', '40');
	    $idTipoEmolumento -> setAttrib('disabled', 'disabled');
		
		$emolumento = new Zend_Form_Element_Text('emolumento');
    	$emolumento -> clearDecorators();
    	$emolumento -> addDecorators($decorator_default);
    	$emolumento -> setLabel("Valor do Emolumento:");
    	$emolumento -> setAttrib('size', '10');

    	$pagina_extra = new Zend_Form_Element_Text('pagina_extra');
    	$pagina_extra -> clearDecorators();
    	$pagina_extra -> addDecorators($decorator_default);
    	$pagina_extra -> setLabel("Valor da página extra:");
    	$pagina_extra -> setAttrib('size', '10');
				
		$pagina_inicial = new Zend_Form_Element_Text('pagina_inicial');
    	$pagina_inicial -> clearDecorators();
    	$pagina_inicial -> addDecorators($decorator_default);
    	$pagina_inicial -> setLabel("Número da página que começa a ser contado as páginas extras:");
    	$pagina_inicial -> setAttrib('size', '10');
    		 	      	
        $submit = new Zend_Form_Element_Submit('submit');
        $submit -> setLabel('Enviar');
        $submit -> setAttrib('id', 'submitbutton');
 
        $this->addElements(array($idTipoEmolumento, $emolumento, $pagina_extra, $pagina_inicial, $submit));
    }
    
	public function setAsEditForm(Zend_Db_Table_Row $row){
        $this->populate($row->toArray());
        $this->setAction(sprintf('editaremolumentofixo/idEmolumentoFixo/%d', $row->idEmolumentoFixo));

        $this->getElement('idEmolumentoFixo');
		$this->getElement('emolumento');
		$this->getElement('pagina_extra');
        $this->getElement('pagina_inicial');
        
        return $this;
    }
}

