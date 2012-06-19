<?php

class Admin_Form_TipoEmolumento extends Zend_Form
{
	public function init(){
       
    	$idEmolumentos = new Zend_Form_Element_Hidden('idEmolumentos'); 
		
		$model_vigencia = new Vigencia();
		
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
		$decorator_check = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field checkbox')));
		
        
		$idVigencia = new Zend_Form_Element_Select('idVigencia');
		$idVigencia -> setLabel('Vigência:');
		$idVigencia -> clearDecorators();
		$idVigencia -> addDecorators($decorator_default);
		$idVigencia -> setAttrib('disabled', 'disabled');
	    foreach ($model_vigencia->findForSelect() as $vigen) {
	    	$idVigencia->addMultiOption($vigen->idVigencia, $vigen->vigencia);
		}
		
		$model_natureza = new Natureza();
        
		$idNatureza = new Zend_Form_Element_Select('idNatureza');
		$idNatureza -> clearDecorators();
		$idNatureza -> addDecorators($decorator_default);
		$idNatureza -> setLabel('Natureza:');
	    foreach ($model_natureza->findForSelect() as $nature) {
	    	$idNatureza -> addMultiOption($nature->idNatureza, $nature->nome);
		}
		
		$emolumento = new Zend_Form_Element_Text('emolumentos');
    	$emolumento -> setLabel("Descrição do Emolumento:");
    	$emolumento -> clearDecorators();
    	$emolumento -> addDecorators($decorator_default);
    	$emolumento -> setAttrib('size', '30');

    	$valor = new Zend_Form_Element_Checkbox('valor');
		$valor -> setLabel("Emolumento possui valor?");
    	$valor -> clearDecorators();
    	$valor -> addDecorators($decorator_check);
    	$valor -> setAttrib('size', '10');
	
        $submit = new Zend_Form_Element_Submit('Enviar');
        $submit -> clearDecorators();
        $submit -> addDecorators($decorator_default);
        $submit -> setAttrib('id', 'submitbutton');
 
        $this->addElements(array($idEmolumentos, $idVigencia, $emolumento, $idNatureza, $valor, $submit));
    }
    
	public function setAsEditForm(Zend_Db_Table_Row $row){
        $this->populate($row->toArray());
        $this->setAction(sprintf('editartipoemolumento/idEmolumentos/%d', $row->idEmolumentos));

        $this->getElement('idEmolumentos');
		$this->getElement('idVigencia');
		$this->getElement('idNatureza');
        $this->getElement('valor');
		$this->getElement('emolumento');
        
        return $this;
    }
}

