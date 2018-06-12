<?php
/**
 * Egovs Infoletter
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter_Helper_Data
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Infoletter_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * @param $mblock der MassenaktionsBlock
     * @param $url des Controllers der die Daten einfügt
     */
    public function addInfoLetter2Massaction($mblock, $url)
    {
       // $url =  Mage::getModel('core/url')->getUrl($urlPath);

        $issues = $this->__getQueueCollection();

        if(count($issues) > 0)
        {
            //$mblock = $observer->getMassactionBlock();
            $mblock->addItem('infoletter_queue', array(
                'label'=> Mage::helper('infoletter')->__('Add to Infoletter'),
                'url'  => $url,
                'additional' => array(
                    'visibility' => array(
                        'name' => 'queue_id',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('infoletter')->__('Queue'),
                        'values' => $issues
                    )
                )
            ));
        }
    }

    private function __getQueueCollection()
    {
        $collection = Mage::getModel('infoletter/queue')->getCollection();
        $collection->getSelect()->where('status='.Egovs_Infoletter_Model_Status::STATUS_NEW);
        $issues = array();
        foreach($collection->getItems() as $item)
        {
            $issues[$item->getId()] = $item->getTitle();
        }

        return $issues ;
    }

}