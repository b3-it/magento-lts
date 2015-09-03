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
 * Adminhtml sales orders block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Slpb_Product_Block_Adminhtml_Pickup_View_Form extends Mage_Adminhtml_Block_Widget_Form
{
	private $_order = null;
	
	
 	protected function _prepareForm()
  	{

  		$id = $this->getRequest()->getParam('order_id');
      	$this->_order = Mage::getModel('sales/order')->load($id);
      
      	return parent::_prepareForm();
  	}
		
    public function getOrder()
    {
    	return $this->_order;
    }
    
   public function  renderView()
   {
   		$o = $this->getOrder();
   		$s = 'Bestellnummer: '.$o->getIncrementId().'<br />';	
   		$s .= 'Kunde: '.$o->getShippingAddress()->getName().'<br />';
   		$s .= 'Adresse: '.$o->getShippingAddress()->getStreetFull().'<br />';
   		$s .= 'Ort: '.$o->getShippingAddress()->getCity(). ' '. $o->getShippingAddress()->getPostcode(). '<br />';
   		$s .= '<br />';
   		
   		$s .= '<table>';
   		
   		foreach ($o->getAllItems() as $item)
   		{
   			$s .= '<tr>';
   			$s .= '<td>' . $item->getSku() . '</td>';
   			$s .= '<td>' . $item->getName() . '</td>';
   			$s .= '<td>' . intval($item->getQtyOrdered()) . ' St&uuml;ck  </td>';
   			$s .= '</tr>';
   		}
   		$s .= '</table>';
   		return $s;
   }
    

}
