<?php
/**
 * Bfr Mach
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Block_Adminhtml_History
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Block_Adminhtml_Download extends Mage_Adminhtml_Block_Widget_Container
{
 	
	
	
	public function __construct()
    {
        

        parent::__construct();

        $this->setTemplate('bfr/mach/download.phtml');

        $this->_addButton('kopf', array(
            'label'     => 'IRBelege',
            'onclick'   => 'setLocation(\'' . $this->getExportUrl('downloadKopf') .'\')',
            //'class'     => 'add',
        ));
        
        $this->_addButton('pos', array(
        		'label'     => 'IRPositionen',
        		'onclick'   => 'setLocation(\'' . $this->getExportUrl('downloadPos') .'\')',
        		//'class'     => 'add',
        ));
        
        $this->_addButton('zu', array(
        		'label'     => 'IRAObjZuordnung',
        		'onclick'   => 'setLocation(\'' . $this->getExportUrl('downloadMapping') .'\')',
        		//'class'     => 'add',
        ));
    }
    
    
    private function getExportUrl($exportType)
    {
    	$lauf = Mage::registry('lauf');
    	return $this->getUrl('*/*/'.$exportType, array('lauf'=>$lauf));
    }
    
    
    public function getHeaderText()
    {
    	return Mage::helper('bfr_mach')->__('Download Files');
    }
    
    
}