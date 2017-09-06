<?php

/**
 * Model für Bestellungen
 * 
 * getCustomerName() muss für Firmenkunden überschrieben werden.<br>
 * cancel(..) muss fpr Slpb "Rückläufer überschrieben werden.
 *
 * @category   	Egovs
 * @package    	Egovs_Extsalesorder
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Adminhtml_Sales_Model_Order
 */
class Egovs_Extsalesorder_Model_Sales_Order extends Mage_Sales_Model_Order
{
	const SPECIAL_CANCEL_STATUS = 'special_canceled';
	
	/**
	 * Erweitert da Magento nur den Vornamen nutzt und sonst Gast anzeigt.
	 * 
	 * Die Methode Unterstützt nun auch:
	 * <ul>
	 * 	<li>Nachname</li>
	 * 	<li>Firma</li>
	 * </ul>
	 * 
	 * @return string Kundenname
	 * 
	 * @see Mage_Sales_Model_Order::getCustomerName()
	 */
	public function getCustomerName()
	{
		if ($this->getCustomerFirstname()) {
			$customerName = $this->getCustomerFirstname() . ' ' . $this->getCustomerLastname();
		} elseif ($this->getCustomerLastname()) {
			$customerName = $this->getCustomerLastname();
		} elseif (!$this->getCustomerIsGuest()) {
			$customer = $this->getCustomerId();
			$customer = Mage::getModel('customer/customer')->load($customer);
			
			if (!$customer || $customer->isEmpty())
				return Mage::helper('sales')->__('Guest');
			
			$customerName = $customer->getCompany();
			
			if (empty($customerName)) {
				$customerName = sprintf('ID: %s',$this->getCustomerId());
			}
			
		} else {
			$customerName = Mage::helper('sales')->__('Guest');
		}
		return $customerName;
	}
	
	/**
	 * Check order state before saving
	 */
	protected function _checkState() {
		if (!$this->getId()) {
			return $this;
		}
		
		$userNotification = $this->hasCustomerNoteNotify() ? $this->getCustomerNoteNotify() : null;
		
		if (!$this->isCanceled()
				&& !$this->canUnhold()
				&& !$this->canInvoice()
				&& !$this->canShip()) {
					if ((0 == $this->getBaseGrandTotal() && !$this->getBaseTotalRefunded() && !$this->hasForcedCanCreditmemo()) || $this->canCreditmemo()) {
						if ($this->getState() !== self::STATE_COMPLETE && $this->getBaseTotalPaid() >= $this->getBaseGrandTotal()) {
							$this->_setState(self::STATE_COMPLETE, true, '', $userNotification);
						}
					}
					/**
					 * Order can be closed just in case when we have refunded amount.
					 * In case of "0" grand total order checking ForcedCanCreditmemo flag
					 */
					elseif (floatval($this->getTotalRefunded()) || (!$this->getTotalRefunded() && $this->hasForcedCanCreditmemo())
							) {
								if ($this->getState() !== self::STATE_CLOSED) {
									if ($this->getStatus() != self::SPECIAL_CANCEL_STATUS) {
										$this->_setState(self::STATE_CLOSED, true, '', $userNotification);
									} else {
										$this->_setState(self::STATE_CLOSED, false, '', $userNotification);
										$history = $this->addStatusHistoryComment('', false); // no sense to set $status again
										$history->setIsCustomerNotified($userNotification); // for backwards compatibility
									}
								}
					}
				}
				
				if ($this->getState() == self::STATE_NEW && $this->getIsInProcess()) {
					$this->setState(self::STATE_PROCESSING, true, '', $userNotification);
				}
				return $this;
	}
}