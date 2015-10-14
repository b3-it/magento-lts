<?php


class Slpb_Shipping_Adminhtml_Model_Pickuptablerate extends Mage_Core_Model_Config_Data
{
    public function _afterSave()
    {
        Mage::getResourceModel('slpbshipping/tablerate')->uploadAndImport($this,Slpb_Shipping_Model_Tablerate::PICKUP);
    }
	
}
