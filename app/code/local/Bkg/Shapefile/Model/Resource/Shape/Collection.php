<?php
class Bkg_Shapefile_Model_Resource_Shape_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_shapefile/shape');
    }
    
    /**
     * {@inheritDoc}
     * @see Mage_Core_Model_Resource_Db_Collection_Abstract::_afterLoad()
     */
    protected function _afterLoad()
    {
        parent::_afterLoad();
        foreach ($this->_items as $item) {
            /**
             * @var Bkg_Shapefile_Model_Resource_Shape
             */
            $item->afterLoad();
        }
        return $this;
    }
    /**
     * {@inheritDoc}
     * @see Mage_Core_Model_Resource_Db_Collection_Abstract::_initSelect()
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->addFieldToSelect('id');
        $this->addFieldToSelect(new Zend_Db_Expr('ST_AsText(shape)'), "shape");
        return $this;
    }
    
}
