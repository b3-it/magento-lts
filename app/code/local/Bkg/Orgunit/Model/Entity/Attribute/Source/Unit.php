<?php

class Bkg_Orgunit_Model_Entity_Attribute_Source_Unit extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{


    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {
    	$collection = Mage::getModel('bkg_orgunit/unit')->getCollection();
        
        if (is_null($this->_options)) {
            $this->_options = array();
            $this->_options[] = array('label'=>'','value'=>'');
            foreach($collection as $item)
            {
            	$this->_options[] = array('label'=>$item->getName(),'value'=>$item->getId());
            }
        }
        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = array();
        foreach ($this->getAllOptions() as $option) {
            $_options[$option['value']] = $option['label'];
        }
        return $_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();
        foreach ($options as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }

 
    public function getPossibleParents($id) {
        $result = [];
        //allow null parent
        $result[''] = '';
        $options = $this->getAllOptions();
        foreach ($options as $o) {
            if (isset($id)) {
                // can't be itself
                if ($o['value'] === $id) {
                    continue;
                }
                // id is parent of this
                if ($this->isParentOf($o['value'], $id)) {
                    continue;
                }
            }
            $result[$o['value']] = $o['label'];
            
        }
        return $result;
    }
    
    private function isParentOf($unit, $parent) {
        if (is_numeric($unit)) {
            /**
             * @var Bkg_Orgunit_Model_Unit $unit
             */
            $unit = Mage::getModel('bkg_unit/unit')->load($unit);
        }
        $id = $unit->getParentId();
        if ($id !== null) {
            return false;
        }
        if ($parent === $id) {
            return true;
        }
        return isParentOf($id, $parent);
    }
}
