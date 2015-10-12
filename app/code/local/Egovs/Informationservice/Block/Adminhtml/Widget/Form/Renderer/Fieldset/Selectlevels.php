<?php
class Egovs_Informationservice_Block_Adminhtml_Widget_Form_Renderer_Fieldset_Selectlevels extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{
	public function render(Varien_Data_Form_Element_Abstract $element) {
		$html = parent::render($element);
		
		//Leerzeichen zulassen
		//#954 (ZVM413)
		return mb_ereg_replace("&amp;nbsp;", "&nbsp;", $html);
	}
}