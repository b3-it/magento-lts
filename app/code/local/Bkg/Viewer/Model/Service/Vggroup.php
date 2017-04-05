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
    			 
    			$polygons = array();
    			try{
    				foreach ($node->getElementsByTagName('Polygon') as $polynode) {
    					if ($polynode instanceof \DOMElement) {
    
    						$lines = [];
    						foreach ($polynode->getElementsByTagName('posList') as $listnode) {
    							$cords = array_chunk(explode(" ", trim($listnode->textContent)), 2);
    							$lines[]= implode(', ', array_map(function($c) {
    								return implode(' ', $c);
    							}, $cords));
    						}
    						$text = implode(', ', $lines);
    						$polygon = new Bkg_Geometry_Polygon();
    						$polygons[] = $polygon->load($text);
    
    					}
    				}
    
    				if (!empty($polygons)) {
    					$multiPoly = new Bkg_Geometry_Multipolygon();
    					foreach($polygons as $polygon)
    					{
    						$multiPoly->addPoloygon($polygon);
    					}
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
    
}
