<?php
/**
 * Renderer für Saldo.
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author 		Holger Kögel <mail@hkoegel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Block_Adminhtml_Widget_Grid_Column_Renderer_Link extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Text
{
   
 
    
    public function render(Varien_Object $row)
    {
    	//der Text
    	$caption = $this->_getValue($row);
    	
    	//die Url
    	$url = $this->getUrl($this->_getLinkUrl(),array($this->_getLinkParam() => $this->_getLinkValue($row)));
    	
    	$html = '<a href="'.$url.'">'.$caption.'</a>'; 
    	return $html;
    }
    

    protected function _getLinkValue(Varien_Object $row)
    {
    	
    	return $row->getData($this->getColumn()->getLinkIndex());
    }
    
    protected function _getLinkUrl()
    {
    	 
    	return $this->getColumn()->getLinkUrl();
    }
    
    protected function _getLinkParam()
    {
    
    	return $this->getColumn()->getLinkParam();
    }
    
    
    
}
