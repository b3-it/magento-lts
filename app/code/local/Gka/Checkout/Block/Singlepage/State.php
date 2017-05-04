<?php

class Gka_Checkout_Block_Singlepage_State extends Mage_Core_Block_Template
{
    public function getSteps()
    {
        return Mage::getSingleton('gkacheckout/type_singlepage_state')->getSteps();
    }
}
