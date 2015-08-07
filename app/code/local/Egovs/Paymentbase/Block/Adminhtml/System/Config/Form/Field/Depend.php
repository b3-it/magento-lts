<?php
/**
 * Renderer der ACLs berücksichtigt
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_System_Config_Form_Field_Depend extends Mage_Adminhtml_Block_System_Config_Form_Field
{
	const DEPENDENCY_FULFILLED = 1;
	const DEPENDENCY_FAILS = 0;
	
	/**
	 * READ ONLY
	 * @var int
	 */
	const DEPENDENCY_RO = 2;
	
	/**
	 * Enter description here...
	 *
	 * @param Varien_Data_Form_Element_Abstract $element Element
	 * 
	 * @return string
	 */
	public function render(Varien_Data_Form_Element_Abstract $element) {
		if (!$this->_isDependencyFulfilled($element)) {
			$element->setReadonly(true);
			$element->setDisabled(true);
			$element->addClass("disabled");
		}
		
		$id = $element->getHtmlId();

		$disabled = '';
		if ($element->getDisabled()) {
			$disabled = 'class="no-display"';
		}
        $useContainerId = $element->getData('use_container_id');
        $html = '<tr id="row_' . $id . '"' . $disabled . '>'
              . '<td class="label"><label for="'.$id.'">'.$element->getLabel().'</label></td>';

        //$isDefault = !$this->getRequest()->getParam('website') && !$this->getRequest()->getParam('store');
        $isMultiple = $element->getExtType()==='multiple';

        // replace [value] with [inherit]
        $namePrefix = preg_replace('#\[value\](\[\])?$#', '', $element->getName());

        $options = $element->getValues();

        $addInheritCheckbox = false;
        if ($element->getCanUseWebsiteValue()) {
            $addInheritCheckbox = true;
            $checkboxLabel = Mage::helper('adminhtml')->__('Use Website');
        } elseif ($element->getCanUseDefaultValue()) {
            $addInheritCheckbox = true;
            $checkboxLabel = Mage::helper('adminhtml')->__('Use Default');
        }

        if ($addInheritCheckbox) {
            $inherit = $element->getInherit()==1 ? 'checked="checked"' : '';
            if ($inherit) {
                $element->setDisabled(true);
            }
        }

        $html.= '<td class="value">';
        $html.= $this->_getElementHtml($element);
        if ($element->getComment()) {
            $html.= '<p class="note"><span>'.$element->getComment().'</span></p>';
        }
        $html.= '</td>';

        if ($addInheritCheckbox) {

            $defText = $element->getDefaultValue();
            if ($options) {
                $defTextArr = array();
                foreach ($options as $k=>$v) {
                    if ($isMultiple) {
                        if (is_array($v['value']) && in_array($k, $v['value'])) {
                            $defTextArr[] = $v['label'];
                        }
                    } elseif ($v['value']==$defText) {
                        $defTextArr[] = $v['label'];
                        break;
                    }
                }
                $defText = join(', ', $defTextArr);
            }

            // default value
            $html.= '<td class="use-default">';
            //$html.= '<input id="'.$id.'_inherit" name="'.$namePrefix.'[inherit]" type="checkbox" value="1" class="input-checkbox config-inherit" '.$inherit.' onclick="$(\''.$id.'\').disabled = this.checked">';
            $html.= '<input id="'.$id.'_inherit" name="'.$namePrefix.'[inherit]" type="checkbox" value="1" class="checkbox config-inherit" '.$inherit.' onclick="toggleValueElements(this, Element.previous(this.parentNode))" /> ';
            $html.= '<label for="'.$id.'_inherit" class="inherit" title="'.htmlspecialchars($defText).'">'.$checkboxLabel.'</label>';
            $html.= '</td>';
        }

        $html.= '<td class="scope-label">';
        if ($element->getScope()) {
            $html .= $element->getScopeLabel();
        }
        $html.= '</td>';

        $html.= '<td class="">';
        if ($element->getHint()) {
            $html.= '<div class="hint" >';
            $html.= '<div style="display: none;">' . $element->getHint() . '</div>';
            $html.= '</div>';
        }
        $html.= '</td>';

        $html.= '</tr>';
        return $html;
	}
	/**
     * Enter description here...
     *
     * @param Varien_Data_Form_Element_Abstract $element Element
     * 
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
    	$_dep = $this->_isDependencyFulfilled($element);
    	if (!$_dep || $_dep === self::DEPENDENCY_RO) {
    		$element->setReadonly(true);
    		$element->setDisabled(true);
    		$element->addClass("disabled");
    	}
    	
        return parent::_getElementHtml($element);
    }
    
    protected function _isDependencyFulfilled($element) {
    	$e = $element->getFieldConfig();
    	$levels = explode('_', $element->getHtmlId());
    	$configData = $this->getConfigData();
    	 
    	switch (count($levels)) {
    		case 3 :
    			//Field entfernen
    			array_pop($levels);
    			break;
    	}
    	 
    	if ($e->egovsdepend) {
    		foreach ($e->egovsdepend->children() as $dependent) {
    			/* @var $dependent Mage_Core_Model_Config_Element */
    			$shouldBeAddedDependence = true;
    			$dependentValue          = (string) $dependent;
    			$dependentFieldName      = $dependent->getName();
    			$path					 = $dependent->getAttribute('path');
    			$ro						 = $dependent->getAttribute('readonly') == "1" ? true : false;
    			if (!$path) {
    				$path = implode('/', $levels);
    			}
    			$dependentField          = "$path/$dependentFieldName";
    			
    			$_return = self::DEPENDENCY_FAILS;
    			if ($ro) {
    				$_return = self::DEPENDENCY_RO;
    			}
    			if (!isset($configData[$dependentField])) {
    				$dependentField = Mage::getModel('core/config_data')->load($dependentField, 'path');
    				if ($dependentField->isEmpty()) {
    					continue;
    				}
    				if ($dependentField->getValue() != $dependentValue) {
    					return $_return;
    				}
    			} elseif ($configData[$dependentField] != $dependentValue) {
    				return $_return;
    			}
    		}
    	}
    	
    	return true;
    }
}