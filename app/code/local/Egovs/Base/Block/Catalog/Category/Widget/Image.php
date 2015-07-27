<?php
class Egovs_Base_Block_Catalog_Category_Widget_Image extends Mage_Catalog_Block_Category_Widget_Link
{
    protected $_imageUrl = null;

    public function getImageURL() {
        if (!$this->_imageUrl && $this->_entityResource) {
            if (!$this->getData('image_url')) {
                $idPath = explode('/', $this->getIdPath());
                if (isset($idPath[1])) {
                    $id = $idPath[1];
                    if ($id) {
                        $this->_imageUrl = Mage::getBaseUrl('media').'catalog/category/'.
                                           $this->_entityResource->getAttributeRawValue($id, 'image', Mage::app()->getStore());
                    }
                }
            } else {
                $this->_imageUrl = $this->getData('image_url');
            }
        }

        return $this->_imageUrl;
    }
}