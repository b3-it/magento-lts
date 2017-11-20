<?php
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Renderer_List extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{
	public function render(Varien_Data_Form_Element_Abstract $element) {
		$html = parent::render($element);
		
		//Leerzeichen zulassen
		//#954 (ZVM413)
		return mb_ereg_replace("&amp;nbsp;", "&nbsp;", $html);
	}
}