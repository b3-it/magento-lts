<?php
/**
 * Renderer zum Kürzen von Strings im Grid.
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Block_Adminhtml_Widget_Grid_Column_Renderer_ShortString extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
   
   /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
    	//String kürzen
    	
    	$value = $this->_getValue($row);
    	$l = intval($this->getColumn()->getLength());
    	if(($l > 0) && (strlen($value) > $l))
    	{
    		$value = substr($value, 0, $l) . "...";
    	}
    	
    	
        if ($this->getColumn()->getEditable()) {
           
            return $value
                   . ($this->getColumn()->getEditOnly() ? '' : ($value != '' ? '' : '&nbsp;'))
                   . $this->_getInputValueElement($row);
        }
        
        return $value;
    }
}