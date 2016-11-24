<?php
/**
 * 
 *  Daten für die Produkterstellung aus bmecat2005/Artikel liefern
 *  @category Egovs
 *  @package  B3it_XmlBind_Bmecat2005_Builder_Item_Product
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Import_Model_Builder_Item_Product2005 extends B3it_XmlBind_Bmecat2005_ProductBuilder_Item_Product
{

    /**
     * (non-PHPdoc)
     * @see B3it_XmlBind_Bmecat2005_ProductBuilder_Item_Product::getAttributeRow()
     */
    public function getAttributeRow($default = array())
    {
        
        if($this->getStockQuantity() == 0){
            $default['framecontract_qty'] = $this->getBuilder()->getStockQuantity();
        }else{
            $default['framecontract_qty'] = $this->getStockQuantity();
        }
        
        $default = parent::getAttributeRow($default);
        
        return $default;
    }
}