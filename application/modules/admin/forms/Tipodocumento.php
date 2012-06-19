<?php

class Admin_Form_Tipodocumento extends Zend_Form
{

    public function init(){
       
    	$idTipodocumentos = new Zend_Form_Element_Hidden('idTipodocumentos'); 
		
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
		$decorator_option = array('ViewHelper','Errors','Label',array(array('row' => 'HtmlTag'),array('class' => 'option-field')));
       
		$model_natureza = new Natureza();
        
		$idNatureza = new Zend_Form_Element_Select('idNatureza');
		$idNatureza->addDecorators($decorator_default);
		$idNatureza->setLabel('Natureza:');
	    foreach ($model_natureza->findForSelect() as $nature) {
	    	$idNatureza->addMultiOption($nature->idNatureza, $nature->nome);
		}
		
		$tipodocumentos = new Zend_Form_Element_Text('nome');
    	$tipodocumentos -> addDecorators($decorator_default);
		$tipodocumentos -> setLabel("Tipo do Documento:");
		$tipodocumentos -> setAttrib('size', '50');
		
        $submit = new Zend_Form_Element_Submit('Enviar');
        $submit -> setAttrib('id', 'submitbutton-import');
		$submit -> clearDecorators();
		$submit -> setDecorators(array('ViewHelper'));
 
        $this->addElements(array($idTipodocumentos, $idNatureza, $tipodocumentos, $submit));
    }


}

