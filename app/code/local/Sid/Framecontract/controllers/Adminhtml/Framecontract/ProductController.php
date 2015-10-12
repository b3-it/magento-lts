<?php

class Sid_Framecontract_Adminhtml_Framecontract_ProductController extends Mage_Adminhtml_Controller_action
{

	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('contract/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		
		$this->_initAction()
			->renderLayout();
	}
	
	public function gridAction()
	{
		$this->getResponse()->setBody(
			$this->getLayout()->createBlock('framecontract/adminhtml_product_grid')->toHtml()
		);
	}

	
	public function saveAction() 
	{
		if ($data = $this->getRequest()->getPost()) {
			if(isset($data['all_products']))
			{
				$all = $data['all_products'];
			}
			else
			{
				$all = array();
			}
			
			if(isset($data['visible_products']))
			{
				$visible = $data['visible_products'];
			}
			else
			{
				$visible = array();
			}
			
			$group = $data['group'];
			$this->disableProducts($group);
			$visible = array_diff($all,$visible);
			$this->enableProducts($visible, $group);

        }
       // Mage::getSingleton('adminhtml/session')->addError(Mage::helper('framecontract')->__('Unable to find item to save'));
       
       $this->_redirect('framecontract/adminhtml_product/index', array('_current' => true,'group'=>$group));
	}
 
	
 	private function disableProducts($groupId)
 	{
 			$collection = Mage::getModel('catalog/product')->getCollection();
			$this->addGroupsFilterToProductCollectionSelect($collection->getSelect(), $groupId);
			//die($collection->getSelect()->__toString());
			foreach ($collection->getItems() as $product)
			{
				if ($product->getId())
				{
					Mage::helper('groupscatalog')->setProductAccessibilityForGroup($product, $groupId, true);
				}
			}
 	}
 	
	private function enableProducts($products, $groupId)
 	{
 			
			foreach ($products as $productId)
			{
				$product = Mage::getModel('catalog/product');
				$product->getResource()->load($product, $productId);
				if ($product->getId())
				{
					Mage::helper('groupscatalog')->setProductAccessibilityForGroup($product, $groupId, false);
				}
			}
 	}
 	
 	
	public function addGroupsFilterToProductCollectionSelect(Varien_Db_Select $select, $customerGroupId = null)
	{
		//if ($this->moduleActive() && (! $this->inAdmin() || isset($customerGroupId)))
		{
		

            $attributeCode = 'groupscatalog_hide_group';
            $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);

			if (! $attribute)
			{
				/*
				 * This seems to happen if no products exist in the catalog.
				 */
				return;
			}

            $tableAlias = '_' . $attributeCode . '_table';
            $default =  $attribute->getDefaultValue();
            if(!$default) $default = "''";
            $attributeValueCol = 'IFNULL(' . $tableAlias . '.value' . ', ' . $default . ')';

            $tableCondition = 'e.entity_id='.$tableAlias.'.entity_id AND ' .
                $tableAlias.'.attribute_id' . '=' .$attribute->getId();

            $select->joinLeft(
                array($tableAlias => $attribute->getBackend()->getTable()),
                $tableCondition, 'value'
            );

            $default = Netzarbeiter_GroupsCatalog_Helper_Data::USE_DEFAULT;

            $commonConditionsSql = sprintf(
                    $attributeValueCol . " = '%1\$s' OR " .
                    "(" .
                        $attributeValueCol . " like '%1\$s,%%' OR " .
                        $attributeValueCol . " like '%%,%1\$s' OR " .
                        $attributeValueCol . " like '%%,%1\$s,%%'" .
                    ")",
                    $customerGroupId
            );

            /*
            if ($this->checkStoreProductAccess($customerGroupId))
            {
                $select->where(
                    $attributeValueCol . " = ? OR ( " .
                    $commonConditionsSql . ")",
                    $default
                );
            }
            else
            */
            {
                $select->where(
                    $attributeValueCol . " != ? AND ( " .
                    $commonConditionsSql . ")",
                    $default
                );
            }
            
		}
	}
	
	
  
	protected function _isAllowed() {
		$action = strtolower($this->getRequest()->getActionName());
		switch ($action) {
			default:
				return Mage::getSingleton('admin/session')->isAllowed('framecontract/product_visibility');
				break;
		}
	}
    
    
    
    
    
}