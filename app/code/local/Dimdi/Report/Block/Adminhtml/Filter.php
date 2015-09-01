<?php
/**
 * Dimdi Report
 *
 *
 * @category   	Dimdi
 * @package    	Dimdi_Report
 * @name        Dimdi_Report_Block_Adminhtml_Filter
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Block_Adminhtml_Filter extends Mage_Adminhtml_Block_Widget_Container
{
  public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->setTemplate('widget/form/container.phtml');
        
      
			
        $this->_addButton('run', array(
            'label'     => Mage::helper('adminhtml')->__('Show Report'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        
       
    }

 	protected function _prepareLayout()
    {
        $this->setChild('form', $this->getLayout()->createBlock('dimdireport/adminhtml_filter_form'));
        
        return parent::_prepareLayout();
    }
    
    public function getHeaderText()
    {
            return Mage::helper('dimdireport')->__('DIMDI Report');
    }
    
	public function getFormHtml()
    {
	       $html = "<script>
	            function saveAndContinueEdit(){
	                editForm.submit($('edit_form').action+'back/edit/filter//');
	            }
	        </script>";
	       $html .= $this->getChildHtml('form');
	       
        return $html;
    }
}