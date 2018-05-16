<?php

class B3it_Subscription_Model_Period_Unit
{
	public static function getOptions()
	{
		$opt = array();
		$opt[] = array('value'=>Zend_Date::DAY, 'label' =>  Mage::helper('b3it_subscription')->__('Day'));
		$opt[] = array('value'=>Zend_Date::MONTH, 'label' =>  Mage::helper('b3it_subscription')->__('Month'));
		$opt[] = array('value'=>Zend_Date::YEAR, 'label' =>  Mage::helper('b3it_subscription')->__('Year'));
		return $opt;
	}
}