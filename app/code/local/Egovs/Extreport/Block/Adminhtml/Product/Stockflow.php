<?php
/**
 * Adminhtml Report: Verlauf der Bestandsmengen
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Product_Stockflow extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	/**
	 * Initialisiert das Grid
	 *
	 * <ul>
	 *  <li>Button Hinzufügen wird entfernt</li>
	 * </ul>
	 *
	 * @return void
	 */
    public function __construct()
    {
        $this->_headerText = Mage::helper('extreport')->__('Stock flow');
        $this->_controller = 'product_stockflow';
        $this->_blockGroup = 'extreport'; //_controller funktioniert sonst nicht
        parent::__construct();
        $this->_removeButton('add');
    }
}
