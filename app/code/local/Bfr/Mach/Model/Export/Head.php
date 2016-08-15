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
class Bfr_Mach_Model_Export_Head extends Bfr_Mach_Model_Export_Abstract
{
	protected $_ExportType = Bfr_Mach_Model_ExportType::TYPE_KOPF;
	
	private $_cols = array('IRQUELLSYSTEM','IRLAUF','IRBELEG','NIEDERLASSUNG','ORGEINHEIT','PERIODE','BUCHUNGSDATUM','BELEGDATUM','BELEG','BELEGART','BELEGKONTOTITEL','BELEGTEXT','STORNO','WAEHRUNG','RWBELEG','GEDRUCKTAM','BENUTZER','RECORDIDENT','SCHREIBGRUPPE','LESEGRUPPE','BELEGVORGABE','BELEGBETRAG','REFERENZ','KASSENANWEISUNG','AKN','VGVORGANG','FESTLEGUNG','FESTLEGUNGSRED','FEHLERTEXT','MANDANT');
	
    public function getData4Order(array $orderIds = array())
    {
    	parent::getData4Order($orderIds);
    	$collection = Mage::getModel('sales/order')->getCollection();
    	
    	$collection->getSelect()
    		->where('entity_id IN( '. implode(',',$orderIds).')' );
    	
    	
    	$result = array();
    	$result[] = implode($this->getDelimiter(), $this->_cols);
    	
    	
    	foreach($collection as $order){
    		$line = array();
    		$line[] = $this->getConfigValue('head/irquellsystem',null, null); //Irquellsystem
    		$line[] = $this->getConfigValue('head/irlauf',null, null); //Irlauf
			$line[] = $order->getIncrementId(); //Irbeleg
			$line[] = $this->getConfigValue('head/niederlassung',null, null); //Niederlassung
			$line[] = $this->getConfigValue('head/orgeinheit',null, null); //Orgeinheit
			$line[] = $this->getConfigValue('head/periode',null, null); //Periode
			$line[] = date('m.d.Y H:i', strtotime($order->getCreatedAt())); //Buchungsdatum
			$line[] = date('m.d.Y H:i', strtotime($order->getCreatedAt())); //Belegdatum
			$line[] = $this->getConfigValue('head/beleg',null, null); //Beleg
			$line[] = $this->getConfigValue('head/belegart',null, null); //Belegart
			$line[] = $this->getConfigValue('head/belegkontotitel',null, null); //Belegkontotitel
			$line[] = $this->getConfigValue('head/belegtext',null, null); //Belegtext
			$line[] = $this->getConfigValue('head/storno',null, null); //Storno
			$line[] = $this->getConfigValue('head/waehrung',null, null); //Waehrung
			$line[] = $this->getConfigValue('head/rwbeleg',null, null); //Rwbeleg
			$line[] = $this->getConfigValue('head/gedrucktam',null, null); //Gedrucktam
			$line[] = $this->getConfigValue('head/benutzer',null, null); //Benutzer
			$line[] = $this->getConfigValue('head/recordident',null, null); //Recordident
			$line[] = $this->getConfigValue('head/schreibgruppe',null, null); //Schreibgruppe
			$line[] = $this->getConfigValue('head/lesegruppe',null, null); //Lesegruppe
			$line[] = $this->getConfigValue('head/belegvorgabe',null, null); //Belegvorgabe
			$line[] = $this->getConfigValue('head/belegbetrag',null, null); //Belegbetrag
			$line[] = $this->getConfigValue('head/referenz',null, null); //Referenz
			$line[] = $this->getConfigValue('head/kassenanweisung',null, null); //Kassenanweisung
			$line[] = $this->getConfigValue('head/akn',null, null); //Akn
			$line[] = $this->getConfigValue('head/vgvorgang',null, null); //Vgvorgang
			$line[] = $this->getConfigValue('head/festlegung',null, null); //Festlegung
			$line[] = $this->getConfigValue('head/festlegungsred',null, null); //Festlegungsred
			$line[] = $this->getConfigValue('head/fehlertext',null, null); //Fehlertext
			$line[] = $this->getConfigValue('head/mandant',null, null); //Mandant
			
    		
    		
    		$result[] = implode($this->getDelimiter(), $line);
    	}
    	
    	return implode("\n",$result);
    }
    
    
   
    
}
