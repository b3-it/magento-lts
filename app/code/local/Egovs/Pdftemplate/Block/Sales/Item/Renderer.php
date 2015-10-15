<?php

/**
 *
 *  Renderer für produktspezifische html Texte für pdf Template
 *  wird im Layout definiert z.B.
 *  	<pdftemplate_pdf_item_renderer>
 *       	<reference name="pdftemplate_pdf_item_renderer">
 *           	<action method="addItemRenderer"><type>configvirtual</type><block>xxx</block><template></template></action>....
 *  ausgabe des Renderes wir im Feld AdditionalItemData des items abgelegt
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Block_Sales_Item_Renderer extends Mage_Core_Block_Template
{
	
	protected $_itemRenders= array();
	  
	  
	  public function __construct()
	  {
	        parent::__construct();
	        $this->addItemRenderer('default', 'pdftemplate/sales_item_renderer_default', 'pdftemplate/sales/item/renderer/default.phtml');
	  }
	  
	  /**
	   * Add renderer for item product type
	   *
	   * @param   string $type
	   * @param   string $block
	   * @param   string $template
	   * @return  Egovs_Pdftemplate_Block_Sales_Item_Renderer_Abstract
	   */
	  public function addItemRenderer($type, $block, $template)
	  {
	  	$this->_itemRenders[$type] = array(
	  			'block'     => $block,
	  			'template'  => $template,
	  			'renderer'  => null
	  	);
	  
	  	return $this;
	  }
	  
	  
	  
	  /**
	   * Retrieve item renderer block
	   *
	   * @param string $type
	   * @return Mage_Core_Block_Abstract
	   */
	  public function getItemRenderer($type,$layout)
	  {
	  	if (!isset($this->_itemRenders[$type])) {
	  		$type = 'default';
	  	}
	  
	  	if (is_null($this->_itemRenders[$type]['renderer'])) {
	  		$block = $layout->createBlock($this->_itemRenders[$type]['block']);
	  		if($block)
	  		{
		  		$this->_itemRenders[$type]['renderer'] =
		  		$block->setTemplate($this->_itemRenders[$type]['template'])
		  		->setRenderedBlock($this);
	  		}
	  	}
	  	return $this->_itemRenders[$type]['renderer'];
	  }
}