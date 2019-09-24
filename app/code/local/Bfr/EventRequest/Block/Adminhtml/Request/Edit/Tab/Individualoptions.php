<?php
/**
 * Bfr EventRequest
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Block_Adminhtml_Request_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Block_Adminhtml_Request_Edit_Tab_Individualoptions extends Mage_Adminhtml_Block_Widget_Form
{
	private $_modelData = null;
  protected function _prepareForm()
  {
  	
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('request_form', array('legend'=>Mage::helper('eventrequest')->__('Options')));
      
      
      
      $individualOptions = $this->getModelData()->getIndividualOptions();
      
      foreach($individualOptions as $key=>$option)
      
      $fieldset->addField('opt_'.$key, 'text', array(
      		'label'     => $option['title'],
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'firstname',
      		'value'		=> $option['value']
      ));
      

      
      return parent::_prepareForm();
  }
  
  public function getModelData()
  {
  	if($this->_modelData == null){
	  	
  		if ( Mage::getSingleton('adminhtml/session')->getEventRequestData() )
	  	{
	  		$this->_modelData = Mage::getSingleton('adminhtml/session')->getEventRequestData();
	  		Mage::getSingleton('adminhtml/session')->setEventRequestData(null);
	  	} elseif ( Mage::registry('request_data') ) {
	  		$this->_modelData = (Mage::registry('request_data'));
	  	}
	  	
	  	
	  	if($this->_modelData)
	  	{
	  		$individualOptions = array();
	  		if($this->_modelData->getQuoteId())
	  		{
	  			
		  		/** @var $product Mage_Catalog_Model_Product */
		  		$product = $this->_modelData->getProduct();
		  		
		  		/** @var $quote Mage_Sales_Model_Quote */
		  		$quote = Mage::getModel('sales/quote');
		  		$quote->setData('shared_store_ids', array(0,1,2,3,4,5,6,7,8,9));
		  		$quote->load($this->_modelData->getQuoteId());
		  		
		  		/** @var $quote Mage_Sales_Model_Quote_Item */
		  		$quoteItem = null;
		  		
		  		foreach($quote->getAllItems() as $item)
		  		{
		  			if($item->getProduct()->getId() == $product->getId())
		  			{
		  				$quoteItem = $item;
		  			}
		  		}
		  		
		  		

		  		
		  		$options = $product->getOptions();
                if($quoteItem != null) {
                    $quoteOptions = $quoteItem->getOptionsByCode();
                    if (isset($quoteOptions['option_ids'])) {
                        $optionsIds = explode(',', $quoteOptions['option_ids']->getValue());
                    } else {
                        $optionsIds = array();
                    }
                    foreach ($options as $option) {
                        /** @var $option Mage_Catalog_Model_Product_Option */
                        if (in_array($option->getId(), $optionsIds)) {
                            $opt = $option->getValuesCollection()->getItems();
                            if (isset($quoteOptions['option_' . $option->getId()])) {
                                $value = $quoteOptions['option_' . $option->getId()]->getValue();
                            } else {
                                $value = null;
                            }
                            if ($option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO || $option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN) {
                                $value = $opt[$value]->getTitle();
                            }
                            if ($option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX || $option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE) {
                                $value = explode(',', $value);
                                foreach ($value as $key => $val) {
                                    $value[$key] = $opt[$val]->getTitle();
                                }
                                $value = implode(',', $value);
                            }

                            $individualOptions[] = array('title' => $option->getTitle(), 'value' => $value);
                        }

                    }
                }
	  		}
	  		$this->_modelData->setIndividualOptions($individualOptions);
	  		
	  	}
	  	
  	}
  	
  	return $this->_modelData;
  }
  
}
