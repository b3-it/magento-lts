<?php

class Sid_ExportOrder_Model_Observer
{

    /**
     *
     * @param Varien_Event_Observer $observer
     */
    public function onVendorSaveAfter($observer)
    {
        $vendor = $observer->getDataObject();
      
        $format = $vendor->getExportFormat();
        $transfer = $vendor->getTransferType();
        
        //Übertragungsweg speichern
        if(($transfer == 'email') || ($transfer == 'email_attachment'))
        {
        	$model = Mage::getModel('exportorder/transfer_email')->load($vendor->getId(),'vendor_id');
        	$data = $vendor->getTransfer();
        	if(empty($data['template'])){
        		$data['template'] = 'exportorder_vendor_order_plain';
        	}
        	$data['vendor_id'] = $vendor->getId();
        	$data['id'] = $model->getId();
        	$model->setData($data)->save();
        }
        
        
        if($transfer == 'post')
        {
        	$model = Mage::getModel('exportorder/transfer_post')->load($vendor->getId(),'vendor_id');
        	$data = $vendor->getTransfer();
        	
        	$data['vendor_id'] = $vendor->getId();
        	$data['id'] = $model->getId();
        	$model->setData($data)->save();
        }
        
        if($transfer == 'link')
        {
        	$model = Mage::getModel('exportorder/transfer_link')->load($vendor->getId(),'vendor_id');
        	$data = $vendor->getTransfer();
        	if(empty($data['template'])){
        		$data['template'] = 'exportorder_vendor_order_link';
        	}
        	$data['vendor_id'] = $vendor->getId();
        	$data['id'] = $model->getId();
        	$model->setData($data)->save();
        }
        
        
        //Fromat speichern
        if($format == 'plain')
        {
        	$model = Mage::getModel('exportorder/format_plain')->load($vendor->getId(),'vendor_id');
        	$data = $vendor->getFormat();
        	$data['vendor_id'] = $vendor->getId();
        	$data['id'] = $model->getId();
        	$model->setData($data)->save();
        }
        
        //Fromat speichern
        if($format == 'transdoc')
        {
        	$model = Mage::getModel('exportorder/format_transdoc')->load($vendor->getId(),'vendor_id');
        	$data = $vendor->getFormat();
        	$data['vendor_id'] = $vendor->getId();
        	$data['id'] = $model->getId();
        	$model->setData($data)->save();
        }
        
        return $this;
    }

  
}
