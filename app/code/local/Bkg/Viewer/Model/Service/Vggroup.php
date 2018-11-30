<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Service_Service
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_Viewer_Model_Service_Vggroup extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/service_vggroup');
    }
    
    
 	public function importFile($path)
    {
    	$path .= DS . $this->getFilename();
    	$data = file_get_contents($path);
    	$this->_import($data);
        
    	return $this;
    }
    
    protected function _import($data)
    {
    	$this->setIdent('import '.now())->save();
    	 
    	 
    	$xmlobj = new \DOMDocument();
    	$xmlobj->loadXML($data);
    	foreach ($xmlobj->getElementsByTagName('featureMember') as $node) {
    		/** @var \DOMElement $node */
    		if ($node instanceof \DOMElement) {
    			$id = $node->getElementsByTagName('GEN')->item(0)->textContent;
    			
    			$multiPoly = new Bkg_Geometry_Multipolygon();
    			//$polygons = array();
    			try{
    				foreach ($node->getElementsByTagName('Polygon') as $polynode) {
    					if ($polynode instanceof \DOMElement) {
    						$polygon = new Bkg_Geometry_Polygon();
    						
    						$lines = [];
    						foreach ($polynode->getElementsByTagName('exterior') as $extnode) 
    						{
	    						foreach ($extnode->getElementsByTagName('posList') as $listnode) {
	    							$cords = array_chunk(explode(" ", trim($listnode->textContent)), 2);
	    							$linestring =  new Bkg_Geometry_LineString();
	    							$linestring->load($cords);
	    							$polygon->setExterior($linestring);
	    						}
	    						
	    						
	    						
    						}
    						foreach ($polynode->getElementsByTagName('interior') as $intnode)
    						{
    							foreach ($intnode->getElementsByTagName('posList') as $listnode) {
    								$cords = array_chunk(explode(" ", trim($listnode->textContent)), 2);
    								$linestring =  new Bkg_Geometry_LineString();
    								$linestring->load($cords);
    								$polygon->addInterior($linestring);
    							}
    						}
    						$multiPoly->addPoloygon($polygon);
    					}
    				}

    
    				//if (!empty($polygons)) 
    				{
    						$tile = Mage::getModel('bkgviewer/service_vg');
    						$tile
    						->setGEOShape($multiPoly)
    						->setGroupId($this->getId())
    						->setIdent($id)
    						->save();
    						//$gmls[$id] = call_user_func_array(array(MultiPolygon::class, 'of'), $polygons);
    					
    				}
    			}
    			catch(Exception $ex)
    			{
    				die($ex);
    			}
    		}
    	}
 
    }
    
    /**
     * Laden einer Gruppe von Verwaltungsgebieten anhand der ident und CRS
     * @param string $ident
     * @param string $crs
     * @return Bkg_Viewer_Model_Resource_Service_Vggroup
     */
    public function loadWithCRS($ident, $crs = null)
    {
    	$this->_beforeLoad(null, null);
    	$this->_getResource()->loadWithCRS($this, $ident, $crs);
    	$this->_afterLoad();
    	$this->setOrigData();
    	$this->_hasDataChanges = false;
    	return $this;
    }
    
}
