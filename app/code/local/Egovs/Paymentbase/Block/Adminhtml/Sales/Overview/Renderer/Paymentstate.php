<?php
/**
 * Block Renderer für verfügbare Versandstatus
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Sales_Overview_Renderer_Paymentstate extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Options
{
	/**
	 * Rendern
	 *
	 * @param Varien_Object $row Zeile
	 *
	 * @return string
	 *
	 * @see Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Options::render()
	 */
    public function render(Varien_Object $row) {
        $options = $this->getColumn()->getOptions();
        $showMissingOptionValues = (bool)$this->getColumn()->getShowMissingOptionValues();
        if (!empty($options) && is_array($options)) {
            $value = $row->getData($this->getColumn()->getIndex());
            if (is_array($value)) {
                $res = array();
                foreach ($value as $item) {
                    if (isset($options[$item])) {
                        $res[] = $options[$item];
                    } elseif ($showMissingOptionValues) {
                        $res[] = $item;
                    }
                }
                return implode(', ', $res);
            } elseif (isset($options[$value])) {
            	if ($value == Mage_Sales_Model_Order_Invoice::STATE_PAID) {
                	return '<div class="balanced">'.$options[$value].'</div>';
            	}
	            if ($value == Mage_Sales_Model_Order_Invoice::STATE_OPEN) {
	                return '<div class="unbalanced">'.$options[$value].'</div>';
	            }
            } elseif (in_array($value, $options)) {
                return $value;
            }
            return '';
        }
    }

    /**
     * {@inheritDoc}
     * @see Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract::renderExport()
     */
    public function renderExport($row) {
        $options = $this->getColumn()->getOptions();
        $value = $row->getData($this->getColumn()->getIndex());
        if (is_array($value)) {
            $res = array();
            foreach ($value as $item) {
                if (isset($options[$item])) {
                    $res[] = $options[$item];
                }
            }
            return implode(', ', $res);
        } elseif (isset($options[$value])) {
            return $options[$value];
        } elseif (in_array($value, $options)) {
            return $value;
        }
        return '';
    }
}
