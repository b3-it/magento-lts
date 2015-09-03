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
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales order create sidebar
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Slpb_Verteiler_Block_Adminhtml_Order_Create_Details extends Mage_Adminhtml_Block_Widget_Form
{
	protected $_customer = null;
	protected $_addresses = null;
 

    
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abo_contract_form', array('legend'=>Mage::helper('verteiler')->__('Verteilerauswahl')));
     
       $fieldset->addField('verteiler', 'select', array(
          'label'     => Mage::helper('verteiler')->__('Verteiler'),
          'name'      => 'create_order[verteiler]',
          'values'    => $this->VerteilerToHashArray(),
      	));
      	
        $fieldset->addField('note1', 'text', array(
          'label'     => Mage::helper('verteiler')->__('Notiz'),
          'name'      => 'create_order[note1]',
      	));
      	
      	 $fieldset->addField('note2','text', array(
          'label'     => Mage::helper('verteiler')->__('Notiz'),
          'name'      => 'create_order[note2]',
      	));
      	
  
      return parent::_prepareForm();
  }
    
  	private function VerteilerToHashArray()
  	{
  		$collection = Mage::getModel('verteiler/verteiler')->getCollection();
  		$res = array();
  		foreach ($collection->getItems() as $item)
  		{
  			$res[$item->getId()] = $item->getName();
  		}
  		
  		return $res;
  	}  
    
  
    
    
    
    private function _getCustomer()
    {
    	if($this->_customer == null)
    	{
    		$contract = Mage::getSingleton('adminhtml/session')->getData('abo_contract_create');
    		$this->_customer = Mage::getModel('customer/customer')->load($contract->getCustomerId());
    	}
    	return $this->_customer;
    }

  
  	
}
