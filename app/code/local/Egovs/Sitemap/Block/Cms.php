<?php
/**
 * 
 *  Sitemap mit allen Seiten und Produkten
 *  @category Egovs
 *  @package  Egovs_Sitemap_Block_Cms
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Sitemap_Block_Cms extends Mage_Core_Block_Template
{

  public function getCmsCollection()
  {
  	$storeId = Mage::app()->getStore($this->getRequest()->getParam('store'))->getId();
   	$collection = Mage::getResourceModel('egovssitemap/cms_page')->getCollection($storeId); 
    return $collection;   
  }
}
