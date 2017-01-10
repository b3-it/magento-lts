<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Service_Crs_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Service_Crs_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('servicecrs_form', array('legend'=>Mage::helper('bkgviewer')->__('Item information')));

<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined index: fields in D:\develweb\moduleGenerator\lib\tabelle.php on line <i>19</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0000</td><td bgcolor='#eeeeec' align='right'>177232</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>917328</td><td bgcolor='#eeeeec'>file->createFile(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>39</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>917552</td><td bgcolor='#eeeeec'>file->_getContent(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>21</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>940264</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->display(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>48</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>940392</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->_execute(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>114</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>960152</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>199</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>962720</td><td bgcolor='#eeeeec'>Smarty_Template_Compiled->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>...\smarty_internal_template.php<b>:</b>184</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>1.3950</td><td bgcolor='#eeeeec' align='right'>985664</td><td bgcolor='#eeeeec'>Smarty_Template_Resource_Base->getRenderedTemplateCode(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_compiled.php' bgcolor='#eeeeec'>...\smarty_template_compiled.php<b>:</b>170</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>1.3950</td><td bgcolor='#eeeeec' align='right'>986472</td><td bgcolor='#eeeeec'>content_585a4fd6ca92b7_33679289(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_resource_base.php' bgcolor='#eeeeec'>...\smarty_template_resource_base.php<b>:</b>128</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>1.3950</td><td bgcolor='#eeeeec' align='right'>987184</td><td bgcolor='#eeeeec'>tabelle->getFields(  )</td><td title='D:\develweb\moduleGenerator\temp\templates_c\366e44dc42fcff23f805af97ee62238a03b00206_0.file.form.tmpl.php' bgcolor='#eeeeec'>...\366e44dc42fcff23f805af97ee62238a03b00206_0.file.form.tmpl.php<b>:</b>51</td></tr>
</table></font>
<br />
<font size='1'><table class='xdebug-error xe-warning' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Warning: Invalid argument supplied for foreach() in D:\develweb\moduleGenerator\lib\tabelle.php on line <i>19</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0000</td><td bgcolor='#eeeeec' align='right'>177232</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>917328</td><td bgcolor='#eeeeec'>file->createFile(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>39</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>917552</td><td bgcolor='#eeeeec'>file->_getContent(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>21</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>940264</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->display(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>48</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>940392</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->_execute(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>114</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>960152</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>199</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>1.3250</td><td bgcolor='#eeeeec' align='right'>962720</td><td bgcolor='#eeeeec'>Smarty_Template_Compiled->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>...\smarty_internal_template.php<b>:</b>184</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>1.3950</td><td bgcolor='#eeeeec' align='right'>985664</td><td bgcolor='#eeeeec'>Smarty_Template_Resource_Base->getRenderedTemplateCode(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_compiled.php' bgcolor='#eeeeec'>...\smarty_template_compiled.php<b>:</b>170</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>1.3950</td><td bgcolor='#eeeeec' align='right'>986472</td><td bgcolor='#eeeeec'>content_585a4fd6ca92b7_33679289(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_resource_base.php' bgcolor='#eeeeec'>...\smarty_template_resource_base.php<b>:</b>128</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>1.3950</td><td bgcolor='#eeeeec' align='right'>987184</td><td bgcolor='#eeeeec'>tabelle->getFields(  )</td><td title='D:\develweb\moduleGenerator\temp\templates_c\366e44dc42fcff23f805af97ee62238a03b00206_0.file.form.tmpl.php' bgcolor='#eeeeec'>...\366e44dc42fcff23f805af97ee62238a03b00206_0.file.form.tmpl.php<b>:</b>51</td></tr>
</table></font>



      if ( Mage::getSingleton('adminhtml/session')->getservicecrsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getservicecrsData());
          Mage::getSingleton('adminhtml/session')->setservicecrsData(null);
      } elseif ( Mage::registry('servicecrs_data') ) {
          $form->setValues(Mage::registry('servicecrs_data')->getData());
      }
      return parent::_prepareForm();
  }
}
