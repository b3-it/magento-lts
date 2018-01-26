update core_resource set data_version=null where code = 'bkg_tollpolicy_setup';
delete from `bkg_tollpolicy_toll_entity`;
delete from `bkg_tollpolicy_use_options_entity`;
delete from `bkg_tollpolicy_use_type_entity`;
delete from bkg_tollpolicy_toll_category;