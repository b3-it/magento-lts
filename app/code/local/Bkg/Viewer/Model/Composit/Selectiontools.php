<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Composit_Layer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_Viewer_Model_Composit_Selectiontools extends Mage_Core_Model_Abstract
{
	protected $_children = array();
	protected $_Service = null;
	protected $_ServiceLayer = null;
	protected static $Count = 0;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/composit_selectiontools');
    }
    
   
	public function getOptions4Product($compositId)
	{
		$collection = $this->getCollection();
		$collection->getSelect()
		->join(array('layer'=>$collection->getTable('bkgviewer/service_layer')),'layer.id= main_table.layer_id',array('title'))
		->where('composit_id = ?', $compositId)
		->order('pos');
		
		return $collection;
	}
    
}
