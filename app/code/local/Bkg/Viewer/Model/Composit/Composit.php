<?php
/**
 *
 * @category       Bkg Viewer
 * @package        Bkg_Viewer
 * @name           Bkg_Viewer_Model_Composit_Composit
 * @author         Holger Kögel <h.koegel@b3-it.de>
 * @copyright      Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license        http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
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
        /**
         * @var Bkg_Viewer_Model_Service_Vggroup $vgg
         */
        $vgg = $this->getVgSystemWithCRS($crs);
        $vgs = Mage::getModel('bkgviewer/service_vg')->getCollection();
        $vgs->getSelect()->where('group_id=?',$vgg->getId());
        
        //Kachelsystem finden
        $ts = $this->getTileSystemWithCRS($crs);
        
        $vggName = $vgg->getName();
        if (empty($vggName)) {
            $vggName = $vgg->getIdent();
        }
        
        $tsName = $ts->getName();
        if (empty($vggName)) {
            $tsName= $ts->getIdent();
        }
        
        // key for using cache
        $keyName = $vggName.'_'.$tsName;
        if (!empty($crs)) {
            $keyName .= '_'.$crs;
        }
        $key = "testingX".md5($keyName);
        
        if (($data = Mage::app()->getCache()->load($key))) {
            //var_dump("data found!");
            $data = gzuncompress($data);
            $data = json_decode($data, true);
        } else {
            //var_dump("data not found!");
            
            $data= array();
            foreach($vgs as $vg)
            {
                $tiles = Mage::getModel('bkgviewer/service_tile')->getCollection();
                $tiles->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns('main_table.ident')
                // NEED ST_Intersects function because it does need to check the object shapes and not only the rectangles
                ->join(array('vg'=>$tiles->getTable('bkgviewer/service_vg')),'(ST_Intersects(main_table.shape, vg.shape) = 1) AND (vg.id='.$vg->getId().' )',array())
                ->where('system_id=?',$ts->getId());
                
                $tmp = array();
                foreach( $tiles->getItems() as $item){
                    $tmp[] = $item->getIdent();
                }
                
                // tiles can be empty
                if (empty($tmp)) {
                    continue;
                }
                
                if (!isset($data[$vg->getIdent()])) {
                    $data[$vg->getIdent()] = $tmp;
                } else {
                    // key already exist, push them to existing array
                    // DO VERSION CHECK FOR VERY OLD PHP
                    // version_compare(phpversion(), '5.6.0', '>=')) nützt hier nichts, da es als Syntax-Fehler behandelt wird!
                    array_push($data[$vg->getIdent()], ...$tmp);
                }
            }
            #the data is stored the best when turned into a json string and then gz compressed
            $str = json_encode($data);
            $str = gzcompress($str, 9);

            Mage::app()->getCache()->save($str, $key, array(), null);
        }
        
        return $data;
    }
    
    public function getOpenLayer($espg = false)
    {
    	$text = "var layers_0 = new ol.Collection();".PHP_EOL;
    	
    	/**
    	 * @var Bkg_Viewer_Model_Resource_Composit_Layer_Collection $collection
    	 */
    	$collection = Mage::getModel('bkgviewer/composit_layer')->getCollection();
    	$collection->getSelect()->order('pos');
    	//echo "}</script>";
    	
    	//var_dump($list);
    	//die();
    	//->where("service_layer_id != null") // no need for category ones there?
    	
    	// done via zIndex
    	//->order('visual_pos')
    	;
    	foreach($collection->getNodesTree($this->getId())->getChildren() as $layer)
    	{
    	    //var_dump($layer);
    	    //die();
    	    /**
    	     * @var Bkg_Viewer_Model_Composit_Layer $layer 
    	     */
			$text .= " ". $layer->getOpenLayer(0, $espg);
    	}
    	 
    	return $text;
    }
    
    public function getLayerTree() {
        
    }
}
