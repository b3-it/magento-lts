<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 26.04.2018
 * Time: 13:46
 */

class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Content_Renderer_Node extends Mage_Core_Block_Template
{
    public function setNodeData($node) {
        $this->setData('node_data', $node);

        return $this;
    }
}