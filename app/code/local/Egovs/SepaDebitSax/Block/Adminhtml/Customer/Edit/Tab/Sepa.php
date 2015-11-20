<?php

/**
 * Customer account form block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_SepaDebitSax_Block_Adminhtml_Customer_Edit_Tab_Sepa extends Mage_Adminhtml_Block_Widget_Form_Container
	implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	protected $_customer;
	
	public function __construct() {
		$this->_controller = 'adminhtml_customer_edit_tab';
		$this->_blockGroup = 'sepadebitsax';
		$this->_mode = "sepa";
		$this->_headerText = Mage::helper ( 'sepadebitsax' )->__ ( 'SEPA Information' );
		
		parent::__construct ();
		$this->removeButton ( 'add' );
		$this->removeButton ( 'back' );
		$this->removeButton ( 'delete' );
		$this->removeButton ( 'save' );
	}
	
	public function getCustomer() {
		if (! $this->_customer) {
			$this->_customer = Mage::registry ( 'current_customer' );
		}
		return $this->_customer;
	}
	
	public function getStoreId() {
		return $this->getCustomer ()->getStoreId ();
	}
	
	public function getTabLabel() {
		return Mage::helper ( 'sepadebitsax' )->__ ( 'SEPA Information' );
	}
	
	public function getTabTitle() {
		return Mage::helper ( 'sepadebitsax' )->__ ( 'SEPA Information' );
	}
	
	public function canShowTab() {
		if (Mage::registry ( 'current_customer' )->getId ()) {
			return true;
		}
		return false;
	}
	
	public function isHidden() {
		if (Mage::registry ( 'current_customer' )->getId ()) {
			return false;
		}
		return true;
	}
}
