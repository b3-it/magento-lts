<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   	Egovs
 * @package    	Egovs_Video
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

/**
 * Media library js helper
 *
 * Es werden die zusätzlichen Fehlermeldungen:
 * <li>
 * 	<ul>Maximum allowed file size for upload is</ul>
 *  <ul>Please check your server PHP settings.</ul>
 * </li>
 *
 * zur Übersetzungstabelle hinzugefügt.
 *
 * @category   	Egovs
 * @package    	Egovs_Video
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class Egovs_Video_Helper_Media_Js extends Mage_Adminhtml_Helper_Media_Js
{

	/**
	 * Fügt einige Übsersetzungen hinzu
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		if (is_array($this->_translateData)) {
			$this->_translateData['Maximum allowed file size for upload is'] = $this->__('Maximum allowed file size for upload is');
			$this->_translateData['Please check your server PHP settings.'] = $this->__('Please check your server PHP settings.');
		}
	}
}
