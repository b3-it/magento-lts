<?php
/**
 * Store-Switcher-Block
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Store_Switcher extends Mage_Adminhtml_Block_Store_Switcher
{
	/**
	 * Liefert die Switch-URL mit den entsprechenden Parametern
	 * 
	 * @return string
	 */
    public function getSwitchUrl()
    {
    	$sw = '';
    	$cgroup = Mage::registry('cgroup');
    	if (isset($cgroup)) {
            $sw = "cgroup/$cgroup";
        }
        if (strlen($sw) > 0) {
        	$sw .= '/';
        }
        if ($url = $this->getData('switch_url')) {
            return $url.$sw;
        }
        
        return $this->getUrl('*/*/*', array('_current' => true, 'store' => null)).$sw;
    }
}
