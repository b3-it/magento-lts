<?php
/**
 * 
 *  Basisklasse um Dateien zur Verfügung zu stellen
 *  @category Egovs
 *  @package  B3it_XmlBind_Bmecat2005_Builder_Abstract
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class  B3it_XmlBind_ProductBuilder_Imageloader_Abstract
{
	const STATUS_OK = 1;
	const STATUS_NOT_FOUND = 2;
	
	/**
	 * welche Dateien wurden schon übertragen
	 * @var array
	 */
	protected $_FilesHandled = array();

	public abstract function moveImage($filename, $targetDir);
}
