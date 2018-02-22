<?php
class Bkg_Orgunit_Block_Adminhtml_Customer_Edit_Tab_Addresses extends Egovs_Base_Block_Adminhtml_Customer_Edit_Tab_Addresses
{
    public function initForm()
    {
        parent::initForm();

        // don't show addresses coming from bkg_orgunit
        $this->_viewVars['addressCollection'] = array_filter($this->_viewVars['addressCollection'], function($addr) {
            return $addr->getData('org_address_id') === null;
        });
            
        return $this;
    }
}
