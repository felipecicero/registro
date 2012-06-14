<?php

class Admin_Form_Emolumento extends Zend_Form
{
	public function init(){
       
    	$idEmolumentos = new Zend_Form_Element_Hidden('idEmolumentos'); 
		
		$model_vigencia = new Vigencia();
        
		$idVigencia = new Zend_Form_Element_Select('idVigencia');
		$idVigencia -> setLabel('Vigencia:');
		$idVigencia -> setAttrib('disabled', 'disabled');
	    foreach ($model_vigencia->findForSelect() as $vigen) {
	    	$idVigencia->addMultiOption($vigen->idVigencia, $vigen->vigencia);
		}
		
		$emolumento = new Zend_Form_Element_Text('emolumentos');
    	$emolumento -> setLabel("Valor do Emolumento:");
    	$emolumento -> setAttrib('size', '30');

    	$valorinicial = new Zend_Form_Element_Text('valorinicial');
    	$valorinicial -> setLabel("Valor Inicial do Emolumento:");
    	$valorinicial -> setAttrib('size', '10');
				
		$valor_final = new Zend_Form_Element_Text('valorfinal');
    	$valor_final -> setLabel("Valor Final do Emolumento:");
    	$valor_final -> setAttrib('size', '10');
    		 	      	
        $submit = new Zend_Form_Element_Submit('submit');
        $submit -> setLabel('Enviar');
        $submit -> setAttrib('id', 'submitbutton');
 
        $this->addElements(array($idEmolumentos, $idVigencia, $emolumento, $valorinicial, $valor_final, $submit));
    }
    
	public function setAsEditForm(Zend_Db_Table_Row $row){
        $this->populate($row->toArray());
        $this->setAction(sprintf('editaremolumento/idEmolumentos/%d', $row->idEmolumentos));

        $this->getElement('idEmolumentos');
		$this->getElement('idVigencia');
		$this->getElement('valorinicial');
        $this->getElement('valorfinal');
		$this->getElement('emolumento');
        
        return $this;
    }
}

