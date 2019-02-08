<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Event_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Options_List extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_options_list';
        $this->_blockGroup = 'eventmanager';

        $this->_headerText =  Mage::registry('event_data')->getTitle();

        parent::__construct();


        $this->removeButton('add');
        $url = $this->getUrl('*/eventmanager_options/index');
        $this->addButton('send_notification', array(
            'label'     => Mage::helper('eventmanager')->__('Back'),
            'onclick'   => "location='".$url ."'",
        ));

    }
}
	
	
