<?php

class Admin_Form_Tipodocumento extends Zend_Form
{

    public function init(){
       
    	$idTipodocumentos = new Zend_Form_Element_Hidden('idTipodocumentos'); 
		
		$model_natureza = new Natureza();
        
		$idNatureza = new Zend_Form_Element_Select('idNatureza');
		$idNatureza->setLabel('Natureza:');
	    foreach ($model_natureza->findForSelect() as $nature) {
	    	$idNatureza->addMultiOption($nature->idNatureza, $nature->nome);
		}
		
		$tipodocumentos = new Zend_Form_Element_Text('nome');
    	$tipodocumentos->setLabel("Tipo do Documento:")
    		 	  ->setAttrib('size', '50');
    		 	      	
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar')
               ->setAttrib('id', 'submitbutton');
 
        $this->addElements(array($idTipodocumentos, $idNatureza, $tipodocumentos, $submit));
    }


}

