<?php
/**
 * Renderer für CronJobs
 *
 * @category	Dwd
 * @package		Dwd_AutoFileAssignment
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_AutoFileAssignment_Block_Adminhtml_System_Config_Form_Field_Cron_Time extends Mage_Adminhtml_Block_System_Config_Form_Field
{
	/**
	 * Enter description here...
	 *
	 * @param Varien_Data_Form_Element_Abstract $element Element
	 *
	 * @return string
	 */
	protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
		if (!($element instanceof Varien_Data_Form_Element_Time)) {
			return parent::_getElementHtml($element);
		}
		$element->addClass('select');

        $value_hrs = 0;
        $value_min = 0;
        //$value_sec = 0;

        if ($value = $element->getValue()) {
            $values = explode(',', $value);
            if (is_array($values) && count($values) > 1 && count($values) <= 3) {
                $value_hrs = $values[0];
                $value_min = $values[1];
                //$value_sec = $values[2];
            }
        }

        $html = '<input type="hidden" id="' . $element->getHtmlId() . '" />';
        $html .= '<select name="'. $element->getName() . '" '.$element->serialize($element->getHtmlAttributes()).' style="width:150px">'."\n";
        $html.= '<option value="*" '. ( ($value_hrs == "*") ? 'selected="selected"' : '' ) .'>' . $this->__('Hourly') . '</option>';
        for ($i=0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $html.= '<option value="'.$hour.'" '. ( ((string) $value_hrs == (string) $i) ? 'selected="selected"' : '' ) .'>' . $hour . '</option>';
        }
        $everyHours = array(2, 3, 4, 6, 8, 12);
        foreach ($everyHours as $hour) {
        	$html.= '<option value="*/'.$hour.'" '. ( ((string) $value_hrs == "*/$hour") ? 'selected="selected"' : '' ) .'>' . $this->__("Every %s hours", $hour) . '</option>';
        }
        $html.= '</select>'."\n";

        $html.= '&nbsp;:&nbsp;<select name="'. $element->getName() . '" '.$element->serialize($element->getHtmlAttributes()).' style="width:40px">'."\n";
        for ($i=0; $i < 60; $i++ ) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $html.= '<option value="'.$hour.'" '. ( ($value_min == $i) ? 'selected="selected"' : '' ) .'>' . $hour . '</option>';
        }
        $html.= '</select>'."\n";

        //Sekunden werden nicht benötigt
        /*
        $html.= '&nbsp;:&nbsp;<select name="'. $element->getName() . '" '.$element->serialize($element->getHtmlAttributes()).' style="width:40px">'."\n";
        for( $i=0;$i<60;$i++ ) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $html.= '<option value="'.$hour.'" '. ( ($value_sec == $i) ? 'selected="selected"' : '' ) .'>' . $hour . '</option>';
        }
        $html.= '</select>'."\n";
        */
        $html.= $element->getAfterElementHtml();
        return $html;
	}
}