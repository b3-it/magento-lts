<?php
/**
 * Configurable Downloadable Products Renderer für Download Action
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Block_Adminhtml_Widget_Grid_Column_Renderer_DownloadAction extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
	/**
	 * Prepares action data for html render
	 *
	 * @param array         &$action        Action Parameter
	 * @param string        &$actionCaption Titel
	 * @param Varien_Object $row            Aktuelle Zeile
	 * 
	 * @return Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
	 */
	protected function _transformActionData(&$action, &$actionCaption, Varien_Object $row)
	{
		foreach ( $action as $attibute => $value ) {
			if (isset($action[$attibute]) && !is_array($action[$attibute])) {
				$this->getColumn()->setFormat($action[$attibute]);
				$action[$attibute] = Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Text::render($row);
			} else {
				$this->getColumn()->setFormat(null);
			}
			
			$file = Mage::helper('downloadable/file')->getFilePath(
                Mage_Downloadable_Model_Link::getBasePath(), $row->getLinkFile()
            );

            if ($row->getLinkFile() && is_file($file)) {
            	$actionCaption = Mage::helper('downloadable/file')->getFileFromPathFile($row->getLinkFile());
                $action['file_info'] = array(
                        'file' => $row->getLinkFile(),
                        'size' => Mage::helper('egovsbase')->binaryHumanReadable(filesize($file)),
                );
            }
	
			switch ($attibute) {
				case 'caption':
					$actionCaption = $action['caption'];
					unset($action['caption']);
					break;
	
				case 'url':
					if (is_array($action['url'])) {
						$params = array($action['field']=>$this->_getValue($row));
						if (isset($action['url']['params'])) {
                            /** @noinspection SlowArrayOperationsInLoopInspection */
                            $params = array_merge($action['url']['params'], $params);
						}
						$action['href'] = $this->getUrl($action['url']['base'], $params);
						unset($action['field']);
					} else {
						$action['href'] = $this->getUrl('adminhtml/downloadable_product_edit/link', array(
                        							'id' => $row->getId(),
                        							'_secure' => true,
                    								)
						);
					}
					unset($action['url']);
					break;
	
				case 'popup':
					$action['onclick'] = 'popWin(this.href, \'_blank\', \'width=900,height=700,resizable=1,scrollbars=1\');return false;';
					break;
	
			}
		}
		return $this;
	}
	
	/**
	 * Render single action as link html
	 *
	 * @param array         $action Action Paarmeter
	 * @param Varien_Object $row    Aktuelle Zeile
	 * 
	 * @return string
	 */
	protected function _toLinkHtml($action, Varien_Object $row)
	{
		$actionAttributes = new Varien_Object();

        $actionCaption = '';
        $this->_transformActionData($action, $actionCaption, $row);

        if (isset($action['confirm'])) {
            $action['onclick'] = 'return window.confirm(\''
                               . addslashes($this->htmlEscape($action['confirm']))
                               . '\')';
            unset($action['confirm']);
        }

        $fileinfo = $action['file_info'];
        if (isset($action['file_info'])) {
        	unset($action['file_info']);
        }
        $actionAttributes->setData($action);
        $html = '<a ' . $actionAttributes->serialize() . '>' . $actionCaption . '</a>';
        if (isset($fileinfo)) {
        	$html .= " ({$fileinfo['size']})";
        }
        return $html;
	}
}
