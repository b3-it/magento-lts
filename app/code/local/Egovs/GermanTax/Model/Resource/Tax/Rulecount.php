<?php

/**
 * Tax
 *
 * @category       Egovs
 * @package        Egovs_GermanTax
 * @author         Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      Copyright (c) 2014 - 2018 B3 IT Systeme GmbH
 * @license        http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Model_Resource_Tax_Rulecount extends Mage_Core_Model_Resource_Db_Abstract
{
	public function _construct() {
        // Note that the extstock_id refers to the key field in your database table.
        $this->_init('sales/quote_address', 'address_id');
    }

    /**
     * Ermittelt die Anzahl der Steuerregeln für eine Bestellung
     *
     * @param Varien_Object $request
     *
     * @return int
     */
    public function getRulecount($order) {
        $select = $this->_getReadAdapter()->select();

        $quote = $order->getQuote();

        $select->from(array('main_table' => 'sales_flat_quote_address'), 'applied_taxes')
            ->where("length(applied_taxes) > 8")
            ->where("main_table.quote_id = ?", intval($quote->getId()));
        if ($quote->getIsVirtual()) {
            $select->where("address_type = 'base_address'");
        } else {
            $select->where("address_type = 'shipping'");
        }

        $res = $this->_getWriteAdapter()->fetchOne($select);

        if (strlen($res) > 8) {
            $res = unserialize($res);
            if (is_array($res)) {
                return count($res);
            }
        }
        return 0;
    }


}