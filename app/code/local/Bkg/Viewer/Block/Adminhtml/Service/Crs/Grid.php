<?php
 /**
  *
  * @category   	Bkg Viewer
  * @package    	Bkg_Viewer
  * @name       	Bkg_Viewer_Block_Adminhtml_Service_Crs_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Viewer_Block_Adminhtml_Service_Crs_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('Service\CrsGrid');
      $this->setDefaultSort('Service\Crs_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkgviewer/service_crs')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('bkgviewer')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined index: fields in D:\develweb\moduleGenerator\lib\tabelle.php on line <i>19</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0000</td><td bgcolor='#eeeeec' align='right'>177232</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.8450</td><td bgcolor='#eeeeec' align='right'>843936</td><td bgcolor='#eeeeec'>file->createFile(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>35</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.8450</td><td bgcolor='#eeeeec' align='right'>844160</td><td bgcolor='#eeeeec'>file->_getContent(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>21</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.8500</td><td bgcolor='#eeeeec' align='right'>866872</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->display(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>48</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.8500</td><td bgcolor='#eeeeec' align='right'>867000</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->_execute(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>114</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.8500</td><td bgcolor='#eeeeec' align='right'>886736</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>199</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.8600</td><td bgcolor='#eeeeec' align='right'>889312</td><td bgcolor='#eeeeec'>Smarty_Template_Compiled->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>...\smarty_internal_template.php<b>:</b>184</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.9450</td><td bgcolor='#eeeeec' align='right'>919312</td><td bgcolor='#eeeeec'>Smarty_Template_Resource_Base->getRenderedTemplateCode(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_compiled.php' bgcolor='#eeeeec'>...\smarty_template_compiled.php<b>:</b>170</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.9450</td><td bgcolor='#eeeeec' align='right'>920320</td><td bgcolor='#eeeeec'>content_585a4f9e706e33_66063721(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_resource_base.php' bgcolor='#eeeeec'>...\smarty_template_resource_base.php<b>:</b>128</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.9450</td><td bgcolor='#eeeeec' align='right'>921080</td><td bgcolor='#eeeeec'>tabelle->getFields(  )</td><td title='D:\develweb\moduleGenerator\temp\templates_c\9ddc58968f2673897fa435a80811fe354bdf84f5_0.file.grid.tmpl.php' bgcolor='#eeeeec'>...\9ddc58968f2673897fa435a80811fe354bdf84f5_0.file.grid.tmpl.php<b>:</b>76</td></tr>
</table></font>
<br />
<font size='1'><table class='xdebug-error xe-warning' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Warning: Invalid argument supplied for foreach() in D:\develweb\moduleGenerator\lib\tabelle.php on line <i>19</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0000</td><td bgcolor='#eeeeec' align='right'>177232</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.8450</td><td bgcolor='#eeeeec' align='right'>843936</td><td bgcolor='#eeeeec'>file->createFile(  )</td><td title='D:\develweb\moduleGenerator\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>35</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.8450</td><td bgcolor='#eeeeec' align='right'>844160</td><td bgcolor='#eeeeec'>file->_getContent(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>21</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.8500</td><td bgcolor='#eeeeec' align='right'>866872</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->display(  )</td><td title='D:\develweb\moduleGenerator\lib\file.php' bgcolor='#eeeeec'>...\file.php<b>:</b>48</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.8500</td><td bgcolor='#eeeeec' align='right'>867000</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->_execute(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>114</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.8500</td><td bgcolor='#eeeeec' align='right'>886736</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>...\smarty_internal_templatebase.php<b>:</b>199</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.8600</td><td bgcolor='#eeeeec' align='right'>889312</td><td bgcolor='#eeeeec'>Smarty_Template_Compiled->render(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>...\smarty_internal_template.php<b>:</b>184</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.9450</td><td bgcolor='#eeeeec' align='right'>919312</td><td bgcolor='#eeeeec'>Smarty_Template_Resource_Base->getRenderedTemplateCode(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_compiled.php' bgcolor='#eeeeec'>...\smarty_template_compiled.php<b>:</b>170</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.9450</td><td bgcolor='#eeeeec' align='right'>920320</td><td bgcolor='#eeeeec'>content_585a4f9e706e33_66063721(  )</td><td title='D:\develweb\moduleGenerator\lib\smarty\libs\sysplugins\smarty_template_resource_base.php' bgcolor='#eeeeec'>...\smarty_template_resource_base.php<b>:</b>128</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.9450</td><td bgcolor='#eeeeec' align='right'>921080</td><td bgcolor='#eeeeec'>tabelle->getFields(  )</td><td title='D:\develweb\moduleGenerator\temp\templates_c\9ddc58968f2673897fa435a80811fe354bdf84f5_0.file.grid.tmpl.php' bgcolor='#eeeeec'>...\9ddc58968f2673897fa435a80811fe354bdf84f5_0.file.grid.tmpl.php<b>:</b>76</td></tr>
</table></font>

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('bkgviewer')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('bkgviewer')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('bkgviewer')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('bkgviewer')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('servicecrs_id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('bkgviewer')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('bkgviewer')->__('Are you sure?')
        ));

        return $this;
    }

	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	return $this->getUrl('*/*/*', $params);

    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
