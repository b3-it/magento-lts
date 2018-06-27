<?php


class Gka_Reports_Model_Resource_Overview_Collection extends Gka_Barkasse_Model_Resource_Kassenbuch_Journal_Collection
{

    protected $_from = null;
    protected $_to = null;

    protected function _initSelect()
    {
        parent::_initSelect();
        $expr = new Zend_Db_Expr('(SELECT sum(id) as sum_id, sum(booking_amount) as sum_booking_amount, journal_id FROM ' . $this->getTable('gka_barkasse/kassenbuch_journal_items') . ' GROUP BY journal_id)');

        $this->getSelect()
            ->joinLeft(array('items' => $expr), 'items.journal_id=main_table.id', array('sum_id', 'sum_booking_amount'));

        if (Mage::helper('gka_barkasse')->isModuleEnabled('Egovs_Isolation'))
        {
            $helper = Mage::helper('isolation');
            if (!$helper->getUserIsAdmin()) {
                $views = $helper->getUserStoreViews();
                $views[] = '-1'; //damit das Array gefüllt ist
                $this->getSelect()
                    ->join(array('cashbox' => $this->getTable('gka_barkasse/kassenbuch_cashbox')), 'main_table.cashbox_id=cashbox.id', array())
                    ->where('cashbox.store_id IN (' . implode(',', $views) . ')');
            }
        }
        return $this;
    }
	
	/**
	 * Setzt die Datumsspanne der Collection
	 *
	 * @param string $from Von Datum
	 * @param string $to   Bis Datum
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Haushaltsstelle_Collection
	 */
	public function setDateRange($from, $to) {
        $this->_from = $from;
        $this->_to = $to;
		return $this;
	}

    /**
     * Setzt den StoreFilter der Collection
     *
     * @param array $storeIds Store IDs
     *
     * @return Egovs_Extreport_Model_Mysql4_Sales_Quantity_Collection
     */
    public function setStoreIds($storeIds)
    {
        $vals = array_values($storeIds);

        $transport = new Varien_Object(array('storeids'=>$storeIds));

        // $this->_storefilter = array_values($storeIds);
        if (count($storeIds) >= 1 && $vals[0] != '') {
            $this->_storefilter = $storeIds;
            //$this->addFieldToFilter('store_id', array('in' => (array)$storeIds));
        }
        $this->_reset() //Wichtig für Datefilter; Reset ruft initSelect() auf!!
            ->getSelect()
            ->where('closing <= ?', $this->_to)
            ->where('closing >= ?', $this->_from)
        ;

        return $this;
    }


}