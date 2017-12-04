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
}
