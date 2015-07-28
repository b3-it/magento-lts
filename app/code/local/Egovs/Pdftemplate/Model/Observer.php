<?php

/**
 *
 *  Observer zum Verarbeite der Templateinfos bei der BE Bearbeitung der  Kundengruppen 
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Model_Observer extends Mage_Core_Model_Abstract
{
	public function onCustomerGroupSaveBefore($observer)
	{
		$group = $observer->getEvent()->getObject();
		$template = Mage::app()->getRequest()->getParam('invoice_template');
		$group->setData('invoice_template',intval($template));
		
		$template = Mage::app()->getRequest()->getParam('shipping_template');
		$group->setData('shipping_template',intval($template));
		
		$template = Mage::app()->getRequest()->getParam('creditmemo_template');
		$group->setData('creditmemo_template',intval($template));
	}
	
	public function afterCustomerGroupEditFormPrepare($observer)
	{
		$block = $observer->getBlock();
		if($block instanceof Mage_Adminhtml_Block_Customer_Group_Edit_Form)
		{
			$form = $block->getForm();
			$fieldset = $form->addFieldset('pdftemplate_fieldset', array('legend'=> Mage::helper('pdftemplate')->__('PDF Templates')));
			
		    $pdf = Mage::getSingleton('pdftemplate/template');
	        if($pdf != null)
	        {
	        
		        $fieldset->addField('invoice_template', 'select',
		            array(
		                'name'  => 'invoice_template',
		                'label' => Mage::helper('pdftemplate')->__('Invoice PDF Template'),
		                'title' => Mage::helper('pdftemplate')->__('Invoice PDF Template'),
		                'class' => 'required-entry',
		                'required' => true,
		                'values' => $pdf->toOptionArray()
		            )
		        );
		        
		       $fieldset->addField('shipping_template', 'select',
		            array(
		                'name'  => 'shipping_template',
		                'label' => Mage::helper('pdftemplate')->__('Shipment PDF Template'),
		                'title' => Mage::helper('pdftemplate')->__('Shipment PDF Template'),
		                'class' => 'required-entry',
		                'required' => true,
		                'values' => $pdf->toOptionArray()
		            )
		        );
		        
		        
		        $fieldset->addField('creditmemo_template', 'select',
		            array(
		                'name'  => 'creditmemo_template',
		                'label' => Mage::helper('pdftemplate')->__('Creditmemo PDF Template'),
		                'title' => Mage::helper('pdftemplate')->__('Creditmemo PDF Template'),
		                'class' => 'required-entry',
		                'required' => true,
		                'values' => $pdf->toOptionArray()
		            )
		        );
	        
		        $customerGroup = Mage::registry('current_group');
	            $form->addValues($customerGroup->getData());
	        }
			
		}
	}

}

