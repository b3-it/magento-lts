<?php

class B3it_Subscription_Block_Adminhtml_Catalog_Product_Edit_Tab_Period extends Mage_Adminhtml_Block_Widget_Form  implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    private $_attributes = null;
    
    public function __construct($attributes)
    {
    	$this->_attributes = $attributes;
        parent::__construct();
       
        
        $this->setId('subscription_product');
        
    }
    
    protected function _prepareForm()
    {
    	$form = new Varien_Data_Form();
    	$this->setForm($form);
    	$fieldset = $form->addFieldset('subscription_form', array('legend'=>Mage::helper('productfile')->__('Subscription Period')));
    
    	
    	$value =  Mage::getModel('b3it_subscription/period')->getOptions4Product();
    	
    	$fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
    	$fieldset->addField('product_subscription_period', 'ol', array(
    			'label'     => Mage::helper('bkg_orgunit')->__('Period'),
    			//'class'     => 'required-entry',
    			//'required'  => true,
    			'name'      => 'product_subscription_period',
    			'values' =>$this->getPeriods(),
    			'value' => $value
    	));
    	
    	
    	
    	
    
    	return parent::_prepareForm();
    }
    
    
    public function getPeriods()
    {
    	$collection = Mage::getModel('b3it_subscription/period')->getCollection();
    	$res = array();
    
    
    	foreach($collection as $item)
    	{
    		$res[$item->getId()] = array('label'=>$item->getShortname(), 'value'=>$item->getId());
    	}
    
    
    	return $res;
    }
  
    /**
     * Liefert aktuelle Produkt Instanz
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct() {
    	return Mage::registry('product');
    }
  

      /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
    	return Mage::helper('catalog')->__('Period');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
    	return "Period";
    }
    
    public function isNew() {
    	if ($this->getProduct()->getId()) {
    		return false;
    	}
    	return true;
    }
    
    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab() {
    	
    	return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
    	return false;
    }
}
