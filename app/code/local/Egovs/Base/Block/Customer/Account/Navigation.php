<?php
/*
 * http://www.matthias-zeis.com/archiv/wie-man-menu-mein-benutzerkonto-von-magento-anpasst
 */
 
class Egovs_Base_Block_Customer_Account_Navigation extends Mage_Customer_Block_Account_Navigation
{
    /**
    * Removes the link from the account navigation.
    *
    * @param string $name Name provided in the layout XML file
    * @return Mage_Customer_Block_Account_Navigation
    */
    public function removeLinkByName($name)
    {
        if (isset($this->_links[$name])) {
            unset($this->_links[$name]);
        } else {
            Mage::log("Customer account navigation link '{$name}' does not exist.", Zend_Log::NOTICE);
        }
        return $this;
    }
}