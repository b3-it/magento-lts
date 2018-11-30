<?php
/**
 *
 * @category   	Egovs
 * @package    	Egovs_Base
 * @copyright  	EDV Beratung Hempel
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * 
 * @see			http://www.php.net/manual/en/function.error-reporting.php
 */
class Egovs_Base_Model_Security_Config_Source_Errorreporting
{
    public function toOptionArray()
    {
        return array(
            array('value'=>E_ALL ^ E_NOTICE, 'label'=>Mage::helper('egovsbase')->__('All but notice')),
            array('value'=>E_ERROR | E_WARNING | E_PARSE, 'label'=>Mage::helper('egovsbase')->__('Simple running errors')),
            array('value'=>E_ALL ^ E_STRICT ^ E_DEPRECATED , 'label'=>Mage::helper('egovsbase')->__('All errors without strict & deprecated')),
        	array('value'=>E_ALL, 'label'=>Mage::helper('egovsbase')->__('Development')),
            array('value'=>0, 'label'=>Mage::helper('egovsbase')->__('Off')),
        );
    }

}