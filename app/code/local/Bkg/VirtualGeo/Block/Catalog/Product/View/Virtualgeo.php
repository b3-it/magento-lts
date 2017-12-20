<?php

class Bkg_VirtualGeo_Block_Catalog_Product_View_Virtualgeo extends Mage_Bundle_Block_Catalog_Product_View_Type_Bundle
{

	protected $_componentsBlockType = array();
	protected $_componentsBlock = array();


	/**
	 * Componenten
	 *
	 * @param string $type
	 * @param string $block
	 * @param string $template
	 */
	public function addComponentsBlock($type, $block = '',$template = '')
	{
		if ($type) {
			$this->_componentsBlockType[$type] = array(
					'block' => $block,
					'template' => $template
			);
		}
	}

	/**
	 * All ComponentKeys for Blockoutput
	 *
	 * @see app\design\frontend\base\default\layout\bkg\virtualgeo.xml
	 * @return array
	 */
	public function getBlocksFromComponents()
	{
		if ( is_array($this->_componentsBlockType) AND count($this->_componentsBlockType) ) {
			return array_keys($this->_componentsBlockType);
		}
		else {
			return null;
		}
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getSelectionTools() {
	    $composit = $this->getComposit();
	    if ($composit) {
	       return Mage::getModel('bkgviewer/composit_selectiontools')->getOptions4Product($composit->getId());
	    }
	    return array();
	}

	/**
	 * Return price block
	 *
	 * @param string $productTypeId
	 * @return mixed
	 */
	protected function _getComponentsBlock($type)
	{
		if (!isset($this->_componentsBlock[$type])) {
			if (isset($this->_componentsBlockType[$type])) {
				if ($this->_componentsBlockType[$type]['block'] != '') {
					$block = $this->_componentsBlockType[$type]['block'];
					$block = $this->getLayout()->createBlock($block);
					$block->setTemplate($this->_componentsBlockType[$type]['template']);
				}
				$this->_componentsBlock[$type] = $block;
			}
			else {
				return null;
			}
		}
		return $this->_componentsBlock[$type];
	}

	public function getComponentsBlock($type)
	{
		return $this->_getComponentsBlock($type);
	}
	
	
	
	/**
	 *
	 * @return Bkg_Viewer_Model_Composit_Composit
	 */
	public function getComposit()
	{
	    if($this->_composit == null){
	        $product = $this->getProduct();
	        if(!$product->getId()){
	            $this->log('Product for Composit not found!');
	            return null;
	        }
	        
	        if(!$product->getGeocomposit()){
	            $this->log('Composit not set!');
	            return null;
	        }
	        
	        $this->_composit = Mage::getModel('bkgviewer/composit_composit')->load($product->getGeocomposit());
	    }
	    
	    return $this->_composit;
	}
}
