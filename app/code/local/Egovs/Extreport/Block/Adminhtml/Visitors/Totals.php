<?php

/**
 * Block-Container für Besucheraktivitäten
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Visitors_Totals extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	/**
	 * Initialisiert den Container
	 */
    public function __construct()
    {
        $this->_controller = 'visitors_totals';
        $this->_blockGroup = 'extreport';
        $this->_headerText = Mage::helper('extreport')->__('Visitors Total');
        parent::__construct();  
        $this->_removeButton('add');
    }
}