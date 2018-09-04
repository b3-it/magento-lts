<?php


class Gka_Reports_Model_Resource_Overview_Collection extends Mage_Sales_Model_Resource_Order_Grid_Collection
{

    protected $_from = null;
    protected $_to = null;

    protected function _initSelect()
    {
        parent::_initSelect();

        $eav = Mage::getResourceModel('eav/entity_attribute');

        $this->getSelect()
            ->joinleft(array('t1'=>$this->getTable('customer/entity').'_varchar'), 'main_table.customer_id=t1.entity_id AND t1.attribute_id = '.intval($eav->getIdByCode('customer','company')),array('company'=>'value') )
        ;

       // die($this->getSelect()->__toString());
        return $this;
    }


    protected function x_afterLoad() {
        die($this->getSelect()->__toString());

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
            ->where('created_at <= ?', $this->_to)
            ->where('created_at >= ?', $this->_from)
        ;

        return $this;
    }


}