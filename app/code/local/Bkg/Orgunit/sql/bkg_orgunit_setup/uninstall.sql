SET foreign_key_checks = 0;
drop table IF EXISTS bkg_orgunit_unit_address_entity_varchar;
drop table IF EXISTS bkg_orgunit_unit_address_entity;
drop table IF EXISTS bkg_orgunit_unit_entity;
drop table IF EXISTS bkg_orgunit_unit;
drop table IF EXISTS bkg_orgunit_eav_attribute;
drop table IF EXISTS bkg_orgunit_form_attribute;
delete from core_resource where code = 'bkg_orgunit_setup';
-- Delete bkg orgunit address type and let the attributes cascade delete
SET foreign_key_checks = 1;
DELETE FROM eav_entity_type WHERE entity_type_code ='bkg_orgunit';