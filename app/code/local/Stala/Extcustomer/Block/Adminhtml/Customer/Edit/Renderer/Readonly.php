<?php
class Stala_Extcustomer_Block_Adminhtml_Customer_Edit_Renderer_Readonly extends Varien_Data_Form_Element_Text
{
	public function getHtml()
    {
        $this->setData('disabled','disabled');
        return parent::getHtml();
    }
}