<?php


class Sid_Framecontract_Block_Adminhtml_Widget_Grid_Column_Renderer_Groups
	extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Checkbox
{
	
	public function renderHeader()
	{
		if($this->getColumn()->getHeader()) {
			return parent::renderHeader();
		}

		$checked = '';
		if ($filter = $this->getColumn()->getFilter()) {
			$checked = $filter->getValue() ? 'checked="checked"' : '';
		}
		//return '';
		return '<input type="checkbox"  name="'.$this->getColumn()->getFieldName().'" onclick="checkBoxes(this);" class="checkbox" '.$checked.' title="'.Mage::helper('adminhtml')->__('Select All').'"/>';
	}

	
	public function render(Varien_Object $row)
    {
    	
        
        $value = explode(',', $row->getData($this->getColumn()->getIndex()));
        $group = $this->getRequest()->getParam('group');
		if (!in_array($group, $value))
		{
			
			$html =  '<input type="checkbox" class="visible_products" name="visible_products[]" value="'.$row->getId().'" checked="checked" />';
			$html .=  '<input type="hidden" name="all_products[]" value="'.$row->getId().'"  />';
			return $html;
		}
		else 
		{
			$html =  '<input type="checkbox" class="visible_products" name="visible_products[]" value="'.$row->getId().'"  />';
			$html .=  '<input type="hidden" name="all_products[]" value="'.$row->getId().'"  />';
			return $html;
		}
        
       
    }
    
 
}