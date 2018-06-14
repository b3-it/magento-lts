<?php
/**
 *
 * @category   	B3it Ids
 * @package    	B3it_Ids
 * @name       	B3it_Ids_Model_Dos_Visit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Ids_Model_Dos_Visit extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_ids/dos_visit');
    }

    public function detect($front, $ip, $agent)
    {
        $front = $front->getRequest()->getPathInfo();
        $url = Mage::getModel("b3it_ids/dos_url")->load($front,'url');
        if(!$url->getId()){
            return $this;
        }

        $collection = $this->getCollection();
        $collection->getSelect()
            ->where('url_id=?',$url->getId())
            ->where('ip=?',$ip)
            ->where('agent=?',$agent)
            ->where('barrier_time > ?',now());

        $visit = $collection->getFirstItem();

        $reaction = false;
        if($visit->getId())
        {
            $reaction = true;
            $visit->setCounter($visit->getCounter()+1);
            $visit->setCurrentDelay($visit->getCurrentDelay()*2);

        }else {

            $visit->setCurrentDelay($url->getDelay())
                ->setIp($ip)
                ->setAgent($agent)
                ->setCounter(1);
        }

        $visit->setLastVisit(now())
            ->setUrlId($url->getId())
            ->setBarrierTime(date('Y-m-d H:i:s',time()+$visit->getCurrentDelay() + $this->_getThrottleTime($url) ))
            ->save();


        if($reaction){
            switch ($url->getAction())
            {
                //case B3it_Ids_Model_Dos_Action::ACTION_DIE: die();
                case B3it_Ids_Model_Dos_Action::ACTION_THROTTLE_20: sleep(20); break;
                case B3it_Ids_Model_Dos_Action::ACTION_THROTTLE_40: sleep(40); break;
                case B3it_Ids_Model_Dos_Action::ACTION_THROTTLE_60: sleep(60); break;
            }
            http_response_code(503);
            die();
        }

        $this->getResource()->cleanUp();
    }

    protected function _getThrottleTime($url)
    {
        switch ($url->getAction())
        {
            case B3it_Ids_Model_Dos_Action::ACTION_THROTTLE_20: return 20; break;
            case B3it_Ids_Model_Dos_Action::ACTION_THROTTLE_40: return 40; break;
            case B3it_Ids_Model_Dos_Action::ACTION_THROTTLE_60: return 60; break;
        }
        return 0;
    }
}
