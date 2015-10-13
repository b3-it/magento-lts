<?php

class Dwd_ConfigurableDownloadable_Block_Adminhtml_Widget_Grid_Column_Filter_NumberOfDownloads extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Range
{
    public function getHtml()
    {
        $html = '<div class="range">';
        $html .= '<div class="range-line"><span class="label">' . Mage::helper('adminhtml')->__('From').':</span> <input type="text" name="'.$this->_getHtmlName().'[from]" id="'.$this->_getHtmlId().'_from" value="'.$this->getEscapedValue('from').'" class="input-text no-changes"/></div>';
        $html .= '<div class="range-line"><span class="label">' . Mage::helper('adminhtml')->__('To').' : </span><input type="text" name="'.$this->_getHtmlName().'[to]" id="'.$this->_getHtmlId().'_to" value="'.$this->getEscapedValue('to').'" class="input-text no-changes"/></div></div>';
        $html .= $this->_renderCheckbox();
        return $html;
    }
    
    protected function _renderCheckbox() {
    	$value = $this->getEscapedValue('ul');
    	$checked = '';
    	if ($value) {
    		$checked = 'checked="checked"';
    	}
    	$html = '<div class=""><span class="label" style="width: 50px">' . Mage::helper('downloadable')->__('Unlimited').' : </span><input type="checkbox" name="'.$this->_getHtmlName().'[ul]" id="'.$this->_getHtmlId().'_ul" value="1" '.$checked.' class="checkbox no-changes"/></div>';
    	
    	return $html;
    }

    public function getValue($index=null)
    {
        if ($index) {
            return $this->getData('value', $index);
        }
        $value = $this->getData('value');
        if ((isset($value['from']) && strlen($value['from']) > 0) || (isset($value['to']) && strlen($value['to']) > 0)) {
            return $value;
        }
        if (isset($value['ul']) && strlen($value['ul']) > 0) {
        	return 0;
        }
        return null;
    }
    

    public function getCondition()
    {
        $value = $this->getValue();
        return $value;
    }

}
