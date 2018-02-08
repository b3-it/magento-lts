<?php
/**
 * 
 *  Anzeige einer Liste von Einträgen mit Position 
 *  @category Egovs
 *  @package  Egovs_Base_Adminhtml_Widget_Form_Toll
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Block_Adminhtml_Widget_Form_Ol extends Varien_Data_Form_Element_Abstract
{
	
	protected $_addpane = null;
	
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
 		
        $this->_addpane = new Egovs_Base_Block_Adminhtml_Widget_Form_Ol_Addpane($attributes);
        $this->_addpane->setData($attributes);
    }
    
    
    public function setAddPane($block)
    {
    	$this->_addpane = $block;
    }
    
    
    public function getAddPane()
    {
    	return $this->_addpane;
    }

    public function getHtml()
    {
    	$renderer = new Mage_Adminhtml_Block_Widget_Form_Renderer_Element();
    	$renderer->setTemplate('egovs/widget/form/ol.phtml');
    	
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
	    	//sortieren
	    	$pos = array();
	    	$value = array();
	    	
	    	foreach ($this->getValue() as $k=>$v)
	    	{
	    		$pos[$k] = intval($v['pos']); 
	    		$value[$k] = $v['value']; 
	    	}
	    	
	    	array_multisort($pos, $value);
	    	
	    	//label
	    	$values = array();
	    	
	    	foreach($this->getValues() as $item)
	    	{
	    		$values[$item['value']] = $item['label'];
	    	}
	    	
	    	
	    	$this->_elements = array();
	    	$i = 0;
	    	foreach($value as $v)
	    	{
	    		$i++;
	    		$label = $v;
	    		if(isset($values[$v]))
	    		{
	    			$label = $values[$v];
	    		}
	    		$this->_elements[] = array('label'=>$label,'value'=>$v,'pos'=>$i);
	    	}
    	}
    	
    	return $this->_elements;
    }
    
    
    
    public function getName($field = 'value')
    {
    	$name = parent::getName();
    	if (strpos($name, '[') === false) {
    		$name.= '['.$field.'][]';
    	}
    	return $name;
    }
    
   
    
}