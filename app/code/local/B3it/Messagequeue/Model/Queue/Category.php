<?php

/**
 * 
 *  Kategorie der Regel
 *  @category B3it
 *  @package  B3it_Messagequeue_Model_Queue_Status
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Queue_Category extends Varien_Object
{
    protected $_options = null;
    
   
    public function getOptionArray(){

        $res = array();
        $opt = $this->getOptions();
        foreach($opt as $k=>$v)
        {
            $res[$k] = $v->getLabel();
        }

    	return $res;
    }


    public function getOptions()
    {
        if($this->_options == null)
        {
            $this->_options = array();
            $opt = Mage::getConfig()->getNode('global/b3it_messagequeue/category')->asArray();

            foreach($opt as $k=>$v)
            {
                $model = Mage::getModel($v['model']);
                if($model) {
                    $model->setLabel($v['label']);
                    $this->_options[$k] =$model;
                }
            }
        }
        return $this->_options;
    }

    public function getModelByName($name)
    {

        $opt = $this->getOptions();

        if(isset($opt[$name])){
            return $opt[$name];
        }

        return null;
    }

}