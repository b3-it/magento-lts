<?php
/**
 * ResourceModel Collection für Versendete Waren
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Product_Shipped_Collection extends Egovs_Extreport_Model_Mysql4_Product_Collection
{
    /**
     * Setzt die Datumsspanne der Collection
     *
     * @param string $from Von Datum
     * @param string $to   Bis Datum
     * 
     * @return Egovs_Extreport_Model_Mysql4_Product_Shipped_Collection
     */
    public function setDateRange($from, $to)
    {
        $this->_reset()
            ->addAttributeToSelect('*')
            ->addShippedQty($from, $to)
            ->setOrder('shipped_qty', 'desc');

        return $this;
    }

    /**
     * Setzt den StoreFilter der Collection
     *
     * @param array $storeIds Store IDs
     * 
     * @return Egovs_Extreport_Model_Mysql4_Product_Shipped_Collection
     */
    public function setStoreIds($storeIds)
    {
        $storeId = array_pop($storeIds);
        $this->setStoreId($storeId);
        $this->addStoreFilter($storeId);
        return $this;
    }
}
