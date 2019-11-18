<?php
/**
 * B3it Zabbix
 *
 * https://medium.com/@manivannan_data/create-controller-in-magento-1-9-113c9409d0b7
 * https://alanstorm.com/magento_loading_config_variables/
 *
 *
 * @category   	B3it
 * @package    	B3it_Zabbix
 * @name       	B3it_Zabbix_IndexController
 * @author 		René Mütterlein <r.muetterlein@b3-it.de>
 * @copyright  	Copyright (c) 2019 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class B3it_Zabbix_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Index-Action
     *
     * @access public
     * @return bool
     */
    public function indexAction()
    {
        /** @var \Mage_Core_Model_App */
        if( count(Mage::getConfig()->loadModules() ) ) {
            echo true;
        }
        else {
            echo false;
        }
    }
}