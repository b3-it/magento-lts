<?php
class Egovs_Informationservice_Block_Adminhtml_Widget_Grid_Column_Filter_Selectlevels extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Select
{
	 public function escapeHtml($data, $allowedTags = null) {
		$string = parent::escapeHtml($data, $allowedTags);
		
		//Leerzeichen zulassen
		//#954 (ZVM413)
		return mb_ereg_replace("&amp;nbsp;", "&nbsp;", $string);
	}
}