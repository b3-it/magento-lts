<?php
/**
 * Adminhtml Report: Haushaltsstellen
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Haushaltsstelle extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	/**
	 * Initialisiert den Block-Container
	 * 
	 * <ul>
	 * 	<li>Entfernt den Hinzufügen-Button</li>
	 * </ul>
	 * 
	 * @return void
	 */
    public function __construct()
    {
    	parent::__construct();
    	
        $this->_headerText = 'Haushaltsstelle';
		$this->_controller = 'sales_haushaltsstelle';
        $this->_blockGroup = 'extreport'; //_controller funktioniert sonst nicht
                    
        $this->_removeButton('add');
    }
}
