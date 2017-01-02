<?php
/**
  *
  * @category   	Bkg Viewer
  * @package    	Bkg_Viewer
  * @name       	Bkg_Viewer Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('bkgviewer/service_crs')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/service_crs')};
	CREATE TABLE {$installer->getTable('bkgviewer/service_crs')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined index: fields in D:\develweb\moduleGenerator\lib\tabelle.php on line <i>40</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0000</td><td bgcolor='#eeeeec' align='right'>177232</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>760712</td><td bgcolor='#eeeeec'>file->createFile(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>26</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>760944</td><td bgcolor='#eeeeec'>file->_getContent(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>21</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>783656</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->display(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>48</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>783784</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->_execute(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>114</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>803536</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>199</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>806120</td><td bgcolor='#eeeeec'>Smarty_Template_Compiled->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>...\smarty_internal_template.php<b>:</b>184</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.3400</td><td bgcolor='#eeeeec' align='right'>825984</td><td bgcolor='#eeeeec'>Smarty_Template_Resource_Base->getRenderedTemplateCode(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_compiled.php' bgcolor='#eeeeec'>...\smarty_template_compiled.php<b>:</b>170</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.3400</td><td bgcolor='#eeeeec' align='right'>826696</td><td bgcolor='#eeeeec'>content_584c80c2673647_04940534(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_resource_base.php' bgcolor='#eeeeec'>...\smarty_template_resource_base.php<b>:</b>128</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.3450</td><td bgcolor='#eeeeec' align='right'>828368</td><td bgcolor='#eeeeec'>tabelle->getCreateTable(  )</td><td title='D:\develweb\moduleGenerator\temp\templates_c\aedff3b6c6fd9f68012d91343d3095cb232733d8_0.file.install-0.1.0.0.tmpl.php' bgcolor='#eeeeec'>...\aedff3b6c6fd9f68012d91343d3095cb232733d8_0.file.install-0.1.0.0.tmpl.php<b>:</b>60</td></tr>
</table></font>
<br />
<font size='1'><table class='xdebug-error xe-warning' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Warning: Invalid argument supplied for foreach() in D:\develweb\moduleGenerator\lib\tabelle.php on line <i>40</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0000</td><td bgcolor='#eeeeec' align='right'>177232</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>760712</td><td bgcolor='#eeeeec'>file->createFile(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>26</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>760944</td><td bgcolor='#eeeeec'>file->_getContent(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>21</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>783656</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->display(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>48</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>783784</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->_execute(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>114</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>803536</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>199</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.2800</td><td bgcolor='#eeeeec' align='right'>806120</td><td bgcolor='#eeeeec'>Smarty_Template_Compiled->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>...\smarty_internal_template.php<b>:</b>184</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.3400</td><td bgcolor='#eeeeec' align='right'>825984</td><td bgcolor='#eeeeec'>Smarty_Template_Resource_Base->getRenderedTemplateCode(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_compiled.php' bgcolor='#eeeeec'>...\smarty_template_compiled.php<b>:</b>170</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.3400</td><td bgcolor='#eeeeec' align='right'>826696</td><td bgcolor='#eeeeec'>content_584c80c2673647_04940534(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_resource_base.php' bgcolor='#eeeeec'>...\smarty_template_resource_base.php<b>:</b>128</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.3450</td><td bgcolor='#eeeeec' align='right'>828368</td><td bgcolor='#eeeeec'>tabelle->getCreateTable(  )</td><td title='D:\develweb\moduleGenerator\temp\templates_c\aedff3b6c6fd9f68012d91343d3095cb232733d8_0.file.install-0.1.0.0.tmpl.php' bgcolor='#eeeeec'>...\aedff3b6c6fd9f68012d91343d3095cb232733d8_0.file.install-0.1.0.0.tmpl.php<b>:</b>60</td></tr>
</table></font>

	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}



/*
if (!$installer->getAttribute('catalog_product', 'request')) {
	$installer->addAttribute('catalog_product', 'request', array(
			'label' => 'With Request',
			'input' => 'select',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => false,
			//'required' => true,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'source'    => 'eav/entity_attribute_source_boolean',
			'default' => '1',
			//'option' => $option,
			'group' => 'General',
			'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
	));
}
*/
$installer->endSetup();
