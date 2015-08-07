<?php
/**
 * Resource Collection für Buchungslistenparameter.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Mysql4_Localparams_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Model_Resource_Db_Collection_Abstract::_construct()
	 */
    protected function _construct() {
        parent::_construct();
        $this->_init('paymentbase/localparams');
    }
    
    /**
     * Verfügbare Parameter zu Ergebnis hinzufügen
     * 
     * @return Egovs_Paymentbase_Model_Mysql4_Localparams_Collection
     */
    public function addParams() {
    	$this->getSelect()
    		->join(array('params'=>$this->getTable('paymentbase/defineparams')), 'params.param_id=main_table.param_id',
    		array('param_id'=>'param_id','param_title'=>'title','ident'=>'ident'));   	
    	return $this;
    }
}