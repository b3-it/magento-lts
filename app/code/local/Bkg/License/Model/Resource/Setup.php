<?php



class Bkg_License_Model_Resource_Setup extends Mage_Catalog_Model_Resource_Setup
{
    public function CreatePdfTemplate($data)
    {
        $template = Mage::getModel('pdftemplate/template');
        $template->setData($data['general']);
        $template->save();

        $model = Mage::getModel('pdftemplate/section');
        $model->setData($data['header']);
        $model->setPdftemplateTemplateId($template->getId());
        $model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_HEADER);
        $model->save();

        $model = Mage::getModel('pdftemplate/section');
        $model->setData($data['address']);
        $model->setPdftemplateTemplateId($template->getId());
        $model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_ADDRESS);
        $model->save();

        $model = Mage::getModel('pdftemplate/section');
        $model->setData($data['body']);
        $model->setPdftemplateTemplateId($template->getId());
        $model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_BODY);
        $model->save();

        $model = Mage::getModel('pdftemplate/section');
        $model->setData($data['footer']);
        $model->setPdftemplateTemplateId($template->getId());
        $model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_FOOTER);
        $model->save();

        $model = Mage::getModel('pdftemplate/section');
        $model->setData($data['marginal']);
        $model->setPdftemplateTemplateId($template->getId());
        $model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_MARGINAL);
        $model->save();

        return $this;
    }
}