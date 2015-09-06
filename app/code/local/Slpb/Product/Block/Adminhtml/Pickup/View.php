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
class Slpb_Product_Block_Adminhtml_Pickup_View extends Mage_Adminhtml_Block_Widget_Form_Container
{
	private $_order = null;
	
	
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'slpbproduct/pickup_view_form';
        $this->_controller = 'adminhtml_pickup';
		$this->_headerText = Mage::helper('sales')->__('Order');
        //$this->_updateButton('save', 'label', Mage::helper('extstock')->__('Deliver'));
       
		$this->_addButton('deliver',array('onclick'=>'setLocation(\''.$this->getFormActionUrl().'\')','label'=>Mage::helper('slpbproduct')->__('Deliver')));
		
		$this->removeButton('delete');
		$this->removeButton('add');
		$this->removeButton('reset');
		$this->removeButton('save');
		return $this;
    }
    

    
    public function getOrder()
    {
    	if($this->_order == null)
    	{
    		$this->_order = Mage::registry('current_order');
    	}
    	
    	return $this->_order;
    }
  
    
    public function getFormActionUrl()
    {
    	return  $this->getUrl('slpbproduct/adminhtml_pickup/deliver',array('order_id' => $this->getOrder()->getId()));
    }
    
 	public function getBackUrl()
    {
    	return  $this->getUrl('slpbproduct/adminhtml_pickup/index');
    }
    

}
