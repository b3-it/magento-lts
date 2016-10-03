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
	
    public function getData4Order(array $orderIds = array(), $Lauf)
    {
    	parent::getData4Order($orderIds, $Lauf);
    	$collection = Mage::getModel('sales/order')->getCollection();
    	
    	$collection->getSelect()
    		->where('entity_id IN( '. implode(',',$orderIds).')' )
    		->order('entity_id');
    	
    	
    	$result = array();
    	$result[] = implode($this->getDelimiter(), $this->_cols);
    	
    	//Zähler
    	$IRBeleg = 0;
    	
    	foreach($collection as $order){
    		$IRBeleg ++;
    		$line = array();
    		$line[] = $this->getConfigValue('head/irquellsystem',null, null); //Irquellsystem
    		$line[] = $this->_Lauf; //Irlauf
			$line[] = $order->getIncrementId(); //?? //Irbeleg
			$line[] = $this->getConfigValue('head/niederlassung',null, null); //Niederlassung
			$line[] = $this->getConfigValue('head/orgeinheit',null, null); //Orgeinheit
			$line[] = $this->getConfigValue('head/periode',null, null); //Periode
			$line[] = date('m.d.Y H:i', strtotime($order->getCreatedAt())); //Buchungsdatum
			$line[] = date('m.d.Y H:i', strtotime($order->getCreatedAt())); //Belegdatum
			$line[] = '0';//$order->getIncrementId(); //Beleg
			$line[] = $this->getConfigValue('head/belegart',null, null); //Belegart
			$line[] = $this->getConfigValue('head/belegkontotitel',null, null); //Belegkontotitel
			$line[] = $this->getConfigValue('head/belegtext',null, null); //Belegtext
			$line[] = $order->getState() == 'canceled' ? 'S' : 'B' ; //Storno
			$line[] = $this->getConfigValue('head/waehrung',null, null); //Waehrung
			$line[] = ''; //Rwbeleg
			$line[] = ''; //Gedrucktam
			$line[] = $this->getConfigValue('head/benutzer',null, null); //Benutzer
			$line[] = '1'; //Recordident
			$line[] = $this->getConfigValue('head/schreibgruppe',null, null); //Schreibgruppe
			$line[] = $this->getConfigValue('head/lesegruppe',null, null); //Lesegruppe
			$line[] = ''; //Belegvorgabe
			$line[] = ''; //Belegbetrag
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
