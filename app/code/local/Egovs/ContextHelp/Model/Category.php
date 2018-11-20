<?php
/**
 *
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category  Egovs
 *  @package   Egovs_ContextHelp_Model_Category
 *  @author    Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license   ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Model_Category extends Mage_Core_Model_Abstract
{
    /**
     * Kategorien aus der XML-Datei lesen
     * @return array[]
     */
	public function getOptions()
	{
		$result = array();
		$sect   = Mage::getConfig()->getNode('global/egovs_contexthelp/category')->asArray();
		foreach($sect as $k=>$v) {
			$result[$k] =$this->__($v);
		}
		return $result;
	}

    /**
     * Kategorien für DropDown aus der XML-Datei lesen
     * @return array[]
     */
	public function getOptionsHash()
	{
		$result = array();
		$sect   = Mage::getConfig()->getNode('global/egovs_contexthelp/category')->asArray();
		foreach($sect as $k=>$v)
		{
			$result[] = array('value'=>$k,'label'=>$this->__($v));
		}
		return $result;
	}

    /**
     * Übersetzungs-Funktion
     * @return string
     */
    public function __()
	{
		$args = func_get_args();
		$expr = new Mage_Core_Model_Translate_Expr(array_shift($args), $this->getModuleName());
		array_unshift($args, $expr);
		return Mage::app()->getTranslator()->translate($args);
	}

}
