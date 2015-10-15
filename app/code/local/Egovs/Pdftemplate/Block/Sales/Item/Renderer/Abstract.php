<?php

/**
 *
 *  Abstract Renderer für produktspezifische html Texte für pdf Template
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

class Egovs_Pdftemplate_Block_Sales_Item_Renderer_Abstract extends Mage_Core_Block_Template
{
	
	protected $_item=null;
	  
	  
	  public function setItem($item)
	  {
	  		$this->_item = $item;
	  		return $this;
	  }
	  
	  public function getItem()
	  {
	  	return $this->_item;
	  }
	  
	  public function __construct()
	  {
	  		parent::_construct();
	  		//soll immer aus dem frontend Layout geladen werden!!
	  		$this->setArea('frontend');
	  }
	  
	  public function getOrderItem()
	  {
	  	if ($this->getItem() instanceof Mage_Sales_Model_Order_Item) {
	  		return $this->getItem();
	  	} else {
	  		return $this->getItem()->getOrderItem();
	  	}
	  }
}