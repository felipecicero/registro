<?php

/**
 * @author Flavio
 * 
 */

class Zend_View_Helper_GetDataTimestamp extends Zend_View_Helper_Abstract
{
 
	    
	    public function getDataTimestamp($date){
			$date = substr($date, 0, 10);
			
			$date =implode("/", array_reverse(explode("-", $date )));
			
			return $date;
	    }
	 
}