<?php
/**
 * Redirectblock für Giropay/Kreditkarte über Saferpay
 *
 * Redirect zu Saferpay
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Block_Redirect
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author		René Sieberg <rsieberg@web.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Saferpay_Redirect extends Mage_Core_Block_Abstract
{

	/**
	 * Modulspezifischer Titel
	 * 
	 * @var string
	 */
	protected $_preTitle = 'Zahlung per';
	
	/**
	 * Gibt den ALT Text für das Logo zurück
	 * 
	 * @return string
	 */
	public function getLogoAlt()
	{
		if (empty($this->_data['logo_alt'])) {
			$this->_data['logo_alt'] = Mage::getStoreConfig('design/header/logo_alt');
		}
		return $this->_data['logo_alt'];
	}
	/**
	 * Liefert eine absolute URL zu der angebenen URL für Links
	 * 
	 * @param string $url URL
	 * 
	 * @return string
	 */
	protected function _getLinkUrl($url='') {
		$newUrl = Mage::app()->getStore()->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, true).$url;
		return $newUrl;
	}
	/**
	 * Liefert eine absolute URL zu der angebenen URL für Skin-Pfade
	 * 
	 * @param string $url URL
	 * 
	 * @return string
	 */
	protected function _getDesignUrl($url='') {
		$newUrl = Mage::getDesign()->getSkinBaseUrl(array('_secure'=>true)).$url;
		return $newUrl;
	}

	/**
	 * Liefert eine absolute URL zu der angebenen URL für JavaScript-Pfade
	 *
	 * @param string $url URL
	 *
	 * @return string
	 */
	protected function _getJSUrl($url='') {
		$newUrl = Mage::app()->getStore()->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS, true).$url;
		return $newUrl;
	}
	/**
	 * Die HTML Seite die zur Anzeige gebracht werden soll.
	 *
	 * @return string Liefert eine HTML-Seite für eine Weiterleitung zurück
	 * (non-PHPdoc)
	 * @see Mage_Core_Block_Abstract::_toHtml()
	 */
	protected function _toHtml() {
		$shared = $this->getOrder ()->getPayment ()->getMethodInstance ();
		$url = $shared->getSaferpayUrl();

		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title> '.$this->_preTitle.' - Saferpay </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Meta Description" />
<meta name="keywords" content="giropay, kreditkarte, saferpay" />
<meta name="robots" content="INDEX,FOLLOW" />
<link rel="icon" href="'.$this->_getDesignUrl('favicon.ico').'" type="image/x-icon" />
<link rel="shortcut icon" href="'.$this->_getDesignUrl('favicon.ico').'" type="image/x-icon" />
<!--
<script type="text/javascript" src="'.$this->_getJSUrl('').'index.php?c=auto&amp;f=,prototype/prototype.js,prototype/validation.js,scriptaculous/builder.js,scriptaculous/effects.js,scriptaculous/dragdrop.js,scriptaculous/controls.js,scriptaculous/slider.js,varien/js.js,varien/form.js,varien/menu.js,mage/translate.js,mage/cookies.js,symmetrics/legitimategerman/legitimategerman.js,varien/weee.js" ></script>
-->
<link rel="stylesheet" type="text/css" href="'.$this->_getDesignUrl('css/reset.css').'" media="all" />
<link rel="stylesheet" type="text/css" href="'.$this->_getDesignUrl('css/styles.css').'" media="all" />

<link rel="stylesheet" type="text/css" href="'.$this->_getDesignUrl('css/clears.css').'" media="all" />
<link rel="stylesheet" type="text/css" href="'.$this->_getDesignUrl('css/print.css').'" media="print" />
<link rel="stylesheet" type="text/css" href="'.$this->_getDesignUrl('css/stock_indicator.css').'" media="all" />
<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="'.$this->_getDesignUrl('css/styles-ie.css').'" media="all" />
<![endif]-->
<!--[if lt IE 7]>
<script type="text/javascript" src="'.$this->getUrl('').'index.php?c=auto&amp;f=,lib/ds-sleight.js,varien/iehover-fix.js" ></script>
<![endif]-->
</head>
<body class=" catalog-category-view categorypath-apparel-hoodies category-hoodies">
<div class="wrapper">
        
    <div class="page">
        <div class="header-container">

	<div class="header">
		<div class="head-top_row">      
			<h1 id="titel" title="'.$this->getLogoAlt().'">'.$this->getLogoAlt().'</h1>
			<a href="'.$this->_getLinkUrl('').'" title="zur Startseite"><span id="logo"></span></a>
		  	<!--style="background-image:url(http://localhost/MagentoShop/webroot/skin/frontend/default/magento_sachsen/);">-->
			<p class="welcome-msg"></p>
		</div>';
		$html .= $this->__ ( 'You will be redirected to Saferpay in a few seconds. If not, click next.' );
		$html .= '<br />';
		$html .= '<br /><a href="'.$url.'" >&raquo;'.$this->__('next').'</a>';
		$html .= '<script type="text/javascript">window.document.location.href="'.$url.'";</script>';
		$html .= '</div></div></body></html>';

		return $html;
	}
}
