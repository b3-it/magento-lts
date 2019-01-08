<?php
/**
 * 
 *  Anzeige einer Liste von Einträgen mit Position 
 *  @category B3it
 *  @package  B3it_Widget_Block_Adminhtml_Form_OrderList
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2017 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Widget_Block_Adminhtml_Form_OrderList extends Varien_Data_Form_Element_Abstract
{

    protected static $_js_loaded = false;

    public function getHtml()
    {
    	$renderer = new Mage_Adminhtml_Block_Widget_Form_Renderer_Element();
    	$renderer->setTemplate('b3it/widget/form/orderlist.phtml');
    	
    	$this->setRenderer($renderer);
        $this->addClass('input-text');

        $add = "";
        if(!self::$_js_loaded){
            self::$_js_loaded = true;
            $add = "<script type=\"text/javascript\" src=\"". Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS)."b3it/widget/adminhtml/form-orderlist.js\"></script> ";
        }

        return $add . parent::getHtml();
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