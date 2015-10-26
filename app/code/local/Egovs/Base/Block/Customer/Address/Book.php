<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Customer
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Customer address book block
 *
 * @category   Egovs
 * @package    Egovs_Base
 * @author
 */
class Egovs_Base_Block_Customer_Address_Book extends Mage_Customer_Block_Address_Book
{
    public $AddressEditingIsDenied = false;

    public function rejectAddressEditing($address_id)
    {
        $data = array('block'=> $this,"address_id"=>$address_id);
        Mage::dispatchEvent('egovs_base_customer_reject_address_editing',$data);
        $res = $this->AddressEditingIsDenied;
		    //$this->AddressEditingIsDenied = false;

		    //für stammadresse
		    if(!$res)
		    {
		        $customer = Mage::getSingleton('customer/session')->getCustomer();
		        $baseAddress = $customer->getBaseAddress();
		        if($address_id != $baseAddress)
		        {
		            return false;
		        }
		        else
		        {
		            if(!Mage::helper('egovsbase')->isModuleEnabled('Egovs_Vies'))
		            {
		                return true;
		            }
		            if($customer->getData('use_group_autoassignment') != 1)
		            {
		                return true;
		            }
		        }
		    }
		    return $res;
		}

    public function getLockedAddressText()
    {
        return $this->__('This address is used by additional service. For changeing contact our customer service please!');
    }
}
