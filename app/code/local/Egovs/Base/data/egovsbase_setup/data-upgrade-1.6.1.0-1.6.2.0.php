<?php
/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();


$addRows =    array(
			array('variable_name' => 'general/imprint/company_first', 'is_allowed' => 1),
			array('variable_name' => 'general/imprint/street', 'is_allowed' => 1),
			array('variable_name' => 'general/imprint/zip', 'is_allowed' => 1),
			array('variable_name' => 'general/imprint/city', 'is_allowed' => 1),
			array('variable_name' => 'general/imprint/email', 'is_allowed' => 1)
);

$table = $installer->getTable('admin/permission_variable');


foreach($addRows as $row)
{
	$sql = "SELECT * FROM $table WHERE variable_name = '" . $row['variable_name']."'";
	if(count($installer->getConnection()->fetchAll($sql)) == 0)
	{
		$installer->getConnection()->insert($table,$row);
	}

}

$installer->endSetup();
