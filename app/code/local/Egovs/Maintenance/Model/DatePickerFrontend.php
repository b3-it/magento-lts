<?php
class Egovs_Maintenance_Model_DatePickerFrontend extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    public function _getElementHtml(Varien_Data_Form_Element_Abstract $element){

		$date = new Varien_Data_Form_Element_Date();
        $format = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);

        $data = array(
            'name'      => $element->getName(),
            'html_id'   => $element->getId(),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
			'format'	=> $format,
			'time'		=> true
        );
        $date->setData($data);
		$date->setForm($element->getForm());

		$which = $element->getId() === "general_offline_from_date" ? "from_date" : "to_date";
		
		$website = Mage::app()->getRequest()->getParam('website');
		$store   = Mage::app()->getRequest()->getParam('store');
		
		if(empty($store)){
			$current = Mage::app()->getWebsite($website)->getConfig('general/offline/'.$which);
		} else {
			$current = Mage::getStoreConfig('general/offline/'.$which, $store);
		}
        $date->setValue($current, $format);
		

        return $date->getElementHtml();

    }
}
