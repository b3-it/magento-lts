<?php

class Stala_Abo_Model_Catalog_Product_Observer 
{
	public function injectButton($observer)
	{
		$block = $observer['block'];
		$product = $observer['product'];
	
		if($product->getIsAboBaseProduct())
		{		
			
	     if (true) {
                $block->setChild('reset_button',
                $block->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label'     => Mage::helper('stalaabo')->__('Create Subscibtion Product'),
                        'onclick'   => 'setLocation(\''.$block->getUrl('adminhtml/stalaabo_catalog_product/duplicateAbo',array('product_id'=>$product->getId())).'\')',
                    ))
                );
            }
		}
		else if($product->getAboParentProduct())
		{
			$parent = Mage::getModel('catalog/product')->load($product->getAboParentProduct());
			$text = Mage::helper('stalaabo')->__('Derivate to:').' '.$parent->getSku().", ".$parent->getName();
			$block->getLayout()->getMessagesBlock()->addNotice($text);
			
			
			if (true) {
                $block->setChild('reset_button',
                $block->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label'     => Mage::helper('stalaabo')->__('Deliver Subscription Product'),
                        'onclick'   => 'setLocation(\''.$block->getUrl('adminhtml/stalaabo_catalog_product/deliverAbo',array('product_id'=>$product->getId())).'\')',
                    ))
                );
            }
			
		}
		
	}
	
	public function catalogProductSaveBefore($observer)
	{
		$product = $observer['product'];
		if(($product->getIsAboBaseProduct())&&($product->getAboParentProduct()))
		{
			Mage::throwException(Mage::helper('stalaabo')->__('Product can not be both subscription base and derivate!'));
		}
	}

	public function catalogProductDeleteBefore($observer)
	{
		$product = $observer['product'];
		if($product->getIsAboBaseProduct())
		{
			$collection = Mage::getModel('stalaabo/contract')->getCollection();
			$collection->getSelect()->where('base_product_id = '.$product->getId());
			if($collection->count() > 0)
			{
				Mage::throwException(Mage::helper('stalaabo')->__('Product used by Subscribtion, it can not be deleted!'));
			}
		}
	}
	


}

?>