<?php
/**
 * Configurable Downloadable Products Renderer für Maximale Downloads
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Block_Adminhtml_Widget_Grid_Column_Renderer_NumberOfDownloads extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Number
{
	protected $_defaultWidth = 55;
	
	/**
	 * Value aus Row ermitteln
	 * 
	 * @return mixed
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Number::_getValue()
	 */
	protected function _getValue(Varien_Object $row)
	{
		$data = parent::_getValue($row);
		if (!is_null($data)) {
			$value = $data * 1;
			$sign = (bool)(int)$this->getColumn()->getShowNumberSign() && ($value > 0) ? '+' : '';
			if ($sign) {
				$value = $sign . $value;
			}
			return $value ? $value : Mage::helper('downloadable')->__('Unlimited');
		}
		return $this->getColumn()->getDefault();
	}
}
