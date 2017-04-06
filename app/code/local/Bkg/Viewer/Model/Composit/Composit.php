<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Composit_Composit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method string getTitle()
 *  @method setTitle(string $value)
 *  @method int getActive()
 *  @method setActive(int $value)
 *  @method string getTileSystem()
 *  @method setTileSystem(string $value)
 *  @method string getVgSystem()
 *  @method setVgSystem(string $value)
 *  @method string getBetroffenheit()
 *  @method setBetroffenheit(string $value)
 */
class Bkg_Viewer_Model_Composit_Composit extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/composit_composit');
    }
    
    public function getLayers()
    {
    	$collection = Mage::getModel('bkgviewer/composit_layer')->getCollection();
    	$collection->getSelect()->where('composit_id = '.$this->getId());
    	
    	return $collection->getItems();
    }
    
    public function getTileSystemWithCRS($crs = null)
    {
    	$ts = Mage::getModel('bkgviewer/service_tilesystem')->loadWithCRS($this->getTileSystem(), $crs);
    	return $ts;
    }
    
    public function getVgSystemWithCRS($crs = null)
    {
    	$vgg = Mage::getModel('bkgviewer/service_vggroup')->loadWithCRS($this->getVgSystem(), $crs);
    	return $vgg;
    }
    
    
    public function getTilesIntersection($crs = null)
    {
    	//verwaltungsgebiete finden
    	$vgg = $this->getVgSystemWithCRS($crs);
    	$vgs = Mage::getModel('bkgviewer/service_vg')->getCollection();
    	$vgs->getSelect()->where('group_id=?',$vgg->getId());
    	
    	//Kachelsystem finden
    	$ts = $this->getTileSystemWithCRS($crs);
    	
    	$res = array();
    	foreach($vgs as $vg)
    	{
    		$tiles = Mage::getModel('bkgviewer/service_tile')->getCollection();
    		$tiles->getSelect()
    			->reset(Zend_Db_Select::COLUMNS)
    			->columns('main_table.ident')
    			->join(array('vg'=>$tiles->getTable('bkgviewer/service_vg')),'(intersects(main_table.shape, vg.shape) = 1) AND (vg.id='.$vg->getId().' )',array())
    			->where('system_id=?',$ts->getId());
    		
    		$tmp = array();
    		foreach( $tiles->getItems() as $item){
    			$tmp[] = $item->getIdent();
    		}
    			
    		$res[$vg->getIdent()] = $tmp;
    		var_dump($res);
    		die($tiles->getSelect()->__toString());
    		
    	}
    }
}
