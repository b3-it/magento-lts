<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Block_Adminhtml_Filter
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Block_Adminhtml_Filter extends Mage_Adminhtml_Block_Widget_Container
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
        $this->setChild('form', $this->getLayout()->createBlock('ibewi/adminhtml_filter_form'));
        
        return parent::_prepareLayout();
    }
    
    public function getHeaderText()
    {
            return Mage::helper('ibewi')->__('IBEWI Report');
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
    
    public function getButtonId()
    {
    	$bt = $this->_children['run_button'];
    	if($bt)
    	{
    			$id = $bt->getId();
    			return $id;
    		
    	}
    	return "id";
    }
  
}