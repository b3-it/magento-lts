<?php
/**
 * Bfr Mach
 *
 *
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Model_Export_Abstract
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Model_Export_Mapping extends Bfr_Mach_Model_Export_Abstract
{
	protected $_ExportType = Bfr_Mach_Model_ExportType::TYPE_ZUORDNUNG;
	
    public function getData4Order(array $orderIds = array())
    {
    	parent::getData4Order($orderIds);
    	$collection = Mage::getModel('sales/order')->getCollection();
    	
    	$collection->getSelect()
    		->where('entity_id IN( '. implode(',',$orderIds).')' );
    	
    	
    	$result = array();
    	
    	foreach($collection as $order){
    		$line = array();
    		$line[] = $this->getConfigValue('head/irquellsystem',null, null); //Irquellsystem
			$line[] = $this->getConfigValue('head/irlauf',null, null); //Irlauf
			$line[] = $this->getConfigValue('head/irbeleg',null, null); //Irbeleg
			$line[] = $this->getConfigValue('head/irposition',null, null); //Irposition
			$line[] = $this->getConfigValue('head/kostenrechnung',null, null); //Kostenrechnung
			$line[] = $this->getConfigValue('head/abrechnungsobjekt',null, null); //Abrechnungsobjekt
			$line[] = $this->getConfigValue('head/betrag',null, null); //Betrag
			$line[] = $this->getConfigValue('head/fwbetrag',null, null); //Fwbetrag
    		
    		
    		
    		$result[] = implode($this->getDelimiter(), $line);
    	}
    	
    	return implode("\n",$result);
    }
    
    
   
    
}
