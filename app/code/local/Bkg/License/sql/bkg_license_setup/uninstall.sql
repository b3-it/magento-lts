SET foreign_key_checks = 0;
drop table bkg_license_copy;
drop table bkg_license_copy_agreement;
drop table bkg_license_copy_text;
drop table bkg_license_copy_toll;
drop table bkg_license_master;
drop table bkg_license_master_agreement;
drop table bkg_license_master_customergroup;
drop table bkg_license_master_product;
drop table bkg_license_master_toll;
drop table bkg_license_master_fee;
SET foreign_key_checks = 1;
DELETE FROM core_resource WHERE code = 'bkg_license_setup';