<?php
/**
 * 
 *  RenderBlock für Produkt Optionen
 *  @category Egovs
 *  @package  Egovs_EventBundle_Block_Catalog_Product_View_Type_Option_Radio
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Block_Catalog_Product_View_Option_Radio
    extends Egovs_EventBundle_Block_Catalog_Product_View_Option
{
    /**
     * Set template
     *
     * @return void
     */
    protected function _construct()
    {
        $this->setTemplate('egovs/eventbundle/catalog/product/view/options/radio.phtml');
    }
}
