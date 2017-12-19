<?php
/**
 * 
 * @author h.koegel
 *
 */

class Bkg_Viewer_Block_Adminhtml_Composit_Composit_Edit_Selectiontools extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bkg/viewer/composit/edit/selectiontools.phtml');
       
    }

  
	public function getTools()
	{

		$res = array();
		$composit = Mage::registry('compositcomposit_data');
        $collection = Mage::getModel('bkgviewer/composit_selectiontools')->getOptions4Product($composit->getId());

		return $collection->getItems();
	}
	

	
	
	

	
}
