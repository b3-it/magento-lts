<?php
/**
 * 
 *  Anzeige einer Liste von Einträgen mit Position 
 *  @category Egovs
 *  @package  Egovs_Base_Adminhtml_Widget_Form_Toll
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Widget_Form_Componentparts extends Varien_Data_Form_Element_Abstract
{
	
	
    

    public function getHtml()
    {
    	$renderer = new Mage_Adminhtml_Block_Widget_Form_Renderer_Element();
    	$renderer->setTemplate('bkg/virtualgeo/widget/form/componentparts.phtml');
    	
    	$this->setRenderer($renderer);
        $this->addClass('input-text');
        return parent::getHtml();
    }

    public function getHtmlAttributes()
    {
        return array('type', 'title', 'class', 'style', 'onclick', 'onchange', 'onkeyup', 'disabled', 'readonly', 'maxlength', 'tabindex');
    }
    

    
    public function getElements()
    {
    	if($this->_elements == null)
        {
            $values = array();
            foreach($this->getValues() as $item)
            {
                $values[$item['value']] = $item['label'];
            }


	    	foreach ($this->getValue() as $k=>$v)
	    	{
                $label =  $values[$v->getEntityId()];
	    	    $pos = $v->getPos();
	    	    $value = $v->getEntityId();
	    	    $v->setLabel($values[$v->getEntityId()]);
                $this->_elements[] = $v;// array('label'=>$label,'value'=>$value,'pos'=>$pos);
	    	}
    	}
    	
    	return $this->_elements;
    }
    
    
    
   
    
   
    
}