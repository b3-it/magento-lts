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
class Bfr_Mach_Model_Export_Pos extends Bfr_Mach_Model_Export_Abstract
{
	protected $_ExportType = Bfr_Mach_Model_ExportType::TYPE_POSITION;
	
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
			$line[] = $this->getConfigValue('head/irposition',null, null); //Irposition
			$line[] = $this->getConfigValue('head/text',null, null); //Text
			$line[] = $this->getConfigValue('head/betrag',null, null); //Betrag
			$line[] = $this->getConfigValue('head/fwbetrag',null, null); //Fwbetrag
			$line[] = $this->getConfigValue('head/sollkontotitel',null, null); //Sollkontotitel
			$line[] = $this->getConfigValue('head/habenkontotitel',null, null); //Habenkontotitel
			$line[] = $this->getConfigValue('head/sollhaushstelle',null, null); //Sollhaushstelle
			$line[] = $this->getConfigValue('head/habenhaushstelle',null, null); //Habenhaushstelle
			$line[] = $this->getConfigValue('head/huelnummer',null, null); //Huelnummer
			$line[] = $this->getConfigValue('head/referenz',null, null); //Referenz
			$line[] = $this->getConfigValue('head/positionsart',null, null); //Positionsart
			$line[] = $this->getConfigValue('head/ust',null, null); //Ust
			$line[] = $this->getConfigValue('head/startabgrenzung',null, null); //Startabgrenzung
			$line[] = $this->getConfigValue('head/endeabgrenzung',null, null); //Endeabgrenzung
			$line[] = $this->getConfigValue('head/periodizitaet',null, null); //Periodizitaet
			$line[] = $this->getConfigValue('head/magkontorolle',null, null); //Magkontorolle
			$line[] = $this->getConfigValue('head/irbeleg',null, null); //Irbeleg
    		
    		
    		$result[] = implode($this->getDelimiter(), $line);
    	}
    	
    	return implode("\n",$result);
    }
    
    
   
    
}
