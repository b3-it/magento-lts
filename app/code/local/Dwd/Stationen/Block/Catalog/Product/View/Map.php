<?php
class Dwd_Stationen_Block_Catalog_Product_View_Map extends Dwd_Stationen_Block_Catalog_Product_View_Abstract
{
    public function getRssUrl()
    {
        return $this->getUrl('fstationen/liste/rss',array(
            'product_id' => $this->getProduct()->getId(),
            '_secure' => $this->getRequest()->isSecure()));
    }

    public function getGeoJsonUrl() {
        return $this->getUrl('fstationen/liste/json',array(
            'product_id' => $this->getProduct()->getId(),
            '_secure' => $this->getRequest()->isSecure()));
    }

}