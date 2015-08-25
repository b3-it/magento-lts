<?php
/**
 * Kapselt Status aus der Konfiguration für Zahlungen per Vorkasse
 *
 * @category   	Egovs
 * @package    	Egovs_BankPayment
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Adminhtml_Model_System_Config_Source_Order_Status
 */
class Egovs_BankPayment_Model_System_Config_Source_Order_Status extends Mage_Adminhtml_Model_System_Config_Source_Order_Status
{
    /**
     * State zu dem Status ermittelt werden sollen.
     * 
     * @var string $_stateStatuses
     * 
     * @see Mage_Sales_Model_Order::STATE_PENDING_PAYMENT
     */
    protected $_stateStatuses = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;

    /**
     * Gibt ein array von Status zum entsprechenden State zurück.
     * 
     * @return array
     * 
     * @see Mage_Adminhtml_Model_System_Config_Source_Order_Status::toOptionArray()
     */
    public function toOptionArray()
    {
        $options = array();
        $options[] = array(
        	   'value' => '',
        	   'label' => Mage::helper('adminhtml')->__('-- Please Select --')
        );
        
        if (version_compare(Mage::getVersion(), '1.5.0', '<')) {
        	return array_merge($options, $this->getArrayFromConfigNode());
        }
        
        /* @var $collection Mage_Sales_Model_Resource_Order_Status_Collection */ 
        $collection = Mage::getResourceModel('sales/order_status_collection');
        $collection->addStateFilter(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT);
        $srcOptions = $collection->toOptionArray();
        //Alle Status die nicht zu diesem Modul gehören entfernen.
        foreach ($srcOptions as $option) {
        	if (stripos($option['value'], "_bankpayment") === false)
        		continue;
        	 
        	$options[] = array(
	        	'value' => $option['value'],
	        	'label' => $option['label']
        	);
        }
                                	
        return $options;
    }
    
    /**
     * Notwendig um zu Magento < 1.5.0 kompatibel zu bleiben.
     * 
     * Das Ergebnis-Array hat die Form:
     * <pre>
     * array(
	 * 	array(
	 *  		$keyValue => $code,
	 *   		$keyLabel => $label
	 * 		)
	 * )
     * </pre>
     * 
     * @param string $keyValue Name des Key Value
     * @param string $keyLabel Name des Key Labels
     * 
     * @return array
     */
    public function getArrayFromConfigNode($keyValue = 'value', $keyLabel = 'label') {
    	$result = array();
    	
    	if (version_compare(Mage::getVersion(), '1.5.0', '>=')) {
    		$statuses = Mage::getConfig()->getNode('global/sales/order/statuses')->asArray();
    		$data = array();
    		foreach ($statuses as $code => $info) {
    			$data[$code] = $info['label'];
    		}
    		$statuses = $data;
    	} else {
	    	if ($this->_stateStatuses) {
	    		$statuses = Mage::getSingleton('sales/order_config')->getStateStatuses($this->_stateStatuses);
	    	} else {
	    		$statuses = Mage::getSingleton('sales/order_config')->getStatuses();
	    	}
    	}
    	//Alle Status die nicht zu diesem Modul gehören entfernen.
    	foreach ($statuses as $code=>$label) {
    		if (stripos($code, "_bankpayment") === false)
    			continue;
    		 
    		$result[] = array(
    	        	   $keyValue => $code,
    	        	   $keyLabel => $label
    		);
    	}
    	
    	return $result;
    }
}